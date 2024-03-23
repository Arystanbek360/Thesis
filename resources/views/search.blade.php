@extends('layout')
@section('content')
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


    <h1 class="mb-4 text-center ">Пойск по тексту {{$search}}</h1>
    @if($articles)
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img
                            src="{{ $article->images[0]->image ?? 'https://i.pcmag.com/imagery/reviews/03aizylUVApdyLAIku1AvRV-39.fit_scale.size_760x427.v1605559903.png' }}"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="{{ route('show', compact('article')) }}"
                               style="text-decoration: none; color: inherit;">
                                <h5 class="card-title mb-3" style="min-height: 3.6rem;">{{ $article->title }}</h5>
                                <p class="card-text"
                                   style="height: 4.5rem; overflow: hidden;">{{ $article->published }}</p>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center" style="overflow-x: auto">
            {!! $articles->appends(['search' => $search])->links('pagination::bootstrap-4') !!}
        </div>
    @else
        <h2>По вашему запросу ({{$search}})ничего не найдено</h2>
    @endif
@endsection
