<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use App\Http\Resources\LoaiSanPham as LoaiSPResource;
use Validator;

class LoaiSanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $loaisp = LoaiSanPham::all();
        $arr = [
            'status' => true,
            'message' => 'Danh sách loại sản phẩm',
            'data' => LoaiSPResource::collection($loaisp)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
            'ten' => 'required'
        ]);
        if ($validator->fails()) {
            $arr = [
                'status' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $loaisp = LoaiSanPham::create($input);
        $arr = [
            'status' => true,
            'message' => 'Thêm loại sản phẩm thành công',
            'data' => new LoaiSPResource($loaisp)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $loaisp = LoaiSanPham::find($id);
        if (is_null($loaisp)) {
            $arr = [
                'status' => false,
                'message' => 'Loại sản phẩm không tồn tại',
                'data' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => 'Chi tiết loại sản phẩm',
            'data' => new LoaiSPResource($loaisp)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoaiSanPham $loai_san_pham) {
        $input = $request->all();
        $validator = Validator::make($input, [
            'ten' => 'required'
        ]);
        if ($validator->fails()) {
            $arr = [
                'status' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $loai_san_pham->ten = $input['ten'];
        $loai_san_pham->save();
        $arr = [
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => new LoaiSPResource($loai_san_pham)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoaiSanPham $loai_san_pham) {
        $loai_san_pham->delete();
        $arr = [
            'status' => true,
            'message' => 'Đã xóa thành công',
            'data' => []
        ];
        return response()->json($arr, 200);
    }
}
