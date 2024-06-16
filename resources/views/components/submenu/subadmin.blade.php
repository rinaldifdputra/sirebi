<ul class="sidebar-menu" data-widget="tree">
    <li class="header">Master Data</li>
    <li>
        <a href="{{ route('admin.index') }}">
            <i class="fa fa-user-secret"></i> <span>Admin</span>
        </a>
    </li>
    <li>
        <a href="{{ route('bidan.index') }}">
            <i class="fa fa-user-md"></i> <span>Bidan</span>
        </a>
    </li>
    <li>
        <a href="{{ route('pasien.index') }}">
            <i class="fa fa-users"></i> <span>Pasien</span>
        </a>
    </li>
    <li>
        <a href="{{ route('jam_praktek.index') }}">
            <i class="fa fa-clock-o"></i> <span>Jam Praktek</span>
        </a>
    </li>
</ul>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">Transaksi</li>
    <li>
        <a href="{{ route('praktek_bidan.index') }}">
            <i class="fa fa-book"></i> <span>Jadwal Praktek Bidan</span>
        </a>
    </li>
    <li>
        <a href="{{ route('praktek_bidan.index_history') }}">
            <i class="fa fa-calendar-check-o"></i> <span>History Jadwal Praktek Bidan</span>
        </a>
    </li>
</ul>
