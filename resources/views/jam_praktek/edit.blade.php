@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Jam Praktek</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <form class="form-horizontal" action="{{ route('jam_praktek.update', $jam_praktek->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="jam_mulai" class="col-sm-2 control-label">Jam Mulai</label>
                                    <div class="col-sm-10">
                                        <select class="select2-container @error('jam_mulai') is-invalid @enderror"
                                            id="jam_mulai" name="jam_mulai" required>
                                            <option value=""></option>
                                            @for ($i = 0; $i <= 24; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00"
                                                    {{ old('jam_mulai', $jam_praktek->jam_mulai) == str_pad($i, 2, '0', STR_PAD_LEFT) . ':00' ? 'selected' : '' }}>
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                                </option>
                                            @endfor
                                        </select>
                                        @error('jam_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jam_selesai" class="col-sm-2 control-label">Jam Selesai</label>
                                    <div class="col-sm-10">
                                        <select class="select2-container @error('jam_selesai') is-invalid @enderror"
                                            id="jam_selesai" name="jam_selesai" required>
                                            <option value=""></option>
                                            @for ($i = 0; $i <= 24; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00"
                                                    {{ old('jam_selesai', $jam_praktek->jam_selesai) == str_pad($i, 2, '0', STR_PAD_LEFT) . ':00' ? 'selected' : '' }}>
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                                </option>
                                            @endfor
                                        </select>
                                        @error('jam_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('jam_praktek.index') }}" class="btn btn-info"><i
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
            // Inisialisasi Select2 untuk kolom Jenis Kelamin
            $('#jam_mulai').select2({
                placeholder: 'Pilih Jam Mulai',
                allowClear: true
            });

            $('#jam_selesai').select2({
                placeholder: 'Pilih Jam Selesai',
                allowClear: true
            });
        });
    </script>
@endsection
