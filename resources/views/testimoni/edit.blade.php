@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Testimoni</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <form class="form-horizontal" action="{{ route('testimoni.update', $cmsTestimoni->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="pasien_id" class="col-sm-2 control-label">Pasien</label>
                                    <div class="col-sm-10">
                                        <select class="select2-container @error('pasien_id') is-invalid @enderror"
                                            id="pasien_id" name="pasien_id" required>
                                            <option value=""></option>
                                            @foreach ($users as $id => $nama_lengkap)
                                                <option value="{{ $id }}"
                                                    {{ old('pasien_id', $cmsTestimoni->pasien_id) == $id ? 'selected' : '' }}>
                                                    {{ $nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('pasien_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                            placeholder="Deskripsi" required>{{ old('deskripsi', $cmsTestimoni->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('testimoni.index') }}" class="btn btn-danger"><i
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
            // Inisialisasi Select2 untuk kolom Pasien
            $('#pasien_id').select2({
                placeholder: 'Pilih Pasien',
                allowClear: true,
            });
        });
    </script>
@endsection
