<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //搜尋用戶
    public function search_user()
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

        return view('user.search_user')->with('users', $users);
    }
}
