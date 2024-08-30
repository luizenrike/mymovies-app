@extends('layouts.main')

@section('title', $filme['title'])

@section('content')

<div class="col-md-12">
    <div class="container container-details">
        @if(session('success'))
        <div class="alert alert-success w-25">
            {{ session('success') }}
        </div>
        @endif
        <div class="row mt-3">
            <div class="col-md-6 justify-content-center">
                <img class="img-detail" src="https://image.tmdb.org/t/p/w500/{{$filme['poster_path']}}" alt="poster do filme {{$filme['title']}}">
                <p class="text-white-info mt-3">{{$filme['overview']}}</p>
            </div>

            <div class="col-md-6">
                <h1 class="text-white-title">ASSISTA AO TRAILER OFICIAL: </h1>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$trailer['key']}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-white-info">
                            <ul class="list-unstyled">
                                <li><ion-icon class="fa-solid fa-fire" style="color: #FFD43B;"></ion-icon> Popularidade:</li>
                                <li><ion-icon class="fa-solid fa-star" style="color: #FFD43B;"></ion-icon> Avaliação:</li>
                                <li><ion-icon class="fa-solid fa-check-to-slot" style="color: #009468;"></ion-icon> Total de Votos:</li>
                                <li><ion-icon class="fa-solid fa-clock" style="color: #f2f2f2;"></ion-icon> Duração:</li>
                            </ul>
                        </div>
                        <div class="col-md-6 text-white-info">
                            <ul class="list-unstyled">
                                <li>{{$filme['popularity']}}</li>
                                <li>{{ number_format($filme['vote_average'], 2) }}</li>
                                <li>{{$filme['vote_count']}}</li>
                                <li>{{$filme['runtime']}} minutos</li>
                            </ul>
                        </div>
                    </div>

                    @if($isFavorite == 0)
                    <form action="/favoritos/adicionar/{{$filme['id']}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container-details">
                            <button type="submit" tooltip="tooltip" title="Adicionar aos favoritos" class="btn-favorite"">
                                    <ion-icon class=" fas fa-heart"></ion-icon>
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="container-details">
                        <button tooltip="tooltip" title="Filme favorito" class="btn-favorite-add"">
                                    <ion-icon class=" fas fa-heart"></ion-icon>
                        </button>
                    </div>

                    @endif


                </div>
            </div>

        </div>
    </div>
</div>

@endsection