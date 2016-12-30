<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('/css/bootstrap-theme.min.css') }}" rel="stylesheet" />
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
@include('layouts.errors')
        <h1>Radiological Equipment Database</h1>
@include('layouts.sidebar')
        @yield('content')
    </div>
@include('layouts.footer')
</body>
</html>
