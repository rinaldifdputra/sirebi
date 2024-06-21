@extends('components.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Jam Praktek</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="durasi_jam" class="col-sm-2 control-label">Jam Praktek :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jam_praktek->jam_mulai }} s/d
                                            {{ $jam_praktek->jam_selesai }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="created_at" class="col-sm-2 control-label">Dibuat pada :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jam_praktek->created_at }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at" class="col-sm-2 control-label">Diperbarui pada :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jam_praktek->updated_at }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('jam_praktek.index') }}" class="btn btn-danger"><i
                                        class="fa fa-arrow-left"></i>
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
