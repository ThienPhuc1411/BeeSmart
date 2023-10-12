<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tin;
use App\Http\Resources\Tin as Tintuc;
use Validator;
class TinController extends Controller
{
    public function index()
     {
         $tintuc = Tin::all();
         return response()->json(['danhmuctin' => $tintuc], 200);
     }

     // Hiển thị thông tin của một cửa hàng cụ thể
     public function show($id)
     {
         $tintuc = Tin::find($id);
 
         if (!$tintuc) {
             return response()->json(['message' => 'Tin không tồn tại'], 404);
         }
 
         return response()->json(['tintuc' => $tintuc], 200);
     }
 
     // Thêm một cửa hàng mới
     public function store(Request $request)
     {
         $input=$request->all();
         // Validate dữ liệu đầu vào
         $validatedData =Validator::make($input,[
             'tieuDe' => 'required|string|max:255',
             'tomTat' => 'required|string',
             'noiDung' => 'required|string',
             'anHien' => 'required|boolean',
             'view' => 'required|integer',
             'idDmTin' => 'required|integer',
             'idUsers' => 'required|integer',
         ]);
         if($validatedData->fails()){
             $arr = [
               'status' => false,
               'message' => 'Lỗi kiểm tra dữ liệu',
               'data' => $validatedData->errors()
             ];
             return response()->json($arr, 200);
          }
         // Tạo một cửa hàng mới và lưu vào cơ sở dữ liệu
         $tintuc = Tin::create($input);
         $arr = ['status' => true,
         'message'=>"Tin đã lưu thành công",
         'data'=> new Tintuc($tintuc)
     ];
         return response()->json($arr, 201);
     }
 
     // Sửa thông tin của một cửa hàng
     public function update(Request $request, $id)
 {
         $input = $request->all();
 
         // Validate dữ liệu đầu vào
         $validator = Validator::make($input, [
            'tieuDe' => 'required|string|max:255',
            'tomTat' => 'required|string',
            'noiDung' => 'required|string',
            'anHien' => 'required|boolean',
            'view' => 'required|integer',
            'idDmTin' => 'required|integer',
            'idUsers' => 'required|integer',
         ]);
 
         if ($validator->fails()) {
             return response()->json([
                 'status' => false,
                 'message' => 'Lỗi kiểm tra dữ liệu',
                 'data' => $validator->errors()
             ], 400); // Sử dụng 400 (Bad Request) cho lỗi kiểm tra dữ liệu không hợp lệ
         }
 
         $tintuc = Tin::find($id);
 
         if (!$tintuc) {
             return response()->json(['message' => 'Tin không tồn tại'], 404);
         }
         // Cập nhật thông tin cửa hàng
         $tintuc->tieuDe = $input['tieuDe'];
         $tintuc->tomTat = $input['tomTat'];
         $tintuc->noiDung = $input['noiDung'];
         $tintuc->view = $input['view'];
         $tintuc->idDmTin = $input['idDmTin'];
         $tintuc->idUsers = $input['idUsers'];
         $tintuc->anHien = $input['anHien'];
         $tintuc->save();
 
         return response()->json([
             'status' => true,
             'message' => 'Tin tức cập nhật thành công',
             'data' => new Tintuc($tintuc)
         ], 200);
     }
     
     // Xóa một cửa hàng
     public function destroy($id)
     {
         $tintuc = Tin::find($id);
 
         if (!$tintuc) {
             return response()->json(['message' => 'Tin không tồn tại'], 404);
         }
 
         $tintuc->delete();
         return response()->json(['message' => 'Tin xóa thành công'], 204);
     }
}
