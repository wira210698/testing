<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>{{$data->judul}}</title>

  <link rel="stylesheet" type="text/css" href="{{asset('/css/one-page-wonder.min.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('/post/vendor/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('/post/vendor/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('/post/css/clean-blog.min.css')}}">


</head>

<body>
  <!-- Navigation -->
   <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom fixed-top" style="padding-bottom:7px; padding-top:7px;">
    <div class="container" style="margin-left:8px;">
      <a class="navbar-brand" href="/"><img src="{{URL::to('/')}}/assets/img/logo-dark.png" alt="Klorofil Logo" class=" brand img-responsive logo" ></a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" style=" float:right; right:0;">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse" id="navbarResponsive" style=" margin-right:-80px;">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/detail/D0002">Keluarga Berencana</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/detail/D0001">Anak</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/detail/D0000">Ibu</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="{{$data->kategori}}" id="{{$data->kategori}}" style="background-color:#f2f2f2;">
    <div class="container mt-5 shadow" style="min-height:550px;background-color:white;">
      <div class="row align-items-center">
      <header class="masthead" style="background-image: url({{URL::to('/')}}/img/doc/{{$data->img}});background-size:520px; width:100%; height:620px;">
        <div class="overlay"></div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
              <div class="post-heading">
                <h1>Pelayanan {{$data->judul}}</h1>
                <span class="meta">Diunggah pada :
                   {{$data->updated_at->format('d-m-Y')}}</span>
              </div>
            </div>
          </div>
        </div>
      </header>

  <article>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
         {!!$data->subjek!!}

          {!! $data->ket !!}
        </div>
      </div>
    </div>
  </article>
        
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-5 bg-black">
    <div class="container">
      <p class="m-0 text-center text-white small">Copyright &copy; Sistem Informasi Pelayanan Posyandu Pustu Lokasari 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('js/vendor/jquery.min.js')}}"></script>
  <script src="{{asset('js/vendor/bootstrap.bundle.min.js')}}"></script>


</body>

</html>
