<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    //好友清單
    public function friend_list()
    {
        return view('friend.friend_list');
    }
    //搜尋好友
    public function search_friend()
    {

        $User = new User;
        $users = [];
        if(isset($_GET['name'])) {
            $users = $User::
                        select('users.id','users.name','friends.status','friends.friend_user_id')
                        ->leftJoin('friends', 'users.id', '=', 'friends.friend_user_id')
                        ->where('name','like',"%{$_GET['name']}%")
                        ->where('users.id','<>', Auth::user()->id)
                        ->get();
        }
        return view('friend.search_friend')->with('users', $users);
    }
    //新增好友
    public function add_friend($id)
    {
        $Friend = new Friend;

        $Friend->user_id = Auth::user()->id;
        $Friend->friend_user_id = $id;
        $Friend->status = 0;//0:已送出邀請但未確認

        $Friend->save();

        return redirect()->back();
    }
    ///取消好友邀請
    public function cancel_invitation($id)
    {

        $Friend = new Friend;

        $Friend::          
            where('friend_user_id','=', $id)
            ->where('user_id','=', Auth::user()->id)
            ->delete();

        return redirect()->back();
    }
}
