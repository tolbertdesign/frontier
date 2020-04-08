<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laravel 7</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <script type="text/javascript">
        // window.__INITIAL_STATE__ = "addslashes(json_encode($fields))";
    </script>
    @yield('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@1.2.0/dist/tailwind.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.7.2/animate.css">
    <link rel="stylesheet" href="/css/default.css">
    <link rel="stylesheet" href="/css/fonts.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.1.0/dist/alpine.js" defer></script>
</head>

<body>
    <div id="header-wrapper">
        <div id="header" class="container">
            <div id="logo">
                <h1><a href="/examples">Examples</a></h1>
            </div>
            <div id="menu">
                <ul>
                    <li class="{{ Request::path() === '/' ? 'current_page_item' : '' }}"><a href="/" accesskey="1" title="">Homepage</a></li>
                    <li class="{{ Request::path() === 'clients' ? 'current_page_item' : '' }}"><a href="#" accesskey="2" title="">Our Clients</a></li>
                    <li class="{{ Request::path() === 'about' ? 'current_page_item' : '' }}"><a href="/about" accesskey="3" title="">About Us</a></li>
                    <li class="{{ Request::is('articles*') ? 'current_page_item' : '' }}"><a href="/articles" accesskey="4" title="">Articles</a></li>
                    <li class="{{ Request::path() === 'contact' ? 'current_page_item' : '' }}"><a href="#" accesskey="5" title="">Contact Us</a></li>
                </ul>
            </div>
        </div>
        @yield('header-featured')
    </div>
    @yield('content')

    <div id="copyright" class="container">
        <p>&copy; Untitled. All rights reserved. | Photos by <a href="siteUrl">siteName</a> | Design by <a href="designerUrl" rel="nofollow">designer</a>.</p>
    </div>
</body>

</html>
