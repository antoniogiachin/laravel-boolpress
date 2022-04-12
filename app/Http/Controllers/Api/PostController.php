<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
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
        $posts = Post::with(['category'])->paginate(4);
        

        //ritorno un json
        return response()->json(
            [
                'results' => $posts,
                'success'=> true,
            ]
        );
    }

   
}
