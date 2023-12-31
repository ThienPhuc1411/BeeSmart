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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

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
                $bills = HoaDon::where('idCh', $idCh)->orderBy('created_at', 'desc')->get();
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
        $von = 0;
        if ($statistical) {
            if (is_array($input['Sp'])) {
                foreach ($input['Sp'] as $sp) {
                    $hdctInput = [
                        'idSp' => $sp['idSp'],
                        'soLuong' => $sp['soLuong'],
                        'tong' => $sp['tong']
                    ];
                    $spOne = SanPham::find($sp['idSp']);
                    // $spOne = SanPham::find($hdctInput['idSp']);
                    $von += $spOne->giaVon * $hdctInput['soLuong'];
                    $hdctInput['idHd'] = $hd->id;
                    $hdct = HoaDonCT::create($hdctInput);
                    if ($spOne->soLuong > 0) {
                        $spOne->decrement('soLuong', $hdctInput['soLuong']);
                    }
                }
                $loiNhuan = $hdInput['tongTien'] - $von;
                $statistical->loiNhuan += $loiNhuan;
                $statistical->hoaDon += 1;
                $statistical->doanhThu += $hdInput['tongTien'];
                $statistical->save();
            }
        } else {
            // $soLuongDT = 0;
            $doanhThuDT = 0;
            $hoaDonDT = 0;
            if (is_array($input['Sp'])) {
                foreach ($input['Sp'] as $sp) {
                    // $statistical->soLuong += $sp['soLuong'];
                    $hdctInput = [
                        'idSp' => $sp['idSp'],
                        'soLuong' => $sp['soLuong'],
                        'tong' => $sp['tong']
                    ];
                    $spOne = SanPham::find($sp['idSp']);
                    $von += $spOne->giaVon * $sp['soLuong'];
                    $hdctInput['idHd'] = $hd->id;
                    $hdct = HoaDonCT::create($hdctInput);
                    if ($spOne->soLuong > 0) {
                        $spOne->decrement('soLuong', $hdctInput['soLuong']);
                    }
                }
                $loiNhuan = $hdInput['tongTien'] - $von;
                $hoaDonDT += 1;

                $doanhThuDT += $hdInput['tongTien'];
            }
            $statisticalInput = [
                'loiNhuan' => $loiNhuan,
                'doanhThu' => $doanhThuDT,
                'hoaDon' => $hoaDonDT,
                'idCh' => $input['idCh'],
                'ngayTao' => $ngayTao
            ];
            $statistical = DoanhThu::create($statisticalInput);
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

    public function viewPDF(Request $request)
    {
        $idCh = $request->idCh;
        // $idCh = 4;
        $cuaHang = CuaHang::find($idCh);
        $hoadon = HoaDon::where('idCh', $idCh)->get();

        $pdf = Pdf::loadHTML(view('pdf.hoadon', compact('hoadon', 'cuaHang'))->render());
        return $pdf->stream('PDF');

        // return view('pdf.hoadon',compact('hoadon','cuaHang'));
    }

    public function downloadPDF(Request $request)
    {
        $idCh = $request->idCh;
        // $idCh = 4;
        $userRole = User::join('sub_cua_hang', 'sub_cua_hang.idUsers', 'users.id')
            ->join('cua_hang', 'sub_cua_hang.idCh', 'cua_hang.id')
            ->where('idCh', $idCh)
            ->select('users.loai')
            ->first();
        // dd($userRole->loai);
        if ($userRole->loai != 1) {
            $cuaHang = CuaHang::find($idCh);
            // dd($request->all());
            $hoadon = HoaDon::where('idCh', $idCh);
            // if(isset($request->type)){
            //     if($request->type == 'theo-ngay'){
            //         $hoadon = $hoadon->where('DAY(created_at)',date('d'));
            //     }
            //     if($request->type == 'theo-thang'){
            //         $hoadon = $hoadon->where('MONTH(created_at)',$request->day);
            //     }
            // }
            if (!empty($request->startDate)) {
                if (!empty($request->endDate)) {
                    $start = $request->startDate;
                    $end = $request->endDate;
                    $start = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
                    $end = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();
                    $hoadon = $hoadon->whereBetween('created_at', [$start, $end])->orderBy('created_at','desc')->get();
                }
                else{
                    $start = $request->startDate;
                    // dd($start);
                    $start = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
                    $hoadon = $hoadon->where('created_at', $start)->orderBy('created_at','desc')->get();
                }
            } else {
                $hoadon = $hoadon->orderBy('created_at','desc')->get();
            }

            // dd($endDate);
            // dd($hoadon);
            $pdf = Pdf::loadView('pdf.hoadon', compact('hoadon', 'cuaHang'));
            return $pdf->download();
        } else {
            $arr = [
                'status' => false,
                'message' => 'Tài khoản của bạn không đủ để thực hiện chức năng này'
            ];
            return response()->json($arr, 200);
        }

    }
}
