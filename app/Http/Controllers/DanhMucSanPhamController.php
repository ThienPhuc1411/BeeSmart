<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucSanPham;
use App\Models\SanPham;
use App\Http\Resources\DanhMucSanPham as DMSPResource;
use Validator;

class DanhMucSanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $danhmucsp = DanhMucSanPham::all();
        $arr = [
            'status' => true,
            'message' => 'Danh sách danh mục sản phẩm',
            'data' => DMSPResource::collection($danhmucsp)
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
        $danhmucsp = DanhMucSanPham::create($input);
        $arr = [
            'status' => true,
            'message' => 'Thêm danh mục sản phẩm thành công',
            'data' => new DMSPResource($danhmucsp)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $danhmucsp = DanhMucSanPham::find($id);
        if (is_null($danhmucsp)) {
            $arr = [
                'status' => false,
                'message' => 'Danh mục sản phẩm không tồn tại',
                'data' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => 'Chi tiết danh mục sản phẩm',
            'data' => new DMSPResource($danhmucsp)
            // 'data' => $danhmucsp
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
    public function update(Request $request, DanhMucSanPham $danh_muc_san_pham) {
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
        $danh_muc_san_pham->ten = $input['ten'];
        $danh_muc_san_pham->save();
        $arr = [
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => new DMSPResource($danh_muc_san_pham)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DanhMucSanPham $danh_muc_san_pham) {
        $danh_muc_san_pham->delete();
        $arr = [
            'status' => true,
            'message' => 'Đã xóa thành công',
            'data' => []
        ];
        return response()->json($arr, 200);
    }
}
