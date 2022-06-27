<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use App\Models\FriendInvitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{
    //好友清單
    public function friend_list()
    {   
        $Friend = new Friend;
        
        $friends = $Friend::
                        select(
                            'users.id AS user_id',
                            'users.name')
                        ->leftJoin('users', 'users.id', '=', 'friends.friend_id')
                        ->where('friends.user_id', Auth::user()->id)
                        ->get();

        return view('friend.friend_list')->with('friends', $friends);
    }
    //搜尋好友
    public function search_friend()
    {

        $User = new User;
        $users = [];
        //當前使用者id
        $user_id = Auth::user()->id;
        if(isset($_GET['name'])) {
            $users = $User::
                        select(
                            'users.id AS user_id',
                            'users.name',
                            DB::raw(" CASE
                                        WHEN (SELECT COUNT(id) FROM friend_invitations WHERE from_id = '$user_id' AND to_id = users.id) > 0 THEN 'SENDED'
                                        WHEN (SELECT COUNT(id) FROM friend_invitations WHERE to_id = '$user_id' AND from_id = users.id) > 0 THEN 'RECIEVED'
                                        WHEN (SELECT COUNT(id) FROM friends WHERE friend_id = users.id AND user_id = $user_id) > 0 THEN 'IS_FRIEND'
                                    END AS invitation_status"))
                        ->where('name','like',"%{$_GET['name']}%")
                        ->where('users.id','<>', $user_id)
                        ->get();
        }
        return view('friend.search_friend')->with('users', $users);
    }
    //好友邀請
    public function friend_invitations()
    {
        $FriendInvitation = new FriendInvitation;
        //好友邀請數
        $invitations = $FriendInvitation::
                        select(
                            'users.id AS user_id',
                            'users.name')
                        ->leftJoin('users', 'users.id', '=', 'friend_invitations.from_id')
                        ->where('friend_invitations.to_id', Auth::user()->id)
                        ->get();
        return view('friend.friend_invitations')->with('invitations', $invitations);
    }
    //新增好友
    public function add_friend($id)
    {
        $FriendInvitation = new FriendInvitation;

        $FriendInvitation->from_id = Auth::user()->id;
        $FriendInvitation->to_id = $id;

        $FriendInvitation->save();

        return redirect()->back();
    }
    //取消好友邀請
    public function cancel_invitation($to_id)
    {

        $FriendInvitation = new FriendInvitation;

        $FriendInvitation::          
            where('to_id','=', $to_id)
            ->where('from_id','=', Auth::user()->id)
            ->delete();

        return redirect()->back();
    }
    //拒絕好友邀請
    public function decline_invitation($from_id)
    {

        $FriendInvitation = new FriendInvitation;

        $FriendInvitation::          
            where('from_id','=', $from_id)
            ->where('to_id','=', Auth::user()->id)
            ->delete();

        return redirect()->back();
    }
    //接受好友邀請
    public function accept_invitation($from_id)
    {

        $FriendInvitation = new FriendInvitation;
        $Friend = new Friend;

        $FriendInvitation::          
            where('from_id','=', $from_id)
            ->where('to_id','=', Auth::user()->id)
            ->delete();

        Friend::create(['user_id' => Auth::user()->id,'friend_id' => $from_id]);
        Friend::create(['user_id' => $from_id,'friend_id' => Auth::user()->id]);

        return redirect()->back();
    }
    //刪除好友
    public function delete_friend($user_id)
    {

        $Friend = new Friend;

        $Friend::where('user_id','=', Auth::user()->id)->where('friend_id','=', $user_id)->delete();
        $Friend::where('user_id','=', $user_id)->where('friend_id','=', Auth::user()->id)->delete();
  
        return redirect()->back();
    }
}
