<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIREBI | Register</title>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('cms/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('cms/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('cms/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('cms/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('cms/dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    {{-- <link rel="stylesheet" href="{{ asset('cms/bower_components/morris.js/morris.css') }}"> --}}
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('cms/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet"
        href="{{ asset('cms/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('cms/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('cms/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/select2/3.3.2/select2.css" type="text/css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="{{ asset('cms/custom_style.css') }}">

    <style>
        .content-wrapper {
            min-height: calc(100vh - 101px);
            background-color: transparent;
            z-index: 800;
        }
    </style>
</head>


<body class="hold-transition login-page">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-10">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-user-plus"></i> Registrasi Pasien</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="container mt-5">
                                <form class="form-horizontal" id="registrasi" action="{{ route('register') }}"
                                    method="POST">
                                    @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="nama_lengkap" class="col-sm-2 control-label">Nama
                                                Lengkap</label>
                                            <div class="col-sm-10">
                                                <input type="text"
                                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                                    id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap"
                                                    value="{{ old('nama_lengkap') }}" required>
                                                @error('nama_lengkap')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_lahir" class="col-sm-2 control-label">Tanggal
                                                Lahir</label>
                                            <div class="col-sm-10">
                                                <input type="text"
                                                    class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror"
                                                    id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir"
                                                    value="{{ old('tanggal_lahir') }}" required readonly>
                                                @error('tanggal_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Jenis Kelamin :</label>
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                                        type="radio" name="jenis_kelamin" id="laki-laki"
                                                        value="Laki-Laki"
                                                        {{ old('jenis_kelamin') == 'Laki-Laki' ? 'checked' : '' }}
                                                        required>
                                                    <label class="form-check-label" for="laki-laki">
                                                        Laki-Laki
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                                        type="radio" name="jenis_kelamin" id="perempuan"
                                                        value="Perempuan"
                                                        {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}
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
                                                <input type="text"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    id="username" name="username" placeholder="Username"
                                                    value="{{ old('username') }}" required>
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-sm-2 control-label">Password :</label>
                                            <div class="col-sm-10">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" placeholder="Password" required>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_hp" class="col-sm-2 control-label">No HP :</label>
                                            <div class="col-sm-10">
                                                <input type="text"
                                                    class="form-control @error('no_hp') is-invalid @enderror"
                                                    id="no_hp" name="no_hp" placeholder="No HP"
                                                    value="{{ old('no_hp') }}" required>
                                                @error('no_hp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pekerjaan_id" class="col-sm-2 control-label">Pekerjaan
                                                :</label>
                                            <div class="col-sm-10">
                                                <select
                                                    class="select2-container @error('pekerjaan_id') is-invalid @enderror"
                                                    id="pekerjaan_id" name="pekerjaan_id" required>
                                                    <option value=""></option>
                                                    @foreach ($pekerjaan as $job)
                                                        <option value="{{ $job->id }}"
                                                            {{ old('pekerjaan_id') == $job->id ? 'selected' : '' }}>
                                                            {{ $job->nama_pekerjaan }}</option>
                                                    @endforeach
                                                </select>
                                                @error('pekerjaan_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <a href="{{ route('login') }}" class="btn btn-danger"><i
                                                class="fa fa-arrow-left"></i>
                                            Batal</a>
                                        <button type="submit" class="btn btn-success pull-right"><i
                                                class="fa fa-save"></i>
                                            Simpan</button>
                                    </div>
                                    <!-- /.box-footer -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.login-box -->

    <!-- ./wrapper -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- jQuery 3 -->
    <script src="{{ asset('cms/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('cms/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('cms/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Morris.js charts -->
    {{-- <script src="{{ asset('cms/bower_components/raphael/raphael.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('cms/bower_components/morris.js/morris.min.js') }}"></script> --}}
    <!-- Sparkline -->
    <script src="{{ asset('cms/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <script src="{{ asset('cms/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('cms/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('cms/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('cms/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ asset('cms/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('cms/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('cms/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('cms/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('cms/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('cms/dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('cms/dist/js/demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/select2/3.3.2/select2.js"></script>
    <script>
        $(document).ready(function() {
            // Add Reservation
            $('#registrasi').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda akan melakukan registrasi',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, registrasi!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit(); // Use e.target.submit() to submit the form
                    } else if (result.isDenied) {
                        Swal.fire('Data gagal ditambah', '', 'info');
                    }
                });
            });
        });

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

        // Apply the select2 dropdown search
        $('#pekerjaan_id').select2({
            placeholder: 'Pilih Pekerjaan',
            allowClear: true
        });
    </script>
</body>

</html>
