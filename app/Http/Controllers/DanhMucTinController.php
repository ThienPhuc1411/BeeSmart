<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucTin;
use App\Http\Resources\DanhMucTin as DM;
use Validator;
class DanhMucTinController extends Controller
{
     // Hiển thị danh sách cửa hàng
     public function index()
     {
         $danhmuctin = DanhMucTin::where('anHien',1)->orderBy('updated_at','desc')->get();
         return response()->json(['danhmuctin' => $danhmuctin], 200);
     }

     // Hiển thị thông tin của một cửa hàng cụ thể
     public function show($id)
     {
         $danhmuctin = DanhMucTin::find($id);
 
         if (!$danhmuctin) {
             return response()->json(['message' => 'Danh mục tin không tồn tại'], 404);
         }
 
         return response()->json(['danhmuctin' => $danhmuctin], 200);
     }
 
     // Thêm một cửa hàng mới
     public function store(Request $request)
     {
         $input=$request->all();
         // Validate dữ liệu đầu vào
         $validatedData =Validator::make($input,[
             'ten' => 'required|string|max:50',
             'anHien' => 'required|boolean',
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
         $danhmuctin = DanhMucTin::create($input);
         $arr = ['status' => true,
         'message'=>"Danh mục tin đã lưu thành công",
         'data'=> new DM($danhmuctin)
     ];
         return response()->json($arr, 201);
     }
 
     // Sửa thông tin của một cửa hàng
     public function update(Request $request, $id)
 {
         $input = $request->all();
 
         // Validate dữ liệu đầu vào
         $validator = Validator::make($input, [
             'ten' => 'required|string|max:50',
             'anHien' => 'required|boolean',
         ]);
 
         if ($validator->fails()) {
             return response()->json([
                 'status' => false,
                 'message' => 'Lỗi kiểm tra dữ liệu',
                 'data' => $validator->errors()
             ], 400); // Sử dụng 400 (Bad Request) cho lỗi kiểm tra dữ liệu không hợp lệ
         }
 
         $danhmuctin = DanhMucTin::find($id);
 
         if (!$danhmuctin) {
             return response()->json(['message' => 'Danh mục tin không tồn tại'], 404);
         }
         // Cập nhật thông tin cửa hàng
         $danhmuctin->ten = $input['ten'];
         $danhmuctin->anHien = $input['anHien'];
         $danhmuctin->save();
 
         return response()->json([
             'status' => true,
             'message' => 'Danh mục tin cập nhật thành công',
             'data' => new DM($danhmuctin)
         ], 200);
     }
     
     // Xóa một cửa hàng
     public function destroy($id)
     {
         $danhmuctin = DanhMucTin::find($id);
 
         if (!$danhmuctin) {
             return response()->json(['message' => 'Danh mục tin không tồn tại'], 404);
         }
 
         $danhmuctin->delete();
         return response()->json(['message' => 'Xóa danh mục tin thành công'], 204);
     }
}
