<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LienHe;
use App\Http\Resources\LienHeResource;
use Validator;
use Mail;
use App\Mail\LienHe as MailLienHe;

class LienHeController extends Controller
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
        $validator = validator::make($input,
        [
            'ten' => 'required|max:225',
            'email' => 'required|max:255|email',
            'sdt' => 'required|max:11|numeric',
            'diaChi' => 'required|max:255'
        ],
        [
            'required' => ':attribute không được bỏ trống',
            'max' => ':attribute không được lớn hơn :max ký tự',
            'email' => ':attribute phải là email',
            'numeric' => 'Không được có chữ trong :attribute',
        ],
        [
            'ten' => 'Tên',
            'email' => 'Email',
            'sdt' => 'Số điện thoại',
            'diaChi' => 'Địa chỉ'
        ]);
        if ($validator->fails()) {
            $arr = [
                'status' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }

        $lienHe = LienHe::create($input);
        
        $userMail = $lienHe['email'];
        // dd($userMail);
        $mailData = [
            'ten' => $lienHe['ten']
        ];
        // dd($lienHe['ten']);
        Mail::to($userMail)->send(new MailLienHe($mailData));

        $arr = [
            'status' => true,
            'message' => ['Đăng ký nhận tư vấn thành công',
                            'Đã gửi mail'],
            'data' => new LienHeResource($lienHe)
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
