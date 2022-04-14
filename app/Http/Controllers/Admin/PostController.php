<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//per usare funzione per lo slug
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //preleva i dati sui post
        $posts = Post::all();

        // passa dati alla vista
        return view('Admin.post.index', compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //prelevo le categorie
        $categories = Category::all();

        //prelevo i tag
        $tags = Tag::all();

        return view('Admin.post.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        //validazioni
        $request->validate(

            [
                "title" => 'required|min:2',
                "content"=> 'required|min:10',
                // accetto category_id se  esiste nella tabella categories alla colonna id
                "category_id"=>'nullable|exists:categories,id',
                // array ricevuto deve contenere valori nullable e presenti nella tabella tags alla colonna id
                "tagsId" => 'nullable|exists:tags,id',
                // validazione immagine nullable, di tipo immagine, e di dimensioni massime di 4mb, in kilobyte binary(con multipli di 24)
                'image' => 'nullable|image|max:4096'
            ]

        );

        // prelevo dati dal form
        $data = $request->all();

        //definisco lo slug - funzione laravel di STR (in alto: use Illuminate\Support\Str;)
        $slug = Str::slug($data['title']);

        //definisco funzione che fa si che lo slug non sia lo stesso se due titoli sono simili
        //imposto un counter, poi ciclo while: query sugli slug di post se trova corrispondenza fa un append allo slug del contatore, incrementa il contatore. Se non trova corrispondenza esce dal ciclo while.
        $counter = 1;

        //potrei togliere "=" e sarebbe comunque un operatore di uguaglianza
        while(Post::where('slug', '=',  $slug)->first()){

            $slug = Str::slug($data['title']) . '-' . $counter;
            $counter++;

        }

        // inserisco lo slug dentro data
        $data['slug'] = $slug;

        // le operazioni sulla immagine solo se presente
        if(isset($data['image'])){
            // storage della immagine in una path
            $imagePath = Storage::put('uploads', $data['image']);
            // il cover del db sarà dunque imagePath
            $data['cover'] = $imagePath;
        }

        //fill su post
        $post->fill($data);
        // salvo
        $post->save();

        if (isset($data['tagsId'])) {
            $post->tags()->sync($data['tagsId']);
        }


        //decido il redirect
        return redirect()->route('admin.posts.show', $post->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //prelevo timestamp attuale
        $now = Carbon::now();
        // dal DB prelevo il created_at e lo trasformo in data carbon
        $postDate = Carbon::create( $post->created_at)->format('d-m-Y');
        // differenza tra timestamp e creazione
        $daysAgo = $now->diffInDays($postDate);
        // passo alla vista
        return view ('admin.post.show', compact('post', 'postDate', 'daysAgo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //prelevo le categorie dal db
        $categories = Category::all();

        //recupero e passo i tags
        $tags = Tag::all();

        return view('admin.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // inserisco validazioni
        $request->validate(
            [
                "title" => 'required|min:2',
                "content"=> 'required|min:10',
                "category_id"=>'nullable|exists:categories,id',
                "tagsId" => 'nullable|exists:tags,id',
                "image" => 'nullable|image|max:4096'
            ]
        );
        //salvo in data il contenuto form
        $data = $request->all();

        //gestisco lo slug
        $slug = Str::slug($data['title']);

        //qualora lo slug sia diverso da quello originale del post allora eseguo il ciclo while come per store
        if($post->slug != $slug){
            $counter =1;
            while(Post::where('slug', $slug)->first()){
                $slug = Str::slug($data['title']) . "-". $counter;
                $counter++;
            };
            $data['slug']=$slug;
        }

        //se nuova immagine è stata inserita e quindi presente in $data
        if(isset($data['image'])){
            // se presente immagine precedente la cancello
            if($post->cover){
                Storage::delete($post->cover);
            }

            // poi procedo allo store della nuova immagine
            $imagePath = Storage::put('uploads', $data['image']);
            $data['cover']= $imagePath;
        }

        $post->fill($data);
        $post->save();

        //sync-> richiamo public function post sync con id dei tag presenti con lo store dentro $data
        if(isset($data['tagsId'])){
            $post->tags()->sync($data['tagsId']);
        }

        return redirect()-> route('admin.posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //elimino immagine se presente
        if($post->cover){
            Storage::delete($post->cover);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('delete', 'Eliminazione avvenuta con successo!');
    }
}
