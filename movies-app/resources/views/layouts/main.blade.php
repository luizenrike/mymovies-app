<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/storage/img/mymovie-icon.png">
  <title>@yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/styles.css">
</head>


<body>

  <header class="py-3 mb-3 border-bottom">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
      <div class="dropdown">
        <a href="/" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 text-white text-decoration-none dropdown-toggle" id="dropdownNavLink" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="movie-logo" src="/storage/img/mymovies.PNG" alt="">
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownNavLink">
          <li>
            <a class="dropdown-item {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}" aria-current="page">Filmes</a>
          </li>
          <li>
            <a class="dropdown-item {{ request()->is('favoritos') ? 'active' : '' }}" href="{{ url('/favoritos') }}">Favoritos</a>
          </li>
        </ul>

      </div>

      <div class="d-flex align-items-center">
        <form class="w-100 me-3" role="search" method="GET" action="/search">
          <input type="search" name="search" class="form-control" placeholder="Busque por um filme..." aria-label="Search">
        </form>

        @auth
        <div class="btn-group mb-2">
          <button type="button" class="btn bg-white dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            <i class="fa-solid fa-user me-2"></i> {{Auth::user()->name}}
          </button>
          <ul class="dropdown-menu dropdown-menu-lg-end">
            <li>
              <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="dropdown-item text-danger">Sair</button>
              </form>
            </li>
          </ul>
        </div>
        @endauth

        @guest
        <div class="dropdown">
          <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Faça seu login
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/login">Entrar</a></li>
            <li><a class="dropdown-item" href="/register">Registrar-se</a></li>
          </ul>
        </div>
        @endguest
      </div>
    </div>
  </header>


  @yield('content')

  <div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
      <p class="col-md-4 mb-0 text-white">&copy; {{date('Y')}} MyMovies</p>

      <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-light text-decoration-none">
        <svg class="bi me-2" width="40" height="32" fill="white">
          <use xlink:href="#bootstrap" />
        </svg>
      </a>

      <ul class="nav col-md-4 justify-content-end">
        <li class="nav-item"><a href="{{url('/')}}" class="nav-link px-2 text-white">Filmes</a></li>
        <li class="nav-item"><a href="{{url('/favoritos')}}" class="nav-link px-2 text-white">Favoritos</a></li>
      </ul>
    </footer>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/d306e8732a.js" crossorigin="anonymous"></script>
  <script src="/js/script.js"></script>
</body>

</html>