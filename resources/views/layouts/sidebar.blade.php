<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">RadDB</a>
    </div><!--/.nav-header -->
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav nav-tabs">
            <li role="presentation" class="active"><a href="{{ route('index') }}">Home</a></li>
            <li role="presentation" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dashboards<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a href="{{ route('dashboard.dashboard')}}">Survey status</a></li>
                    <li role="presentation"><a href="{{ route('dashboard.showUntested')}}">Surveys to be scheduled</a></li>
                    <li role="presentation"><a href="{{ route('dashboard.showPending')}}">Pending surveys</a></li>
                    <li role="presentation"><a href="{{ route('dashboard.showSchedule')}}">Survey schedule</a></li>
                    <li role="presentation"><a href="{{ route('dashboard.surveyGraph') }}">Survey graphs</a></li>
                </ul>
            </li>
            <li role="presentation" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Listings<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a href="{{ route('machines.index') }}">List machines</a></li>
                    <li role="presentation"><a href="{{ route('machines.showModalityIndex') }}">List by modality</a></li>
                    <li role="presentation"><a href="{{ route('machines.showLocationIndex') }}">List by location</a></li>
                    <li role="presentation"><a href="{{ route('machines.showManufacturerIndex') }}">List by manufacturer</a></li>
                    <li role="presentation"><a href="{{ route('machines.installed') }}">Installed machines</a></li>
                    <li role="presentation"><a href="{{ route('machines.inactive') }}">Inactive machines</a></li>
                    <li role="presentation"><a href="{{ route('machines.removed') }}">Removed machines</a></li>
                </ul>
            </li>
            @if (Auth::check())
            <li role="presentation" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Machines<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a href="{{ route('machines.create') }}">New machine</a></li>
                    <li role="presentation"><a href="{{ route('opnotes.create' )}}">Add operational note</a></li>
                </ul>
            </li>
            <li role="presentation" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Surveys<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a href="{{ route('surveys.create') }}">Add survey</a></li>
                    <li role="presentation"><a href="{{ route('recommendations.create') }}">Add survey recommendation</a></li>
                    <li role="presentation"><a href="{{ route('surveyreports.create') }}">Add survey report</a></li>
                </ul>
            </li>
            <li role="presentation" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Test Equipment<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a href="{{ route('testequipment.index') }}">List Test Equipment</a></li>
                    <li role="presentation"><a href="{{ route('testequipment.showCalDates') }}">Recent calibration dates</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ url('/logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
            @else
            <li role="presentation"><a href="{{route('home.index')}}">Login</a></li>
            @endif
            <li role="presentation" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a href="http://128.23.56.214/MPwiki/index.php/RadDB" target="_blank">Help (local)</a></li>
                    <li role="presentation"><a href="https://github.com/imabug/raddb/wiki" target="_blank">Help (on Github)</a></li>
                    <li role="presentation"><a href="https://github.com/imabug/raddb/issues" target="_blank">Report a bug</a></li>
                </ul>
            </li>
        </ul>
    </div><!--/.nav-collapse -->
    </div><!--/.container -->
</nav>
