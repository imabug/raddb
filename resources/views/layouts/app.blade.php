<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
        crossorigin="anonymous">
{{-- Only load the Slick and jQuery-File-Upload CSS if the machine detail page is being shown
    Slick image carousel http://kenwheeler.github.io/slick/ --}}
@if (Route::currentRouteName() == 'machines.show')
    <!-- Slick image carousel http://kenwheeler.github.io/slick/ -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css">
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css">
    <!-- jQuery-File-Upload css https://github.com/blueimp/jQuery-File-Upload -->
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{ asset('css/jquery.fileupload.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fileupload-ui.css') }}">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="{{ asset('css/jquery.fileupload-noscript.css') }}"></noscript>
    <noscript><link rel="stylesheet" href="{{ asset('css/jquery.fileupload-ui-noscript.css') }}"></noscript>
@endif
<!-- Bootstrap core JavaScript
================================================== -->
<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
<script
    src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"
    integrity="sha256-JklDYODbg0X+8sPiKkcFURb5z7RvlNMIaE3RA2z97vw="
    crossorigin="anonymous"></script>
<script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script
    src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
    crossorigin="anonymous"></script>

{{-- Only load the Slick and jQuery-File-Uploadjavascript if the machine detail page is being shown
    Slick image carousel http://kenwheeler.github.io/slick/ --}}
@if (Route::currentRouteName() == 'machines.show')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/slick_cfg.js') }}"></script>
    <!-- blueimp jQuery-File-Upload https://github.com/blueimp/jQuery-File-Upload -->
    <script src="{{ asset('js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-process.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-image.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-validate.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-main.js')}}"></script>
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
    <div class="container-fluid">
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
