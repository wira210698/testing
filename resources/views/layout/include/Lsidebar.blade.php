<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						@if(auth()->user()->role_id == "petugas")
						<li><a href="/kader" class="{{ request()->is('kader','kader/create','kader/*/edit') ? 'active' : '' }}"><i class="fa fa-users"></i> <span>Kader</span></a></li>
						@endif
						<li><a href="/ibu" class="{{ request()->is('ibu','ibu/create','ibu/*','ibu/*/edit') ? 'active' : '' }}"><i class="fa fa-female"></i> <span>ibu</span></a></li>
						<li><a href="/KB" class="{{ request()->is('KB','KB/create','KB/*','KB/*/edit') ? 'active' : '' }}"><i class="fa fa-heart"></i> <span>Keluarga Berencana</span></a></li>
						<li><a href="/anak" class="{{ request()->is('anak','anak/create','anak/*','anak/*/edit') ? 'active' : '' }}"><i class="fa fa-child"></i> <span>Anak</span></a></li>
						
						@if(auth()->user()->role_id == "petugas")
						<li><a href="/doc" class="{{ request()->is('doc','doc/create','doc/*','doc/*/edit') ? 'active' : '' }}"><i class="fa fa-file-picture-o"></i> <span>Dokumentasi</span></a></li>
						<li><a href="/grafik" class="{{ request()->is('grafik','grafik_ibu','grafik_anak','grafik_kb') ? 'active' : '' }}"><i class="fa fa-bar-chart"></i> <span>Grafik</span></a></li>
						<li><a href="/laporan" class="{{ request()->is('laporan','laporan_ibu','laporan_anak','laporan_kb') ? 'active' : '' }}"><i class="fa fa-file"></i> <span>Laporan</span></a></li>
						@endif
					</ul>
				</nav>
			</div>
		</div>