<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>請先驗證您的email</h1>
    @if (\Session::has('message'))
        {!! \Session::get('message') !!}
    @endif
    <form action="{{ route('verification.send')}} " method="post">
        @csrf
        <button>重寄驗證信</button>
    </form>
</body>
</html>