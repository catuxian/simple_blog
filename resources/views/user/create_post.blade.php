<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增文章</title>
</head>
<body>
    <form method="post" action="{{route('posts.store')}}">
        @csrf
        <label for="title">
            標題
        </label>
        <input type="text" name="title" id="title">
        <br>
        <label for="content">
            文章內容
        </label>
        <textarea name="content" id="content" cols="30" rows="10">

        </textarea>
        <input type="submit" value="送出">
    </form>
</body>
</html>