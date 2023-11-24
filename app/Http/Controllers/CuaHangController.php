<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuaHang;
use App\Http\Resources\CuaHang as Store;
use Validator;
use Illuminate\Support\Str;
use App\Models\subCuaHang;
use Mail;
use App\Mail\TaoCuaHang;
use Auth;

class CuaHangController extends Controller
{
    // Hiển thị danh sách cửa hàng
    public function index(Request $request)
    {
        $idUser = $request->idUsers;
        // dd($request->idUsers);
        $stores = CuaHang::where('sub_cua_hang.idUsers','=',$idUser)
        ->join('sub_cua_hang','sub_cua_hang.idCh','cua_hang.id')
        ->join('users','sub_cua_hang.idUsers','users.id')
        ->select('cua_hang.*')
        ->get();
        // dd($stores);
        $arr = [
            'status' => true,
            'message' => "Danh sách cửa hàng",
            'data' => $stores
        ];
        return response()->json($arr, 200);
    }

    // Hiển thị thông tin của một cửa hàng cụ thể
    public function show($slug)
    {
        $store = CuaHang::where('slug', $slug)->first();

        if (!$store) {
            return response()->json(['message' => 'Cửa hàng không tồn tại'], 404);
        }

        return response()->json(['store' => $store], 200);
    }

    // Thêm một cửa hàng mới
    public function store(Request $request)
    {
        $input = $request->all();
        // dd($input);
        // Validate dữ liệu đầu vào
        $validatedData = Validator::make($input, [
            'tenCh' => 'required|string|max:50',
            'diaChi' => 'required|string|max:255',
            'idLoaiCh' => 'required',
        ], [
            'required' => ':attribute không được để trống',
        ], [
            'tenCh' => 'Tên cửa hàng',
            'diaChi' => 'Địa chỉ cửa hàng'
        ]);
        if ($validatedData->fails()) {
            $arr = [
                'status' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validatedData->errors()
            ];
            return response()->json($arr, 200);
        }
        // Tạo slug từ tên cửa hàng
        $slug = str::slug($input['tenCh']);
        // dd($slug);
        $input['slug'] = $slug;
        // dd($input['slug']);

        // Tạo một cửa hàng mới và lưu vào cơ sở dữ liệu
        $store = CuaHang::create($input);
        $lastId = $store->id;
        $subChInput = [
            'idUsers' => $input['idUsers'],
            'idCh' => $lastId,
        ];
        $subCh = subCuaHang::create($subChInput);


        //Gửi mail thông báo tạo cửa hàng thành công
        $userMail = Auth::email(); //temp
        $mailData = [
            'ten' => Auth::HoTen(),
            'title' => 'Đã tạo cửa hàng thành công',
            'body' => $store->tenCh,
            'slug' => $store->slug
        ];
        Mail::to($userMail)->send(new TaoCuaHang($mailData));


        $arr = [
            'status' => true,
            // 'message' => "Cửa hàng đã lưu thành công",
            'message' => [
                'Cửa hàng đã được lưu thành công',
                'Mail thông báo đã được gửi đi'
            ],
            'data' => new Store($store)
        ];
        return response()->json($arr, 201);
    }

    // Sửa thông tin của một cửa hàng
    public function update(Request $request, $id)
    {
        $input = $request->all();

        // Validate dữ liệu đầu vào
        $validator = Validator::make($input, [
            'tenCh' => 'required|string|max:50',
            'diaChi' => 'required|string|max:255',
            'Member' => 'required|boolean',
            'idLoaiCh' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ], 400); // Sử dụng 400 (Bad Request) cho lỗi kiểm tra dữ liệu không hợp lệ
        }

        $store = CuaHang::find($id);

        if (!$store) {
            return response()->json(['message' => 'Cửa hàng không tồn tại'], 404);
        }
        // Cập nhật thông tin cửa hàng
        $store->tenCh = $input['tenCh'];
        $store->diaChi = $input['diaChi'];
        $store->Member = $input['Member'];
        $store->idLoaiCh = $input['idLoaiCh'];
        $store->save();

        return response()->json([
            'status' => true,
            'message' => 'Cửa hàng cập nhật thành công',
            'data' => new Store($store)
        ], 200);
    }

    // Xóa một cửa hàng
    public function destroy($id)
    {
        $store = CuaHang::find($id);

        if (!$store) {
            return response()->json(['message' => 'Cửa hàng không tồn tại'], 404);
        }

        $store->delete();
        return response()->json(['message' => 'Xóa cửa hàng thành công'], 204);
    }
}
