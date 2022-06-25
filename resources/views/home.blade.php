<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>網站頁面</h1>
    @if(Auth::check())
    <a href="{{ route('user_home')}}">會員中心</a>
    <a href="{{ route('logout')}}">登出</a>
    @else
    <a href="{{ route('login')}}">登入</a>

    @endif
</body>
</html>