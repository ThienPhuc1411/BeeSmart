<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhMucTin;

class DanhMucTinController extends Controller
{
    //
    public function index()
    {
        $data = DanhMucTin::select('*')->orderBy('updated_at','desc')->get();
        $title = "Danh mục tin";
        return view("admin.loai-tin.list-post-type", compact('data', 'title'));
    }

    public function store()
    {
        $title = "Thêm Danh mục tin";
        return view('admin.loai-tin.add', compact('title'));
    }

    public function handleStore(Request $request)
    {
        $loaitin = new DanhMucTin();
        $request->validate([
            'ten' => ['required']
        ], [
            'required' => ':attribute không được để trống'
        ], [
            'ten' => 'Tên danh mục tin'
        ]);
        $loaitin->fill($request->all());
        $loaitin->save();
        $msg = "Thêm loại tin thành công";
        return redirect()->route('post-type.index')->with('msg', $msg);
    }

    public function edit($id)
    {
        $loaitin = DanhMucTin::find($id);
        if ($loaitin == null) {
            $msg = 'Tin tức không tồn tại';
            return back()->with('msg', $msg);
        } else {
            $title = "Danh mục tin";
            return view('admin.loai-tin.edit', compact('loaitin', 'title'));
        }
    }

    public function update(Request $request, $id)
    {
        $loaitin = DanhMucTin::find($id);
        $request->validate([
            'ten' => ['required']
        ], [
            'required' => ':attribute không được để trống'
        ], [
            'ten' => 'Tên Danh mục tin'
        ]);
        $loaitin->update($request->all());
        $loaitin->save();
        $msg = 'Cập nhật tin tức thành công';
        return redirect()->route('post-type.index')->with('msg', $msg);
    }

    public function delete($id)
    {
        $loaitin = DanhMucTin::find($id);
        if ($loaitin == null) {
            $msg = 'Không thể xóa danh mục tin vào lúc này, vui lòng thử lại sau';
        } else {
            $loaitin->delete();
            $msg = "Danh mục tin " . $loaitin->ten . " đã được đưa vào thùng rác";
        }
        return redirect()->route('post-type.index')->with('msg', $msg);
    }

    public function trash()
    {
        $loaitin = DanhMucTin::onlyTrashed()->get();
        $title = 'Thùng rác danh mục tin';
        return view('admin.loai-tin.trash-post-type', compact('loaitin', 'title'));
    }

    public function restore($id)
    {
        $loaitin = DanhMucTin::onlyTrashed()->find($id);
        if (!empty($loaitin)) {
            $loaitin->restore();
            $msg = 'Khôi phục Danh mục tin thành công';
        } else {
            $msg = 'Danh mục tin không tồn tại';
        }
        return redirect()->route('post-type.index')->with('msg', $msg);
    }

    public function forceDelete($id)
    {
        $loaitin = DanhMucTin::onlyTrashed()->find($id);
        if (!empty($loaitin)) {
            $loaitin->forceDelete();
            $msg = 'Xóa loại cửa hàng thành công';
        } else {
            $msg = 'Loại cửa hàng không tồn tại';
        }
        return redirect()->route('post-type.trash')->with('msg', $msg);
    }

    public function show($id)
    {
        $post = DanhMucTin::find($id);
        $post->anHien = 1;
        $post->save();
        $msg = "Đã thay đổi trạng thái bài viết";
        return redirect()->route('post-type.index')->with('msg', $msg);
    }

    public function hide($id)
    {
        $post = DanhMucTin::find($id);
        $post->anHien = 0;
        $post->save();
        $msg = "Đã thay đổi trạng thái bài viết";
        return redirect()->route('post-type.index')->with('msg', $msg);
    }
}
