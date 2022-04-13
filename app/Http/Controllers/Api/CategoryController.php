<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function show($id){

        //recupero la categoria
        $category = Category::where('id', $id)->with(['post'])->first();

        return response()->json(
            [
                'result' => $category,
                'success' =>true,
            ]
            );
    }
}
