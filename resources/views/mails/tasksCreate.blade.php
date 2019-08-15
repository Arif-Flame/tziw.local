<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
@if($type == "creating")
<h2>Пользователь {{$user_name}} создал новую заявку заявку!</h2>
<h3>Тема: {{$theme}}</h3>

<h3>Описание: {{$text}}</h3>
@else
    <h2>Ответ на заявку "{{$theme}}":</h2>
    <h3>Описание: {{$ansver}}</h3>
@endif
</body>
</html>
