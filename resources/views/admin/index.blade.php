@extends('components.layout')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Admin</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="mb-4">
                <a href="{{ route('admin.create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> Tambah Data</a>
            </div>
            <table class="table table-bordered data-table" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input class="form-control form-control-sm search" type="text"
                                placeholder="Cari Nama Lengkap"></td>
                        <td><input class="form-control form-control-sm search datepicker" type="text"
                                placeholder="Cari Tanggal Lahir" readonly></td>
                        <td>
                            <select id="searchJenisKelamin" style="width: 100%;">
                                <option value=""></option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                        <td><input class="form-control form-control-sm search" type="text" placeholder="Cari No HP"></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->nama_lengkap }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d-m-Y') }}</td>
                            <td>{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $user->no_hp }}</td>
                            <td>
                                <a href="{{ route('admin.show', $user->id) }}" class="btn btn-info btn-sm"><i
                                        class="fa fa-search-plus"></i></a>
                                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-warning btn-sm"><i
                                        class="fa fa-pencil-square-o"></i></a>
                                <form action="{{ route('admin.destroy', $user->id) }}" method="post" id="deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" id="btnHapus"><i
                                            class="fa fa-trash-o"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: false,
                orderCellsTop: true,
                fixedHeader: true,
                order: [],
                language: {
                    "sSearch": "Pencarian :",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Tidak ditemukan data yang sesuai",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });

            // Apply the search
            $('.search').on('keyup change', function() {
                var index = $(this).closest('td').index();
                table.column(index).search(this.value).draw();
            });

            // Apply the select2 dropdown search
            $('#searchJenisKelamin').select2({
                placeholder: 'Pilih Jenis Kelamin',
                allowClear: true
            });

            $('#searchJenisKelamin').on('change', function() {
                var value = $(this).val();
                table.columns(4).search(value).draw();
            });

            // Datepicker
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                orientation: 'bottom'
            });

            // Handling success and error messages
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
        $(document).on('click', '#btnHapus', function() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda akan menghapus data ini',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                } else if (result.isDenied) {
                    Swal.fire('Data gagal dihapus', '', 'info')
                }
            });
        });
    </script>
@endsection
