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

    <!-- Bootstrap core CSS -->
    <link href="{{ url('template_resource/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ url('template_resource/sticky-footer-navbar.css') }}" rel="stylesheet">
  </head>

  <body class="bg-dark text-light">

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-secondary">
        <a class="navbar-brand text-success" href="{{ route('landing.splash') }}">ABOWST</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarCollapse" style="">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('landing.splash') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('landing.about') }}">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('landing.contact') }}">Contact</a>
            </li>
          </ul>
          <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
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
        <span class="text-muted">Place sticky footer content here.</span>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ url('template_resource/jquery-3.2.1.slim.min.js') }}"></script>
    <script src="{{ url('template_resource/popper.min.js') }}"></script>
    <script src="{{ url('template_resource/bootstrap.min.js') }}"></script>

</body></html>