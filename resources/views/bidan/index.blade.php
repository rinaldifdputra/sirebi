@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Bidan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="mb-4">
                        <a href="{{ route('bidan.create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> Tambah
                            Data</a>
                    </div>
                    <table class="table table-bordered data-table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>No HP</th>
                                <th>Pekerjaan</th>
                                <th>Aksi</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input class="form-control form-control-sm search" type="text"
                                        placeholder="Cari Nama Lengkap">
                                </td>
                                <td><input class="form-control form-control-sm search" type="text"
                                        placeholder="Cari Username">
                                </td>
                                <td><input class="form-control form-control-sm search datepicker" type="text"
                                        placeholder="Cari Tanggal Lahir"></td>
                                <td>
                                    <select class="select2-container" id="searchJenisKelamin">
                                        <option value=""></option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                                <td><input class="form-control form-control-sm search" type="text"
                                        placeholder="Cari No HP">
                                </td>
                                <td><input class="form-control form-control-sm search" type="text"
                                        placeholder="Cari Pekerjaan">
                                </td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            // Inisialisasi DataTables
            let dtOverrideGlobals = {
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('bidan.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_lengkap',
                        name: 'nama_lengkap'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir',
                        render: function(data, type, row) {
                            // Format tanggal menjadi dd-mm-yyyy
                            let date = new Date(data);
                            let day = ("0" + date.getDate()).slice(-2);
                            let month = ("0" + (date.getMonth() + 1)).slice(-2);
                            let year = date.getFullYear();
                            return `${day}-${month}-${year}`;
                        }
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'pekerjaan',
                        name: 'pekerjaan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '10%'
                    },
                ],
                orderCellsTop: true,
                order: [
                    [1, 'asc']
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
            };

            let table = $('.data-table').DataTable(dtOverrideGlobals);

            // // Datepicker untuk kolom Tanggal Lahir
            // $('.datepicker').datepicker({
            //     autoclose: true,
            //     format: 'yyyy-mm-dd'
            // });

            // Aksi saat tombol delete diklik
            $('.data-table').on('click', '#btnHapus[data-remote]', function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = $(this).data('remote');
                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi',
                    text: 'Apakah ingin menghapus data ini?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                _method: 'DELETE',
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('.data-table').DataTable().draw(true);
                                });
                            },
                            error: function(err) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        }).always(function() {
                            location.reload();
                        });
                    }
                });
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            // Fungsi pencarian dan filtering
            $('.data-table').on('keyup change', '.search', function() {
                let index = $(this).closest('td').index();
                table.column(index).search(this.value).draw();
            });

            $('.data-table thead').on('change', '.select2-container', function() {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                let index = $(this).parent().index()

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
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
        $(document).ready(function() {
            // Inisialisasi Select2 untuk kolom Jenis Kelamin
            $('#searchJenisKelamin').select2({
                placeholder: 'Pilih Jenis Kelamin',
                allowClear: true
            });
        });
    </script>
@endsection
