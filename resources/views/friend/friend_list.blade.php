<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>好友清單</h1>
    <a href="{{ route('search_friend') }}">新增好友</a>
    <table>
        <tr>
            <td colspan="2">用戶</td>
        </tr>
        @foreach ($friends as $friend)
        <tr>
            <td>
                {{ $friend->name }}
            </td>
            <td>
            <form action="{{ route('delete_friend', $friend->user_id)}}" method="post">
                    @csrf
                    <button type="submit">刪除好友</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>