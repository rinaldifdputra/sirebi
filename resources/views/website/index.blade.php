@extends('website.components.layout')
@section('content')
    <!-- ################# Slider Starts Here#######################--->
    <div class="slider-detail">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>

            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('website/assets/images/slider/slide-02.jpg') }}"
                        alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class=" bounceInDown">{{ $tentang_kami->judul }}</h5>
                        <p class=" bounceInLeft" style="text-align: justify">{!! $tentang_kami->deskripsi !!}</p>

                    </div>
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('website/assets/images/slider/slide-03.jpg') }}"
                        alt="Third slide">
                    <div class="carousel-caption vdg-cur d-none d-md-block">
                        <h5 class=" bounceInDown">{{ $tentang_kami->judul }}</h5>
                        <p class=" bounceInLeft" style="text-align: justify">{!! $tentang_kami->deskripsi !!}</p>
                    </div>
                </div>

            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>


    </div>

    <!-- ################# Hospital Detail Starts Here#######################--->
    <div class="top-msg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 vkjd ohs">
                    <h2><i class="far fa-clock"></i> Jadwal Praktek</h2>
                    <table class="table table-bordered" id="data-table" style="width: 100%">
                        <thead>
                            <tr id="header">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jam Praktek</th>
                                <th>Bidan</th>
                                <th>Kuota</th>
                                <th>Sisa Kuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item => $value)
                                <tr>
                                    <td style="text-align: right;">{{ $item + 1 }}</td>
                                    <td>{{ $value->tanggal }}</td>
                                    <td>{{ $value->jam_praktek->jam_mulai }} - {{ $value->jam_praktek->jam_selesai }}</td>
                                    <td>{{ $value->bidan->nama_lengkap }}</td>
                                    <td>{{ $value->kuota }}</td>
                                    <td>{{ $value->sisa_kuota }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ################# Our Team Starts Here#######################--->
    <section class="our-team">
        <div class="container">
            <div class="inner-title row">
                <h2>Tim Kami</h2>
            </div>
            <div class="row team-row">
                @foreach ($bidan as $item)
                    <div class="col-md-3 col-sm-6">
                        <div class="single-usr">
                            <img src="{{ asset('website/assets/images/nurse.png') }}" alt="">
                            <div class="det-o">
                                <h4>{{ $item->nama_lengkap }}</h4>
                                <i>Bidan</i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- ################# Testimonial Starts Here#######################--->
    <section class="testimonial-container">
        <div class="container">
            <div class="inner-title row">
                <h2>Testimoni</h2>
            </div>
            <div class="row">
                <div class="col-md-offset-2 float-auto col-md-10">
                    <div id="testimonial-slider" class="owl-carousel">

                        @foreach ($testimoni as $items)
                            <div class="testimonial">
                                <div class="pic">
                                    @if ($items->testimoni->jenis_kelamin == 'Laki-Laki')
                                        <img src="{{ asset('website/assets/images/pasien_pria.png') }}" alt="">
                                    @elseif ($items->testimoni->jenis_kelamin == 'Perempuan')
                                        <img src="{{ asset('website/assets/images/pasien_wanita.png') }}" alt="">
                                    @endif
                                </div>
                                <p class="description">
                                    {!! $items->deskripsi !!}
                                </p>
                                <h3 class="title">{{ $items->testimoni->nama_lengkap }}
                                    <span class="post"> -
                                        {{ $items->testimoni->pekerjaan->nama_pekerjaan }}</span>
                                </h3>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
