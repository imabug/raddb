<nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">
  <div class="container">
    <a class="navbar-brand" href="{{ route('index') }}">RadDB</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarNav" class="collapse navbar-collapse">
      <ul class="navbar-nav">
        <li role="presentation" class="nav-item"><a href="{{ route('index') }}" class="nav-link active">Home</a></li>
        <li role="presentation" class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" id="navbarDashboards" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dashboards<span class="caret"></span></a>
          <ul class="dropdown-menu" aria-labelledby="navbarDashboards">
            <li role="presentation"><a class="dropdown-item" href="{{ route('dashboard.dashboard')}}">Survey status</a></li>
            <li role="presentation"><a class="dropdown-item" href="{{ route('dashboard.surveyCount') }}">Survey count graphs</a></li>
            <li role="presentation"><a class="dropdown-item" href="{{ route('dashboard.surveyCalendar') }}">Survey calendar</a></li>
            <li role="presentation"><a class="dropdown-item" href="{{ route('dashboard.surveyCategories') }}">Survey categories</a></li>
          </ul>
        </li>
        <li role="presentation" class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" id="navbarListings" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Listings<span class="caret"></span></a>
          <ul class="dropdown-menu" aria-labelledby="navbarListings">
            <li role="presentation"><a class="dropdown-item" href="{{ route('machines.index') }}">List machines</a></li>
          </ul>
        </li>
        @if (Auth::check())
          <li role="presentation" class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="navbarMachines" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Machines<span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="navbarMachines">
              <li role="presentation"><a class="dropdown-item" href="{{ route('machines.create') }}">New machine</a></li>
              <li role="presentation"><a class="dropdown-item" href="{{ route('opnotes.create' )}}">Add operational note</a></li>
            </ul>
          </li>
          <li role="presentation" class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="navbarSurveys" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Surveys<span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="navbarSurveys">
              <li role="presentation"><a class="dropdown-item" href="{{ route('surveys.create') }}">Add survey</a></li>
              <li role="presentation"><a class="dropdown-item" href="{{ route('recommendations.create') }}">Add survey recommendation</a></li>
              <li role="presentation"><a class="dropdown-item" href="{{ route('surveyreports.create', ['id' => null]) }}">Add survey report</a></li>
            </ul>
          </li>
          <li role="presentation" class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="navbarTestEquip" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Test Equipment<span class="caret"></span></a>
            <ul class="dropdown-menu" aria-labelledby="navbarTestEquip">
              <li role="presentation"><a class="dropdown-item" href="/machines?table[filters][machine_status]=Active&table[filters][modality]=19">List Test Equipment</a></li>
              <li role="presentation"><a class="dropdown-item" href="{{ route('testequipment.showCalDates') }}">Recent calibration dates</a></li>
            </ul>
          </li>
          <li role="presentation" class="nav-item">
            <a class="nav-link" href="{{ url('/logout') }}"
               onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
              Logout
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </li>
        @else
          <li role="presentation" class="nav-item"><a class="nav-link" href="{{url('/login')}}">Login</a></li>
        @endif
        <li role="presentation" class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" id="navbarHelp" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help<span class="caret"></span></a>
          <ul class="dropdown-menu" aria-labelledby="navbarHelp">
            <li role="presentation"><a class="dropdown-item" href="http://128.23.56.214/MPwiki/index.php/RadDB" target="_blank">Help (local)</a></li>
            <li role="presentation"><a class="dropdown-item" href="https://github.com/imabug/raddb/wiki" target="_blank">Help (on Github)</a></li>
            <li role="presentation"><a class="dropdown-item" href="https://github.com/imabug/raddb/issues" target="_blank">Report a bug</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- navbarNav -->
  </div><!-- container -->
</nav>
