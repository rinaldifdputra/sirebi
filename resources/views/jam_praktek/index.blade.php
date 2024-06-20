@extends('components.layout')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Jam Praktek</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="mb-4">
                <a href="{{ route('jam_praktek.create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> Tambah
                    Data</a>
            </div>
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <select class="select2-container" id="searchJamMulai">
                                <option value=""></option>
                                @for ($i = 0; $i <= 24; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00">
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <select class="select2-container" id="searchJamSelesai">
                                <option value=""></option>
                                @for ($i = 0; $i <= 24; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00">
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="jam-mulai">{{ $item->jam_mulai }}</td>
                            <td class="jam-selesai">{{ $item->jam_selesai }}</td>
                            <td>
                                <a href="{{ route('jam_praktek.show', $item->id) }}" class="btn btn-info btn-sm"><i
                                        class="fa fa-search-plus"></i></a>
                                <a href="{{ route('jam_praktek.edit', $item->id) }}" class="btn btn-warning btn-sm"><i
                                        class="fa fa-pencil-square-o"></i></a>
                                <form action="{{ route('jam_praktek.destroy', $item->id) }}" method="post"
                                    class="d-inline" id="deleteForm-{{ $item->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                        data-id="{{ $item->id }}"><i class="fa fa-trash-o"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
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
                } else if (result.isDenied) {
                    Swal.fire('Data gagal dihapus', '', 'info');
                }
            });
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

            // Initialize Select2
            $('#searchJamMulai, #searchJamSelesai').select2({
                placeholder: 'Pilih',
                allowClear: true
            });

            // Filter functionality
            $('#searchJamMulai').on('change', function() {
                var value = $(this).val();
                table.columns(1).search(value).draw(); // Update the column index
            });

            $('#searchJamSelesai').on('change', function() {
                var value = $(this).val();
                table.columns(2).search(value).draw(); // Update the column index
            });

        });
    </script>
@endsection
