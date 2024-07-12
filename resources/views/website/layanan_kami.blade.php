    @extends('website.components.layout')
    @section('content')
        <div class="page-nav no-margin row">
        </div>
        <section class="key-features kf-2">
            <div class="container">
                <div class="inner-title">
                    <h2>Layanan Kami</h2>
                </div>

                <div class="row_new">
                    @foreach ($layanan_kami as $layanan)
                        <div class="col-md-4 col-sm-6">
                            <div class="single-key">
                                {{-- <h5 class="key-title">{{ $layanan->nama_layanan }}</h5>
                                <p class="key-content">{{ $layanan->deskripsi }}</p> --}}
                                <table>
                                    <tr valign="top">
                                        <td>
                                            <h5 class="key-title">{{ $layanan->nama_layanan }}</h5>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td style="text-align: justify">
                                            {{ $layanan->deskripsi }}
                                        </td>
                                    </tr>
                                </table>
                                <p class="key-content">
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <style>
            .row_new {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                /* Jarak antar kolom dan baris */
            }

            .col-md-4 {
                flex: 1 1 calc(33.333% - 20px);
                /* 3 kolom dengan jarak 20px */
            }

            .single-key {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                /* Menjaga jarak antara header dan konten */
                align-items: flex-start;
                /* Menyelaraskan konten ke kiri */
                padding: 20px;
                border-radius: 5px;
                background: #f4f4f4;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: left;
                height: 100%;
                /* Atur tinggi penuh */
            }

            .key-title {
                font-size: 1.4em;
                font-weight: bold;
                color: #a5238e;
                margin-bottom: 10px;
                margin-top: 0;
                /* Menghapus margin atas */
            }

            .key-content {
                color: #666;
                font-size: 1em;
                line-height: 1.5;
                /* Spasi baris untuk konten */
                margin: 0;
                /* Menghapus margin default */
            }

            @media (max-width: 992px) {
                .col-md-4 {
                    flex: 1 1 calc(50% - 20px);
                    /* 2 kolom pada layar lebih kecil */
                }
            }

            @media (max-width: 576px) {
                .col-md-4 {
                    flex: 1 1 100%;
                    /* 1 kolom pada layar sangat kecil */
                }
            }
        </style>
    @endsection
