<ul class="sidebar-menu" data-widget="tree">
    <li class="header">
        <h5><b>Transaksi</b></h5>
    </li>
    <li
        class="{{ (request()->is('praktek_bidan/index') || request()->is('reservasi/create/*') ? 'active' : '' || request()->is('reservasi/*/edit')) ? 'active' : '' }}">
        <a href="{{ route('praktek_bidan.index') }}">
            <i class="fa fa-book"></i> <span>Jadwal Praktek Bidan</span>
        </a>
    </li>
    <li class="{{ request()->is('praktek_bidan/index_history') || request()->is('reservasi/show/*') ? 'active' : '' }}">
        <a href="{{ route('praktek_bidan.index_history') }}">
            <i class="fa fa-calendar-check-o"></i> <span>History Reservasi</span>
        </a>
    </li>
</ul>
