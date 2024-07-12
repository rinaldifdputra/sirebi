@extends('components.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Tentang Kami</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="judul" class="col-sm-2 control-label">Judul :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $cmsTentangKami->judul }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi" class="col-sm-2 control-label">Deskripsi :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{!! $cmsTentangKami->deskripsi !!}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat" class="col-sm-2 control-label">Alamat :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $cmsTentangKami->alamat }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telp" class="col-sm-2 control-label">Telepon :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $cmsTentangKami->telp }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="created_at" class="col-sm-2 control-label">Dibuat pada :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $cmsTentangKami->created_at }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at" class="col-sm-2 control-label">Diperbarui pada :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $cmsTentangKami->updated_at }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('tentang_kami.index') }}" class="btn btn-danger">
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
