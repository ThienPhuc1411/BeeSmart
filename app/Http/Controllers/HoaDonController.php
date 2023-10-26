<?php

namespace App\Http\Controllers;

use App\Models\HoaDonCT;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Http\Resources\HoaDonResource;
use App\Http\Resources\HDCTResource;
use Validator;
use Carbon\Carbon;

class HoaDonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $bills = HoaDon::all();
        $arr = [
            'status' => true,
            'message' => 'Danh sách hóa đơn',
            'data' => HoaDonResource::collection($bills)
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
            'Sp' => 'required',
            'tongTien' => 'required|numeric',
            'tongGiamGia' => 'numeric',
            'idCh' => 'required'
        ]);
        if ($validator->fails()) {
            $arr = [
                'status' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }

        $hdInput = [
            'tongTien' => $input['tongTien'],
            'tongGiamGia' => $input['tongGiamGia'],
            'idCh' => $input['idCh']
        ];
        $latestId = HoaDon::latest('id')->first();
        if (!is_null($latestId)) {
            $maHd = $latestId->id + 1;
        } else {
            $maHd = 1;
        }
        $hdInput['maHd'] = 'HD'. str_pad($maHd, 7, '0', STR_PAD_LEFT). '-'. Carbon::now()->format('dmY');
        $hd = HoaDon::create($hdInput);

        if (is_array($input['Sp'])) {
            foreach ($input['Sp'] as $sp) {
                $hdctInput = [
                    'idSp' => $sp['idSp'],
                    'soLuong' => $sp['soLuong'],
                    'tong' => $sp['tong']
                ];
                $hdctInput['idHd'] = $hd->id;
                $hdct = HoaDonCT::create($hdctInput);
            }
        }
        $arr = [
            'status' => true,
            'message' => 'Hóa đơn đã tạo thành công',
            'data' => new HoaDonResource($hd)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $bill = HoaDon::findOrFail($id);
        $hdcts = HoaDonCT::whereBelongsTo($bill)->get();
        $arr = [
            'status' => true,
            'message' => 'Hóa đơn'. ' '. $bill->maHd,
            'data' => [
                new HoaDonResource($bill),
                HDCTResource::collection($hdcts)
                ]
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
    public function update(Request $request, HoaDon $hoa_don) {
        // $input = $request->all();
        // $validator = Validator::make($input, [
        //     'tongTien' => 'required|numeric',
        //     'tongGiamGia' => 'numeric',
        //     'idCh' => 'required'
        // ]);
        // if ($validator->fails()) {
        //     $arr = [
        //         'status' => false,
        //         'message' => 'Lỗi kiểm tra dữ liệu',
        //         'data' => $validator->errors()
        //     ];
        //     return response()->json($arr, 200);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
