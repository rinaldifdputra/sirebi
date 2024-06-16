@extends('components.layout')
@section('content')
    <div class="row">
        <div class="col-xs-8">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Reservasi Pasien</h3>
                </div>
                <div class="box-body">
                    <button type="button" class="btn btn-success" id="tambah-reservasi">
                        <i class="fa fa-plus"></i> Tambah Reservasi
                    </button>
                    <br><br>
                    <table id="pasien-table" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Antrian</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>No HP</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservasi as $item => $value)
                                <tr>
                                    <td style="text-align: right; width:15px;">{{ $item + 1 }}</td>
                                    <td style="width: 50px">{{ $value->no_antrian }}</td>
                                    <td>{{ $value->pasien->nama_lengkap }}</td>
                                    <td style="width: 120px">{{ $value->pasien->tanggal_lahir }}</td>
                                    <td style="width: 110px">{{ $value->pasien->jenis_kelamin }}</td>
                                    <td style="width: 50px">{{ $value->pasien->no_hp }}</td>
                                    <td style="width: 50px">{{ $value->status }}</td>
                                    <td style="width: 150px">
                                        @if ($value->status != 'Batal')
                                            <button type="button" class="btn btn-warning btn-sm edit" data-toggle="modal"
                                                data-target="#editModalBatal_{{ $value->id }}">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>

                                            <button type="button" class="btn btn-info btn-sm edit" data-toggle="modal"
                                                data-target="#editModalJadwalUlang_{{ $value->id }}">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        @endif

                                        <form action="{{ route('reservasi.destroy', ['id' => $value->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>

                                        <div class="modal fade" id="editModalBatal_{{ $value->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modal-edit-reservasi-label">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="modal-edit-reservasi-label">Batal
                                                            Reservasi</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="form-batal-reservasi-{{ $value->id }}" method="POST"
                                                        action="{{ route('reservasi.update', ['id' => $value->id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" id="edit_reservasi_id"
                                                                value="{{ $value->id }}">
                                                            <input type="hidden" name="jadwal_praktek_id"
                                                                value="{{ $value->jadwal_praktek_id }}">
                                                            <input type="hidden" name="jadwal_praktek_id"
                                                                value="{{ $value->pasien_id }}">

                                                            <div class="form-group row">
                                                                <label for="edit_tanggal"
                                                                    class="col-sm-4 col-form-label text-right">Tanggal:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->jadwal_praktek->tanggal }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_jam_praktek"
                                                                    class="col-sm-4 col-form-label text-right">Jam
                                                                    Praktek:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->jadwal_praktek->jam_praktek->jam_mulai }} -
                                                                    {{ $value->jadwal_praktek->jam_praktek->jam_selesai }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_bidan"
                                                                    class="col-sm-4 col-form-label text-right">Bidan:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->jadwal_praktek->bidan->nama_lengkap }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_kuota"
                                                                    class="col-sm-4 col-form-label text-right">Kuota:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->jadwal_praktek->kuota }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_sisa_kuota"
                                                                    class="col-sm-4 col-form-label text-right">Sisa
                                                                    Kuota:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $sisaKuota }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_pasien_id"
                                                                    class="col-sm-4 col-form-label text-right">Nama
                                                                    Pasien:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->pasien->nama_lengkap }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_pasien_id"
                                                                    class="col-sm-4 col-form-label text-right">Status Saat
                                                                    Ini:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->status }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_status"
                                                                    class="col-sm-4 col-form-label text-right">Status Diubah
                                                                    Ke:</label>
                                                                <div class="col-sm-8">
                                                                    <select class="select2" name="status" id="edit_status"
                                                                        required>
                                                                        <option value="Batal"
                                                                            {{ $value->status == 'Batal' ? 'selected' : '' }}>
                                                                            Batal</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="edit_keterangan"
                                                                    class="col-sm-4 col-form-label text-right">Keterangan:</label>
                                                                <div class="col-sm-8">
                                                                    <textarea class="form-control" name="keterangan" id="edit_keterangan" rows="3">{{ $value->keterangan }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">
                                                                <i class="fa fa-arrow-left"></i> Batal
                                                            </button>
                                                            <button type="submit" class="btn btn-success"
                                                                id="btnEditReservasi">
                                                                <i class="fa fa-save"></i> Simpan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="editModalJadwalUlang_{{ $value->id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="modal-edit-reservasi-label">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="modal-edit-reservasi-label">Jadwal
                                                            Ulang Reservasi</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="form-jadwal-ulang-reservasi-{{ $value->id }}"
                                                        method="POST"
                                                        action="{{ route('reservasi.update', ['id' => $value->id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" id="edit_reservasi_id"
                                                                value="{{ $value->id }}">
                                                            <input type="hidden" name="jadwal_praktek_id"
                                                                value="{{ $value->jadwal_praktek_id }}">
                                                            <input type="hidden" name="pasien_id"
                                                                value="{{ $value->pasien_id }}">

                                                            <div class="form-group row">
                                                                <label for="edit_tanggal"
                                                                    class="col-sm-4 col-form-label text-right">Tanggal:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->jadwal_praktek->tanggal }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_jam_praktek"
                                                                    class="col-sm-4 col-form-label text-right">Jam
                                                                    Praktek:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->jadwal_praktek->jam_praktek->jam_mulai }} -
                                                                    {{ $value->jadwal_praktek->jam_praktek->jam_selesai }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_bidan"
                                                                    class="col-sm-4 col-form-label text-right">Bidan:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->jadwal_praktek->bidan->nama_lengkap }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_kuota"
                                                                    class="col-sm-4 col-form-label text-right">Kuota:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->jadwal_praktek->kuota }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_sisa_kuota"
                                                                    class="col-sm-4 col-form-label text-right">Sisa
                                                                    Kuota:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $sisaKuota }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_pasien_id"
                                                                    class="col-sm-4 col-form-label text-right">Nama
                                                                    Pasien:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->pasien->nama_lengkap }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_pasien_id"
                                                                    class="col-sm-4 col-form-label text-right">Status Saat
                                                                    Ini:</label>
                                                                <div class="col-sm-8">
                                                                    {{ $value->status }}
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="edit_status"
                                                                    class="col-sm-4 col-form-label text-right">Status
                                                                    Diubah Ke:</label>
                                                                <div class="col-sm-8">
                                                                    <select class="select2" name="status"
                                                                        id="edit_status" required>
                                                                        @if (Auth::user()->role != 'Pasien')
                                                                            <option value="Jadwal Ulang"
                                                                                {{ $value->status == 'Jadwal Ulang' ? 'selected' : '' }}>
                                                                                Jadwal Ulang</option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="edit_jadwal_praktek_id"
                                                                    class="col-sm-4 col-form-label text-right">Jadwal
                                                                    Praktek:</label>
                                                                <div class="col-sm-8">
                                                                    <select class="select2" name="jadwal_praktek_id"
                                                                        id="edit_jadwal_praktek_id">
                                                                        @foreach ($availableJadwalPraktek as $jadwal)
                                                                            <option value="{{ $jadwal->id }}"
                                                                                {{ $value->jadwal_praktek_id == $jadwal->id ? 'selected' : '' }}>
                                                                                {{ $jadwal->tanggal }} -
                                                                                {{ $jadwal->jam_praktek->jam_mulai }} -
                                                                                {{ $jadwal->jam_praktek->jam_selesai }}
                                                                                (Sisa Kuota: {{ $jadwal->sisa_kuota }})
                                                                                - {{ $jadwal->bidan->nama_lengkap }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="edit_keterangan"
                                                                    class="col-sm-4 col-form-label text-right">Keterangan:</label>
                                                                <div class="col-sm-8">
                                                                    <textarea class="form-control" name="keterangan" id="edit_keterangan" rows="3">{{ $value->keterangan }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">
                                                                <i class="fa fa-arrow-left"></i> Batal
                                                            </button>
                                                            <button type="submit" class="btn btn-success"
                                                                id="btnJadwalUlangReservasi">
                                                                <i class="fa fa-save"></i> Simpan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                $('#form-batal-reservasi-{{ $value->id }}').on('submit', function(event) {
                                                    event.preventDefault(); // Prevent the form from submitting normally

                                                    Swal.fire({
                                                        title: 'Konfirmasi',
                                                        text: 'Apakah Anda yakin ingin membatalkan reservasi ini?',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Ya, Batalkan!',
                                                        cancelButtonText: 'Batal'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // Submit the form
                                                            $.ajax({
                                                                url: $(this).attr('action'),
                                                                type: 'POST',
                                                                data: $(this).serialize(),
                                                                success: function(response) {
                                                                    Swal.fire({
                                                                        title: 'Berhasil!',
                                                                        text: 'Reservasi berhasil dibatalkan.',
                                                                        icon: 'success'
                                                                    }).then(() => {
                                                                        location
                                                                            .reload(); // Reload the page after successful operation
                                                                    });
                                                                },
                                                                error: function(err) {
                                                                    Swal.fire({
                                                                        title: 'Gagal!',
                                                                        text: 'Terjadi kesalahan saat membatalkan reservasi.',
                                                                        icon: 'error'
                                                                    });
                                                                }
                                                            });
                                                        }
                                                    });
                                                });

                                                $('#form-jadwal-ulang-reservasi-{{ $value->id }}').on('submit', function(event) {
                                                    event.preventDefault(); // Prevent the form from submitting normally

                                                    Swal.fire({
                                                        title: 'Konfirmasi',
                                                        text: 'Apakah Anda yakin ingin menjadwalkan ulang reservasi ini?',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Ya, Jadwalkan Ulang!',
                                                        cancelButtonText: 'Batal'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // Submit the form
                                                            $.ajax({
                                                                url: $(this).attr('action'),
                                                                type: 'POST',
                                                                data: $(this).serialize(),
                                                                success: function(response) {
                                                                    Swal.fire({
                                                                        title: 'Berhasil!',
                                                                        text: 'Reservasi berhasil dijadwalkan ulang.',
                                                                        icon: 'success'
                                                                    }).then(() => {
                                                                        location
                                                                            .reload(); // Reload the page after successful operation
                                                                    });
                                                                },
                                                                error: function(err) {
                                                                    Swal.fire({
                                                                        title: 'Gagal!',
                                                                        text: 'Terjadi kesalahan saat menjadwalkan ulang reservasi.',
                                                                        icon: 'error'
                                                                    });
                                                                }
                                                            });
                                                        }
                                                    });
                                                });

                                            });
                                        </script>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Jadwal Praktek</h3>
                </div>
                <div class="box-body">
                    <div class="container mt-5">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group row">
                                    <label for="tanggal" class="col-sm-2 control-label text-right">Tanggal:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwal->tanggal }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jam_praktek_id" class="col-sm-2 control-label text-right">Jam
                                        Praktek:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwal->jam_praktek->jam_mulai }} -
                                            {{ $jadwal->jam_praktek->jam_selesai }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bidan_id" class="col-sm-2 control-label text-right">Bidan:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwal->bidan->nama_lengkap }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kuota" class="col-sm-2 control-label text-right">Kuota:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $jadwal->kuota }}</p>
                                    </div>
                                </div>
                                <div class="form-group row" id="sisa-kuota">
                                    <label for="kuota" class="col-sm-2 control-label text-right">Sisa Kuota:</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{ $sisaKuota }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="box-footer">
                        <a href="{{ route('praktek_bidan.index') }}" class="btn btn-info">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Reservasi -->
    <div class="modal fade" id="modal-tambah-reservasi" tabindex="-1" role="dialog"
        aria-labelledby="modal-tambah-reservasi-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-tambah-reservasi-label">Tambah Reservasi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-tambah-reservasi" method="POST"
                    action="{{ route('reservasi.store', ['jadwalPraktekId' => $jadwal->id]) }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="jadwal_praktek_id" value="{{ $jadwal->id }}">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-5 control-label text-right">Tanggal:</label>
                            <div class="col-sm-7">
                                {{ $jadwal->tanggal }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jam_praktek" class="col-sm-5 control-label text-right">Jam Praktek:</label>
                            <div class="col-sm-7">
                                {{ $jadwal->jam_praktek->jam_mulai }} - {{ $jadwal->jam_praktek->jam_selesai }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bidan" class="col-sm-5 control-label text-right">Bidan:</label>
                            <div class="col-sm-7">
                                {{ $jadwal->bidan->nama_lengkap }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kuota" class="col-sm-5 control-label text-right">Kuota:</label>
                            <div class="col-sm-7">
                                {{ $jadwal->kuota }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sisa_kuota" class="col-sm-5 control-label text-right">Sisa Kuota:</label>
                            <div class="col-sm-7">
                                {{ $sisaKuota }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pasien_id" class="col-sm-5 control-label text-right">Nama Pasien:</label>
                            <div class="col-sm-7">
                                <select class="select2" name="pasien_id" id="pasien_id" required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach ($pasien as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa fa-arrow-left"></i> Batal</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Reservasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        $(document).ready(function() {

            // Initialize Select2
            $('.select2').select2();

            // Show Add Reservation Modal
            $('#tambah-reservasi').on('click', function() {
                $('#modal-tambah-reservasi').modal('show');
            });



            // Add Reservation
            var sisaKuota = {{ $sisaKuota }}; // Get the remaining quota from the back-end

            // Disable the reservation button if no quota is left
            if (sisaKuota <= 0) {
                $('#tambah-reservasi').prop('disabled', true);
                $('#tambah-reservasi').text('Kuota Penuh');
            }

            // Show Add Reservation Modal
            $('#tambah-reservasi').on('click', function() {
                if (sisaKuota > 0) {
                    $('#modal-tambah-reservasi').modal('show');
                } else {
                    Swal.fire('Kuota Penuh!', 'Tidak bisa menambah reservasi karena kuota sudah penuh.',
                        'error');
                }
            });

            // Add Reservation
            $('#form-tambah-reservasi').on('submit', function(e) {
                e.preventDefault();
                if (sisaKuota > 0) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Anda akan menambah reservasi baru',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, tambah!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('reservasi.store', ['jadwalPraktekId' => $jadwal->id]) }}',
                                data: $('#form-tambah-reservasi').serialize(),
                                success: function(response) {
                                    $('#modal-tambah-reservasi').modal('hide');
                                    Swal.fire('Ditambah!',
                                        'Reservasi baru telah ditambah.', 'success');
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire('Gagal!',
                                        'Terjadi kesalahan saat menambah reservasi.',
                                        'error');
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire('Kuota Penuh!', 'Tidak bisa menambah reservasi karena kuota sudah penuh.',
                        'error');
                }
            });


            // Handle delete button click
            $('.delete').on('click', function(e) {
                e.preventDefault(); // Prevent form submission
                var form = $(this).closest('form'); // Get the closest form
                var url = form.attr('action'); // Get form action URL
                var token = $('input[name="_token"]').val(); // Get CSRF token

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda akan menghapus reservasi ini',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                _token: token,
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                Swal.fire('Dihapus!', 'Reservasi telah dihapus.',
                                    'success');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Gagal!',
                                    'Terjadi kesalahan saat menghapus reservasi.',
                                    'error');
                            }
                        });
                    }
                });
            });

            // Menampilkan SweetAlert untuk notifikasi
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
