@extends('layout/main')
@extends('layout.include.nav')

@section('title','Edit Dokumentasi')

@section('container'.'') 
        <div class="main">
            <div class="main-content">
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="panel>
                            <div class="panel-header">
                                <h2 >Form Edit Data</h2>
                            </div>
                            <div class="panel panel-headline">
								<div class="panel-heading">
									<h3 class="panel-title">Data Informasi {{$data->judul}}</h3>
								</div>
								<div class="panel-body">
                                     <form method="post" action="/doc/{{$data->id}}" enctype="multipart/form-data">
                                      @csrf
                                      @method('patch')
                                           <input type="hidden" name="judul" value="{{$data->judul}}">
                                          <div class="row">
                                              <div class="col-8 col-sm-6">
                                                  <div class="form-group">
                                                      <label for="img">Gambar</label>
                                                      <input type="file" name="img">
                                                      <input type="hidden"  id="img"  name="img_last" value="{{$data->img}}">
                                                      <br>
                                                      <img src="{{URL::to('/')}}/img/doc/{{$data->img}}" width="58">
                                                      
                                                  </div> 
                                               </div>  
                                            </div>
                                           <div class="row">   
                                               <div class="col-8 col-sm-12">
                                                      <div class="form-group">
                                                          <label for="subjek">Rangkuman Penjelasan</label>
                                                          <textarea class="form-control" placeholder="Keterangan Tambahan" rows="4" name="subjek">{{$data->subjek}}</textarea>
                                                          @error('subjek')
                                                              <div class="invalid-feedback">{{$message}}</div> 
                                                          @enderror
                                                      </div>
                                                  </div>   
                                           </div>
                                           @if($data->judul != "About")
                                           <div class="row">
                                                <div class="col-8 col-sm-12">
                                                    <label for="ket">Keterangan Tambahan</label>
                                                    <textarea class="form-control" placeholder="Keterangan Tambahan" rows="4" name="ket">{{$data->ket}}</textarea>
                                                </div>
                                           </div>
                                           @endif
                                           <button type="submit" class="btn btn-primary">Edit Data </button>
                                     </form>
									
								</div>
							</div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
        <script src="{{asset('/ckeditor/ckeditor.js')}}"></script>
        <script>
                CKEDITOR.replace( 'ket' ,{
                    // Define the toolbar groups as it is a more accessible solution.
                    toolbarGroups: [
                        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                        { name: 'forms', groups: [ 'forms' ] },
                        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                        { name: 'links', groups: [ 'links' ] },
                        { name: 'insert', groups: [ 'insert' ] },
                        { name: 'styles', groups: [ 'styles' ] },
                        { name: 'colors', groups: [ 'colors' ] },
                        { name: 'tools', groups: [ 'tools' ] },
                        { name: 'others', groups: [ 'others' ] },
                        { name: 'about', groups: [ 'about' ] }
                    ],
                    // Remove the redundant buttons from toolbar groups defined above.
                    removeButtons: 'Source,Save,Templates,NewPage,Preview,Print,PasteText,PasteFromWord,Cut,Find,Replace,SelectAll,Form,Scayt,Checkbox,Radio,TextField,Outdent,Blockquote,CreateDiv,Indent,BidiLtr,Link,Image,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,BidiRtl,Language,Anchor,Unlink,Maximize,About,ShowBlocks,Textarea,Select,Button,HiddenField,CopyFormatting,RemoveFormat,Copy,Paste,ImageButton'
                    });
        </script>
        <script>
                CKEDITOR.replace( 'subjek' ,{
                    // Define the toolbar groups as it is a more accessible solution.
                    toolbarGroups: [
                        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                        { name: 'forms', groups: [ 'forms' ] },
                        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                        { name: 'links', groups: [ 'links' ] },
                        { name: 'insert', groups: [ 'insert' ] },
                        { name: 'styles', groups: [ 'styles' ] },
                        { name: 'colors', groups: [ 'colors' ] },
                        { name: 'tools', groups: [ 'tools' ] },
                        { name: 'others', groups: [ 'others' ] },
                        { name: 'about', groups: [ 'about' ] }
                    ],
                    // Remove the redundant buttons from toolbar groups defined above.
                    removeButtons: 'Source,Save,Templates,NewPage,Preview,Print,PasteText,PasteFromWord,Cut,Find,Replace,SelectAll,Form,Scayt,Checkbox,Radio,TextField,Outdent,Blockquote,CreateDiv,Indent,BidiLtr,Link,Image,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,BidiRtl,Language,Anchor,Unlink,Maximize,About,ShowBlocks,Textarea,Select,Button,HiddenField,CopyFormatting,RemoveFormat,Copy,Paste,ImageButton'
                    });
        </script>
        @endsection
