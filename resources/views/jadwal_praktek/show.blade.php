@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Jadwal Praktek</h3>
                </div>
                <div class="box-body">
                    <div class="container mt-5">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwal->tanggal }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jam_praktek_id" class="col-sm-2 control-label">Jam Praktek</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwal->jam_praktek->jam_mulai }} -
                                            {{ $jadwal->jam_praktek->jam_selesai }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bidan_id" class="col-sm-2 control-label">Bidan</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwal->bidan->nama_lengkap }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kuota" class="col-sm-2 control-label">Kuota</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwal->kuota }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table id="pasien-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Antrian</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>No HP</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="box-body">
                    <div class="box-footer">
                        <a href="{{ route('jadwal_praktek.index') }}" class="btn btn-info">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#pasien-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('jadwal_praktek.getPasienByJadwal', $jadwal->id) }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_antrian',
                        name: 'no_antrian'
                    },
                    {
                        data: 'nama_pasien',
                        name: 'nama_pasien'
                    },
                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir'
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
