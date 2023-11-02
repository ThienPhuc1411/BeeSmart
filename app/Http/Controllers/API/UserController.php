<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
Use Illuminate\Http\Response;
Use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\Validator;
Use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**

     */
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

     */
    public function logout(): Response
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return Response(['data' => 'Đăng xuất thành công'],200);
    }
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email'    => 'unique:users|required|email',
            'password' => 'required',
            'sdt' => 'required',
            'quan' => 'required',
        ];

        $input     = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }


        $user     = User::create($input);
        $arr=[
            'status'=>true,
            'message'=>'Bạn đã đăng ký thành công',
            'data'=>$user,
        ];
        // dd($input);
        return response()->json($arr,201);

    }
}
