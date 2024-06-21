@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Reservasi Bidan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <form class="form-horizontal">
                            <div class="box-body">
                                <!-- Tambahkan form-group untuk menampilkan informasi jadwal praktek -->
                                <div class="form-group">
                                    <label for="tanggal" class="col-sm-2 control-label">Tanggal :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">
                                            {{ \Carbon\Carbon::parse($jadwalPraktek->tanggal)->format('d-m-Y') }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jam_praktek_id" class="col-sm-2 control-label">Jam Praktek :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwalPraktek->jam_praktek->jam_mulai }} -
                                            {{ $jadwalPraktek->jam_praktek->jam_selesai }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bidan_id" class="col-sm-2 control-label">Bidan :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwalPraktek->bidan->nama_lengkap }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kuota" class="col-sm-2 control-label">Kuota :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwalPraktek->kuota }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sisa_kuota" class="col-sm-2 control-label">Sisa Kuota :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $sisaKuota }}</p>
                                    </div>
                                </div>
                                <!-- Form-group untuk dropdown Status -->
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Status:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $reservasi->status }}</p>
                                    </div>
                                </div>
                                <div class="form-group" id="keterangan_group" style="display: none;">
                                    <label for="keterangan" class="col-sm-2 control-label">Keterangan :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $reservasi->keterangan }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ url()->previous() }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
