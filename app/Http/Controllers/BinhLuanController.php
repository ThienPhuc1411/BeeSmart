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
    public function index(Request $request)
    {
        //
        $idTin = $request->idTin;
        $bl = BinhLuan::where('idTin',$idTin)->where('anHien',1)->orderBy('updated_at','desc')->get();
        $arr = [
            'status' => true,
            'message' => 'Danh sách bình luận',
            'data' => $bl
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
        //
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'noiDung' => 'required',
                'hoTen' => 'required',
                'email' => 'required|email'
            ],
            [
                'required' => 'Bạn chưa nhập :attribute'
            ],
            [
                'noiDung' => 'Nội dung',
                'hoTen' => 'Tên',
                'email' => 'Địa chỉ email'
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
