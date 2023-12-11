<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>


  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  {{-- Fontawesome CDN --}}

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Usando Vite -->
  @vite(['resources/js/app.js'])

  <link rel="stylesheet" type="text/css"
    href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js">
  </script>

  <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js">
  </script>
</head>

<body>
  <div id="app">
    <div id="loading" style="display: none;">
      @include('layouts.loading')
      <!-- Includi la vista del caricamento -->
    </div>
    @include('partials._navbar')

    <main class="container">
      @yield('content')
    </main>
  </div>
  <script>
    // Mostra la pagina di caricamento durante il caricamento delle altre pagine
      document.addEventListener('DOMContentLoaded', function () {
          document.getElementById('loading').style.display = 'block';
      });

      window.onload = function () {
          document.getElementById('loading').style.display = 'none';
      };
  </script>
  @yield('modals')
  @yield('scripts')
</body>

</html>