@extends('components.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Layanan Kami</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nama_layanan" class="col-sm-2 control-label">Nama Layanan :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $cmsLayananKami->nama_layanan }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi" class="col-sm-2 control-label">Deskripsi :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{!! $cmsLayananKami->deskripsi !!}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="created_at" class="col-sm-2 control-label">Dibuat pada :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $cmsLayananKami->created_at }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at" class="col-sm-2 control-label">Diperbarui pada :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $cmsLayananKami->updated_at }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('layanan_kami.index') }}" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
