<?php

use App\Entities\Article;
use Illuminate\Support\Facades\Route;

Route::post('/login', function () {
    $email = Request::get('email');
    $password = Request::get('password');

    if (Auth::attempt([
        'email' => $email,
        'password' => $password
    ])) {
        return response()->json('', 204);
    } else {
        return response()->json([
            'error' => 'invalid_credentials'
        ], 403);
    }
});

Route::get('/examples', function () {
    return view('examples.index');
});

Route::get('/theme-switcher', function () {
    return view('examples.theme-switcher');
});

Route::get('/01-document-create-element', function () {
    return view('examples.react.01-document-create-element');
});

Route::get('/02-react-create-element', function () {
    return view('examples.react.02-react-create-element');
});


Route::get('/articles', 'ArticlesController@index');
Route::post('/articles', 'ArticlesController@store');
Route::get('/articles/create', 'ArticlesController@create');
Route::get('/articles/{article}', 'ArticlesController@show');
Route::get('/articles/{article}/edit', 'ArticlesController@edit');
Route::put('/articles/{article}', 'ArticlesController@update');

Route::get('/about', function () {
    return view('examples.laracasts.about', [
        'articles' => Article::take(3)->latest()->get()
    ]);
});

Route::get('/', function () {
    return view('examples.laracasts.index');
});
