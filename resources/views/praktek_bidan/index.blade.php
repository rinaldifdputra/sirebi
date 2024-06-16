@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Jadwal Praktek</h3>
                </div>
                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Bidan')
                    <div class="mb-4">
                        <a href="{{ route('jadwal_praktek.create') }}" class="btn btn-success"><i class="fa fa-plus"></i>
                            Tambah
                            Data</a>
                    </div>
                @endif
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered data-table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jam Praktek</th>
                                <th>Bidan</th>
                                <th>Kuota</th>
                                <th>Sisa Kuota</th>
                                <th>Aksi</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input class="form-control form-control-sm search" type="text"
                                        placeholder="Cari Tanggal">
                                </td>
                                <td>
                                    <select class="select2-container" id="searchJamPraktek">
                                        <option value=""></option>
                                        @foreach ($jam_praktek as $jam)
                                            <option value="{{ $jam->jam_praktek }}">
                                                {{ $jam->jam_praktek }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="select2-container" id="searchBidan">
                                        <option value=""></option>
                                        @foreach ($bidan as $bdn)
                                            <option value="{{ $bdn->nama_lengkap }}">
                                                {{ $bdn->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                                <td>
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
                ajax: "{{ route('praktek_bidan.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
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
                        data: 'jam_praktek',
                        name: 'jam_praktek'
                    },
                    {
                        data: 'bidan.nama_lengkap',
                        name: 'bidan.nama_lengkap'
                    },
                    {
                        data: 'kuota',
                        name: 'kuota'
                    },
                    {
                        data: 'jumlah_reservasi',
                        name: 'jumlah_reservasi'
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
            $('#searchJamPraktek').select2({
                placeholder: 'Pilih Jam Praktek',
                allowClear: true
            });

            $('#searchBidan').select2({
                placeholder: 'Pilih Bidan',
                allowClear: true
            });
        });
    </script>
@endsection
