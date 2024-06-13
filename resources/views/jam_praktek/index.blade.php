@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Jam Praktek</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="mb-4">
                        <a href="{{ route('jam_praktek.create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i>
                            Tambah
                            Data</a>
                    </div>
                    <table class="table table-bordered data-table" style="width: 100%">
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
                                <td><select class="select2-container" id="searchJamSelesai">
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
                ajax: "{{ route('jam_praktek.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'jam_mulai',
                        name: 'jam_mulai'
                    },
                    {
                        data: 'jam_selesai',
                        name: 'jam_selesai'
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
            $('#searchJamMulai').select2({
                placeholder: 'Pilih Jam Mulai',
                allowClear: true
            });

            $('#searchJamSelesai').select2({
                placeholder: 'Pilih Jam Selesai',
                allowClear: true
            });
        });
    </script>
@endsection
