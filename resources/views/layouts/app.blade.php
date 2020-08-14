<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SERP API</title>
        <style>
         .bd-placeholder-img {
         font-size: 1.125rem;
         text-anchor: middle;
         -webkit-user-select: none;
         -moz-user-select: none;
         -ms-user-select: none;
         user-select: none;
         }
         @media (min-width: 768px) {
         .bd-placeholder-img-lg {
         font-size: 3.5rem;
         }
         }
        </style>
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   </head>
   <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                    @if(Route::currentRouteName() == 'home')
                        <a class="nav-link active" href="{{ route('home') }}">Home</a>
                    @else
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    @endif
                  </li>
                  <li class="nav-item">
                    @if(Route::currentRouteName() == 'result')
                        <a class="nav-link active" href="{{ route('result') }}">Result</a>
                    @else
                        <a class="nav-link" href="{{ route('result') }}">Result</a>
                    @endif
                  </li>
                </ul>
            </div>
        </nav>

        <div id="app">
            @yield('content')
        </div>

        <script src="{{mix('js/app.js')}}" ></script>
    </body>
 </html>
