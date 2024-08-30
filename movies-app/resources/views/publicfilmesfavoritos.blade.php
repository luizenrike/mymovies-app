@extends('layouts.main')

@section('title', 'Favoritos de '.$username)

@section('content')

<div class="container">
    <h1 class="text-white-info">Visualizando os favoritos de {{$username}}</h1>
</div>


@if(empty($filmes))
<div class="container container-details">
    <div class="alert alert-warning w-50" role="alert">Não há filmes favoritos</div>
</div>

@else
<div class="col-md-12">
    @foreach($filmes as $filme)
    <hr>
    <hr>
    <div class="container shadow-container">
        <div class="row mt-3">
            <div class="col-md-6 container-details ">
                <img class="img-detail-fav" src="https://image.tmdb.org/t/p/w500/{{$filme['poster_path']}}" alt="poster do filme {{$filme['title']}}">
                <h3 class="text-white-info mt-3">SINOPSE</h3>
                <p class="text-white-info mt-3">{{$filme['overview']}}</p>
            </div>

            <div class="col-md-6">
                <div class="container ">

                    <div class="row">
                        <div class="col-md-6 text-white-info info-favorite-container">
                            <ul class="list-unstyled">
                                <li><ion-icon class="fa-solid fa-fire" style="color: #FFD43B;"></ion-icon> Popularidade:</li>
                                <li><ion-icon class="fa-solid fa-star" style="color: #FFD43B;"></ion-icon> Avaliação:</li>
                                <li><ion-icon class="fa-solid fa-check-to-slot" style="color: #009468;"></ion-icon> Total de Votos:</li>
                                <li><ion-icon class="fa-solid fa-clock" style="color: #f2f2f2;"></ion-icon> Duração:</li>
                            </ul>
                        </div>
                        <div class="col-md-6 text-white-info info-favorite-container">
                            <ul class="list-unstyled">
                                <li>{{$filme['popularity']}}</li>
                                <li>{{ number_format($filme['vote_average'], 2) }}</li>
                                <li>{{$filme['vote_count']}}</li>
                                <li>{{$filme['runtime']}} minutos</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    @endforeach
</div>
@endif

@endsection