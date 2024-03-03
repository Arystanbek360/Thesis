<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$article->title}}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 85vh">
    <h1>{{$article->title}}</h1>
    <img src="{{$article->images[0]->image}}" class="card-img-top" alt="...">
    {{--    <p>Категория: название категории</p>--}}
    <div class="col-11">
        <h2 class="mt-5">Краткое описание: {{$article->short_description}}</h2>
        <p>Описание: {{$article->description}}</p>
        <p>Автор: {{$article->author}}</p>
        <p><small class="text-muted">{{$article->published}}</small></p>
        <div>
            <!-- Заглушки для кнопок лайка и дизлайка -->
            <button type="button" class="btn btn-success">Лайк</button>
            <button type="button" class="btn btn-danger">Дизлайк</button>
        </div>
    </div>
</div>
<footer class="bg-dark text-light text-center py-3 mt-4" style="min-height: 15vh">
    Сделано Арыстанбеком
</footer>
</body>
</html>
