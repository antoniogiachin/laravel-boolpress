@extends('admin.layouts.base')

@section('content')
    <div class="container">
        <h1 class="my-3">Modifica {{ $post->title }}</h1>
        {{-- metodo POST e azione sullo store --}}
        <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">

            {{-- token sicurezza --}}
            @csrf

            {{-- method put --}}
            @method('PUT')

            {{-- titolo --}}
            {{-- Le old anche il value di base --}}
            <div class="mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
            </div>
            {{-- contenuto --}}
            <div class="mb-3">
                <div class="form-floating">
                    <textarea class="form-control" style="min-height: 250px" placeholder="Inserisci il post qui" id="content" name="content" rows="50">{{ old('content', $post->content) }}</textarea>
                    <label for="content">Post</label>
                </div>
            </div>

            {{-- select category --}}
            <div class="form-group">
                <label for="category_id">Categoria</label>
                <select class="form-select mb-3" name="category_id" id="category_id">
                    <option value=''>Seleziona la categoria</option>
                    @foreach ($categories as $category)
                        <option {{(old('category_id', $post->category_id) == $category->id) ? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            {{-- checkbox per tags, stampo una checkbox per ogni tag --}}
            @foreach ($tags as $tag )
               {{-- id, for e value impostati su $tag->id --}}
               {{-- se ho commesso un errore nella compilazione del form  gestisco old come se fosse un create -> chiedo di rendere checked solo i $tag->id presenti nell'array tagsId --}}
               @if ($errors->any())
                   <div class="form-check mb-2">
                       <input {{ in_array($tag->id, old('tagsId', [])) ? 'checked' : '' }} name="tagsId[]" class="form-check-input" type="checkbox" value="{{ $tag->id }}" id="{{ $tag->id }}">
                       <label class="form-check-label" for="{{ $tag->id }}"> {{ $tag->name }} </label>
                   </div>
               @else
                   <div class="form-check mb-2">
                       {{-- se i tags di questo post includono quelli selezionati metitli su checked --}}
                       <input {{ $post->tags->contains($tag->id) ? 'checked' : '' }} name="tagsId[]" class="form-check-input" type="checkbox" value="{{ $tag->id }}" id="{{ $tag->id }}">
                       <label class="form-check-label" for="{{ $tag->id }}"> {{ $tag->name }} </label>
                   </div>
               @endif
            @endforeach

            {{-- visualizzo immagine precedente se presente --}}
            @if($post->cover)
                <div><img src="{{ asset('storage/' . $post->cover) }}" class="img-fluid w-25" alt="{{ $post->name }}"></div>
            @endif
            {{-- upload immagine --}}
            <div class="my-4">
                <label for="image" class="h4 form-label">Carica immagine del post</label>
                <input class="form-control" type="file" id="image" name="image">
            </div>

            {{-- bottone submit --}}
            <button type="submit" class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection
