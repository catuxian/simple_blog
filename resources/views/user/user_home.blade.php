<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @if(Auth::check())
    {{ Auth::user()->name}} 已登入
    <a href="{{ route('logout')}}">登出</a>
    @endif
    <h1>會員首頁</h1>
    <a href="{{ route('friend_list') }}">好友清單</a>
    <a href="{{ route('friend_invitations') }}">好友邀請</a>
    <table>
        <tr>
            <td>標題</td>
            <td>編輯</td>
            <td>刪除</td>
        </tr>
        @foreach ($posts as $post)
        <tr>
            <td>
                {{ $post->title }}
            </td>
            <td>
                <a href="{{ route('posts.edit', ['id'=>$post->id]) }}">編輯</a>
            </td>
            <td>
                <form action="{{ route('posts.destroy', $post->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">刪除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <a href="{{route('posts.create')}}">新增資料</a>
</body>

</html>