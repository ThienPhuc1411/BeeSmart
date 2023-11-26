<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tin;
use App\Models\DanhMucTin;
use Illuminate\Support\Facades\Auth;


class TinTucController extends Controller
{
    //
    public function index()
    {
        $post = Tin::select('tin_tuc.*', 'danh_muc_tin.ten as tenDm')
            ->join('danh_muc_tin', 'danh_muc_tin.id', 'tin_tuc.idDmTin')
            ->orderBy('updated_at','desc')
            ->get();
        $title = "Tin tức";
        // dd($post);
        return view('admin.tin-tuc.list-post', compact('post', 'title'));
    }

    public function show($id)
    {
        $post = Tin::find($id);
        $post->anHien = 1;
        $post->save();
        $msg = "Đã thay đổi trạng thái bài viết";
        return redirect()->route('post.index')->with('msg', $msg);
    }

    public function hide($id)
    {
        $post = Tin::find($id);
        $post->anHien = 0;
        $post->save();
        $msg = "Đã thay đổi trạng thái bài viết";
        return redirect()->route('post.index')->with('msg', $msg);
    }

    public function update($id)
    {
        $cate = DanhMucTin::all();
        $post = Tin::find($id);
        $title = 'Cập nhật Tin';
        return view("admin.tin-tuc.edit", compact('cate', 'post', 'title'));
    }

    public function handleUpdate(Request $request, $id)
    {
        $post = Tin::find($id);
        if ($post == null) {
            return back()->with('msg', 'Liên kết không tồn tại');
        } else {
            $request->validate(
                [
                    'tieuDe' => ['required', 'unique:tin_tuc'],
                    'tomTat' => ['required'],
                    'idDmTin' => ['required'],
                    'noiDung' => ['required'],
                    'urlHinh' => ['required', 'image'],
                ],
                [
                    'required' => ':attribute không được để trống',
                    'image' => ':attribute không đúng định dạng',
                    'unique' => ':attribute đã tồn tại'
                ],
                [
                    'tieuDe' => 'Tiêu Đề Tin',
                    'tomTat' => 'Tóm tắt',
                    'idDmTin' => 'Danh mục tin',
                    'noiDung' => 'Nội dung tin',
                    'urlHinh' => 'Hình ảnh'
                ]
            );
            if ($request->hasFile('urlHinh')) {
                $file = $request->file('urlHinh');
                $fileDestinationPath = "upload/post";
                if ($file->move($fileDestinationPath, $file->getClientOriginalName())) {
                    $msg = 'Cập nhật tin thành công';
                } else {
                    $msg = 'Không upload được Ảnh';
                }
                $slug = \Str::slug($request->tieuDe);
                $post->tieuDe = $request->tieuDe;
                $post->tomTat = $request->tomTat;
                $post->noiDung = $request->noiDung;
                $post->idDmTin = $request->idDmTin;
                $post->slug = $slug;
                $post->urlHinh = $fileDestinationPath . '/' . $file->getClientOriginalName();
                $post->save();
            }else{
                $msg = 'Không có file Ảnh';
            }
            return back()->with('msg', $msg);

        }
    }

    public function add(){
        $cate = DanhMucTin::all();
        $title = "Thêm tin";
        return view("admin.tin-tuc.add", compact("cate","title"));
    }

    public function handleAdd(Request $request){
        $post = new Tin;
        $idUsers=Auth::id();
        // dd($idUsers);
        $request->validate(
            [
                'tieuDe' => ['required', 'unique:tin_tuc'],
                'tomTat' => ['required'],
                'idDmTin' => ['required'],
                'noiDung' => ['required'],
                'urlHinh' => ['required', 'image'],
            ],
            [
                'required' => ':attribute không được để trống',
                'image' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại'
            ],
            [
                'tieuDe' => 'Tiêu Đề Tin',
                'tomTat' => 'Tóm tắt',
                'idDmTin' => 'Danh mục tin',
                'noiDung' => 'Nội dung tin',
                'urlHinh' => 'Hình ảnh'
            ]
        );
        if ($request->hasFile('urlHinh')) {
            $file = $request->file('urlHinh');
            $fileDestinationPath = "upload/post";
            if ($file->move($fileDestinationPath, $file->getClientOriginalName())) {
                $msg = 'Thêm tin thành công';
            } else {
                $msg = 'Không upload được Ảnh';
            }
            $post->idUsers = $request->idUsers;
            $slug = \Str::slug($request->tieuDe);
            $post->tieuDe = $request->tieuDe;
            $post->tomTat = $request->tomTat;
            $post->noiDung = $request->noiDung;
            $post->idDmTin = $request->idDmTin;
            $post->slug= $slug;
            $post->idUsers=$idUsers;
            $post->urlHinh = $fileDestinationPath . '/' . $file->getClientOriginalName();
            $post->save();
        }else{
            $msg = 'Không có file Ảnh';
        }
        return back()->with('msg', $msg);
    }

    public function delete($id){
        $post = Tin::find($id);
        if($post == null){
            $msg = 'Không thể xóa tin vào lúc này, vui lòng thử lại sau';
        }else{
            $post ->delete();
            $msg = 'Tin đã được đưa vào thùng rác';
        }
        return redirect()->route('post.index')->with('msg', $msg);
    }

    public function trash(){
        $title = 'Thùng rác';
        $post = Tin::onlyTrashed()->orderBy('id','desc')->get();
        return view('admin.tin-tuc.trash-post',compact('post','title'));
    }

    public function forceDelete($id){
        $post = Tin::onlyTrashed()->where('id',$id)->first();
        if(!empty($post)){
            $post->forceDelete();
            $msg = 'Đã xóa tin tức thành công';
        }else{
            $msg = 'Tin tức không tồn tại';
        }
        return redirect()->route('post.trash')->with('msg', $msg);
    }

    public function restore($id){
        $post = Tin::onlyTrashed()->find($id);
        if(!empty($post)){
            $post->restore();
            $msg = 'Khôi phục tin tức thành công';
        }else{
            $msg = 'Tin tức không tồn tại';
        }
        return redirect()->route('post.trash')->with('msg', $msg);
    }
}
