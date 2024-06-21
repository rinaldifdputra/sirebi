@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        @if (Auth::user()->role != 'Pasien')
                            History Daftar Jadwal Praktek
                        @else
                            History Daftar Reservasi
                        @endif
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered data-table table-striped" style="width: 100%">
                        <thead>
                            <tr id="header">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jam Praktek</th>
                                <th>Bidan</th>
                                <th>Kuota</th>
                                <th>Sisa Kuota</th>
                                @if (Auth::user()->role == 'Pasien')
                                    <th>Status</th>
                                @endif
                                <th>Aksi</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input class="form-control form-control-sm search datepicker" type="text"
                                        placeholder="Cari Tanggal" readonly></td>
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
                                <td></td>
                                @if (Auth::user()->role == 'Pasien')
                                    <td></td>
                                @endif
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $jadwal)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $jadwal->jam_praktek->jam_praktek }}</td>
                                    <td>{{ $jadwal->bidan->nama_lengkap }}</td>
                                    <td>{{ $jadwal->kuota }}</td>
                                    <td>{{ $jadwal->kuota - $jadwal->reservasi_tetap_count }}</td>
                                    @if (Auth::user()->role == 'Pasien')
                                        <td>
                                            @php
                                                $reservasi = $jadwal->reservasi
                                                    ->where('pasien_id', Auth::user()->id)
                                                    ->first();
                                            @endphp
                                            {{ $reservasi ? $reservasi->status : 'Belum Reservasi' }}
                                        </td>
                                    @endif
                                    <td>
                                        @if (Auth::user()->role != 'Pasien')
                                            <a href="{{ route('jadwal_praktek.show', $jadwal->id) }}"
                                                class="btn btn-info btn-sm"><i class="fa fa-search-plus"></i></a>
                                        @else
                                            <a href="{{ route('reservasi.show', $jadwal->id) }}"
                                                class="btn btn-info btn-sm"><i class="fa fa-search-plus"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
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
            $('#searchBidan').select2({
                placeholder: 'Pilih Nama Bidan',
                allowClear: true
            });

            // Apply the select2 dropdown search
            $('#searchJamPraktek').select2({
                placeholder: 'Pilih Jam Praktek',
                allowClear: true
            });

            // Datepicker
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                orientation: 'bottom',
                clearBtn: true,
                endDate: new Date()
            });

            // Apply the select2 dropdown search
            $('#searchBidan, #searchJamPraktek').on('change', function() {
                var val = $(this).val();
                var index = $(this).closest('td').index();
                table.column(index).search(val ? '^' + $(this).val() + '$' : '', true, false).draw();
            });

            $('#searchJamPraktek').on('change', function() {
                var val = $(this).val();
                table.column(2).search(val ? '^' + val + '$' : '', true, false).draw();
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
    </script>
@endsection
