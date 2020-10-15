<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <!--
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137369865-4"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-137369865-4');
        </script>
        -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#3490DC">
        <meta property="og:title" content="National Economy Online">
	    <meta property="og:type" content="website">
	    <meta property="og:url" content="{{ request()->fullUrl() }}">
	    <meta property="og:site_name" content="National Economy Online">
	    <meta property="og:description" content="「ナショナルエコノミー」がオンラインで遊べるWebアプリです">
		<meta property="twitter:card" content="summary">
	    <meta property="og:image" content="{{ url('/') }}/apple-touch-icon-180x180.png">
        <title>National Economy Online</title>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link rel="apple-touch-icon" type="image/png" href="/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="/icon-192x192.png">
    </head>
    <body>
        <noscript>JavaScriptを有効にしてご利用ください。</noscript>
        <div id="app"></div>
    </body>
</html>