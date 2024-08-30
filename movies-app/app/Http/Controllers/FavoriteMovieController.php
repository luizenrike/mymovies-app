<?php

namespace App\Http\Controllers;

use App\Models\FavoriteMovie;
use App\Models\PublicFavoriteMovie;
use Exception;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class FavoriteMovieController extends Controller
{
    public function store(int $movieId, Request $request)
    {

        $user = $request->user();
        FavoriteMovie::updateOrCreate([
            'user_id' => $user->id,
            'movie_id' => $movieId
        ]);

        PublicFavoriteMovie::updateOrCreate([
            'username' => $user->name,
            'movie_id' => $movieId
        ]);

        return redirect()->back()->with('success', 'Novo filme adicionado aos favoritos!');
    }

    public function filmesFavoritos(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $user = $request->user();
        $favoriteMovies = $user->favoriteMovies;
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
                return redirect('/')->with('fail-search', 'Não foi possível encontrar um filme da sua lista de favoritos');
            }
        }

        $username = $user->name;

        return view('filmesfavoritos', [
            'filmes' => $filmes,
            'username' => $username
        ]);
    }

    public function destroy(int $movieId, Request $request)
    {
        $user = $request->user();
        try{
            FavoriteMovie::where('user_id', $user->id)->where('movie_id', $movieId)->first()->delete();
            PublicFavoriteMovie::where('username', $user->name)->where('movie_id', $movieId)->first()->delete();
            return redirect()->back()->with('success', 'Filme removido da sua lista de favoritos!');
        }catch(Exception $ex){
            return redirect()->back()->with('fail', 'Não foi possível remover o filme selecionado');
        }

    }
}
