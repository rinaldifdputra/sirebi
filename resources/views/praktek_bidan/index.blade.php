@extends('components.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Jadwal Praktek</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if (Auth::user()->role != 'Pasien')
                <div class="mb-4">
                    <a href="{{ route('jadwal_praktek.create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i>
                        Tambah
                        Data</a>
                </div>
            @endif
            <table class="table table-bordered data-table table-striped" style="width: 100%">
                <thead>
                    <tr id="header">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Praktek</th>
                        <th>Nama Bidan</th>
                        <th>Kuota</th>
                        <th>Jumlah Reservasi</th>
                        @if (Auth::user()->role == 'Pasien')
                            <th>Status</th>
                        @endif
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input class="form-control form-control-sm search datepicker" type="text"
                                placeholder="Cari Tanggal" readonly>
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
                        @if (Auth::user()->role == 'Pasien')
                            <td></td>
                        @endif
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $jadwal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $jadwal->jam_praktek->jam_praktek }}</td>
                            <td>{{ $jadwal->bidan->nama_lengkap }}</td>
                            <td>{{ $jadwal->kuota }}</td>
                            <td>{{ $jadwal->kuota - $jadwal->reservasi_tetap_count }}</td>
                            @if (Auth::user()->role == 'Pasien')
                                <td>
                                    @php
                                        $reservasi = $jadwal->reservasi->where('pasien_id', Auth::user()->id)->first();
                                    @endphp
                                    {{ $reservasi ? $reservasi->status : 'Belum Reservasi' }}
                                </td>
                            @endif
                            <td>
                                @if (Auth::user()->role == 'Pasien')
                                    {{-- Cek apakah pengguna sedang login dan memiliki reservasi pada jadwal praktek ini --}}
                                    @if ($jadwal->reservasi_tetap_count > 0 && $jadwal->reservasi_tetap->where('pasien_id', Auth::user()->id)->isNotEmpty())
                                        {{-- Dapatkan reservasi pertama --}}
                                        @php
                                            $reservasi = $jadwal->reservasi_tetap
                                                ->where('pasien_id', Auth::user()->id)
                                                ->first();
                                        @endphp

                                        {{-- Pastikan reservasi tidak null dan status bukan 'Batal' --}}
                                        @if ($reservasi && $reservasi->status != 'Batal')
                                            {{-- Pengguna adalah pasien dan sudah memiliki reservasi yang tidak dibatalkan, tampilkan tombol edit --}}
                                            <a href="{{ route('reservasi.edit', $jadwal->id) }}"
                                                class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                        @else
                                            {{-- Pengguna adalah pasien, tetapi belum memiliki reservasi atau reservasi yang dibatalkan, tampilkan tombol tambah --}}
                                            <a href="{{ route('reservasi.create', $jadwal->id) }}"
                                                class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                        @endif
                                    @else
                                        {{-- Pengguna adalah pasien dan belum memiliki reservasi pada jadwal praktek ini, tampilkan tombol tambah --}}
                                        <a href="{{ route('reservasi.create', $jadwal->id) }}"
                                            class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
                                    @endif
                                @else
                                    <a href="{{ route('jadwal_praktek.show', $jadwal->id) }}"
                                        class="btn btn-info btn-sm"><i class="fa fa-search-plus"></i></a>
                                    <a href="{{ route('jadwal_praktek.edit', $jadwal->id) }}"
                                        class="edit btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                    <form action="{{ route('jadwal_praktek.destroy', $jadwal->id) }}" method="post"
                                        id="deleteForm" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" id="btnHapus"><i
                                                class="fa fa-trash-o"></i></button>
                                    </form>
                                @endif
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
                startDate: new Date()
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
