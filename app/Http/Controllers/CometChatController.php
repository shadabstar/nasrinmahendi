<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CometChatController extends Controller
{
    public function index(){
        return view("admin.chat");
    }

    public function index2(){
        return view("admin.chat2");
    }
}
