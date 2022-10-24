<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Evertec Test</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        .links {
            text-decoration: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-center">
                <img src="https://seeklogo.com/images/E/evertec-logo-AE4A1CEE6F-seeklogo.com.png?v=637938408840000000" alt="">
                </a>
                @if (Route::has('login'))
                    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="text-md text-gray-700 dark:text-gray-500 links"
                            >
                                Resumen
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-md text-gray-700 dark:text-gray-500 links">
                                Iniciar Sesión
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </header>

    <main>
        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                    @foreach ($products as $product)

                        <div class="col">
                            <div class="card shadow-sm">
                                <img
                                    src="{{$product->url_image}}"
                                    width="100%"
                                    height="100%"
                                    alt="Imagen producto uno"
                                >
                                <div class="card-body">
                                    <p style="font-size: 25px;">
                                        <strong>
                                            <em>{{$product->name}}</em>
                                        </strong>
                                    </p>
                                    <p class="card-text"> {{$product->summary}} </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="{{ route('product.buy', $product->id) }}"
                                                type="button"
                                                class="btn btn-sm btn-outline-secondary"
                                            >
                                                Comprar
                                            </a>
                                        </div>
                                        <small class="text-muted">US $ {{$product->price}} </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <footer class="text-muted py-5">
        <div class="container">
            <p class="float-end mb-1">
                Prueba Integracion CheackOut
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>