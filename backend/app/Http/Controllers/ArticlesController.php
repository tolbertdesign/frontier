<?php

namespace App\Http\Controllers;

use App\Entities\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();

        return view('examples.laracasts.articles.index', ['articles' => $articles]);
    }

    public function show($id)
    {
        $article = Article::find($id);

        return view('examples.laracasts.articles.show', ['article' => $article]);
    }

    public function create()
    {
        return view('examples.laracasts.articles.create');
    }

    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'exceprt' => 'required',
            'body' => 'required',
        ]);
        // persist the new article
        // dump(request()->all());

        // validation

        // clean up
        $article = new Article();
        $article->title = request('title');
        $article->excerpt = request('excerpt');
        $article->body = request('body');
        $article->save();

        return redirect('/articles');
    }

    public function edit($id)
    {
        // find the article associated with the id
        $article = Article::find($id);

        return view('examples.laracasts.articles.edit', compact('article'));
    }

    public function update($id)
    {
        request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'exceprt' => 'required',
            'body' => 'required',
        ]);

        $article = Article::find($id);

        $article->title = request('title');
        $article->excerpt = request('excerpt');
        $article->body = request('body');
        $article->save();

        return redirect('/articles' . $article->id);
    }
}
