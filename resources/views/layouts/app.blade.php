<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet" />
    <title>Radiological Equipment Database</title>
</head>
<body>
@if (count($errors) > 0)
	<div class="text-warning">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

    <div class="container">
        <h1>Radiological Equipment Database</h1>
        <nav class="navbar navbar-default navbar-static-top">
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav nav-tabs">
                    <li class="active"><a href="/">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dashboards<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>Survey status</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Machines<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/machines/create">New machine</a></li>
                            <li>Modify machine</li>
                            <li>Add op note</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Surveys<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/surveys/create">Add survey</a></li>
                            <li><a href="/recommendations/create">Add survey recommendation</a></li>
                            <li>Add service report</li>
                            <li>Add survey report</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/machines">List machines</a></li>
                            <li><a href="/machines/modalities">List by modality</a></li>
                            <li><a href="/machines/locations">List by location</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/admin/locations">Locations</a></li>
                            <li><a href="/admin/manufacturers">Manufacturers</a></li>
                            <li><a href="/admin/modalities">Modalities</a></li>
                            <li><a href="/admin/testers">Testers</a></li>
                            <li><a href="/admin/testtypes">Test Types</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        @yield('content')
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="/js/bootstrap.min.js"></script>

</body>
</html>
