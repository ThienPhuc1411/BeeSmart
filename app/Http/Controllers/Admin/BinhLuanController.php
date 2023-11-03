<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BinhLuan;

class BinhLuanController extends Controller
{
    //
    public function index(){
        $binhLuan = BinhLuan::select('binh_luan.*','tin_tuc.tieuDe as tenTin')
        ->join('tin_tuc','tin_tuc.id','binh_luan.idTin')
        ->orderBy('ngayDang','desc')
        ->get();
        $title = 'Danh sách bình luận';
        return view('admin.binh-luan.list-cmt',compact('binhLuan','title'));
    }

    public function approve($id){
        $binhLuan = BinhLuan::find($id);
        $binhLuan->anHien = 1;
        $binhLuan->save();
        $msg = 'Đã duyệt bình luận';
        return redirect()->back()->with('msg',$msg);
    }

    public function delete($id){
        $binhLuan = BinhLuan::find($id);
        if($binhLuan == null){
            $msg = 'Không thể xóa bình luận vào lúc này';
        }else{
            $binhLuan ->delete();
            $msg = 'Tin đã được đưa vào thùng rác';
        }
        return redirect()->route('cmt.index')->with('msg',$msg);
    }

    public function trash(){
        $title = 'Thùng rác';
        $binhLuan = BinhLuan::onlyTrashed()
        ->select('binh_luan.*','tin_tuc.tieuDe as tenTin')
        ->join('tin_tuc','tin_tuc.id','binh_luan.idTin')
        ->orderBy('ngayDang','desc')
        ->get();
        return view('admin.binh-luan.trash-cmt',compact('binhLuan','title'));
    }

    public function forceDelete($id){
        $binhLuan = BinhLuan::onlyTrashed()->where('id',$id)->first();
        if(!empty($binhLuan)){
            $binhLuan->forceDelete();
            $msg = 'Đã xóa bình luận thành công';
        }else{
            $msg = 'Bình luận không tồn tại';
        }
        return redirect()->route('binh-luan.trash')->with('msg', $msg);
    }
    
    public function restore($id){
        $binhLuan = BinhLuan::onlyTrashed()->find($id);
        if(!empty($binhLuan)){
            $binhLuan->restore();
            $msg = 'Khôi phục bình luận thành công';
        }else{
            $msg = 'Bình luận không tồn tại';
        }
        return redirect()->route('binh-luan.trash')->with('msg', $msg);
    }
}
