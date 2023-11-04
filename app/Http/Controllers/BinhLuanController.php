<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BinhLuan;
use App\Http\Resources\BinhLuan as comments;
use Validator;
class BinhLuanController extends Controller
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
        //
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'noiDung' => 'required'
            ],
            [
                'required' => 'Bạn chưa nhập :attribute'
            ],
            [
                'noiDung' => 'Nội dung'
            ]
        );
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Không thể bình luận vào lúc này',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $input['ngayDang'] = date('Y-m-d');
        $cmt = BinhLuan::create($input);
        $arr = [
            'status' => true,
            'message' => "Bình luận của bạn đã được lưu lại",
            'data' => new comments($cmt)
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
