@extends('layouts.main')

@section('title', 'Meus Favoritos')

@section('content')

<div class="container">
        <ion-icon class="fa-solid fa-share bottom-right-icon" title="Compartilhar lista" onclick="copyToClipboard('{{$username}}')"></ion-icon>
</div>



@if(session('success'))
<div class="alert alert-success w-50" role="alert">{{ session('success') }}</div>
@endif

@if(session('fail'))
<div class="alert alert-danger w-50" role="alert">{{ session('fail') }}</div>
@endif

@if(empty($filmes))
<div class="container container-details">
    <div class="alert alert-warning w-50" role="alert">Você não possui filmes favoritos</div>
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

                        <div class="icon-container">
                            <form action="/favoritos/deletar/{{$filme['id']}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link no-border" tooltip="tooltip" title="Remover filme dos favoritos">
                                    <ion-icon class="fa-solid fa-trash trash-icon" style="color: #adb5bd;"></ion-icon>
                                </button>
                            </form>
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