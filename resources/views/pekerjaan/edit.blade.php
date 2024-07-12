@extends('components.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Pekerjaan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <form class="form-horizontal" action="{{ route('pekerjaan.update', $pekerjaan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nama_pekerjaan" class="col-sm-2 control-label">Nama Pekerjaan</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('nama_pekerjaan') is-invalid @enderror"
                                            id="nama_pekerjaan" name="nama_pekerjaan"
                                            value="{{ old('nama_pekerjaan', $pekerjaan->nama_pekerjaan) }}" required>
                                        @error('nama_pekerjaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('pekerjaan.index') }}" class="btn btn-danger">
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
    </script>
@endsection
