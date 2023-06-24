<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function newsByAuthor(Request $request, Author $author)
    {
        return $author->news()->paginate();
    }
}
