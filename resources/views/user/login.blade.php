<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Blog Login</title>
    <style type="text/css">
        .fail {
            width: 200px;
            margin: 20px auto;
            color: red;
        }

        form {
            font-size: 16px;
            color: #999;
            font-weight: bold;
            text-align: center;
        }

        form {
            width: 160px;
            margin: 20px auto;
            padding: 10px;
            border: 1px dotted #ccc;
        }

        form input[type="text"],
        form input[type="password"] {
            margin: 2px 0 20px;
            color: #999;
            width: 90%;
        }

        form input[type="submit"] {
            width: 100%;
            height: 30px;
            color: #666;
            font-size: 16px;
        }
    </style>
</head>

<body> 
    @if ($errors->has('fail'))
    <div class="fail">{{ $errors->first('fail') }}</div>
    @endif
    <form method="POST" action="{{route('login')}}">
        @csrf
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="{{ old('email') }}">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Login">
        <a href="">忘記密碼</a>
        <a href=" {{ route('register') }}">註冊帳號</a>
    </form>
</body>

</html>