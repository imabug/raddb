<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
       href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
       integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu"
       crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet"
       href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css"
       integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ"
       crossorigin="anonymous">
{{-- Only load the Slick CSS if the machine detail page is being shown
    Slick image carousel http://kenwheeler.github.io/slick/ --}}
@if (Route::currentRouteName() == 'machines.show')
    <!-- Slick image carousel http://kenwheeler.github.io/slick/ -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css">
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css">
@endif
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
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
  integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
  crossorigin="anonymous"></script>

{{-- Only load the Slick if the machine detail page is being shown
    Slick image carousel http://kenwheeler.github.io/slick/ --}}
@if (Route::currentRouteName() == 'machines.show')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/slick_cfg.js') }}"></script>
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
</body>
</html>
