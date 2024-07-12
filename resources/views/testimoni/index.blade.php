@extends('components.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Testimoni</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if (Auth::user()->role != 'Pasien')
                <div class="mb-4">
                    <a href="{{ route('testimoni.create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> Tambah
                        Data</a>
                </div>
            @endif
            <table class="table table-bordered data-table table-striped" style="width: 100%">
                <thead>
                    <tr id="header">
                        <th>No</th>
                        <th>Pasien</th>
                        <th>Deskripsi</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <select class="select2-container" id="searchPasien">
                                <option value=""></option>
                                @foreach ($users as $id => $nama_lengkap)
                                    <option value="{{ $nama_lengkap }}">{{ $nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input class="form-control form-control-sm search" type="text" placeholder="Cari Deskripsi">
                        </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($testimonis as $index => $testimoni)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $users[$testimoni->pasien_id] }}</td>
                            <td>{{ $testimoni->deskripsi }}</td>
                            <td>
                                <a href="{{ route('testimoni.show', $testimoni->id) }}" class="btn btn-info btn-sm"><i
                                        class="fa fa-search-plus"></i></a>
                                <a href="{{ route('testimoni.edit', $testimoni->id) }}" class="btn btn-warning btn-sm"><i
                                        class="fa fa-pencil-square-o"></i></a>
                                <form action="{{ route('testimoni.destroy', $testimoni->id) }}" method="post"
                                    class="d-inline">
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
            $('#searchPasien').select2({
                placeholder: 'Pilih Nama Pasien',
                allowClear: true
            }).on('change', function() {
                var val = $(this).val();
                table.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
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
