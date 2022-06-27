<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\FriendInvitation;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $Post = new Post;
        $FriendInvitation = new FriendInvitation;
        
        //依照會員id找到對應的文章
        $posts = $Post::where('user_id', Auth::user()->id)->get();

        //好友邀請數
        $invitation_count = $FriendInvitation::where('to_id', Auth::user()->id)->count();

        return view('user.user_home')->with('posts', $posts)->with('invitation_count', $invitation_count);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create_post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $Post = new Post;
        $Post->user_id = Auth::user()->id;
        $Post->title = $input['title'];
        $Post->content = $input['content'];
 
        $Post->save();

        return redirect()->route('user_home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "顯示指定資料";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Post = new Post;
        $post_data = Post::find($id);
        
        return view('user.edit_post')->with('post', $post_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except(['_token','_method']);

        Post::where('id', $id)
                ->update([
                    'title' => $input['title'],
                    'content' => $input['content']
                ]);

        return redirect()->route('posts.edit',['id' => $id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        
        return redirect()->route('user_home');
    }
}
