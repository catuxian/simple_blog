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
    <h1>好友邀請</h1>
    <table>
        <tr>
            <td colspan="2">用戶</td>
        </tr>
        @foreach ($invitations as $invitation)
        <tr>
            <td>
                {{ $invitation->name }}
            </td>
            <td>
                <form action="{{ route('accept_invitation', $invitation->user_id)}}" method="post">
                    @csrf
                    <button type="submit">接受好友邀請</button>
                </form>
                <form action="{{ route('decline_invitation', $invitation->user_id)}}" method="post">
                    @csrf
                    <button type="submit">拒絕</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>