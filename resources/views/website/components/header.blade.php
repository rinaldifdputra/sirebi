<header id="menu-jk">
    <div class="container">
        <div class="row top">
            <div class="col-md-3 d-none d-lg-block">
                <div class="call d-flex">
                    <i class="fas fa-phone"></i>
                    <div class="call-no">
                        1-898-8767-567 <br>
                        1-898-8767-568
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-7 logo">
                <img src="{{ asset('website/assets/images/logo_sirebi.png') }}" alt="">
                <a data-toggle="collapse" data-target="#menu" href="#menu"><i
                        class="fas d-block d-md-none small-menu fa-bars"></i></a>
            </div>
            <div class="col-lg-3 col-md-5 d-none d-md-block call-r">
                <div class="call d-flex">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="call-no">
                        211 Santio Street Sandio <br>
                        CA 8765-18798 USA
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav id="menu" class="d-none d-md-block">
        <div class="container">
            <div class="row nav-ro">
                <ul>
                    <li><a href="{{ route('website.index') }}">Beranda</a></li>
                    <li><a href="{{ route('website.about') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('website.service') }}">Layanan Kami</a></li>
                    <li><a href="{{ route('website.contact') }}">Hubungi Kami</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
