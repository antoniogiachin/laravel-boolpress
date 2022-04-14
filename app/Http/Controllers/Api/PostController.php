<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Dotenv\Result\Success;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //con chiamata al db prelevo tutti i post
        // $posts = Post::all();
        // questo non stamperebbe le categorie, ma solamente l'id di categoty, per risolvere
        $posts = Post::with(['category', 'tags'])->paginate(4);

        // prelevati i posts dentro una collectione con each li ciclo epr vedere se hanno immagine e nel caso con url li passo con chiamata api altrimenti passo immagine di placeholder
        $posts->each(function($post){
            if($post->cover){
                $post->cover = url('storage/' . $post->cover);
            } else {
                $post->cover = url('img/placeholder.png');
            }
        });


        //ritorno un json
        return response()->json(
            [
                'results' => $posts,
                'success'=> true,
            ]
        );
    }

    //funzione creazione json del singolo post
    public function show($slug){

        //singolo post
        $post = Post::where('slug', $slug)->with(['category', 'tags'])->first();

        //gestione immagine
        if ($post->cover) {
            $post->cover = url('storage/' . $post->cover);
        } else {
            $post->cover = url('img/placeholder.png');
        }
        // se il post esiste lo passo come json, altrimenti il json sarà un errore di risposta
        if($post){
            return response()->json([
                'result' => $post,
                'success' => true,
            ]);
        } else {
            return response()->json([
                'result' => 'Nessun Post trovato',
                'success'=> false,
            ]);
        }
    }


}
