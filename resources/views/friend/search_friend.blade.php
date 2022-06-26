<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="{{ route('user_home') }}">會員中心</a>
    <form action="" method="GET">
        <label for="name">
            輸入會員名稱
        </label>
        <input type="text" name="name" id="name" value="{{ Request::get('email') }}">
        <input type="submit" value="搜尋">
    </form>
    <h2>搜尋結果</h2>
    <table>
        <tr>
            <td colspan="2">用戶</td>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>
                {{ $user->name }}
            </td>
            @if($user->status == '0')
            <td>
                <form action="{{ route('cancel_invitation', $user->friend_user_id)}}" method="post">
                    @csrf
                    <button type="submit">取消好友邀請</button>
                </form>
            </td>
            @else
            <td>
                <form action="{{ route('add_friend', $user->id)}}" method="post">
                    @csrf
                    <button type="submit">新增好友</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </table>
</body>

</html>