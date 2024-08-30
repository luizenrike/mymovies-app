<?php

namespace App\Http\Controllers;

use App\Models\PublicFavoriteMovie;
use Illuminate\Http\Request;

class PublicFavoriteMovieController extends Controller
{
    public function getListaFavoritos(string $username){
        $client = new \GuzzleHttp\Client();
        $favoriteMovies = PublicFavoriteMovie::where('username', $username)->get(); 
        $filmes = [];

        foreach ($favoriteMovies as $filme) {
            try {
                if(!empty($favoriteMovies)){
                    $response = $client->request('GET', "https://api.themoviedb.org/3/movie/{$filme->movie_id}?language=pt-BR", [
                        'headers' => [
                            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNWJlNjQ3YTg5NjZkNzZjNzk2ZTM5NWM0ZTJiMTIyNSIsIm5iZiI6MTcyNDg3MzU2Mi45NjA3NzcsInN1YiI6IjY2Y2U1NGUwYzY4NjgxZGI0ZGEwOTI0ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.7or274I22Ko1GfvWl70PbEq1OpjQCkpvuV3mS_3mnxk',
                            'Accept' => 'application/json',
                        ],
                    ]);
                    $movieJson = json_decode($response->getBody(), true);
                    $filmes[] = $movieJson;
                }
                
            } catch (\Exception $e) {
                return redirect('/')->with('fail-search', 'Não foi possível encontrar um filme da lista de favoritos');
            }
        }

        return view('publicfilmesfavoritos', [
            'filmes' => $filmes,
            'username' => $username
        ]);
    }
}
