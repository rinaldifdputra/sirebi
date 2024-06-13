<aside class="main-sidebar">
    <section class="sidebar">
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        @if (Auth::user()->role == 'Admin')
            @include('components.submenu.subadmin')
        @elseif (Auth::user()->role == 'Bidan')
            @include('components.submenu.subbidan')
        @elseif (Auth::user()->role == 'Pasien')
            @include('components.submenu.subpasien')
        @endif
    </section>
</aside>
