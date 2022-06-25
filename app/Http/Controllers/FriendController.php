<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FriendController extends Controller
{
    //搜尋好友
    public function search_friend()
    {

        $User = new User;
        $users = [];
        if(isset($_GET['name'])) {
            $users = $User::where('name','like',"%{$_GET['name']}%")->get();
        }

        return view('friend.search_friend')->with('users', $users);
    }
    //新增好友
    public function add_friend()
    {
        echo "asdasd";
    }
}
