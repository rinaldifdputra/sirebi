<style>
    .nav-ro {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .nav-ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 15px;
        /* Spasi antara elemen list, sesuaikan sesuai kebutuhan */
    }

    .nav-ul li {
        display: inline-block;
    }

    .navbar li.active a {
        color: #a5238e !important;
    }
</style>

@php
    use App\Models\CMS_TentangKami;

    $tentang_kami = CMS_TentangKami::first();
    $hari = date('l');
@endphp

<header id="menu-jk">
    <div class="container">
        <div class="row top">
            <div class="col-md-3 d-none d-lg-block">
                <div class="call d-flex">
                    <i class="fas fa-phone"></i>
                    <div class="call-no">
                        Hubungi Kami<br />
                        {{ $tentang_kami->telp }}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-7 logo">
                <img src="{{ asset('website/assets/images/logo_sirebi.png') }}" alt="">
                {{-- <i class="fas fa-hospital"></i> --}}
                <a data-toggle="collapse" data-target="#menu" href="#menu"><i
                        class="fas d-block d-md-none small-menu fa-bars"></i></a>
            </div>
            <div class="col-lg-3 col-md-5 d-none d-md-block call-r">
                <div class="call d-flex">
                    <i class="fas fa-calendar-alt"></i>
                    <div class="call-no">
                        {{ hari_ini($hari) }},{{ tanggal_indonesia(date('Y-m-d')) }} <br>
                        </span><span id="jam">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav id="menu" class="d-none d-md-block">
        <div class="container">
            <div class="row nav-ro justify-content-center">
                <ul class="nav-ul">
                    <li class="{{ request()->is('/') ? 'active' : '' }}"><a
                            href="{{ route('website.index') }}">Beranda</a></li>
                    <li class="{{ request()->is('website/tentang_kami') ? 'active' : '' }}">
                        <a href="{{ route('website.tentang_kami') }}">Tentang Kami</a>
                    </li>
                    <li class="{{ request()->is('website/layanan_kami') ? 'active' : '' }}"><a
                            href="{{ route('website.layanan_kami') }}">Layanan Kami</a></li>
                    <li class="{{ request()->is('website/hubungi_kami') ? 'active' : '' }}"><a
                            href="{{ route('website.hubungi_kami') }}">Hubungi Kami</a></li>
                    <li>
                        @if (Auth::check())
                            @if (Auth::user()->role == 'Admin')
                                <a href="{{ route('admin_dashboard.dashboard') }}" target="_blank">
                                    <i class="fas fa-user"></i> Selamat datang, {{ Auth::user()->nama_lengkap }}</a> |
                                <a href="{{ route('logout') }}"><span style="color: #dc3545;">Logout </span></a>
                            @elseif (Auth::user()->role == 'Pasien')
                                <a href="{{ route('pasien_dashboard.dashboard') }}" target="_blank">
                                    <i class="fas fa-user"></i> Selamat datang, {{ Auth::user()->nama_lengkap }}</a> |
                                <a href="{{ route('logout') }}"><span style="color: #dc3545;">Logout </span></a>
                            @elseif (Auth::user()->role == 'Bidan')
                                <a href="{{ route('bidan_dashboard.dashboard') }}" target="_blank">
                                    <i class="fas fa-user"></i> Selamat datang, {{ Auth::user()->nama_lengkap }}</a> |
                                <a href="{{ route('logout') }}"><span style="color: #dc3545;">Logout </span></a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" target="_blank">Login</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<script type="text/javascript">
    // 1 detik = 1000
    window.setTimeout("waktu()", 1000);

    function waktu() {
        var tanggal = new Date();
        setTimeout("waktu()", 1000);

        var jam = tanggal.getHours();
        if (jam < 10) {
            jam = '0' + jam;
        } else {
            jam;
        }

        var menit = tanggal.getMinutes();
        if (menit < 10) {
            menit = '0' + menit;
        } else {
            menit;
        }

        var detik = tanggal.getSeconds();
        if (detik < 10) {
            detik = '0' + detik;
        } else {
            detik;
        }

        document.getElementById("jam").innerHTML = jam + ":" + menit + ":" + detik + ' WIB';
    }
</script>
