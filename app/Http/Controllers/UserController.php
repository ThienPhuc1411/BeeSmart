<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use DB;
use Auth;
use Validator;
use App\Models\subCuaHang;
use App\Models\CuaHang;

class UserController extends Controller
{
    //
    public function index(){
        $title = 'Khách hàng';
        $users = DB::table('users')->paginate(10)->withQueryString();
        return view('admin.list-client',compact('users','title'));
    }

    public function block(Request $request){
        $title = 'Khách hàng';
        $id = $request->id;
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        $users = DB::table('users')->paginate(10)->withQueryString();
        return view('admin.list-client',compact('users','title'));
        // dd($id);
    }

    public function unblock(Request $request){
        $title = 'Khách hàng';
        $id = $request->id;
        $user = User::find($id);
        $user->status = 1;
        $user->save();
        $users = DB::table('users')->paginate(10)->withQueryString();
        return view('admin.list-client',compact('users','title'));
        // dd($id);
    }

    public function loginUser(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){

            return Response(['message' => $validator->errors()],401);
        }

        if(Auth::attempt($request->all())){

            $user = Auth::user();

            $success =  $user->createToken('MyApp')->plainTextToken;

            return Response(['token' => $success],200);
        }

        return Response(['message' => 'email or password wrong'],401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function userDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            return Response(['data' => $user],200);
        }

        return Response(['data' => 'Unauthorized'],401);
    }

    /**
     * Display the specified resource.
     */
    public function logout(): Response
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return Response(['data' => 'User Logout successfully.'],200);
    }
    // public function register(Request $request)
    // {
    //     $rules = [
    //         'HoTen' => 'required',
    //         'email'    => 'unique:users|required|email',
    //         'password' => 'required',
    //         'sdt' => 'required',
    //         'quan' => 'required',
    //     ];

    //     $input     = $request->all();
    //     $validator = Validator::make($input, $rules);

    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'error' => $validator->messages()]);
    //     }


    //     $user     = User::create($input);
    //     $arr=[
    //         'status'=>true,
    //         'message'=>'Bạn đã đăng ký thành công',
    //         'data'=>$user,
    //     ];
    //     // dd($input);
    //     return response()->json($arr,201);

    // }


    public function register(Request $request)
    {
        $rules = [
            'HoTen' => 'required',
            'email'    => 'unique:users|required|email',
            'password' => 'required',
            'sdt' => 'required',
            'quan' => 'required',
        ];

        $input     = [
            'HoTen'=>$request->HoTen,
            'email'=>$request->email,
            'password'=> $request->password,
            'sdt'=>$request->sdt,
            'quan'=>$request->quan
        ];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }


        $user     = User::create($input);
        if(!empty($request->idLoaiCh)){

            $ch=[
                'tenCh'=>$request->tenCh,
                'diaChi'=>$request->diaChi,
                'idLoaiCh'=>$request->idLoaiCh,
            ];
            $ch=CuaHang::create($ch);
            $subch=
            [
                'idCh'=>$ch->id,
                'idUsers'=>$user->id
            ];
            subCuaHang::create($subch);

        }
        $tt_user=DB::table('users')
        ->join('sub_cua_hang','sub_cua_hang.idUsers','users.id')
        ->join('cua_hang','cua_hang.id','sub_cua_hang.idCh')
        ->join('loai_cua_hang','loai_cua_hang.id','cua_hang.idLoaiCh')
        ->where('users.id',$user->id)
        ->select('users.*','sub_cua_hang.idCh as idCh','cua_hang.tenCh','loai_cua_hang.ten as tenLoaiCh','loai_cua_hang.id as idLoaiCh')
        ->get();
        $arr=[
            'status'=>true,
            'message'=>'Bạn đã đăng ký thành công',
            'data'=>$tt_user,
        ];
        // dd($input);
        return response()->json($arr,201);

    }
}
