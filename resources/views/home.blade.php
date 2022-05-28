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
</body>
</html>