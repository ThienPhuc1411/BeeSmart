<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index_admin(){
        return view('/admin/index');
    }
    public function tb_user(){
        return view('/admin/tb-user');
    }
    public function tb_post(){
        return view('/admin/tb-post');
    }
}
