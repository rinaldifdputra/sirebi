@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Bidan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="container mt-5">
                        <form class="form-horizontal" action="{{ route('bidan.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="nama_lengkap" class="col-sm-2 control-label">Nama Lengkap :</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                                            id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap"
                                            value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="col-sm-2 control-label">Tanggal Lahir :</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror"
                                            id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir"
                                            value="{{ old('tanggal_lahir', $user->tanggal_lahir instanceof \Carbon\Carbon ? $user->tanggal_lahir->format('d-m-Y') : date('d-m-Y', strtotime($user->tanggal_lahir))) }}"
                                            required readonly>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Jenis Kelamin :</label>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                                type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-Laki"
                                                {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-Laki' ? 'checked' : '' }}
                                                required>
                                            <label class="form-check-label" for="laki-laki">
                                                Laki-Laki
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                                type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan"
                                                {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}
                                                required>
                                            <label class="form-check-label" for="perempuan">
                                                Perempuan
                                            </label>
                                            @error('jenis_kelamin')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label">Username :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="username" name="username" placeholder="Username"
                                            value="{{ old('username', $user->username) }}" required>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp" class="col-sm-2 control-label">No HP :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                            id="no_hp" name="no_hp" placeholder="No HP"
                                            value="{{ old('no_hp', $user->no_hp) }}" required>
                                        @error('no_hp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan" class="col-sm-2 control-label">Pekerjaan :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                            id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan"
                                            value="{{ old('pekerjaan', $user->pekerjaan) }}" required>
                                        @error('pekerjaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('bidan.index') }}" class="btn btn-danger"><i
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
            $('#tanggal_lahir').datepicker({
                autoclose: true,
                orientation: 'bottom',
                clearBtn: true,
                format: 'dd-mm-yyyy',
                endDate: new Date() // Membatasi tanggal maksimal menjadi hari ini
            });

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

        $('#no_hp').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $('#nama_lengkap, #pekerjaan').on('input', function() {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });
    </script>
@endsection
