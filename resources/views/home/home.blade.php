<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Pelayanan Posyandu</title>

  <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('/css/one-page-wonder.min.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('/css/style.css')}}">

  <style>
  html, body{
    height:100%;
  }
  </style>


</head>

<body>
  <!-- Navigasi -->
  
  <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom fixed-top" style="padding-bottom:7px; padding-top:7px;">
    <div class="container" style="margin-left:8px;">
      <a class="navbar-brand" href="#"><img src="assets/img/logo-dark.png" alt="Klorofil Logo" class=" brand img-responsive logo" ></a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" style=" float:right; margin-right:-25px;">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse" id="navbarResponsive" style=" margin-right:-80px; float:right;">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#gallery">Foto Gallery</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#kb">Keluarga Berencana</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#anak">Anak</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#ibu">Ibu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">About</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="masthead text-center text-white shadow" style="background-image: url('img/beranda.png');">
    <div class="masthead-content">
      <div class="container">
        <h1 class="masthead-heading mb-0" style=" color:#1a66ff;">Pelayanan Posyandu</h1>
        <h2 class="masthead-subheading mb-0" style=" color:#1a66ff;">Puskesmas Pembantu Desa Lokasari</h2>
        <a href="/login" class="btn  btn-xl rounded-pill mt-5" style="background-color:#00b3b3; color:black;">Login</a>
      </div>
    </div>
  </header>
@foreach($data->sortByDesc('id') as $about)
@if($about->kategori =="About")
<section class="about shadow" id="about" style="min-height:550px; background-color:#f2f2f2;">
		<div class="container" style="background-color:#f2f2f2;">
			<div class="row">
				<div class="col-sm-12">
				<h2 class="text-center display-4 mt-5">{{$about->judul}}</h2>
				<hr>
				</div>
			</div>
			<div class="row justify-content-sm-center">
				<div class="col-sm-5">
					<p>
             {!!$about->subjek!!}
          </p>
				</div>
        <div class="col-sm-5">
          <p>
            <img class="img-fluid img-thumbnail" src="img/doc/{{$about->img}}" alt="" widht="85">
          </p>
        </div>
			</div>
		</div>
	</section>
@endif
@endforeach

@foreach($data as $doc)

@if($doc->kategori =="Ibu")
  <section class="ibu shadow" id="ibu" style="background-color:#FFC0CB;">
    <div class="container" style="background-color:#FFC0CB;">
      <div class="row align-items-center">
        <div class="col-lg-6 order-lg-2">
          <div class="p-5">
            <img class="img-fluid rounded-circle" src="img/doc/{{$doc->img}}" alt="Responsive image">
          </div>
        </div>
        <div class="col-lg-6 order-lg-1">
          <div class="p-5">
            <h2 class="display-4">{{$doc->judul}}</h2>
            <p>{!!$doc->subjek!!} <a href="/detail/{{$doc->id}}/" class="btn btn-primary btn-sm ">More Detail..</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
@elseif($doc->kategori =="anak")
  <section class="anak" id="anak" style="background-color:yellow;">
    <div class="container" style="background-color:yellow;">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="p-5">
            <img class="img-fluid rounded-circle " src="img/doc/{{$doc->img}}" alt="Responsive image">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="p-5">
            <h2 class="display-4">{{$doc->judul}}</h2>
            <p>{!!$doc->subjek!!}<a href="/detail/{{$doc->id}}/" class="btn btn-primary btn-sm ">More Detail..</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
@elseif($doc->kategori =="KB")
  <section class="kb" id="kb" style="background-color:	#5F9EA0;">
    <div class="container" style="background-color:	#5F9EA0;">
      <div class="row align-items-center">
        <div class="col-lg-6 order-lg-2">
          <div class="p-5">
            <img class="img-fluid rounded-box " src="img/doc/{{$doc->img}}" alt="Responsive image">
          </div>
        </div>
        <div class="col-lg-6 order-lg-1">
          <div class="p-5">
            <h2 class="display-4">{{$doc->judul}}</h2>
            <p>{!!$doc->subjek!!} <a href="/detail/{{$doc->id}}" class="btn btn-primary btn-sm ">More Detail..</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
@endforeach

<!--Foto Gallery -->
<section class="gallery" id="gallery">
	<div class="container mb-n4 mt-5">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="text-center display-4">
					Foto Gallery
				</h2>
				<hr>
			</div>
		</div>
	</div>
    <div class="container">
      <div class="row ml-5 mr-n5">
        <ul class="gallery">
          @foreach($image as $img)
            <li>
                  <div class="hovereffect">
                    <a href="#img{{$loop->iteration}}" data-toggle="modal">
                        <img src="img/doc/{{$img->img}}" alt="" class="img-responsive" style="margin-right:40px; widht:500px; height:275px;">
                        <div class="overlay">
                          <span><h2>{{$img->judul}}</h2></span>
                        </div>
                      </a>
                  </div>
                    <div class="lightbox" id="img{{$loop->iteration}}">
                      <a href="" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="img/close.png" width="25" height="25">
                      </a>
                      <img src="img/doc/{{$img->img}}">
                    </div>
             </li>
          @endforeach
          <div class="clear"></div>
        </ul>
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


</body>
</html>
  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('js/vendor/jquery.min.js')}}"></script>
  <script src="{{asset('js/vendor/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('js/scroll.js')}}"></script>

