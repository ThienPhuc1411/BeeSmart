<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\san_pham as san_phamResource;
use App\Models\san_pham;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class san_phamController extends Controller
{

    public function index()
    {
        $products = san_pham::all();
        $arr = [
        'status' => true,
        'message' => "Danh sách sản phẩm",
        'data'=>san_phamResource::collection($products)
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
         'giaVon' => 'required',
         'giaBan' => 'required',
          'idCh' => 'required',
          'idNcc' => 'required',
          'idDm' => 'required',
          'idTh' => 'required',
          'idLoaiSp' => 'required',
          'maSp' => 'required'
        ]);
        if($validator->fails()){
            $arr = [
            'success' => false,
            'message' => 'Lỗi kiểm tra dữ liệu',
            'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $product = san_pham::create($input);
        $arr = ['status' => true,
            'message'=>"Sản phẩm đã lưu thành công",
            'data'=> new san_phamResource($product)
        ];
        return response()->json($arr, 201);
    }



    public function show(string $id)
    {
        $product = san_pham::find($id);
        if (is_null($product)) {
            $arr = [
            'success' => false,
            'message' => 'Không có sản phẩm này',
            'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
        'status' => true,
        'message' => "Chi tiết sản phẩm ",
        'data'=> new san_phamResource($product)
        ];
        return response()->json($arr, 201);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $product=san_pham::find($id);
        $input = $request->all();
        $product->ten = $input['ten'];
        $product->giaVon = $input['giaVon'];
        $product->giaBan = $input['giaBan'];
        $product->donVi = $input['donVi'];
        $product->khuyenMai = $input['khuyenMai'];
        $product->soLuong = $input['soLuong'];
        $product->khoiLuong = $input['khoiLuong'];
        $product->anHien = $input['anHien'];
        $product->idCh = $input['idCh'];
        $product->idNcc = $input['idNcc'];
        $product->idDm = $input['idDm'];
        $product->idTh = $input['idTh'];
        $product->idLoaiSp = $input['idLoaiSp'];
        $product->maSp = $input['maSp'];

        $product->save();
        $arr = [
            'status' => true,
            'message' => 'Sản phẩm cập nhật thành công',
            'data' => new san_phamResource($product)
        ];
        return response()->json($arr, 200);
    }

    public function destroy(string $id)
    {
        $product=san_pham::find($id);
        $product->delete();
        $arr = [
            'status' => true,
            'message' =>'Sản phẩm đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
    public function sptheoDm(string $id)
    {
        // $product = san_pham::find($id);
        $product=DB::table('san_pham')->where('idDm','=',$id);
        if (is_null($product)) {
            $arr = [
            'success' => false,
            'message' => 'Không có sản phẩm này',
            'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
        'status' => true,
        'message' => "Chi tiết sản phẩm ",
        'data'=> new san_phamResource($product)
        ];
        return response()->json($arr, 201);
    }
    public function sptheoTh(string $id)
    {
        // $product = san_pham::find($id);
        $product=DB::table('san_pham')->where('idTh','=',$id);
        if (is_null($product)) {
            $arr = [
            'success' => false,
            'message' => 'Không có sản phẩm này',
            'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
        'status' => true,
        'message' => "Chi tiết sản phẩm ",
        'data'=> new san_phamResource($product)
        ];
        return response()->json($arr, 201);
    }
    public function sptheoCh(string $id)
    {
        // $product = san_pham::find($id);
        $product=DB::table('san_pham')->where('idCh','=',$id);
        if (is_null($product)) {
            $arr = [
            'success' => false,
            'message' => 'Không có sản phẩm này',
            'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
        'status' => true,
        'message' => "Chi tiết sản phẩm ",
        'data'=> new san_phamResource($product)
        ];
        return response()->json($arr, 201);
    }
    public function sptheoNcc(string $id)
    {
        // $product = san_pham::find($id);
        $product=DB::table('san_pham')->where('idNcc','=',$id);
        if (is_null($product)) {
            $arr = [
            'success' => false,
            'message' => 'Không có sản phẩm này',
            'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
        'status' => true,
        'message' => "Chi tiết sản phẩm ",
        'data'=> new san_phamResource($product)
        ];
        return response()->json($arr, 201);
    }
    public function sptheoLoaiSp(string $id)
    {
        // $product = san_pham::find($id);
        $product=DB::table('san_pham')->where('idLoaiSp','=',$id);
        if (is_null($product)) {
            $arr = [
            'success' => false,
            'message' => 'Không có sản phẩm này',
            'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
        'status' => true,
        'message' => "Chi tiết sản phẩm ",
        'data'=> new san_phamResource($product)
        ];
        return response()->json($arr, 201);
    }
    public function spSearch(string $search,$kieu_search)
    {
        // $product = san_pham::find($id);
        if($kieu_search==0)
        $product=DB::table('san_pham')
        ->where('ten','like','%'.$search.'%');

        if($kieu_search==1)
        $product->orWhere('maSp','like','%'.$search.'%');

        if($kieu_search==2){
        $product->orWhere('ten','like','%'.$search.'%');
        }

        if (is_null($product)) {
            $arr = [
            'success' => false,
            'message' => 'Không có sản phẩm ban cần tìm',
            'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
        'status' => true,
        'message' => "Danh sách sản phẩm ",
        'data'=> new san_phamResource($product)
        ];
        return response()->json($arr, 201);
    }



}
