<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function home() 
    {
        //找到全部文章
        return view('home');
    }
}
