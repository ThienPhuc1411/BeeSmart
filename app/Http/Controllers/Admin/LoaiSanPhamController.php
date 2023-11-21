<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use Validator;

class LoaiSanPhamController extends Controller
{
    //
    public function index()
    {
        $loaiSp = LoaiSanPham::select('*')->orderBy('updated_at','desc')->get();
        $title = "Loại Sản Phẩm";
        return view('admin.product-type.list-product-type', compact('loaiSp', 'title'));
    }

    public function store()
    {
        $title = "Thêm loại sản phẩm";
        return view('admin.product-type.add', compact('title'));
    }

    public function handleStore(Request $request)
    {
        $LoaiSanPham = new LoaiSanPham();
        $request->validate([
            'ten' => ['required']
        ],[
            'required' => ':attribute không được để trống'
        ],[
            'ten' => 'Tên loại sản phẩm'
        ]);
        $LoaiSanPham->fill($request->all());
        $LoaiSanPham->save();
        $msg = "Đã thêm loại sản phẩm thành công";
        return redirect()->route('product-type.index')->with('msg', $msg);
    }

    public function edit($id)
    {
        $loaiSp = LoaiSanPham::find($id);
        $title = "Loại sản phẩm";
        return view('admin.product-type.edit', compact('loaiSp', 'title'));
    }

    public function update(Request $request, $id)
    {
        $loaiSp = LoaiSanPham::find($id);
        $request->validate([
            'ten' => ['required']
        ],[
            'required' => ':attribute không được để trống'
        ],[
            'ten' => 'Tên loại sản phẩm'
        ]);
        $loaiSp->update($request->all());
        $loaiSp->save();
        $msg = "Đã cập nhật loại sản phẩm thành công";
        return redirect()->route("product-type.index")->with("msg", $msg);
    }

    public function delete($id)
    {
        $loaiSp = LoaiSanPham::find($id);
        if ($loaiSp == null) {
            $msg = 'Không thể xóa loại sản phẩm vào lúc này, vui lòng thử lại sau';
        } else {
            $loaiSp->delete();
            $msg = "Loại sản phẩm " . $loaiSp->ten . " đã được đưa vào thùng rác";
        }
        return redirect()->route('product-type.index')->with('msg', $msg);
    }

    public function trash()
    {
        $loaiSp = LoaiSanPham::onlyTrashed()->get();
        $title = 'Thùng rác loại sản phẩm';
        return view('admin.product-type.trash-product-type', compact('loaiSp', 'title'));
    }

    public function restore($id)
    {
        $loaiSp = LoaiSanPham::onlyTrashed()->find($id);
        if (!empty($loaiSp)) {
            $loaiSp->restore();
            $msg = 'Khôi phục loại sản phẩm thành công';
        } else {
            $msg = 'Loại sản phẩm không tồn tại';
        }
        return redirect()->route('product-type.index')->with('msg', $msg);
    }

    public function forceDelete($id)
    {
        $loaiSp = LoaiSanPham::onlyTrashed()->find($id);
        if (!empty($loaiSp)) {
            $loaiSp->forceDelete();
            $msg = 'Xóa loại sản phẩm thành công';
        } else {
            $msg = 'Loại sản phẩm không tồn tại';
        }
        return redirect()->route('product-type.trash')->with('msg', $msg);
    }
}
