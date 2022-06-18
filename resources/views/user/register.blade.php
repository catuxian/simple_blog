<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
        註冊頁面
    </h1>
    <form action="{{ route('add_account') }}" method="post" >
        @csrf
        <label for="name">姓名</label>
        <input type="text" name="name" id="name">
        <br>
        <label for="email">信箱</label>
        <input type="email" name="email" id="email">
        <br>
        <label for="password">密碼</label>
        <input type="password" name="password" id="password">
        <br>
        <label for="password_confirm">確認密碼</label>
        <input type="password" name="password_confirm" id="password_confirm">
        <br>
        <input type="submit" value="送出">
    </form>
</body>
</html>