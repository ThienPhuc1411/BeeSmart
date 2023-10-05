<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaiCuaHang;
use App\Http\Resources\LoaiCuaHang as LoaiStore;
use Validator;
class LoaiCHController extends Controller
{
    // Hiển thị danh sách cửa hàng
    public function index()
    {
        $stores = LoaiCuaHang::all();
        return response()->json(['stores' => $stores], 200);
    }

    // Hiển thị thông tin của một cửa hàng cụ thể
    public function show($id)
    {
        $store = LoaiCuaHang::find($id);

        if (!$store) {
            return response()->json(['message' => 'Loại Cửa hàng không tồn tại'], 404);
        }

        return response()->json(['store' => $store], 200);
    }

    // Thêm một cửa hàng mới
    public function store(Request $request)
    {
        $input=$request->all();
        // Validate dữ liệu đầu vào
        $validatedData =Validator::make($input,[
            'ten' => 'required|string|max:50',
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
        $store = LoaiCuaHang::create($input);
        $arr = ['status' => true,
        'message'=>"Sản phẩm đã lưu thành công",
        'data'=> new LoaiStore($store)
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ], 400); // Sử dụng 400 (Bad Request) cho lỗi kiểm tra dữ liệu không hợp lệ
        }

        $store = LoaiCuaHang::find($id);

        if (!$store) {
            return response()->json(['message' => 'Loại Cửa hàng không tồn tại'], 404);
        }
        // Cập nhật thông tin cửa hàng
        $store->ten = $input['ten'];
        $store->save();

        return response()->json([
            'status' => true,
            'message' => 'Loại Cửa hàng cập nhật thành công',
            'data' => new LoaiStore($store)
        ], 200);
    }
    
    // Xóa một cửa hàng
    public function destroy($id)
    {
        $store = LoaiCuaHang::find($id);

        if (!$store) {
            return response()->json(['message' => 'Loại Cửa hàng không tồn tại'], 404);
        }

        $store->delete();
        return response()->json(['message' => 'Xóa cửa hàng thành công'], 204);
    }
}
