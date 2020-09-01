<nav class="navbar navbar-default navbar-dark bg-dark navbar-fixed-top"style="">
			<div class="container-fluid" style="margin-left:-20px; height:80px;">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-menu"></i></button>
				</div>
				<div class="navbar-btn navbar-btn-left" style="margin-left:3px; padding-bottom:1px; padding-top:5px;">
					<a href="/"><img src="{{URL::to('/')}}/assets/img/logo-dark.png" alt="posyandu Logo" ></a>
				</div>
				
				<div class=" navbar-btn navbar-btn-right dropdown" style="margin-left:3px; padding:0; margin-top:23px;">
							<a href="#" class=""  class="dropdown-toggle" data-toggle="dropdown"><img src="{{URL::to('/')}}/img/foto/{{auth()->user()->image}}" class="img-circle" alt="Avatar" widht="24" height="24"> <span>{{auth()->user()->username}}</span></a>
							<ul class="dropdown-menu notifications" style="margin-left:-165px; max-widht:275px;">
								<li class="text-center">
									<div class="profile-header">
									<div class="overlay"></div>
										<div class="profile-main">
											<img src="{{URL::to('/')}}/img/foto/{{auth()->user()->image}}" class="img-circle" alt="Avatar" widht="65" height="65">
										</div>
									</div>
								</li>
								<li><a href="#"><i class="lnr lnr-user"></i> <span>{{auth()->user()->nama}}</span></a></li>
								<li><a href="#"><i class="lnr lnr-phone"></i> <span>{{auth()->user()->telp}}</span></a></li>
								<li><a href="#"><i class="lnr lnr-home"></i> <span>{{auth()->user()->alamat}}</span></a></li>
							</ul>
							<form action="/logout" method="get" style="display:inline-block;">
								@csrf
								<button  onClick="return confirm('Anda Yakin Mau Keluar ?')"><i class="fa fa-sign-out"></i></button>
							</form>
				</div>
				
			</div>
		</nav>
		
  <script src="{{asset('/assets/vendor/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>