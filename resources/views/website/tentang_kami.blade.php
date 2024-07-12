    @extends('website.components.layout')
    @section('content')
        <div class="page-nav no-margin row">
        </div>
        <div class="about-us">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <img src="{{ asset('website/assets/images/istockphoto-1303601244-612x612.jpg') }}" alt="">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <h2>{{ $tentang_kami->judul }}</h2>
                        <p style="text-align: justify"> {!! $tentang_kami->deskripsi !!}</p>

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
                                    <i>{{ $item->pekerjaan }}</i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endsection
