<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Latest compiled and minified Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
    </style>

<!-- JQuery -->
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"></script>
    <script
      src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"
      integrity="sha256-Ap4KLoCf1rXb52q+i3p0k2vjBsmownyBTE1EqlRiMwA="
      crossorigin="anonymous"></script>
    <script
      src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
      integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
      crossorigin="anonymous"></script>
<!-- Bootstrap core JavaScript -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"></script>
<!-- Alpine.js -->
    <script
      defer
      src="https://unpkg.com/alpinejs@3.4.2/dist/cdn.min.js"></script>

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
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12">
@include('layouts.errors')
@include('layouts.messages')
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
    @livewireScripts
</body>
</html>
