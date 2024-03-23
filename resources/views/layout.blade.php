<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 576px) {
            .d-flex.justify-content-center {
                max-width: 100vw;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">
<div style="background-color: rgba(0, 181, 204, 0.25);">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
            <div class="container-fluid d-flex">
                <a class="navbar-brand" href="{{ route('index') }}"
                   style="display: block; min-width: 50%; height: 10vh; overflow: hidden; position: relative;">
                    <div style="background-image: url('https://colab.ws/storage/images/resized/GoGAxxlmSfGaZ5TtVBz3KRV5FHrIG1w13LGYfG59_medium.webp');
                background-size: contain;
                background-repeat: no-repeat;
                width: 100%;
                height: 100%;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);">
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"
                      style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Hamburger_icon.svg/1200px-Hamburger_icon.svg.png')"></span>
                </button>
                <div class="collapse navbar-collapse col-lg-5" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                Категории
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($categories as $category)
                                    <li><a class="dropdown-item"
                                           href="{{route('category',compact('category'))}}">{{$category->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    <form action="{{route('search')}}" class="d-flex" role="search">
                        @method('GET')
                        <input name="search" class="form-control me-2" type="search" placeholder="Search"
                               aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</div>
<div class="container" style="min-height: 92vh">
    <div style="background-color: rgba(255, 165, 0, 0.25);border-radius: 2%" class="p-5">
        @yield('content')
    </div>
</div>
<footer class="bg-dark text-light text-center py-3 mt-4">
    Сделано Арыстанбеком
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
