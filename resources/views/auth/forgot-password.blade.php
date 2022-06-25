<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="{{ route('login') }}"> 登入 </a>
    <h1>忘記密碼</h1>
    <form method="post" action=" {{ route('password.email') }} ">
    @csrf
    <label for="email">
        請輸入註冊時使用的email
    </label>
    <br>
    <input type="email" name="email" required>
    <input type="submit" value="送出">
    </form>
</body>

</html>