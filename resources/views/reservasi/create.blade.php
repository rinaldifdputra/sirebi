@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Reservasi Bidan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <form id="reservasiForm" class="form-horizontal"
                            action="{{ route('reservasi.store', ['jadwalPraktekId' => $jadwalPraktekId]) }}" method="POST">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="tanggal" class="col-sm-2 control-label">Tanggal :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwalPraktek->tanggal }}</p>
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
                                    <label for="kuota" class="col-sm-2 control-label">Sisa Kuota :</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $sisaKuota }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('praktek_bidan.index') }}" class="btn btn-danger"><i
                                        class="fa fa-arrow-left"></i> Batal</a>
                                <button type="button" id="btnReservasi" class="btn btn-success pull-right"><i
                                        class="fa fa-save"></i>
                                    Reservasi</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ $errors->first() }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });

        $(document).ready(function() {
            $('#jadwal_praktek_id').select2({
                placeholder: 'Pilih Jadwal Praktek',
                allowClear: true
            });

            // Tambahkan event listener untuk tombol Reservasi
            $('#btnReservasi').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Apakah Anda yakin ingin melakukan reservasi?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, reservasi!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#reservasiForm').submit(); // Submit form jika dikonfirmasi
                    }
                });
            });
        });
    </script>
@endsection
