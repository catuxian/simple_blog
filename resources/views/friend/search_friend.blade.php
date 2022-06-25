<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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
            <td>用戶</td>
            <td>操作</td>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>
                {{ $user->name }}
            </td>
            <td>
                <a href="javascript:void(0)">新增好友</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>

</html>