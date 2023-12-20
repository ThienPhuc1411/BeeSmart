<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SanPham as SanPhamResource;
use App\Models\SanPham;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use app\Models\CuaHang;
use App\Models\nhaCungCap;
use Excel;
use App\Imports\products as productImport;

class SanPhamController extends Controller
{

    public function index(Request $request)
    {
        // $products = san_pham::all();

        $idCh = $request->idCh;
        $supplier = nhaCungCap::where('idCh', '=', $idCh)->get();
        $data = DB::table('san_pham')
            ->join('cua_hang', 'cua_hang.id', 'san_pham.idCh')
            ->join('dm_san_pham', 'dm_san_pham.id', 'san_pham.idDm')
            ->join('loai_san_pham', 'loai_san_pham.id', 'san_pham.idLoai')
            ->join('nha_cung_cap', 'nha_cung_cap.id', 'san_pham.idNcc')
            ->join('thuong_hieu', 'thuong_hieu.id', 'san_pham.idTh')
            ->select(
                'san_pham.*',
                'cua_hang.tenCh as tenCh',
                'dm_san_pham.ten as tenDm',
                'loai_san_pham.ten as tenLoaiSp',
                'nha_cung_cap.ten as tenNcc',
                'thuong_hieu.ten as tenTh'
            )
            ->where('san_pham.idCh', '=', $idCh)
            ->orderBy('updated_at', 'desc')
            ->get();
        $arr = [
            'status' => true,
            'message' => "Danh sách sản phẩm",
            'datalink' => $data,
            'supplier' => $supplier,
        ];
        return response()->json($arr, 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'ten' => 'required',
            'giaVon' => 'required|numeric|integer|min:0|lt:giaBan',
            'giaBan' => 'required|numeric|integer|min:0|',
            'idCh' => 'required',
            'donVi' => 'required|numeric',
            'maSp' => 'required|between:1,10'

        ], [
            'required' => ':attribute Không được để trống',
            'numeric' => ':attribute Phải là số',
            'integer' => ':attribute Phải là số nguyên ',
            // 'between'=>':attribute Phải nằm trong khoảng ',
            'min' => ':attribute Phải là số dương'
        ], [
            'ten' => 'Tên sản phẩm',
            'giaVon' => 'Giá Vốn',
            'giaBan' => 'Giá Bán',
            'idCh' => 'Cửa Hàng',
            'idNcc' => 'Nhà Cung Cấp',
            'idTh' => 'Thương Thiệu',
            'idDm' => 'Danh Mục',
            'idLoai' => 'Loại Sản Phẩm',
            'maSp' => 'Mã Sản Phẩm',
            'donVi' => 'Đơn vị tính'
        ]);

        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }

        // check khối lượng & thể tích
        if (empty($input['khoiLuong'])) {
            $input['khoiLuong'] = null;
        } else {
            $input['theTich'] = null;
        }
        //check img
        if (!empty($input['img'])) {

            $file = $request->file('img');
            $fileDestinationPath = "upload/products";
            if ($file->move($fileDestinationPath, $file->getClientOriginalName())) {
                $input['img'] = $fileDestinationPath . '/' . $file->getClientOriginalName();
            } else {
                $arr = [
                    'success' => false,
                    'message' => 'Lỗi kiểm tra dữ liệu',
                    'data' => $validator->errors()
                ];
                return response()->json($arr, 200);
            }
        }
        //check số lượng
        if (!empty($input['soLuong']) && $input['soLuong'] < 0) {
            $arr = [
                'success' => false,
                'message' => 'Số Lượng không được là số âm'
            ];
            return response()->json($arr, 200);
        }
        $loaiUser = DB::table('users')
            ->join('sub_cua_hang', 'sub_cua_hang.idUsers', 'users.id')
            ->join('cua_hang', 'cua_hang.id', 'sub_cua_hang.idCh')
            ->select('users.*')
            ->where('cua_hang.id', $request->idCh)
            ->first();
        $checkSp = DB::table('san_pham')->select('*')->where('idCh', $request->idCh)->get();
        // dd($loaiUser->loai);
        if ($loaiUser->loai == 1) {
            if (count($checkSp) >= 30) {
                $arr = [
                    'success' => false,
                    'message' => 'Số sản phẩm được thêm tối đa của tài khoản BASIC là 30'
                ];
                return response()->json($arr, 403);
            }
        } else if ($loaiUser->loai == 2) {
            dd(count($checkSp));
            if (count($checkSp) >= 60) {
                $arr = [
                    'success' => false,
                    'message' => 'Số sản phẩm được thêm tối đa của tài khoản ADVANCE là 60'
                ];
                return response()->json($arr, 403);
            }
        } else {
            $mytime = Carbon::now()->format("Y-m-d");
            $input['ngayTao'] = $mytime;
            $product = SanPham::create($input);
            $datalink = DB::table('san_pham')
                ->join('cua_hang', 'cua_hang.id', 'san_pham.idCh')
                ->join('dm_san_pham', 'dm_san_pham.id', 'san_pham.idDm')
                ->join('loai_san_pham', 'loai_san_pham.id', 'san_pham.idLoai')
                ->join('nha_cung_cap', 'nha_cung_cap.id', 'san_pham.idNcc')
                ->join('thuong_hieu', 'thuong_hieu.id', 'san_pham.idTh')
                ->where('san_pham.id', '=', $product->id)
                ->select(
                    'san_pham.*',
                    'cua_hang.tenCh as tenCh',
                    'dm_san_pham.ten as tenDm',
                    'loai_san_pham.ten as tenLoaiSp',
                    'nha_cung_cap.ten as tenNcc',
                    'thuong_hieu.ten as tenTh'
                )->orderBy('updated_at', 'desc')->get();


            $arr = [
                'status' => true,
                'message' => "Sản phẩm đã lưu thành công",
                // 'data'=>new san_phamResource($product),
                'datalink' => $datalink
            ];
            return response()->json($arr, 201);
        }
    }



    public function show(string $id)
    {
        $product = SanPham::find($id);
        if (is_null($product)) {
            $arr = [
                'success' => false,
                'message' => 'Không có sản phẩm này',
                'data' => []
            ];
            return response()->json($arr, 200);
        }
        $datalink = DB::table('san_pham')
            ->join('cua_hang', 'cua_hang.id', 'san_pham.idCh')
            ->join('dm_san_pham', 'dm_san_pham.id', 'san_pham.idDm')
            ->join('loai_san_pham', 'loai_san_pham.id', 'san_pham.idLoai')
            ->join('nha_cung_cap', 'nha_cung_cap.id', 'san_pham.idNcc')
            ->join('thuong_hieu', 'thuong_hieu.id', 'san_pham.idTh')
            ->where('san_pham.id', '=', $id)
            ->select(
                'san_pham.*',
                'cua_hang.tenCh as tenCh',
                'dm_san_pham.ten as tenDm',
                'loai_san_pham.ten as tenLoaiSp',
                'nha_cung_cap.ten as tenNcc',
                'thuong_hieu.ten as tenTh'
            )->orderBy('updated_at', 'desc')->get();
        $arr = [
            'status' => true,
            'message' => "Chi tiết sản phẩm ",
            // 'data'=> new san_phamResource($product),
            'datalink' => $datalink
        ];
        return response()->json($arr, 201);
    }

    public function edit(string $id)
    {
        $product = SanPham::find($id);
        if (is_null($product)) {
            $arr = [
                'success' => false,
                'message' => 'Không có sản phẩm này',
                'data' => []
            ];
            return response()->json($arr, 200);
        }
        $datalink = DB::table('san_pham')
            ->join('cua_hang', 'cua_hang.id', 'san_pham.idCh')
            ->join('dm_san_pham', 'dm_san_pham.id', 'san_pham.idDm')
            ->join('loai_san_pham', 'loai_san_pham.id', 'san_pham.idLoai')
            ->join('nha_cung_cap', 'nha_cung_cap.id', 'san_pham.idNcc')
            ->join('thuong_hieu', 'thuong_hieu.id', 'san_pham.idTh')
            ->where('san_pham.id', '=', $id)
            ->select(
                'san_pham.*',
                'cua_hang.tenCh as tenCh',
                'dm_san_pham.ten as tenDm',
                'loai_san_pham.ten as tenLoaiSp',
                'nha_cung_cap.ten as tenNcc',
                'thuong_hieu.ten as tenTh'
            )->orderBy('updated_at', 'desc')->get();
        $arr = [
            'status' => true,
            'message' => "Chi tiết sản phẩm ",
            // 'data'=> new san_phamResource($product),
            'datalink' => $datalink
        ];
        return response()->json($arr, 201);
    }

    public function update(Request $request, $id)
    {
        $product = SanPham::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'ten' => 'required',
            'giaVon' => 'required|numeric|integer|min:0|lt:giaBan',
            'giaBan' => 'required|numeric|integer|min:0|',
            'idCh' => 'required',
            'idNcc' => 'required',
            'idDm' => 'required',
            'idTh' => 'required',
            'idLoai' => 'required',
            'maSp' => 'required',
            'donVi' => 'required|numeric',
        ], [
            'required' => ':attribute Không được để trống',
            'numeric' => ':attribute Phải là số',
            'integer' => ':attribute Phải là số nguyên ',
            'between' => ':attribute Phải là số dương ',
            'min' => ':attribute Phải là số dương'
        ], [
            'ten' => 'Tên sản phẩm',
            'giaVon' => 'Giá Vốn',
            'giaBan' => 'Giá Bán',
            'idCh' => 'Cửa Hàng',
            'idNcc' => 'Nhà Cung Cấp',
            'idTh' => 'Thương Thiệu',
            'idDm' => 'Danh Mục',
            'idLoai' => 'Loại Sản Phẩm',
            'maSp' => 'Mã Sản Phẩm',
            'donVi' => 'Đơn vị tính'
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $product->ten = $input['ten'];
        $product->giaVon = $input['giaVon'];
        $product->giaBan = $input['giaBan'];
        $product->donVi = $input['donVi'];
        //check khối lượng & thể tích
        if (!empty($input['khoiLuong']) && !empty($input['theTich'])) {
            $arr = [
                'success' => false,
                'message' => '1 sản phẩm không thể vừa có Khối Lượng và Thể Tích',
                'data' => []
            ];
            return response()->json($arr, 200);
        }
        if (!isset($input['soLuong'])) {
            $product->soLuong = $product->soLuong + 0;
        } else {

            if ($input['soLuong'] < 0) {
                if ($product->soLuong == 0) {
                    $product->soLuong = 0;
                }
            } else {
                $product->soLuong = $input['soLuong'];
            }
        }
        $product->anHien = $input['anHien'];
        $product->idCh = $input['idCh'];
        $product->idNcc = $input['idNcc'];
        $product->idDm = $input['idDm'];
        $product->idTh = $input['idTh'];
        $product->idLoai = $input['idLoai'];
        $product->maSp = $input['maSp'];
        $mytime = Carbon::now()->format("Y-m-d");
        if (!empty($input['img'])) {
            $file = $request->file('img');
            $fileDestinationPath = "upload/products";
            if ($file->move($fileDestinationPath, $file->getClientOriginalName())) {
                $input['img'] = $fileDestinationPath . '/' . $file->getClientOriginalName();
                $product->img = $input['img'];
            } else {
                $arr = [
                    'success' => false,
                    'message' => 'Lỗi kiểm tra dữ liệu',
                    'data' => $validator->errors()
                ];
                return response()->json($arr, 200);
            }
        }
        $product->ngayTao = $mytime;
        $product->save();

        $datalink = DB::table('san_pham')
            ->join('cua_hang', 'cua_hang.id', 'san_pham.idCh')
            ->join('dm_san_pham', 'dm_san_pham.id', 'san_pham.idDm')
            ->join('loai_san_pham', 'loai_san_pham.id', 'san_pham.idLoai')
            ->join('nha_cung_cap', 'nha_cung_cap.id', 'san_pham.idNcc')
            ->join('thuong_hieu', 'thuong_hieu.id', 'san_pham.idTh')
            ->where('san_pham.id', '=', $product->id)
            ->select(
                'san_pham.*',
                'cua_hang.tenCh as tenCh',
                'dm_san_pham.ten as tenDm',
                'loai_san_pham.ten as tenLoaiSp',
                'nha_cung_cap.ten as tenNcc',
                'thuong_hieu.ten as tenTh'
            )->first();
        $arr = [
            'status' => true,
            'message' => 'Sản phẩm cập nhật thành công',
            // 'data' => new san_phamResource($product),
            'datalink' => $datalink
        ];
        return response()->json($arr, 200);
    }

    public function destroy(string $id)
    {
        $product = SanPham::find($id);
        $product->delete();
        $arr = [
            'status' => true,
            'message' => 'Sản phẩm đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }



    public function sort_search(Request $request)
    {
        $input = $request->all();
        $query = DB::table('san_pham')->select('*');
        // dd($input);
        if (!empty($input['keyword'])) {
            if (!empty($input['dm'])) {
                $query = $query->where('idDm', '=', $input['dm']);
            }
            if (!empty($input['th'])) {
                $query = $query->where('idTh', '=', $input['th']);
            }
            if (!empty($input['idCh'])) {
                $query = $query->where('idCh', '=', $input['idCh']);
            }
            if (!empty($input['ncc'])) {
                $query = $query->where('idNcc', '=', $input['ncc']);
            }
            if (!empty($input['loai'])) {
                $query = $query->where('idLoai', '=', $input['loai']);
            }
            if (!empty($input['tinhTrang'])) {
                if ($input['tinhTrang'] == 1) {
                    $query = $query->where('soLuong', 0);
                }
                if ($input['tinhTrang'] == 2) {
                    $query = $query->where('soLuong', '>', 0);
                }
            }

            $query = $query->where('ten', 'like', $input['keyword'] . '%');
        } else {
            if (!empty($input['dm'])) {
                $query = $query->where('idDm', '=', $input['dm']);
            }
            if (!empty($input['th'])) {
                $query = $query->where('idTh', '=', $input['th']);
            }
            if (!empty($input['idCh'])) {
                $query = $query->where('idCh', '=', $input['idCh']);
            }
            if (!empty($input['ncc'])) {
                $query = $query->where('idNcc', '=', $input['ncc']);
            }
            if (!empty($input['loai'])) {
                $query = $query->where('idLoai', '=', $input['loai']);
            }
            if (isset($input['tinhTrang'])) {
                if ($input['tinhTrang'] == 1) {
                    $query = $query->where('soLuong', 0);
                }
                if ($input['tinhTrang'] == 2) {
                    $query = $query->where('soLuong', '>', 0);
                }
            }
        }
        // dd($query);
        $query = $query->orderBy('updated_at', 'desc')->get();

        if (count($query) != 0) {
            $arr = [
                'status' => true,
                'message' => "Danh sách sản phẩm",
                'data' => $query
            ];
        } else {
            $arr = [
                'status' => false,
                'message' => "Không tìm được sản phẩm",
                'data' => []
            ];
        }
        return response()->json($arr, 200);
    }

    public function importExcel()
    {
        return view('admin.import-excel');
    }

    public function saveImportExcel(Request $request)
    {
        $idCh = $request->idCh;
        $checkSp = SanPham::where('idCh', $idCh)->get();
        if (count($checkSp) > 30) {
            $arr = [
                'status' => false,
                'message' => 'Trong cửa hàng đã có sản phẩm bạn không thể sử dụng chức năng này'
            ];
            return response()->json($arr, 403);
        }
        Excel::import(new productImport, $request->file);
        $sanpham = SanPham::where('idCh', '=', null)->get();
        // dd($sanpham);

        foreach ($sanpham as $item) {
            $item->idCh = $idCh;
            $item->save();
        }
        return $arr = [
            'status' => true,
            'message' => 'Thành Công'
        ];
    }

}
