@extends('layouts.main')

@section('title', 'Busca')

@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-md-9 offset-md-1 mb-3 mt-3">
            
            <h2 class="text-white-title">BUSCANDO POR FILMES COM TÍTULO DE "{{$search}}"</h2>
            <div class="container mt-3 h-100">
                <div class="row">
                
                    @foreach($filmes as $filme)
                    <div class="col-md-2  mb-3">
                        <div class="card zoom-card d-flex">
                            <a href="#" tooltip="tooltip" title="{{$filme['title']}}">
                                <img src="https://image.tmdb.org/t/p/w500/{{$filme['poster_path']}}" class="img-card" alt="imagem do filme {{$filme['title']}}">
                            </a>
                            <div class="card-body d-flex flex-column card-bg">
                                <ion-icon class="fa-solid fa-star" style="color: #FFD43B;"><span class="text-white">{{ number_format($filme['vote_average'], 2) }}</span></ion-icon>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="list-group">
                <span class="list-group-item list-group-item-action active">
                    Gêneros
                </span>
                @foreach($generos as $genero)
                <a href="{{url('/genero/'.$genero['id'])}}" class="list-group-item list-group-item-action list-genre">{{$genero['name']}}</a>
                @endforeach

            </div>
        </div>
    </div>
</div>




<div class="pagination-wrapper d-flex justify-content-center">
    {{ $filmes->links('pagination::bootstrap-5') }}
</div>

@endsection