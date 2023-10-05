<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuaHang;
use App\Http\Resources\CuaHang as Store;
use Validator;
class CuaHangController extends Controller
{
    // Hiển thị danh sách cửa hàng
    public function index()
    {
        $stores = CuaHang::all();
        return response()->json(['stores' => $stores], 200);
    }

    // Hiển thị thông tin của một cửa hàng cụ thể
    public function show($id)
    {
        $store = CuaHang::find($id);

        if (!$store) {
            return response()->json(['message' => 'Cửa hàng không tồn tại'], 404);
        }

        return response()->json(['store' => $store], 200);
    }

    // Thêm một cửa hàng mới
    public function store(Request $request)
    {
        $input=$request->all();
        // Validate dữ liệu đầu vào
        $validatedData =Validator::make($input,[
            'ten_ch' => 'required|string|max:50',
            'diaChi' => 'required|string|max:255',
            'Member' => 'required|boolean',
            'idLoaiCh' => 'required|integer',
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
        $store = CuaHang::create($input);
        $arr = ['status' => true,
        'message'=>"Sản phẩm đã lưu thành công",
        'data'=> new Store($store)
    ];
        return response()->json($arr, 201);
    }

    // Sửa thông tin của một cửa hàng
    public function update(Request $request, $id)
{
        $input = $request->all();

        // Validate dữ liệu đầu vào
        $validator = Validator::make($input, [
            'ten_ch' => 'required|string|max:50',
            'diaChi' => 'required|string|max:255',
            'Member' => 'required|boolean',
            'idLoaiCh' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ], 400); // Sử dụng 400 (Bad Request) cho lỗi kiểm tra dữ liệu không hợp lệ
        }

        $store = CuaHang::find($id);

        if (!$store) {
            return response()->json(['message' => 'Cửa hàng không tồn tại'], 404);
        }
        // Cập nhật thông tin cửa hàng
        $store->ten_ch = $input['ten_ch'];
        $store->diaChi = $input['diaChi'];
        $store->Member = $input['Member'];
        $store->idLoaiCh = $input['idLoaiCh'];
        $store->save();

        return response()->json([
            'status' => true,
            'message' => 'Cửa hàng cập nhật thành công',
            'data' => new Store($store)
        ], 200);
    }
    
    // Xóa một cửa hàng
    public function destroy($id)
    {
        $store = CuaHang::find($id);

        if (!$store) {
            return response()->json(['message' => 'Cửa hàng không tồn tại'], 404);
        }

        $store->delete();
        return response()->json(['message' => 'Xóa cửa hàng thành công'], 204);
    }
}
