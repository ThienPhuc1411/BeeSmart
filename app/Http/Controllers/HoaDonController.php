<?php

namespace App\Http\Controllers;

use App\Models\HoaDonCT;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Http\Resources\HoaDonResource;
use App\Http\Resources\HDCTResource;
use Validator;
use Carbon\Carbon;
use App\Models\CuaHang;
use App\Models\DoanhThu;
use App\Models\SanPham;

class HoaDonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (isset($request->idCh)) {
            $idCh = $request->idCh;
            $isExist = CuaHang::select('*')->where('id', $idCh)->exists();
            if ($isExist) {
                $bills = HoaDon::where('idCh', $idCh)->get();
                $arr = [
                    'status' => true,
                    'message' => 'Danh sách hóa đơn',
                    'data' => HoaDonResource::collection($bills)
                ];
            } else {
                $arr = [
                    'status' => false,
                    'message' => 'Cửa hàng không tồn tại'
                ];
            }
        } else {
            $arr = [
                'status' => false,
                'message' => 'Thiếu thông tin'
            ];
        }
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
        $hdInput['maHd'] = 'HD' . str_pad($maHd, 7, '0', STR_PAD_LEFT) . '-' . Carbon::now()->format('dmY');
        $hd = HoaDon::create($hdInput);

        $ngayTao = Carbon::now()->format("Y-m-d");
        $statistical = DoanhThu::where('ngayTao', $ngayTao)->where('idCh', $hdInput['idCh'])->first();
        if ($statistical) {
            if (is_array($input['Sp'])) {
                foreach ($input['Sp'] as $sp) {
                    $statistical->soLuong += $sp['soLuong'];
                    $hdctInput = [
                        'idSp' => $sp['idSp'],
                        'soLuong' => $sp['soLuong'],
                        'tong' => $sp['tong']
                    ];
                    $spOne = SanPham::find($sp['idSp']);
                    $von = $spOne->giaVon * $sp['soLuong'];
                    $loiNhuan = $input['tongTien'] - $von;
                    $statistical->loiNhuan += $loiNhuan;
                    $hdctInput['idHd'] = $hd->id;
                    $hdct = HoaDonCT::create($hdctInput);
                    $soLuongSp = SanPham::find($hdctInput['idSp']);
                    $soLuongSp->decrement('soLuong', $hdctInput['soLuong']);
                }
                $statistical->hoaDon += 1;
                $statistical->doanhThu += $hdInput['tongTien'];
                $statistical->save();
            } else {
                $loiNhuan = 0;
                $soLuong = 0;
                $doanhThu = 0;
                $hoaDon = 1;
                if (is_array($input['Sp'])) {
                    foreach ($input['Sp'] as $sp) {
                        $statistical->soLuong += $sp['soLuong'];
                        $hdctInput = [
                            'idSp' => $sp['idSp'],
                            'soLuong' => $sp['soLuong'],
                            'tong' => $sp['tong']
                        ];
                        $spOne = SanPham::find($sp['idSp']);
                        $von = $spOne->giaVon * $sp['soLuong'];
                        $loiNhuan = $input['tongTien'] - $von;
                        $statistical->loiNhuan += $loiNhuan;
                        $hdctInput['idHd'] = $hd->id;
                        $hdct = HoaDonCT::create($hdctInput);
                        $soLuongSp = SanPham::find($hdctInput['idSp']);
                        $soLuongSp->decrement('soLuong', $hdctInput['soLuong']);
                    }
                    $statistical->hoaDon += 1;
                    $statistical->doanhThu += $hdInput['tongTien'];
                }
                $statisticalInput = [
                    'loiNhuan' => $loiNhuan,
                    'soLuong' => $soLuong,
                    'doanhThu' => $doanhThu,
                    'hoaDon' => $hoaDon,
                    'idCh' => $input['idCh'],
                    'ngayTao' => $ngayTao
                ];
                $statistical = DoanhThu::create($statisticalInput);
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
    public function show(string $id)
    {
        $bill = HoaDon::findOrFail($id);
        $hdcts = HoaDonCT::whereBelongsTo($bill)->get();
        $arr = [
            'status' => true,
            'message' => 'Hóa đơn' . ' ' . $bill->maHd,
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
    public function update(Request $request, HoaDon $hoa_don)
    {
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
