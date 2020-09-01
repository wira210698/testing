<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- Bootstrap CSS -->
    
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/plugins/css/bootstrap-editable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/vendor/linearicons/style.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('/assets/css/main.css')}}">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">

    <title>@yield('title')</title>
  </head>
  <body>
    <!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		@include('layout.include.nav')
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		@include('layout.include.Lsidebar')
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
    @yield('container')
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
  <script src="{{asset('/assets/vendor/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('/select2/js/select2.js')}}"></script>
  <script src="{{asset('assets/scripts/klorofil-common.js')}}"></script>
  <script src="{{asset('/plugins/js/bootstrap-editable.js')}}"></script>
  <script src="{{asset('/validator/dist/jquery.validate.min.js')}}"></script>
  

  
  </body>
</html>
@yield('footer')