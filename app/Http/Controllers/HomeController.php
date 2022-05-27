<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('id', 'DESC')->paginate(20);

        return view('home', [
            'articles' => $articles,
        ]);
    }

    public function getArticleDetails($id)
    {
        $article = Article::find($id);

        return view('details', [
            'article' => $article,
        ]);
    }

    public function getCategory($id)
    {
        $category = Category::find($id);
        $articles = Article::where('category_id', $id)->orderBy('id', 'DESC')->paginate(20);

        return view('category', [
            'category' => $category,
            'articles' => $articles,
        ]);
    }
}
