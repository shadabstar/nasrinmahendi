<!-- ========== Left Sidebar Start ========== -->

<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">

            {{-- Welcome, {{ auth()->user()->name }} --}}
            <ul>
                @php
                    $role = session('role');
                @endphp
                {{-- <li class="text-muted menu-title">Navigation</li> --}}

                <li class="">
                    <a href="{{ route('service-provider-dashboard') }}" class="waves-effect @yield('dashboard')"><i
                            class="ti-home"></i>
                        <span>Dashboard </span> </a>
                </li>

                <li class="">
                    <a href="{{ route('order-list') }}" class="waves-effect @yield('business')"><i
                            class="ti-user"></i>
                        <span> Orders </span> </a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->
