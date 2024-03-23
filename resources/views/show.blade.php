@extends('layout')
@section('content')
    <div class="container mt-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 85vh">
        <h1 class="text-center">{{$article->title}}</h1>
        <img src="{{$article->images[0]->image}}" class="card-img-top" alt="...">
        {{--    <p>Категория: название категории</p>--}}
        <div class="col-11">
            <h2 class="mt-5">Краткое описание: {{$article->short_description}}</h2>
            <p>Описание: {{$article->description}}</p>
            <p>Автор: {{$article->author}}</p>
            <p><small class="text-muted">{{$article->published}}</small></p>
            <div>
                <button type="button" class="btn btn-success">Лайк</button>
                <button type="button" class="btn btn-danger">Дизлайк</button>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <h3 class="mt-5 mb-4 text-center">Рекомендации</h3>
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                @foreach($recomends as $key => $recomend)
                    <div class="carousel-item {{$key == 0 ? 'active' : ''}}">
                        <a href="{{ route('show', $recomend->id) }}">
                            <img
                                src="{{$recomend->images[0]->image ?? 'https://i.pcmag.com/imagery/reviews/03aizylUVApdyLAIku1AvRV-39.fit_scale.size_760x427.v1605559903.png'}}"
                                class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block bg-dark rounded-2">
                                <h6 class="fs-4">{{$recomend->title}}</h6>
                            </div>
                            <div class="carousel-caption d-block d-sm-none bg-dark rounded-2">
                                <h6 class="fs-6">{{$recomend->title}}</h6>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev btn btn-link" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
            <button class="carousel-control-next btn btn-link" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
        </div>
    </div>

@endsection
