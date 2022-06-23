<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>重設密碼</h1>
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <label for="password">
            輸入密碼:
        </label>
        <input type="password" name="password" id="password">
        <label for="password_confirmation">
            確認密碼:
        </label>
        <input type="password" name="password_confirmation" id="password_confirmation">
        <input type="submit" value="送出">
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ Request::get('email') }}">
    </form>
</body>
</html>