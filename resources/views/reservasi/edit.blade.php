@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Reservasi Bidan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <form class="form-horizontal" action="{{ route('reservasi.update', $reservasi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                <!-- Tambahkan form-group untuk menampilkan informasi jadwal praktek -->
                                <div class="form-group">
                                    <label for="tanggal" class="col-sm-2 control-label">Tanggal:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwalPraktek->tanggal }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jam_praktek_id" class="col-sm-2 control-label">Jam Praktek:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwalPraktek->jam_praktek->jam_mulai }} -
                                            {{ $jadwalPraktek->jam_praktek->jam_selesai }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bidan_id" class="col-sm-2 control-label">Bidan:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwalPraktek->bidan->nama_lengkap }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kuota" class="col-sm-2 control-label">Kuota:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwalPraktek->kuota }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sisa_kuota" class="col-sm-2 control-label">Sisa Kuota:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $sisaKuota }}</p>
                                    </div>
                                </div>
                                <!-- Form-group untuk dropdown Status -->
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Status:</label>
                                    <div class="col-sm-10">
                                        <select class="select2-container @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                            <option value=""></option>
                                            <option value="Tetap" {{ $reservasi->status == 'Tetap' ? 'selected' : '' }}>
                                                Tetap</option>
                                            <option value="Batal" {{ $reservasi->status == 'Batal' ? 'selected' : '' }}>
                                                Batal</option>
                                            <option value="Jadwal Ulang"
                                                {{ $reservasi->status == 'Jadwal Ulang' ? 'selected' : '' }}>Jadwal Ulang
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Tambahkan form-group untuk dropdown Jadwal Praktek -->
                                <div class="form-group" id="jadwal_praktek_group" style="display: none;">
                                    <label for="jadwal_praktek_id" class="col-sm-2 control-label">Jadwal Praktek:</label>
                                    <div class="col-sm-10">
                                        <select class="select2-container @error('jadwal_praktek_id') is-invalid @enderror"
                                            id="jadwal_praktek_id" name="jadwal_praktek_id" required>
                                            @foreach ($availableJadwalPraktek as $jadwal)
                                                <option value="{{ $jadwal->id }}"
                                                    {{ $reservasi->jadwal_praktek_id == $jadwal->id ? 'selected' : '' }}>
                                                    {{ $jadwal->tanggal }} -
                                                    {{ $jadwal->jam_praktek->jam_mulai }} -
                                                    {{ $jadwal->jam_praktek->jam_selesai }}
                                                    (Sisa Kuota: {{ $jadwal->sisa_kuota }})
                                                    -
                                                    {{ $jadwal->bidan->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('jadwal_praktek_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Tambahkan form-group untuk textarea Keterangan -->
                                <div class="form-group" id="keterangan_group" style="display: none;">
                                    <label for="keterangan" class="col-sm-2 control-label">Keterangan:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan">{{ $reservasi->keterangan }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('praktek_bidan.index') }}" class="btn btn-danger"><i
                                        class="fa fa-arrow-left"></i> Batal</a>
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i>
                                    Simpan</button>
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
            // Menampilkan SweetAlert untuk notifikasi
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
            // Menginisialisasi select2 untuk dropdown Jadwal Praktek
            $('#jadwal_praktek_id').select2({
                placeholder: 'Pilih Jadwal Praktek',
                allowClear: true
            });

            // Menginisialisasi select2 untuk dropdown Status
            $('#status').select2({
                placeholder: 'Pilih Status',
                allowClear: true
            });

            // Function untuk menampilkan/menyembunyikan field berdasarkan status
            function toggleFields() {
                var status = $('#status').val();
                if (status === 'Jadwal Ulang') {
                    $('#jadwal_praktek_group').show();
                    $('#keterangan_group').show();
                } else if (status === 'Batal') {
                    $('#jadwal_praktek_group').hide();
                    $('#keterangan_group').show();
                } else {
                    $('#jadwal_praktek_group').hide();
                    $('#keterangan_group').hide();
                }
            }

            // Memanggil fungsi toggleFields() saat halaman pertama kali dimuat
            toggleFields();

            // Memanggil fungsi toggleFields() ketika status berubah
            $('#status').change(function() {
                toggleFields();
            });

            // Memeriksa peran pengguna untuk menentukan apakah opsi 'Jadwal Ulang' ditampilkan
            var userRole = "{{ Auth::user()->role }}";
            if (userRole === 'Pasien') {
                $('#status option[value="Jadwal Ulang"]').hide();
            }
        });
    </script>
@endsection
