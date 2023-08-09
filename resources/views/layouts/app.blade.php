<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
      crossorigin="anonymous">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- Only load the Slick CSS if the machine detail page is being shown
              Slick image carousel http://kenwheeler.github.io/slick/ --}}
    @if (Route::currentRouteName() == 'machines.show')
      <!-- Slick image carousel http://kenwheeler.github.io/slick/ -->
      <link
        rel="stylesheet"
        type="text/css"
        href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
      <!-- Add the slick-theme.css if you want default styling -->
      <link
        rel="stylesheet"
        type="text/css"
        href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    @endif
    <!-- Livewire CSS -->
    @livewireStyles
    <style>
     [x-cloak] { display: none !important; }
    </style>

    <!-- JQuery -->
    <script
      src="https://code.jquery.com/jquery-3.7.0.min.js"
      integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
      crossorigin="anonymous"></script>
    <script
      src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
      integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0="
      crossorigin="anonymous"></script>
    <script
      src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"
      integrity="sha256-UnTxHm+zKuDPLfufgEMnKGXDl6fEIjtM+n1Q6lL73ok="
      crossorigin="anonymous"></script>
    <!-- Bootstrap core JavaScript -->
    <!-- JavaScript Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
      crossorigin="anonymous"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Only load the Slick if the machine detail page is being shown
              Slick image carousel http://kenwheeler.github.io/slick/ --}}
    @if (Route::currentRouteName() == 'machines.show')
      <!-- Slick image carousel JS -->
      <script
        type="text/javascript"
        src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
      <script
        type="text/javascript"
        src="{{ asset('js/slick_cfg.js') }}"></script>
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
