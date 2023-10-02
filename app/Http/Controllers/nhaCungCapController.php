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
    public function index()
    {
        //
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
        $validator = Validator::make($input, [
            'ten' => 'required',
            'diaChi' => 'required',
            'sdt' => 'required|max:11|min:10',
            'email' => 'required|unique:email',
            'MST' => 'required',

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
        //
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
    public function update(Request $request, nhaCungCap $ncc)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required'
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $ncc->name = $input['name'];
        $ncc->price = $input['price'];
        $ncc->save();
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
        //
    }
}
