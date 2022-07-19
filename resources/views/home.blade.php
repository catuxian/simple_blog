<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    <h1>檸檬留言板</h1>
    @if(Auth::check())
    <a href="{{ route('user_home')}}">會員中心</a>
    <a href="{{ route('logout')}}">登出</a>
    @endif
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>