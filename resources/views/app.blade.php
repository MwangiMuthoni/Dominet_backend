<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  
  <title>Mbitrix spa</title>

  <meta name="description" content="Mbitrix spa, building powerful applications">

  <meta property="og:title" content="Mbitrix spa">
  <meta property="og:description" content="Mbitrix spa, building powerful applications">
  <meta property="og:image" content="{{ url('img/logo.png') }}" />
  <meta property="og:url" content="{{ url('/') }}">
  <meta property="og:type" content="website">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Mbitrix spa">
  <meta name="twitter:description" content="Mbitrix spa, building powerful applications">
  <meta name="twitter:image" content="{{ url('img/logo.png') }}">

  <!-- Favicon Icons -->
  <link rel="shortcut icon" href="{{ url('img/logo.png') }}" type="image/x-icon">

  <!-- PNG Icons -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{ url('img/logo.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ url('img/logo.png') }}">

  <!-- Apple Touch Icons -->
  <link rel="apple-touch-icon" sizes="57x57" href="{{ url('img/logo.png') }}">

  <!-- Microsoft Tiles -->
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="{{ url('img/logo.png') }}">
  <meta name="theme-color" content="#ffffff">

  <!-- Manifest File -->
  <link rel="manifest" href="{{ url('site.webmanifest') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:wght@100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>

<body>
    <div id="app">
  
    </div>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>