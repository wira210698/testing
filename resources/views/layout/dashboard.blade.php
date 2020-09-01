<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/material-icons-min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">

    <title>@yield('title')</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler sideMenuToggler" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">SIP PUSTU</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Putra Wiranata
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="warpper d-flex">
      <div class="sideMenu">
        <div class="sidebar">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="material-icon icon"></i>
                <span class="text"></span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="material-icon icon"></i><
                  span class="text"></span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="material-icon icon"></i>
                <span class="text"></span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="material-icon icon"></i>
                <span class="text"></span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="material-icon icon"></i>
                <span class="text"></span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    @yield('container')



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('js/App.js')}}"></script>
    <script src="{{asset('plugins/js/jquery.js')}}"></script>
    <script src="{{asset('plugins/js/popper.js')}}"></script>
    <script src="{{asset('plugins/js/script.js')}}"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
  </body>
</html>
@yield('footer')