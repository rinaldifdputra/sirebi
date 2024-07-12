<ul class="sidebar-menu" data-widget="tree">
    <li class="header">
        <h5><b>Master Data</b></h5>
    </li>
    <li
        class="{{ request()->is('admin') || request()->is('admin/create') || request()->is('admin/*/edit') || request()->is('admin/*') ? 'active' : '' }}">
        <a href="{{ route('admin.index') }}">
            <i class="fa fa-user-secret"></i> <span>Admin</span>
        </a>
    </li>
    <li class="{{ request()->is('bidan*') ? 'active' : '' }}">
        <a href="{{ route('bidan.index') }}">
            <i class="fa fa-user-md"></i> <span>Bidan</span>
        </a>
    </li>
    <li class="{{ request()->is('pasien*') ? 'active' : '' }}">
        <a href="{{ route('pasien.index') }}">
            <i class="fa fa-users"></i> <span>Pasien</span>
        </a>
    </li>
    <li class="{{ request()->is('jam_praktek*') ? 'active' : '' }}">
        <a href="{{ route('jam_praktek.index') }}">
            <i class="fa fa-clock-o"></i> <span>Jam Praktek</span>
        </a>
    </li>
    <li class="{{ request()->is('pekerjaan*') ? 'active' : '' }}">
        <a href="{{ route('pekerjaan.index') }}">
            <i class="fa fa-folder-o"></i> <span>Pekerjaan</span>
        </a>
    </li>
</ul>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">
        <h5><b>Transaksi</b></h5>
    </li>
    <li class="{{ request()->is('praktek_bidan/index') || request()->is('jadwal_praktek*') ? 'active' : '' }}">
        <a href="{{ route('praktek_bidan.index') }}">
            <i class="fa fa-book"></i> <span>Jadwal Praktek Bidan</span>
        </a>
    </li>
    <li class="{{ request()->is('praktek_bidan/index_history') || request()->is('reservasi*') ? 'active' : '' }}">
        <a href="{{ route('praktek_bidan.index_history') }}">
            <i class="fa fa-calendar-check-o"></i> <span>History Jadwal Praktek Bidan</span>
        </a>
    </li>
</ul>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">
        <h5><b>CMS Website</b></h5>
    </li>
    <li class="{{ request()->is('tentang_kami*') ? 'active' : '' }}">
        <a href="{{ route('tentang_kami.index') }}">
            <i class="fa fa-clone"></i> <span>Tentang Kami</span>
        </a>
    </li>
    <li class="{{ request()->is('layanan_kami*') ? 'active' : '' }}">
        <a href="{{ route('layanan_kami.index') }}">
            <i class="fa fa-thumbs-o-up"></i> <span>Layanan Kami</span>
        </a>
    </li>
    <li class="{{ request()->is('testimoni*') ? 'active' : '' }}">
        <a href="{{ route('testimoni.index') }}">
            <i class="fa fa-comments-o"></i> <span>Testimoni Pasien</span>
        </a>
    </li>
</ul>
