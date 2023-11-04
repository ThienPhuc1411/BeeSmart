<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\nhaCungCap;
use Validator;
use App\Http\Resources\nhaCungCapResource as NCC;

class nhaCungCapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $idCh = $request->idCh;
        $ncc = nhaCungCap::where('idCh',$idCh)->get();
        $arr = [
            'status' => true,
            'message' => "Danh sách nhà cung cấp",
            'data' => $ncc
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
    public function store(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $validator = Validator::make($input, [
            'ten' => 'required',
            'diaChi' => 'required',
            'sdt' => 'required|max:11|min:10',
            'email' => 'required|unique:nha_cung_cap|email',
            'MST' => 'required',
            'idCh' => 'required'
        ], [
            'required' => 'Trường :attribute không được để trống',
            'max' => 'Trường :attribute không được hơn :max ký tự',
            'min' => 'Trường :attribute không được ít hơn :min ký tự',
            'email' => 'Trường :attribute không đúng định dạng',
            'unique' => ':attribute đã tồn tại'
        ], [
            'ten' => 'Tên nhà cung cấp',
            'diaChi' => 'Địa chỉ',
            'sdt' => 'Số điện thoại',
            'email' => 'Địa chỉ email',
            'MST' => 'Mã số thuế',
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Vui lòng kiểm tra lại thông tin đã nhập',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $ncc = nhaCungCap::create($input);
        $arr = [
            'status' => true,
            'message' => "Đã thêm nhà cung cấp mới",
            'data' => new NCC($ncc)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ncc = nhaCungCap::find($id);
        if (is_null($ncc)) {
            $arr = [
                'success' => false,
                'message' => 'Không tồn tại Nhà Cung Cấp',
                'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => "Thông tin Nhà Cung Cấp " . $ncc->ten,
            'data' => new NCC($ncc)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $ncc = nhaCungCap::find($id);
        $validator = Validator::make($input, [
            'ten' => 'required',
            'diaChi' => 'required',
            'sdt' => 'required|max:11|min:10',
            'email' => 'required|email',
            'MST' => 'required',
            'idCh' => 'required'
        ], [
            'required' => 'Trường :attribute không được để trống',
            'max' => 'Trường :attribute không được hơn :max ký tự',
            'min' => 'Trường :attribute không được ít hơn :min ký tự',
            'email' => 'Trường :attribute không đúng định dạng'
        ], [
            'ten' => 'Tên nhà cung cấp',
            'diaChi' => 'Địa chỉ',
            'sdt' => 'Số điện thoại',
            'email' => 'Địa chỉ email',
            'MST' => 'Mã số thuế',
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $ncc->ten = $input['ten'];
        $ncc->diaChi = $input['diaChi'];
        $ncc->email = $input['email'];
        $ncc->sdt = $input['sdt'];
        $ncc->MST = $input['MST'];
        $ncc->idCh = $input['idCh'];
        $ncc->save();
        // $ncc = nhaCungCap::update($input);
        $arr = [
            'status' => true,
            'message' => 'Cập nhật nhà cung cấp thành công',
            'data' => new NCC($ncc)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ncc = nhaCungCap::find($id);
        if (is_null($ncc)) {
            $arr = [
                'success' => false,
                'message' => 'Không tồn tại Nhà Cung Cấp',
                'data' => []
            ];
            return response()->json($arr, 200);
        }
        $ncc->delete();
        $arr = [
            'status' => true,
            'message' => 'Đã xóa Nhà Cung Cấp',
            'data' => [],
        ];
        return response()->json($arr, 201);
    }
}
