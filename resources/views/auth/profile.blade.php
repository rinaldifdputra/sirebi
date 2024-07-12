@extends('components.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Profil Pasien</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nama_lengkap" class="col-sm-2 control-label">Nama Lengkap :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->nama_lengkap }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label">Username :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->username }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="col-sm-2 control-label">Tanggal Lahir :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">
                                            {{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d-m-Y') }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin" class="col-sm-2 control-label">Jenis Kelamin :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->jenis_kelamin }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp" class="col-sm-2 control-label">No HP :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $user->no_hp }}</p>
                                    </div>
                                </div>
                                @if ($user->role == 'Pasien')
                                    <div class="form-group">
                                        <label for="pekerjaan" class="col-sm-2 control-label">Pekerjaan :</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static">{{ $user->pekerjaan->nama_pekerjaan }}</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="created_at" class="col-sm-2 control-label">Dibuat pada :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at" class="col-sm-2 control-label">Diperbarui pada :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">
                                            {{ \Carbon\Carbon::parse($user->updated_at)->format('d-m-Y H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ url()->previous() }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>
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
