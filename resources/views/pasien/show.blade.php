@extends('components.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Pasien</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nama_lengkap" class="col-sm-2 control-label">Nama Lengkap:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->nama_lengkap }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label">Username:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->username }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="col-sm-2 control-label">Tanggal Lahir:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->tanggal_lahir }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin" class="col-sm-2 control-label">Jenis Kelamin:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->jenis_kelamin }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp" class="col-sm-2 control-label">No HP:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->no_hp }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan" class="col-sm-2 control-label">Pekerjaan:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->pekerjaan }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="created_at" class="col-sm-2 control-label">Dibuat pada:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->created_at }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at" class="col-sm-2 control-label">Diperbarui pada:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->updated_at }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('pasien.index') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
