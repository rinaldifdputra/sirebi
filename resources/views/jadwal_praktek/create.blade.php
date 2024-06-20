@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Jadwal Praktek</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <form class="form-horizontal" action="{{ route('jadwal_praktek.store') }}" method="POST">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control datepicker @error('tanggal') is-invalid @enderror"
                                            id="tanggal" name="tanggal" placeholder="Tanggal" value="{{ old('tanggal') }}"
                                            required readonly>
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jam_praktek_id" class="col-sm-2 control-label">Jam Praktek</label>
                                    <div class="col-sm-10">
                                        <select class="select2-container @error('jam_praktek_id') is-invalid @enderror"
                                            id="jam_praktek_id" name="jam_praktek_id" required>
                                            <option value=""></option>
                                            @foreach ($jam_praktek as $jam)
                                                <option value="{{ $jam->id }}"
                                                    {{ old('jam_praktek_id') == $jam->id ? 'selected' : '' }}>
                                                    {{ $jam->jam_mulai }} - {{ $jam->jam_selesai }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('jam_praktek_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bidan_id" class="col-sm-2 control-label">Bidan</label>
                                    <div class="col-sm-10">
                                        <select class="select2-container @error('bidan_id') is-invalid @enderror"
                                            id="bidan_id" name="bidan_id" required>
                                            @if (Auth::user()->role == 'Admin')
                                                <option value=""></option>
                                                @foreach ($bidan as $bdn)
                                                    <option value="{{ $bdn->id }}"
                                                        {{ old('bidan_id') == $bdn->id ? 'selected' : '' }}>
                                                        {{ $bdn->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            @elseif (Auth::user()->role == 'Bidan')
                                                @foreach ($bidan as $bdn)
                                                    <option value="{{ $bdn->id }}"
                                                        {{ old('bidan_id') == $bdn->id ? 'selected' : '' }}>
                                                        {{ $bdn->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('bidan_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kuota" class="col-sm-2 control-label">Kuota</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('kuota') is-invalid @enderror"
                                            id="kuota" name="kuota" placeholder="Kuota" value="{{ old('kuota') }}"
                                            required>
                                        @error('kuota')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('praktek_bidan.index') }}" class="btn btn-danger"><i
                                        class="fa fa-arrow-left"></i>
                                    Batal</a>
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
            // Inisialisasi Select2 untuk kolom Jam Praktek
            $('#jam_praktek_id').select2({
                placeholder: 'Pilih Jam Praktek',
                allowClear: true,
            });

            // Inisialisasi Select2 untuk kolom Bidan
            $('#bidan_id').select2({
                placeholder: 'Pilih Bidan',
                allowClear: true,
            });

            // Datepicker untuk kolom Tanggal
            $('.datepicker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
                startDate: new Date() // Memperbolehkan memilih tanggal dari hari ini ke depan
            });

            // Hanya memperbolehkan inputan angka untuk kolom Kuota
            $('#kuota').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
@endsection
