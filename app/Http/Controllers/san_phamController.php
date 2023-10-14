<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\san_pham as san_phamResource;
use App\Models\san_pham;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
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
          'idLoai' => 'required',
          'maSp' => 'required',
          'donVi'=>'required'
        ]);
        if($validator->fails()){
            $arr = [
            'success' => false,
            'message' => 'Lỗi kiểm tra dữ liệu',
            'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        if(empty($input['khoiLuong'])){
            $input['khoiLuong']=null;
        }else{
           $input['theTich']=null;
        }
        $img=$request->file('img');
        $destination=public_path('/upload');
        $ext=$img->getClientOriginalExtension();
        $fileName= Str::random(6).'_'.time().'.'.$ext;
        $img->move($destination,$fileName);
        $input['img']=$fileName;
        $mytime=Carbon::now()->format("Y-m-d");
        $input['ngayTao']=$mytime;
        $product = san_pham::create($input);

        $datalink=DB::table('san_pham')
        ->join('cua_hang','cua_hang.id','san_pham.idCh')
        ->join('dm_san_pham','dm_san_pham.id','san_pham.idDm')
        ->join('loai_san_pham','loai_san_pham.id','san_pham.idLoai')
        ->join('nha_cung_cap','nha_cung_cap.id','san_pham.idNcc')
        ->join('thuong_hieu','thuong_hieu.id','san_pham.idTh')
        ->join('loai_cua_hang','loai_cua_hang.id','cua_hang.idLoaiCh')
        ->where('san_pham.id','=',$product->id)
        ->select(
        'cua_hang.tenCh as tenCh',
        'dm_san_pham.ten as tenDm',
        'loai_san_pham.ten as tenLoaiSp',
        'nha_cung_cap.ten as tenNcc',
        'thuong_hieu.ten as tenTh',
        'loai_cua_hang.ten as tenLoaiCh'
        )->first();


        $arr = ['status' => true,
            'message'=>"Sản phẩm đã lưu thành công",
            'data'=>new san_phamResource($product),
            'datalink'=> $datalink
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
            'data' => []
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
        if(!empty($input['khoiLuong'])){
            $product->khoiLuong=$input['khoiLuong'];
         }
        if(!empty($input['theTich'])){
            $product->theTich=  $input['theTich'];
        }
        if(!empty($input['khoiLuong'])&&!empty($input['theTich'])){
            $arr = [
                'success' => false,
                'message' => '1 sản phẩm không thể vừa có Khối Lượng và Thể Tích',
                'data' => []
                ];
                return response()->json($arr, 200);


        }
        $product->soLuong = $input['soLuong'];
        $product->anHien = $input['anHien'];
        $product->idCh = $input['idCh'];
        $product->idNcc = $input['idNcc'];
        $product->idDm = $input['idDm'];
        $product->idTh = $input['idTh'];
        $product->idLoai = $input['idLoai'];
        $product->maSp = $input['maSp'];
        $mytime=Carbon::now()->format("Y-m-d");
        $img=$request->file('img');
        $destination=public_path('/upload');
        $ext=$img->getClientOriginalExtension();
        $fileName= Str::random(6).'_'.time().'.'.$ext;
        $img->move($destination,$fileName);
        $product->img=$fileName;
        $product->ngayTao=$mytime;
        $product->save();

        $datalink=DB::table('san_pham')
        ->join('cua_hang','cua_hang.id','san_pham.idCh')
        ->join('dm_san_pham','dm_san_pham.id','san_pham.idDm')
        ->join('loai_san_pham','loai_san_pham.id','san_pham.idLoai')
        ->join('nha_cung_cap','nha_cung_cap.id','san_pham.idNcc')
        ->join('thuong_hieu','thuong_hieu.id','san_pham.idTh')
        ->join('loai_cua_hang','loai_cua_hang.id','cua_hang.idLoaiCh')
        ->where('san_pham.id','=',$product->id)
        ->select(
        'cua_hang.tenCh as tenCh',
        'dm_san_pham.ten as tenDm',
        'loai_san_pham.ten as tenLoaiSp',
        'nha_cung_cap.ten as tenNcc',
        'thuong_hieu.ten as tenTh',
        'loai_cua_hang.ten as tenLoaiCh'
        )->first();
        $arr = [
            'status' => true,
            'message' => 'Sản phẩm cập nhật thành công',
            'data' => new san_phamResource($product),
            'datalink'=>$datalink
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

        $product=DB::table('san_pham')
        ->join('cua_hang','cua_hang.id','san_pham.idCh')
        ->join('dm_san_pham','dm_san_pham.id','san_pham.idDm')
        ->join('loai_san_pham','loai_san_pham.id','san_pham.idLoai')
        ->join('nha_cung_cap','nha_cung_cap.id','san_pham.idNcc')
        ->join('thuong_hieu','thuong_hieu.id','san_pham.idTh')
        ->join('loai_cua_hang','loai_cua_hang.id','cua_hang.idLoaiCh')
        // ->where('san_pham.id','=',$product->id)
        ->where('idDm','=',$id)
        ->select(
            'san_pham.*',
            'cua_hang.tenCh as tenCh',
            'dm_san_pham.ten as tenDm',
            'loai_san_pham.ten as tenLoaiSp',
            'nha_cung_cap.ten as tenNcc',
            'thuong_hieu.ten as tenTh',
            'loai_cua_hang.ten as tenLoaiCh'
            )
        ->get();
        dd($product);
        if (is_null($product)) {
            $arr = [
            'success' => false,
            'message' => 'Không có sản phẩm này',
            'data' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
        'status' => true,
        'message' => "Chi tiết sản phẩm ",
        'data'=> $product
        ];

        return response()->json($arr, 201);
    }
    public function sptheoTh(string $id)
    {

        $product=DB::table('san_pham')->where('idTh','=',$id)->get();;
        if (is_null($product)) {
            $arr = [
            'success' => false,
            'message' => 'Không có sản phẩm này',
            'data' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
        'status' => true,
        'message' => "Chi tiết sản phẩm ",
        'data'=> $product
        ];
        return response()->json($arr, 201);
    }
    public function sptheoCh(string $id)
    {

        $product=DB::table('san_pham')->where('idCh','=',$id)->get();;
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
        'data'=> $product
        ];
        return response()->json($arr, 201);
    }
    public function sptheoNcc(string $id)
    {

        $product=DB::table('san_pham')->where('idNcc','=',$id)->get();;
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
        'data'=> $product
        ];
        return response()->json($arr, 201);
    }
    public function sptheoLoaiSp(string $id)
    {

        $product=DB::table('san_pham')->where('idLoai','=',$id)->get();;
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
        'data'=> $product
        ];
        return response()->json($arr, 201);
    }
    public function spSearch(string $search,$kieu_search)
    {

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
