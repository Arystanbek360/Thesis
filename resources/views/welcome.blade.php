<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Последние статьи</h1>
    <div class="row">
        @foreach($articles as $article)
            <div class="col-md-4 mb-4" id="article_id">
                <div class="card">
                    <img src="{{($article->images[0]->image)??'https://i.pcmag.com/imagery/reviews/03aizylUVApdyLAIku1AvRV-39.fit_scale.size_760x427.v1605559903.png'
}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="{{route('show',compact('article'))}}">
                            <h5 class="card-title">{{$article->title}}</h5>
                            <p class="card-text"><small class="text-muted">{{$article->published}}</small></p>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {!! $articles->links('pagination::bootstrap-4') !!}
    </div>
</div>
<footer class="bg-dark text-light text-center py-3 mt-4">
    Сделано Арыстанбеком
</footer>
</body>
</html>
