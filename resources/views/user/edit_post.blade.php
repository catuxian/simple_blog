<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="{{route('user_home')}}">管理者首頁</a>
    <h1>編輯文章</h1>
    <form method="post" action="{{route('posts.update',['id'=>$post->id])}}">
        @csrf
        @method('PUT') 
        <label for="title">
            標題
        </label>
        <input type="text" name="title" id="title" value="{{ $post->title }}">
        <br>
        <label for="content">
            文章內容
        </label>
        <textarea name="content" id="content" cols="30" rows="10">
            {{ $post->content }}
        </textarea>
        <input type="submit" value="送出">
    </form>
</body>
</html>