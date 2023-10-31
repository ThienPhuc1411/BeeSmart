<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThuongHieu;
use App\Http\Resources\ThuongHieu as BrandResource;
use Validator;
use Str;

class ThuongHieuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $idCh = $request->id;
        // dd($request->id);
        $brands = ThuongHieu::where('idCh',$idCh)->get();
        $arr = [
            'status' => true,
            'message' => 'Danh sách thương hiệu',
            'data' => $brands
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
            'ten' => 'required|max:225',
            'idCh' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $arr = [
                'status' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }

        $brand = ThuongHieu::create($input);
        $arr = [
            'status' => true,
            'message' => 'Thêm thương hiệu thành công',
            'data' => new BrandResource($brand)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        $brand = ThuongHieu::find($id);
        if (is_null($brand)) {
            $arr = [
                'status' => false,
                'message' => 'Thương hiệu không tông tại',
                'data' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => 'Chi tiết thương hiệu',
            'data' => new BrandResource($brand)
        ];
        return response()->json($arr, 201);
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
    public function update(Request $request, ThuongHieu $thuong_hieu) {
        $input = $request->all();
        $validator = Validator::make($input, [
            'ten' => 'required',
            'idCh' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $arr = [
                'status' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }

        $thuong_hieu->ten = $input['ten'];
        $thuong_hieu->save();
        $arr = [
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => new BrandResource($thuong_hieu)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThuongHieu $thuong_hieu) {
        $thuong_hieu->delete();
        $arr = [
            'status' => true,
            'message' => 'Đã xóa thành công',
            'data' => []
        ];
        return response()->json($arr, 200);
    }
}
