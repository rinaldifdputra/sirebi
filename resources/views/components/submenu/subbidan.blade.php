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
