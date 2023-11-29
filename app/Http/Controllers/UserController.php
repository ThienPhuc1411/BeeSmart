<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use DB;
use Mail;
use Auth;
use Hash;
use Str;
use Validator;
use App\Mail\QuenMatKhau;
use App\Models\subCuaHang;
use App\Models\CuaHang;
use App\Mail\TaoCuaHang;


class UserController extends Controller
{
    //

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
            $tt_user=DB::table('users')
            ->join('sub_cua_hang','sub_cua_hang.idUsers','users.id')
            ->join('cua_hang','cua_hang.id','sub_cua_hang.idCh')
            ->join('loai_cua_hang','loai_cua_hang.id','cua_hang.idLoaiCh')
            ->select('users.*','sub_cua_hang.idCh as idCh','cua_hang.tenCh','loai_cua_hang.ten as tenLoaiCh','loai_cua_hang.id as idLoaiCh')
            ->where('users.id',$user->id)
            ->get();

        // dd($user);
        $success =  $user->createToken('MyApp')->plainTextToken;
            $arr=[
                'status'=>true,
                'token' => $success,

                'tt_user'=>$tt_user,
            ];
            return response($arr,200);
        }

        return Response(['message' => 'Email hoặc Mật khẩu không đúng','status'=>false],401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function userDetails(): Response
    {
        if (Auth::check()) {


            $user=Auth::user();
            $tt_user=DB::table('users')
            ->join('sub_cua_hang','sub_cua_hang.idUsers','users.id')
            ->join('cua_hang','cua_hang.id','sub_cua_hang.idCh')
            ->join('loai_cua_hang','loai_cua_hang.id','cua_hang.idLoaiCh')
            ->where('users.id',$user->id)
            ->select('users.*','sub_cua_hang.idCh as idCh','cua_hang.tenCh','loai_cua_hang.ten as tenLoaiCh','loai_cua_hang.id as idLoaiCh')
            ->get();



                $arr=[
                    'status'=>true,
                    'tt_user'=>$tt_user,
                ];
                return response($arr,200);
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
            'sdt' => 'required|between:10,11|starts_with:0',
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
                'slug' => str::slug($request->tenCh),
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
          
        $mailData = [
                    'status'=>true,
                    'title' => 'Đã tạo tài khoản thành công',
                    'body' => $ch->tenCh,
                    'ten' => $user->HoTen,
                    
                ];
        $userMail=$user->email;
         Mail::to($userMail)->send(new TaoCuaHang($mailData));
        $arr=[
            'status'=>true,
            'message'=>'Bạn đã đăng ký thành công',
            'data'=>$tt_user,
            'test'=>$mailData
        ];
        // dd($input);
        return response()->json($arr,201);

    }
    public function checkEmail(Request $request){

        $email=$request->email;


        if((DB::table('users')->where('email','=',$email)->first())){
            $id=DB::table('users')->where('email','=',$email)->first();
             // dd($id->id);
            //lí do sài $id->id , vì giá trị trong find phải là int
            $user = User::where('email','=',$email)->first();
            $tt_user=DB::table('users')
            ->join('sub_cua_hang','sub_cua_hang.idUsers','users.id')
            ->join('cua_hang','cua_hang.id','sub_cua_hang.idCh')
            ->join('loai_cua_hang','loai_cua_hang.id','cua_hang.idLoaiCh')
            ->select('users.*','sub_cua_hang.idCh as idCh','cua_hang.tenCh','loai_cua_hang.ten as tenLoaiCh','loai_cua_hang.id as idLoaiCh')
            ->where('users.id',$user->id)
            ->first();




            $success =  $user->createToken('MyApp')->plainTextToken;
                $arr=[
                    'status'=>true,
                    'token' => $success,

                    'tt_user'=>$tt_user,
                ];
                return response()->json($arr,200);


        }
        else{
            $arr=[
                'status'=>false,
                'message'=>'Email chưa được đăng ký',

            ];
            return response()->json($arr,401);
        }

    }
    public function changePassword(Request $request){

        $id=$request->id;
        $newpass=$request->newpass;
        $checkpass=$request->checkpass;
        $user=User::find($id);
        // dd($user->password);
        // dd($checkpass);
        // dd(bcrypt($checkpass));


        if (Hash::check($checkpass, $user->password)) {
            $user->password=$newpass;
            $user->save();
            $arr=[
                'status'=>true,
                'message'=>'Đổi mật khẩu thành công'

                ];
        }


        else{
            $arr=[
                    'status'=>false,
                    'message'=>'Mật khẩu cũ không đúng'
                    ];
        }
        return response()->json($arr,200);


    }
    public function forgotPassword(Request $request){

            $userMail = $request->email;
            if((DB::table('users')->where('email','=',$userMail)->first())){
                $newPassword =Str::random(6);
                // dd($newPassword);
                $user=User::where('email','=',$userMail)->first();
                $user->password=$newPassword;
                $user->save();
                $mailData = [
                    'status'=>true,
                    'ten' => $user->HoTen,
                    'newpass' => $newPassword
                ];
                Mail::to($userMail)->send(new QuenMatKhau($mailData));
                return response()->json($mailData,201);
            }else{
                $mailData = [
                    'status'=>false,
                    'title' => 'Email không tồn tại',

                ];
                return response()->json($mailData,200);
            }



    }
    public function updateInfo(Request $request){
         $rules = [
            
            'sdt' => 'between:10,11|starts_with:0',
            
        ];

        $checksdt     = [
            
            'sdt'=>$request->sdt
            
        ];
        $validator = Validator::make($checksdt, $rules);
         if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        $input=$request->all();
        
        $id=$input['id'];
        $user=User::where('id','=',$id)->first();
        if(!empty($input['sdt'])){
              $user->sdt=$input['sdt'];
        }
        
        
         if(!empty($input['Diachi'])){
             $user->Diachi=$input['Diachi'];
         }
         
         if(!empty($input['quan'])){
              $user->quan=$input['quan'];
             
         }
         
          if(!empty($input['HoTen'])){
               $user->HoTen=$input['HoTen'];
             
         }
      
        
       
       
        $user->save();
        $arr = [
            'status' => true,
            'message' => 'Tài khoản cập nhật thành công',
            // 'data' => new san_phamResource($product),
            'datalink' => $user
        ];
        return response()->json($arr, 200);
    }
}
