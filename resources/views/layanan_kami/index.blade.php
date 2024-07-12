@extends('components.layout')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Layanan Kami</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="mb-4">
                <a href="{{ route('layanan_kami.create') }}" class="btn btn-success">
                    <i class="fa fa-plus"></i> Tambah Layanan Kami
                </a>
            </div>
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr id="header">
                        <th>No</th>
                        <th>Nama Layanan</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="text" class="form-control" id="searchNamaLayanan"
                                placeholder="Cari Nama Layanan...">
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="nama_layanan">{{ $item->nama_layanan }}</td>
                            <td class="deskripsi">{{ Str::limit($item->deskripsi, 50) }}</td>
                            <td>
                                <a href="{{ route('layanan_kami.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-search-plus"></i>
                                </a>
                                <a href="{{ route('layanan_kami.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <form action="{{ route('layanan_kami.destroy', $item->id) }}" method="POST"
                                    id="deleteForm-{{ $item->id }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                        data-id="{{ $item->id }}">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTables
            var table = $('#data-table').DataTable({
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

            // Filter functionality
            $('#searchNamaLayanan').on('keyup', function() {
                table.columns(1).search($(this).val()).draw();
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

            // Handling delete confirmation
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
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
                        $('#deleteForm-' + id).submit();
                    }
                });
            });
        });
    </script>
@endsection
