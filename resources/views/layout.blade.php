<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://getbootstrap.com/docs/4.0/assets/img/favicons/favicon.ico">

    <title>@yield("title")</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- Bootstrap core CSS -->
    <link href="{{ url('template_resource/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ url('template_resource/sticky-footer-navbar.css') }}" rel="stylesheet">

    <!-- HELPER JS Custom js functions -->
    <script src="{{ url('template_resource/helper.js') }}"></script>
  </head>

  <body class="bg-dark text-light">

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-secondary">
        <a class="navbar-brand text-success" href="{{ route('landing.splash') }}">ABOWST</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-end" id="navbarCollapse" style="">
          <div class="row">
            
            <div class="col-sm-6 d-flex align-items-start">
              <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('landing.splash') }}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('landing.about') }}">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('landing.contact') }}">Contact</a>
              </li>

              @if (Auth::check())
              <li class="nav-item">
                <a class="nav-link text-warning" href="{{ route('user.logout') }}">Logout</a>
              </li>
              @else
              <li class="nav-item">
                <a class="nav-link text-success" href="{{ route('user.login_page') }}">Login</a>
              </li>
              @endif


              </ul>
            </div>

            <div class="col-sm-6 d-flex align-items-end">
              
              <form class="input-group" method="get" action="{{ route('search.results') }}">
                <input type="text" class="form-control" placeholder="Search" name="query" data-input_field>
                <div class="input-group-append">
                  <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                </div>
              </form>

            </div>
          </div>
          
          

        </div>
      </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
      @yield("content")
      @yield("scripts")
    </main>

    <footer class="footer bg-dark">
      <div class="container-fluid bg-secondary mt-3">
          @if (Auth::check())
          <span class="text-warning">Logged In As {{ auth()->user()->name }}</span>
          @else
          <span class="text-muted">Place sticky footer content here.</span>
          @endif
        
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ url('template_resource/jquery-3.2.1.slim.min.js') }}"></script>
    <script src="{{ url('template_resource/popper.min.js') }}"></script>
    <script src="{{ url('template_resource/bootstrap.min.js') }}"></script>

</body></html>