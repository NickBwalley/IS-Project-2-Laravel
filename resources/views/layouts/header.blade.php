<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kinyanjui"s Farm') }}</title>

     <!-- Styles -->
     <link rel="stylesheet" href="{{ URL::to('assets/css/styleindex.css')}}" type="text/css">


     {{-- content of the header --}}
  </head>
<body>
      <header>
        <nav>
          <h1>Kinyanjui Farm.</h1>
          <ul id="navli">
            <li><a class="homered" href="index.html">HOME</a></li>
            <li><a class="homeblack" href="#">ABOUT US</a></li>
            <li><a class="homeblack" href="contact.html">CONTACT</a></li>
            <li><a class="homeblack" href="{{ route('login') }}">LOG IN</a></li>
          </ul>
        </nav>
      </header>

</body>
@yield('content')
</html>

