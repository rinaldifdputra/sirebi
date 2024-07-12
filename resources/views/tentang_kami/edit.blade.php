@extends('components.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Tentang Kami</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <form class="form-horizontal" action="{{ route('tentang_kami.update', $cmsTentangKami->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="judul" class="col-sm-2 control-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                            id="judul" name="judul" value="{{ old('judul', $cmsTentangKami->judul) }}"
                                            required>
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5"
                                            required>{{ old('deskripsi', $cmsTentangKami->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat" class="col-sm-2 control-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                            id="alamat" name="alamat"
                                            value="{{ old('alamat', $cmsTentangKami->alamat) }}">
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telp" class="col-sm-2 control-label">Telepon</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('telp') is-invalid @enderror"
                                            id="telp" name="telp" value="{{ old('telp', $cmsTentangKami->telp) }}">
                                        @error('telp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('tentang_kami.index') }}" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-success pull-right">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
    <script>
        $(function() {
            CKEDITOR.replace('deskripsi');

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
    </script>
@endsection
