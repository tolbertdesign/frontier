@extends('layouts.default')

@section('content')

<div id="wrapper">
    <div id="page" class="container">
        <div id="content">
            <div class="title">
                <h2>{{ $article->title }}</h2>
            </div>
            <p>
                <img src="/img/banner.jpg" alt="" class="image image-full" />
            </p>
            {{ $article->body }}
        </div>
    </div>
</div>
@endsection
