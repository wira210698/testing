<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login SIPEDU</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" type="text/css" href="{{asset('/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/plugins/css/bootstrap-editable.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/vendor/linearicons/style.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('/assets/css/main.css')}}">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<style>
		body { 
		background: url(img/background-login.jpeg) no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		}
		/*memberi style pada class panel default*/
		.panel-default {
		opacity: 0.9;
		margin-top:180px;
		}
		.form-group.last {
		margin-bottom:0px;
		}
	</style>
</head>
	<body data-gr-c-s-loaded="true">
	<!-- NAVBAR -->
	<nav class="navbar navbar-default navbar-dark bg-dark navbar-fixed-top" style="height:80px;">
			<div class="container-fluid">
				<div class="navbar-btn navbar-btn-left" style="margin-left:23px; margin-top:-3px;">
					<a href="/"><img src="assets/img/logo-dark.png" alt="posyandu Logo" ></a>
				</div>
			</div>
		</nav>
	<!-- FORM LOGIN -->
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">

			<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="panel panel-default">
							<div class="panel-heading" >
									<div class="logo text-center"><img src="assets/img/logo-dark.png" alt="Klorofil Logo"></div>
								</div>
							<div class="panel-body">
								@if(session('error'))
                                    <div class="alert alert-warning alert-dismissible" role="alert">
										<i class="fa fa-warning"></i> {{session('error')}}
									</div>
                                @endif
								<form class="form-auth-small" action="post_login" method="post"> 
								@csrf
									<div class="form-group">
										<label for="username" class="control-label sr-only">Username</label>
										<input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{old('username')}}">
									</div>
									<div class="form-group">
										<label for="password" class="control-label sr-only">Password</label>
										<input type="password" class="form-control" id="password" name="password" placeholder="Password">
									</div>
									<div class="form-group clearfix">
									</div>
									<button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
									
								</form>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<!-- END FORM LOGIN -->


</body>

</html>
