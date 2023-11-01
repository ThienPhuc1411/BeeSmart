<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoaiCuaHang;
use Validator;

class LoaiCuaHangController extends Controller
{
    //
    public function index()
    {
        $loaiCh = LoaiCuaHang::all();
        $title = "Loại cửa hàng";
        return view('admin.store-type.list-store-type', compact('loaiCh', 'title'));
    }

    public function store()
    {
        $title = "Thêm loại cửa hàng";
        return view('admin.store-type.add', compact('title'));
    }

    public function handleStore(Request $request)
    {
        $loaiCuaHang = new LoaiCuaHang();
        $request->validate([
            'ten' => ['required']
        ],[
            'required' => ':attribute không được để trống'
        ],[
            'ten' => 'Tên loại cửa hàng'
        ]);
        $loaiCuaHang->fill($request->all());
        $loaiCuaHang->save();
        $msg = "Đã thêm loại cửa hàng thành công";
        return redirect()->route('admin.store-type.index')->with('msg', $msg);
    }

    public function edit($id)
    {
        $loaiCh = LoaiCuaHang::find($id);
        $title = "Loại cửa hàng";
        return view('admin.store-type.edit', compact('loaiCh', 'title'));
    }

    public function update(Request $request, $id)
    {
        $loaiCh = LoaiCuaHang::find($id);
        $request->validate([
            'ten' => ['required']
        ],[
            'required' => ':attribute không được để trống'
        ],[
            'ten' => 'Tên loại cửa hàng'
        ]);
        $loaiCh->update($request->all());
        $loaiCh->save();
        $msg = "Đã cập nhật loại cửa hàng thành công";
        return redirect()->route("admin.store-type.index")->with("msg", $msg);
    }

    public function delete($id)
    {
        $loaiCh = LoaiCuaHang::find($id);
        if ($loaiCh == null) {
            $msg = 'Không thể xóa loại cửa hàng vào lúc này, vui lòng thử lại sau';
        } else {
            $loaiCh->delete();
            $msg = "Loại cửa hàng " . $loaiCh->ten . " đã được đưa vào thùng rác";
        }
        return redirect()->route('store-type.index')->with('msg', $msg);
    }

    public function trash()
    {
        $loaiCh = LoaiCuaHang::onlyTrashed()->get();
        $title = 'Thùng rác loại cửa hàng';
        return view('admin.store-type.trash-store-type', compact('loaiCh', 'title'));
    }

    public function restore($id)
    {
        $loaiCh = LoaiCuaHang::onlyTrashed()->find($id);
        if (!empty($loaiCh)) {
            $loaiCh->restore();
            $msg = 'Khôi phục loại cửa hàng thành công';
        } else {
            $msg = 'Loại cửa hàng không tồn tại';
        }
        return redirect()->route('store-type.index')->with('msg', $msg);
    }

    public function forceDelete($id)
    {
        $loaiCh = LoaiCuaHang::onlyTrashed()->find($id);
        if (!empty($loaiCh)) {
            $loaiCh->forceDelete();
            $msg = 'Xóa loại cửa hàng thành công';
        } else {
            $msg = 'Loại cửa hàng không tồn tại';
        }
        return redirect()->route('store-type.trash')->with('msg', $msg);
    }
}
