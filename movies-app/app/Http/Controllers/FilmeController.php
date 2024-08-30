<?php

namespace App\Http\Controllers;

use App\Models\FavoriteMovie;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Empty_;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class FilmeController extends Controller
{
    public function index(Request $request): View
    {
        $client = new \GuzzleHttp\Client();
        $cacheTime = 30;

        $filmesPopulares = Cache::remember('filmes_populares', $cacheTime, function () {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/popular?language=pt-BR&page=1', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNWJlNjQ3YTg5NjZkNzZjNzk2ZTM5NWM0ZTJiMTIyNSIsIm5iZiI6MTcyNDg3MzU2Mi45NjA3NzcsInN1YiI6IjY2Y2U1NGUwYzY4NjgxZGI0ZGEwOTI0ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.7or274I22Ko1GfvWl70PbEq1OpjQCkpvuV3mS_3mnxk',
                    'accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        });

        $filmesTopRated = Cache::remember('filmes_top_rated', $cacheTime, function () {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/top_rated?language=pt-BR&page=1', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNWJlNjQ3YTg5NjZkNzZjNzk2ZTM5NWM0ZTJiMTIyNSIsIm5iZiI6MTcyNDg3MzU2Mi45NjA3NzcsInN1YiI6IjY2Y2U1NGUwYzY4NjgxZGI0ZGEwOTI0ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.7or274I22Ko1GfvWl70PbEq1OpjQCkpvuV3mS_3mnxk',
                    'accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        });

        $generosFilmes = Cache::remember('generos', $cacheTime, function () {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list?language=pt-BR', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNWJlNjQ3YTg5NjZkNzZjNzk2ZTM5NWM0ZTJiMTIyNSIsIm5iZiI6MTcyNDg3MzU2Mi45NjA3NzcsInN1YiI6IjY2Y2U1NGUwYzY4NjgxZGI0ZGEwOTI0ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.7or274I22Ko1GfvWl70PbEq1OpjQCkpvuV3mS_3mnxk',
                    'accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        });

        $page = $request->input('page', 1);
        $perPage = 10;

        $response = $client->request('GET', "https://api.themoviedb.org/3/discover/movie?include_adult=false&include_video=false&language=pt-BR&page={$page}&sort_by=popularity.desc", [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNWJlNjQ3YTg5NjZkNzZjNzk2ZTM5NWM0ZTJiMTIyNSIsIm5iZiI6MTcyNDg3MzU2Mi45NjA3NzcsInN1YiI6IjY2Y2U1NGUwYzY4NjgxZGI0ZGEwOTI0ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.7or274I22Ko1GfvWl70PbEq1OpjQCkpvuV3mS_3mnxk',
                'accept' => 'application/json',
            ],
        ]);

        $filmes = json_decode($response->getBody(), true);
        $filmesPaginados = $filmes['results'];

        $filmesPaginados = new LengthAwarePaginator(
            $filmesPaginados,
            $filmes['total_results'],
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $filmesPopularesTop10 = array_slice($filmesPopulares['results'], 0, 10);
        $filmesTop10Rated = array_slice($filmesTopRated['results'], 0, 10);
        $generos = $generosFilmes['genres'];

        return view('index', [
            'filmesPopulares' => $filmesPopularesTop10,
            'filmesTopRated' => $filmesTop10Rated,
            'filmesPaginados' => $filmesPaginados,
            'generos' => $generos
        ]);
    }

    public function filmesPorGenero(int $idGenero, Request $request)
    {
        $cacheTime = 30;
        $page = $request->input('page', 1);
        $perPage = 10;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', "https://api.themoviedb.org/3/discover/movie?api_key=a5be647a8966d76c796e395c4e2b1225&with_genres={$idGenero}&language=pt-BR&page={$page}", [
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNWJlNjQ3YTg5NjZkNzZjNzk2ZTM5NWM0ZTJiMTIyNSIsIm5iZiI6MTcyNDg3MzU2Mi45NjA3NzcsInN1YiI6IjY2Y2U1NGUwYzY4NjgxZGI0ZGEwOTI0ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.7or274I22Ko1GfvWl70PbEq1OpjQCkpvuV3mS_3mnxk',
                'accept' => 'application/json',
            ],
        ]);

        $generosFilmes = Cache::remember('generos', $cacheTime, function () {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list?language=pt-BR', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNWJlNjQ3YTg5NjZkNzZjNzk2ZTM5NWM0ZTJiMTIyNSIsIm5iZiI6MTcyNDg3MzU2Mi45NjA3NzcsInN1YiI6IjY2Y2U1NGUwYzY4NjgxZGI0ZGEwOTI0ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.7or274I22Ko1GfvWl70PbEq1OpjQCkpvuV3mS_3mnxk',
                    'accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        });


        $jsonFilmes = json_decode($response->getBody(), true);
        $filmes = $jsonFilmes['results'];
        $filmes = new LengthAwarePaginator(
            $filmes,
            $jsonFilmes['total_results'],
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $generos = collect($generosFilmes['genres']);
        $generoAtual = $generos->firstWhere('id', $idGenero);

        if (empty($generoAtual)) {
            return redirect('/')->with('fail-search', 'Não foi possível encontrar filmes com o gênero repassado');
        }


        return view('filmesgenero', [
            'filmes' => $filmes,
            'generos' => $generos,
            'genero' => $generoAtual['name']
        ]);
    }

    public function filmesSearch(Request $request)
    {
        $cacheTime = 30;
        $page = $request->input('page', 1);
        $perPage = 10;
        $search = $request->input('search');
        $query = urlencode($search);

        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', "https://api.themoviedb.org/3/search/movie?api_key=a5be647a8966d76c796e395c4e2b1225&query={$query}&language=pt-BR&page={$page}");

        $generosFilmes = Cache::remember('generos', $cacheTime, function () use ($client) {
            $response = $client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list?language=pt-BR', [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNWJlNjQ3YTg5NjZkNzZjNzk2ZTM5NWM0ZTJiMTIyNSIsIm5iZiI6MTcyNDg3MzU2Mi45NjA3NzcsInN1YiI6IjY2Y2U1NGUwYzY4NjgxZGI0ZGEwOTI0ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.7or274I22Ko1GfvWl70PbEq1OpjQCkpvuV3mS_3mnxk',
                    'accept' => 'application/json',
                ],
            ]);
            return json_decode($response->getBody(), true);
        });


        $jsonFilmes = json_decode($response->getBody(), true);
        $filmes = $jsonFilmes['results'];
        $totalResults = $jsonFilmes['total_results'];

        $filmes = new LengthAwarePaginator(
            $filmes,
            $totalResults,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $generos = $generosFilmes['genres'];

        return view('filmessearch', [
            'filmes' => $filmes,
            'generos' => $generos,
            'search' => $search
        ]);
    }

    public function filmeDetails(int $id, Request $request){
        $client = new \GuzzleHttp\Client();

        $user = $request->user();

        $isFavorite = null;
        if($user){
            $isFavorite = FavoriteMovie::where('user_id', $user->id)
                               ->where('movie_id', $id)
                               ->first();
        }

        $favoriteMovieUser = 0;

        if($isFavorite != null)
            $favoriteMovieUser = 1;


        try{
            $response = $client->request('GET', "https://api.themoviedb.org/3/movie/{$id}?language=pt-BR", [
                'headers' => [
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNWJlNjQ3YTg5NjZkNzZjNzk2ZTM5NWM0ZTJiMTIyNSIsIm5iZiI6MTcyNDg3MzU2Mi45NjA3NzcsInN1YiI6IjY2Y2U1NGUwYzY4NjgxZGI0ZGEwOTI0ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.7or274I22Ko1GfvWl70PbEq1OpjQCkpvuV3mS_3mnxk',
                    'accept' => 'application/json',
                ],
            ]);

            $responseTrailer = $client->request('GET', "https://api.themoviedb.org/3/movie/{$id}/videos?language=pt-BR", [
                'headers' => [
                  'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNWJlNjQ3YTg5NjZkNzZjNzk2ZTM5NWM0ZTJiMTIyNSIsIm5iZiI6MTcyNDg3MzU2Mi45NjA3NzcsInN1YiI6IjY2Y2U1NGUwYzY4NjgxZGI0ZGEwOTI0ZCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.7or274I22Ko1GfvWl70PbEq1OpjQCkpvuV3mS_3mnxk',
                  'accept' => 'application/json',
                ],
              ]);

            $trailerJson = json_decode($responseTrailer->getBody(), true);
            $filme = json_decode($response->getBody(), true);

            $trailers = $trailerJson['results'];
            if(!empty($trailers))
                $trailer = $trailers[0];
            else
                $trailer = ['key' => "notfound"];

            

            return view('filmedetalhe', [
                'filme' => $filme,
                'trailer' => $trailer,
                'isFavorite' => $favoriteMovieUser
            ]);



        }catch(RequestException $ex){
            if($ex->getResponse()->getStatusCode() == 400){
                abort(404);
            }else{
                return redirect('/')->with('fail-search', 'Não foi possível encontrar filme');
            }
        }

    }
}
