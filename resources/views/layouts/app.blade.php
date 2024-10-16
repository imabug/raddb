<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-icons.min.css">
    {{-- Only load the Slick CSS if the machine detail page is being shown
              Slick image carousel http://kenwheeler.github.io/slick/ --}}
    @if (Route::currentRouteName() == 'machines.show')
      <!-- Slick image carousel http://kenwheeler.github.io/slick/ -->
      <link rel="stylesheet" type="text/css" href="/css/slick.css"/>
      <!-- Add the slick-theme.css if you want default styling -->
      <link rel="stylesheet" type="text/css" href="/css/slick-theme.css"/>
    @endif
    <!-- Alpine.js -->
    <!-- <script defer type="text/javascript" src="/js/alpinejs.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
    <!-- Livewire CSS -->
    @livewireStyles
    <style>
     [x-cloak] { display: none !important; }
    </style>

    <!-- JQuery -->
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/jquery-migrate-3.5.0.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <!-- JavaScript Bundle with Popper -->
    <script src="/js/bootstrap.bundle.min.js"></script>

    {{-- Only load the Slick if the machine detail page is being shown
              Slick image carousel http://kenwheeler.github.io/slick/ --}}
    @if (Route::currentRouteName() == 'machines.show')
      <!-- Slick image carousel JS -->
      <script type="text/javascript" src="/js/slick.min.js"></script>
      <script type="text/javascript" src="/js/slick_cfg.js"></script>
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script>
     window.Laravel = <?php echo json_encode([
       'csrfToken' => csrf_token(),
     ]); ?>
    </script>
    <title>{{ config('app.name', 'Laravel') }}</title>
  </head>
  <body>
    <!-- Livewire JS -->
    @livewireScripts

    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-12">
          {{-- <x-messages.error /> --}}
          <x-messages.status />
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-md-12">
          <h1>Radiological Equipment Database</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-md-12">
          @include('layouts.sidebar')
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-md-12">
          @yield('content')
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-md-12">
          @include('layouts.footer')
        </div>
      </div>
    </div>
  </body>
</html>
