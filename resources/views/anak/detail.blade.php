@extends('anak/modal')
@extends('layout/main')
@extends('layout.include.nav')
@section('title','Detail Anak')

@section('container'.'')
<div class="main" style="min-height:800px;">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
                @if($anak->status=="Anak Balita" && $anak->umur < 240 )
					<h1 class="name" >Detail Data Anak Balita</h1>
                @elseif($anak->status=="Anak Balita" && $anak->umur >= 240)
					<h1 class="name" >Detail Data Anak Prasekolah</h1>
				@else
					<h1 class="name" >Detail Data Bayi</h1>
				@endif 
					<div class="panel panel-profile" >
						<div class="clearfix">
							<!-- LEFT COLUMN -->
							<div class="profile-left" >
								<!-- PROFILE DETAIL -->
								<div class="profile-detail">
									<div class="profile-info" >
										<h3 class="heading">{{$anak->nama_anak}}</h3>
										<ul class="list-unstyled list-justify">
											<li>NIK Anak <span>{{$anak->NIK}}</span></li>
                                            <li>Nama anak <span>{{$anak->nama_ibu}}</span></li>
                                            <li>Tanggal Lahir   <span>{{$anak->tgl_lahir}}</span></li>
                                            @if($anak->umur >= 240 )
                                            <li>Umur <span>{{round(($anak->umur/12)/4)}} Tahun</span></li>
                                            @else
                                            <li>Umur <span>{{$anak->umur}} Minggu</span></li>
                                            @endif
                                            <li>Alamat <span>Dusun {{$anak->dusun->nama_dusun}}</span></li>

											@if($anak->jk >0)
                                            <li>Jenis Kelamin <span>Laki-Laki</span></li>
											@else
                                            <li>Jenis Kelamin <span>Perempuan</span></li>
											@endif

											@if($anak->buku_KIA =="")
                                            <li>Buku KIA <span>Belum Punya</span></li>
											@else
                                            <li>Buku KIA <span>Punya</span></li>
											@endif
                                            <div class="profile-info" style="margin-left:-45px; margin-top:-18px;">
                                                <div class="panel-heading" style="margin-bottom:-9px;"> 
                                                    <h3 class="panel-title">Keterangan</h3>
                                                </div>
                                                <div class="slimScrollDiv" style="position: relative; overflow: auto; width: auto; height: 75px;">
                                                        <div class="panel-body" style="overflow: auto; width: auto; height: 75px; margin-top:-15px;">
                                                            @if($anak->ket =="")
                                                            <p>- </p>
                                                            @else
                                                            <p>{{$anak->ket}}</p>
                                                            @endif
                                                            </div>
                                                        <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 113px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 61.744px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                                                    </div>
                                            </div>
										</ul>
									</div>
									<div class="text-center" style="margin-top:-30px;">
                                            <a href="{{$anak->id}}/edit" class="btn btn-primary">Edit Data</a>
                                            <form action="{{$anak->id}}" method="post"style="display: inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger" onClick="return confirm('Hapus Data anak ?') ">Delete Profile</button>
                                            </form>
                                        </div>
								</div>
								<!-- END PROFILE DETAIL -->
							</div>
							<!-- END LEFT COLUMN -->
							<!-- RIGHT COLUMN -->
							<div class="profile-right" style="height:500px">
								
								<!-- TABBED CONTENT -->
								 <div class="heading custom-tabs-line tabs-line-bottom left-aligned">
                                    <ul class="nav" role="tablist" style="margin-top:-15px; margin-left:-15px; margin-bottom:-11px;"  id="myTab">
                                        @if($anak->status =="Anak Balita" && $anak->umur < 240 )
                                        <li  >
                                            <a class="nav-link" data-toggle="tab" href="#kunjungan">
                                               Kunjungan Anak Balita
                                            </a>
                                        </li>
                                        @elseif($anak->status =="Anak Balita" && $anak->umur >= 240)
                                         <li >
                                            <a class="nav-link" data-toggle="tab" href="#prasekolah">
                                                 Kunjungan Anak Prasekolah
                                            </a>
                                        </li>
                                        @else
                                        <li  >
                                            <a class="nav-link" data-toggle="tab" href="#kunjungan">
                                               Kunjungan Bayi
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nav-link" data-toggle="tab" href="#kondisilahir">
                                                 Kondisi Lahir
                                            </a>
                                        </li>
                                        @endif
                                        <li >
                                            <a class="nav-link" data-toggle="tab" href="#kematiananak">
                                                Meninggal
                                            </a>
                                        </li>
                                        <li >
                                            <a class="nav-link" data-toggle="tab" href="#Imunisasi">
                                                 Imunisasi
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                                <div class="tab-content" >
                                    <div class="tab-pane fade in" id="kunjungan" style="padding:0; margin-left:-17px;">
                                    <button type="button" class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target="#exampleModal">
                                         <i class="fa fa-plus"></i>
                                     </button>
                                    <button type="button" class="btn btn-success" style="margin-bottom:15px;" data-toggle="modal" data-target="#modalInfo">
                                         <i class="fa fa-question-circle"></i>
                                     </button>
                                        @if($anak->kunjungananak->count()>0)
                                        <div class="table-responsive" >
                                            <table class="table project-table" style="font-size:12px;">
                                                <thead>
                                                     <tr>
                                                         <th>#</th>
                                                         <th>Tanggal Kunjungan</th>
                                                         <th>Kode Pelayanan</th>
                                                         <th>Tempat Pelayanan</th>
                                                         <th>Umur</th>
                                                         <th>Berat Badan</th>
                                                         <th>Kondisi Anak</th>
                                                         <th>Keterangan</th>
                                                         <th>Aksi</th>
                                                     </tr>
                                                 </thead>
                                                 <tbody class="text-center">
                                                 @foreach($anak->kunjungananak as $ki)
                                                     <tr>
                                                         <td>{{$loop->iteration}}</td>
                                                         <td>
                                                             <a href="#" class="tgl_kunjungan" data-type="date" data-pk="{{$ki->id}}" data-url="/api/anak/{{$anak->id}}/tanggalAnak" data-title="Masukan Tanggal ">
                                                                 {{$ki->tgl_kunjungan}}
                                                             </a>
                                                         </td>
                                                         <td>
														@if($anak->status=="Bayi")
                                                             <a href="#" class="kd_pelayanan2" data-type="select" data-pk="{{$ki->id}}" data-url="/api/anak/{{$anak->id}}/kdPelayanan" data-title="Pilih Kode Pelayanan ">
                                                                 {{$ki->kd_pelayanan}} 
                                                             </a>
														@else
                                                             <a href="#" class="kd_pelayanan1" data-type="select" data-pk="{{$ki->id}}" data-url="/api/anak/{{$anak->id}}/kdPelayanan" data-title="Pilih Kode Pelayanan ">
                                                                 {{$ki->kd_pelayanan}} 
                                                             </a>
														@endif
                                                         </td>
                                                         <td>
                                                             <a href="#" class="tempat" data-type="select" data-pk="{{$ki->id}}" data-url="/api/anak/{{$anak->id}}/tempat" data-title="Pilih Tempat Pelayanan ">
                                                                 {{$ki->tempat}}
                                                             </a>
                                                         </td>
                                                         <td>
                                                             <a href="#" class="umur" data-type="number" data-pk="{{$ki->id}}" data-url="/api/anak/{{$anak->id}}/umur" data-title="Masukan Umur Anak ">
                                                                 {{$ki->umur}} 
                                                             </a>
															 Minggu
                                                         </td>
                                                         <td>
                                                             <a href="#" class="bb" data-type="number" data-pk="{{$ki->id}}" data-url="/api/anak/{{$anak->id}}/bb" data-title="Masukan Berat Badan (gr)">
                                                                 {{$ki->bb}}
                                                             </a>
															 gr
                                                         </td>
                                                         <td>
                                                             <a href="#" class="kondisi_anak" data-type="select" data-pk="{{$ki->id}}" data-url="/api/anak/{{$anak->id}}/kondisi" data-title="Pilih Kondisi Anak">
                                                                 {{$ki->kondisi_anak}}
                                                             </a>
                                                         </td>
                                                         <td>
                                                         @if($ki->ket=="")
                                                             <a href="#" class="ket" data-type="text" data-pk="{{$ki->id}}" data-url="/api/anak/{{$anak->id}}/ketAnak" data-title="Masukan Keterangan">
                                                                 -
                                                             </a>
                                                        `@else
                                                             <a href="#" class="ket" data-type="text" data-pk="{{$ki->id}}" data-url="/api/anak/{{$anak->id}}/ketAnak" data-title="Masukan Keterangan">
                                                                 {{$ki->ket}}
                                                             </a>
                                                        @endif
                                                         </td>
                                                         <td>
                                                             <form action="{{$anak->id}}/{{$ki->id}}" method="post" class="d-inline">
                                                                 @csrf
                                                                 @method('delete')
                                                                 <button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Hapus Data Anak ?') ">Delete Profile</button>
                                                             </form>
                                                         </td>
                                                     </tr>
                                                 @endforeach
                                                 </tbody>
                                            </table>
                                             @if($anak->kunjungananak->count()>=4)
                                            {!!$anak->paginate(8,['*'],'kunjungananak')!!}
                                            @endif
                                        </div>
                                        @else
                                        <h4 class="name text-center" >Data Kunjungan Kosong</h4>
                                        @endif
                                        @section('modalKunjungan')
                                        @endsection
                                    </div>

                                    <div class="tab-pane fade" id="prasekolah" style="padding:0; margin-left:-17px;">
                                    <button type="button" class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target=".modalPrasekolah">
                                        <i class="fa fa-plus"></i> 
                                    </button>
                                    <div class="table-responsive">
                                        @if($anak->prasekolah->count()>0)
                                            <table class="table project-table" style="font-size:12.5px;">
                                                 <thead>
                                                      <tr>
                                                          <th>#</th>
                                                          <th>Tanggal Pelayanan</th>
                                                          <th>Tempat Pelayanan</th>
                                                          <th>Status Gizi Anak</th>
                                                          <th>Pemberian ARV</th>
                                                          <th>Aksi</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                  @foreach($anak->prasekolah as $pe)
                                                      <tr>
                                                          <td>{{$loop->iteration}}</td>
                                                          <td>
                                                              <a href="#" class="tgl_pelayanan" data-type="date" data-pk="{{$pe->id}}" data-url="/api/anak/{{$anak->id}}/tanggalPelayanan" data-title="Masukan Tanggal ">
                                                                  {{$pe->tgl_pelayanan}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                              <a href="#" class="tempat" data-type="select" data-pk="{{$pe->id}}" data-url="/api/anak/{{$anak->id}}/tempatP" data-title="Masukan TempatPelayanan ">
                                                                  {{$pe->tempat}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                              <a href="#" class="status_gizi" data-type="select" data-pk="{{$pe->id}}" data-url="/api/anak/{{$anak->id}}/giziP" data-title="Masukan Status Gizi">
                                                                  {{$pe->status_gizi}}
                                                              </a>
                                                          </td>
                                                          @if($pe->pemberian_arv > 0)
                                                          <td>
                                                             <a href="#" class="pemberian_arv" data-type="select" data-pk="{{$pe->id}}" data-url="/api/anak/{{$anak->id}}/arvP" data-title="Pemberian ARV">
                                                                Ada
                                                            </a>
                                                          </td>
                                                          @else
                                                          <td>
                                                            <a href="#" class="pemberian_arv" data-type="select" data-pk="{{$pe->id}}" data-url="/api/anak/{{$anak->id}}/arvP" data-title="Pemberian ARV">
                                                                Tidak
                                                            </a>
                                                          </td>
                                                          @endif
                                                          <td>
                                                              <form action="{{$anak->id}}/{{$pe->id}}/prasekolah" method="post" class="d-inline">
                                                                  @csrf
                                                                  @method('delete')
                                                                  <button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Hapus Data ?') ">Delete Profile</button>
                                                              </form>
                                                          </td>
                                                      </tr>
                                                  @endforeach
                                                  </tbody>
                                            </table>
                                        @if($anak->prasekolah->count() >=4)
                                          {!!$anak->paginate(8,['*'],'prasekolah')!!}
                                        @endif
                                        @else
                                        <h4 class="name text-center" >Data Anak Prasekolah Kosong</h4>
                                        @endif
                                        </div>
                                         @section('modalPrasekolah')
                                         @endsection
                                    </div>
                                    
                                    <div class="tab-pane fade" id="kondisilahir" style="padding:0; margin-left:-17px;">
                                    <button type="button"  class="btn btn-primary" @if($anak->kondisilahir) disabled="disabled" @endif style="margin-bottom:15px;" data-toggle="modal" data-target=".modalKondisiLahir">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                        <div class="table-responsive">
                                        @if(!$anak->kondisilahir) 
                                        <h4 class="name text-center" >Data Kondisi Lahir Bayi Kosong</h4>
                                        @else
                                            <table class="table project-table" style="font-size:12px;">
                                                 <thead>
                                                      <tr>
                                                          <th>#</th>
                                                          <th>Tanggal Pelayanan</th>
                                                          <th>Tempat Lahir</th>
                                                          <th>Kondisi Lahir</th>
                                                          <th>Pelayanan</th>
                                                          <th>Keterangan</th>
                                                          <th>Aksi</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody> 
                                                      <tr>
                                                          <td>1</td>
                                                          <td>
                                                              <a href="#" class="tgl_pelayanan" data-type="date" data-pk="{{$anak->kondisilahir->id}}" data-url="/api/anak/{{$anak->id}}/tanggalPelayananL" data-title="Masukan Tanggal ">
                                                                  {{$anak->kondisilahir->tgl_pelayanan}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                              <a href="#" class="tempat" data-type="select" data-pk="{{$anak->kondisilahir->id}}" data-url="/api/anak/{{$anak->id}}/tempatL" data-title="Masukan TempatLahir ">
                                                                  {{$anak->kondisilahir->tempat}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                              <a href="#" class="kd_kondisi" data-type="select" data-pk="{{$anak->kondisilahir->id}}" data-url="/api/anak/{{$anak->id}}/kondisiL" data-title="Masukan Kondisi Lahir">
                                                                  {{$anak->kondisilahir->kd_kondisi}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                              <a href="#" class="kd_pelayanan2" data-type="select" data-pk="{{$anak->kondisilahir->id}}" data-url="/api/anak/{{$anak->id}}/pelayananL" data-title="Masukan Jenis Pelayanan">
                                                                  {{$anak->kondisilahir->kd_pelayanan}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                            @if($anak->kondisilahir->ket=="")
                                                             <a href="#" class="ket" data-type="text" data-pk="{{$anak->kondisilahir->id}}" data-url="/api/anak/{{$anak->id}}/ketL" data-title="Masukan Keterangan">
                                                                 -
                                                             </a>
                                                            @else
                                                             <a href="#" class="ket" data-type="text" data-pk="{{$anak->kondisilahir->id}}" data-url="/api/anak/{{$anak->id}}/ketL" data-title="Masukan Keterangan">
                                                                  {{$anak->kondisilahir->ket}}
                                                             </a>
                                                            @endif
                                                          </td>
                                                          <td>
                                                              <form action="{{$anak->id}}/{{$anak->kondisilahir->id}}/kondisiLahir" method="post" class="d-inline">
                                                                  @csrf
                                                                  @method('delete')
                                                                  <button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Hapus Data ?') ">Delete Profile</button>
                                                              </form>
                                                          </td>
                                                      </tr>
                                                  </tbody>
                                            </table>
                                       
                                        @endif
                                        </div>
                                         @section('modalKondisiLahir')
                                         @endsection
                                    </div>

                                    <div class="tab-pane fade" id="kematiananak" style="padding:0; margin-left:-17px;">
                                    <button type="button"  class="btn btn-primary" @if($anak->kematiananak) disabled="disabled" @endif style="margin-bottom:15px;" data-toggle="modal" data-target=".modalKematian">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                        <div class="table-responsive">
                                        @if(!$anak->kematiananak) 
                                        <h4 class="name text-center" >Data Meninggal Kosong</h4>
                                        @else
                                            <table class="table project-table" style="font-size:12px;">
                                                 <thead>
                                                      <tr>
                                                          <th>#</th>
                                                          <th>Tanggal Meninggal</th>
                                                          <th>Tempat Meninggal</th>
                                                          <th>Usia</th>
                                                          <th>Penyebab</th>
                                                          <th>Keterangan</th>
                                                          <th>Aksi</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody> 
                                                      <tr>
                                                          <td>1</td>
                                                          <td>
                                                              <a href="#" class="tgl_kematian" data-type="date" data-pk="{{$anak->kematiananak->id}}" data-url="/api/anak/{{$anak->id}}/tanggalKematian" data-title="Masukan Tanggal ">
                                                                  {{$anak->kematiananak->tgl_kematian}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                              <a href="#" class="tempat" data-type="select" data-pk="{{$anak->kematiananak->id}}" data-url="/api/anak/{{$anak->id}}/tempatM" data-title="Masukan Tempat Meninggal ">
                                                                  {{$anak->kematiananak->tempat}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                              <a href="#" class="usia_kematian" data-type="number" data-pk="{{$anak->kematiananak->id}}" data-url="/api/anak/{{$anak->id}}/usiaM" data-title="Masukan Usia Anak / Bayi">
                                                                  {{$anak->kematiananak->usia_kematian}}
                                                              </a>  Minggu
                                                          </td>
                                                          <td>
                                                              <a href="#" class="penyebab_kematian" data-type="select" data-pk="{{$anak->kematiananak->id}}" data-url="/api/anak/{{$anak->id}}/penyebabM" data-title="Masukan Penyebab Meninggal">
                                                                  {{$anak->kematiananak->penyebab_kematian}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                            @if($anak->kematiananak->ket=="")
                                                             <a href="#" class="ket" data-type="text" data-pk="{{$anak->kematiananak->id}}" data-url="/api/anak/{{$anak->id}}/ketM" data-title="Masukan Keterangan">
                                                                 -
                                                             </a>
                                                            @else
                                                             <a href="#" class="ket" data-type="text" data-pk="{{$anak->kematiananak->id}}" data-url="/api/anak/{{$anak->id}}/ketM" data-title="Masukan Keterangan">
                                                                  {{$anak->kematiananak->ket}}
                                                             </a>
                                                            @endif
                                                          </td>
                                                          <td>
                                                              <form action="{{$anak->id}}/{{$anak->kematiananak->id}}/kematian" method="post" class="d-inline">
                                                                  @csrf
                                                                  @method('delete')
                                                                  <button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Hapus Data ?') ">Delete Profile</button>
                                                              </form>
                                                          </td>
                                                      </tr>
                                                  </tbody>
                                            </table>
                                       
                                        @endif
                                        </div>
                                         @section('modalMeninggal')
                                         @endsection
                                    </div>

                                    <div class="tab-pane fade" id="Imunisasi" style="padding:0; margin-left:-17px;">
                                    <button type="button" class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target=".modalImunisasi">
                                        <i class="fa fa-plus"></i> 
                                    </button>
                                    <div class="table-responsive">
                                    @if($anak->imunisasi->count()<1)
                                        <h4 class="name text-center" >Data Imunisasi Kosong</h4>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table project-table" style="font-size:12px;">
                                                 <thead>
                                                      <tr>
                                                          <th>#</th>
                                                          <th>Imunisasi</th>
                                                          <th>Tanggal Imunisasi</th>
                                                          <th>Aksi</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach($anak->imunisasi as $i) 
                                                      <tr>
                                                          <td>{{$loop->iteration}}</td>
                                                          <td>
                                                                  {{$i->nama_imunisasi}}
                                                          </td>
                                                          <td>
                                                              <a href="#" class="tgl_kunjungan" data-type="date" data-pk="{{$i->id}}" data-url="/api/anak/{{$anak->id}}/tanggalImunisasi" data-title="Masukan Tanggal ">
                                                                  {{$i->pivot->tgl_kunjungan}}
                                                              </a>
                                                          </td>
                                                          <td>
                                                              <form action="{{$anak->id}}/{{$i->id}}/imunisasi" method="post" class="d-inline">
                                                                  @csrf
                                                                  @method('delete')
                                                                  <button type="submit" class="btn btn-danger btn-sm lnr lnr-trash" onClick="return confirm('Hapus Data ?') "></button>
                                                              </form>
                                                          </td>
                                                    @endforeach
                                                      </tr>
                                                  </tbody>
                                                @endif
                                            </table>
                                            @if($anak->imunisasi->count() >=4)
                                            {!!$anak->paginate(8,['*'],'imunisasi')!!}
                                            @endif
                                        </div>
                                         @section('modalImunisasi')
                                         @endsection
                                    </div>
                                    
                                    
                                    


                                </div>
								<!-- END TABBED CONTENT -->
							</div>
							<!-- END RIGHT COLUMN -->
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>

@endsection
@section('footer')
<script src="{{asset('js/data/tab.js')}}"></script>
<script>
	$(document).ready(function() {

        //validate modal
       $("#formKunjungan").validate({
            rules: {
                tgl_kunjungan: "required",
                kd_pelayanan: "required",
                tempat: "required",
                umur: {
                    required: true,
                    number: true,
                    min: 1,
                    maxlength: 3
                },
                bb: {
                    required: true,
                    number: true,
                    min: 1,
                    maxlength:6
                },
                kondisi_anak: "required"
            },
            messages: {
                tgl_kunjungan: "Data Tidak Boleh Kosong",
                kd_pelayanan: "Data Belum dipilih",
                tempat: "Data Belum dipilih",
                umur: {
                    required: "Data Tidak boleh Kosong",
                    number: "Data Harus Angka",
                    min: "Masukan dengan format yang benar",
                    maxlength: "Masukan Data Dengan Benar"
                },
                bb: {
                    required: "Data Tidak boleh Kosong",
                    number: "Data Harus Angka",
                    min: "Masukan dengan format yang benar",
                    maxlength: "Masukan Data Dengan Benar"
                },
                kondisi_anak: "Data Belum dipilih"
            }
        });
       $("#formPrasekolah").validate({
            rules: {
                tgl_pelayanan: "required",
                tempat: "required",
                status_gizi: "required"
            },
            messages: {
                tgl_pelayanan: "Data Tidak Boleh Kosong",
                tempat: "Data Belum dipilih",
                status_gizi: "Data Belum dipilih"
            }
        });
       $("#formKondisiLahir").validate({
            rules: {
                tgl_pelayanan: "required",
                tempat: "required",
                kd_kondisi: "required",
                kd_pelayanan: "required"
            },
            messages: {
                tgl_pelayanan: "Data Tidak Boleh Kosong",
                tempat: "Data Belum dipilih",
                kd_kondisi: "Data Belum dipilih",
                kd_pelayanan: "Data Belum dipilih"
            }
        });
       $("#formAnakMeninggal").validate({
            rules: {
                tgl_kematian: "required",
                tempat: "required",
                usia_kematian: {
                    required: true,
                    number: true,
                    min: 1,
                    maxlength: 3
                },
                penyebab_kematian: "required"
            },
            messages: {
                tgl_kematian: "Data Tidak Boleh Kosong",
                tempat: "Data Belum dipilih",
                usia_kematian: {
                    required: "Data Tidak boleh Kosong",
                    number: "Data Harus Angka",
                    min: "Masukan dengan format yang benar",
                    maxlength: "Masukan Data Dengan Benar"
                },
                penyebab_kematian: "Data Belum dipilih"
            }
        });

        $("#formImunisasi").validate({
            rules: {
                tgl_kunjungan: "required",
                imunisasi_id: "required"
            },
            messages: {
                tgl_kunjungan: "Data Tidak Boleh Kosong",
                imunisasi_id: "Data Belum dipilih"
            }
        });
        //edit live


        // Kunjungan
         $('.tgl_kunjungan').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
        $('.kd_pelayanan1').editable({
             source: [
                   {value: 'D', text: 'D'},
                   {value: 'D 2x', text: 'D 2x'},
                   {value: 'D 4x', text: 'D 4x'},
                   {value: '*', text: '*'},
                   {value: 'M', text: 'M'},
                   {value: 'S', text: 'S'},
                   {value: 'LT', text: 'LT'},
                   {value: 'EID+ISERO+', text: 'EID+ISERO+'},
                   {value: 'ARV', text: 'ARV'},
                   {value: 'PPK', text: 'PPK'},
                   {value: 'A', text: 'A'}
                ],
                validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
        $('.kd_pelayanan2').editable({
             source: [
                   {value: 'D', text: 'D'},
                   {value: 'D 2x', text: 'D 2x'},
                   {value: 'D 4x', text: 'D 4x'},
                   {value: 'IMD', text: 'IMD'},
                   {value: 'Vit K1', text: 'Vit K1'},
                   {value: 'SHK+', text: 'SHK+'},
                   {value: 'SHK-', text: 'SHK-'},
                   {value: 'HK+', text: 'HK+'},
                   {value: 'HK-', text: 'HK-'},
                   {value: 'LT', text: 'LT'},
                   {value: 'PR', text: 'PR'},
                   {value: 'E1', text: 'E1'},
                   {value: 'E2', text: 'E2'},
                   {value: 'E3', text: 'E3'},
                   {value: 'E4', text: 'E4'},
                   {value: 'E5', text: 'E5'},
                   {value: 'E6', text: 'E6'}
                ],
                validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.tempat').editable({
              source: [
                   {value: 'Puskesmas/Pustu', text: 'Puskesmas/Pustu'},
                   {value: 'Polindes', text: 'Polindes'},
                   {value: 'Posyandu', text: 'Posyandu'},
                   {value: 'Kunjungan Rumah', text: 'Kunjungan Rumah'},
                   {value: 'Unit Pelayanan Swasta', text: 'Unit Pelayanan Swasta'},
                   {value: 'Rumah Sakit', text: 'Rumah Sakit'}
                ],
			 validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.umur').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.bb').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.kondisi_anak').editable({
             source: [
                   {value: 'N', text: 'N'},
                   {value: 'T', text: 'T'},
                   {value: 'O', text: 'O'},
                   {value: 'B', text: 'B'}
                ],
			 validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.ket').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });


         $('.tgl_pelayanan').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.status_gizi').editable({
              source: [
                   {value: 'Kurus Sekali', text: 'Kurus Sekali'},
                   {value: 'Kurus', text: 'Kurus'},
                   {value: 'Normal', text: 'Normal'},
                   {value: 'Gemuk', text: 'Gemuk'},
                   {value: 'Hasil SDITK Sesuai', text: 'Hasil SDITK Sesuai'},
                   {value: 'Hasil SDITK Meragukan', text: 'Hasil SDITK Meragukan'},
                   {value: 'Hasil SDITK Penyimpangan', text: 'Hasil SDITK Penyimpangan'}
                ],
			 validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
          $('.pemberian_arv').editable({
              source: [
                   {value: '1', text: 'Ada'},
                   {value: '0', text: 'Tidak'}
                ],
			 validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });

        //  Kondisi Lahir
         $('.kd_kondisi').editable({
             source: [
                   {value: 'Sehat', text: 'Sehat'},
                   {value: 'Asfiksia', text: 'Asfiksia'},
                   {value: 'Trauma Lahir', text: 'Trauma Lahir'},
                   {value: 'Infeksi', text: 'Infeksi'},
                   {value: 'Kelainan Kongenital', text: 'Kelainan Kongenital'},
                   {value: 'Hipotermi', text: 'Hipotermi'},
                   {value: 'Lain-lain', text: 'Lain-lain'}
                ],
			 validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });

        //  Kematian

        $('.tgl_kematian').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.usia_kematian').editable({
             validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });
         $('.penyebab_kematian').editable({
              source: [
                   {value: 'Diare', text: 'Diare'},
                   {value: 'Pneumonia', text: 'Pneumonia'},
                   {value: 'Malaria', text: 'Malaria'},
                   {value: 'Campak', text: 'Campak'},
                   {value: 'DBD', text: 'DBD'},
                   {value: 'Difteri', text: 'Difteri'},
                   {value: 'Lain-lain', text: 'Lain-lain'}
                ],
			 validate: function(value){
                if($.trim(value)==''){
                    return 'Data Tidak boleh kosong'
                }
             }
         });


         
     })
</script>
@stop