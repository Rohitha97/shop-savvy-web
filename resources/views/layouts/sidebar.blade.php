<aside class="sidenav navbar navbar-vertical navbar-expand-xs border bg-dark border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header text-center">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}" target="_blank">
            <img src="{{ asset('assets/img/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @php
                $url = Request::url();
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ $url == route('home') ? 'active' : 'text-white' }}" href="{{ route('home') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house {{ $url == route('home') ? '' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $url == route('admin.products') ? 'active' : 'text-white' }}"
                    href="{{ route('admin.products') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i
                            class="fa-brands fa-product-hunt {{ $url == route('admin.products') ? '' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $url == route('admin.stocks') ? 'active' : 'text-white' }}"
                    href="{{ route('admin.stocks') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i
                            class="fa-brands fa-stack-exchange {{ $url == route('admin.stocks') ? '' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Stocks</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $url == route('admin.orders') ? 'active' : 'text-white' }}"
                    href="{{ route('admin.orders') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-bag-shopping {{ $url == route('admin.orders') ? '' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $url == route('admin.users') ? 'active' : 'text-white' }}"
                    href="{{ route('admin.users') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user {{ $url == route('admin.users') ? '' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $url == route('admin.usertypes') ? 'active' : 'text-white' }}"
                    href="{{ route('admin.usertypes') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-gear {{ $url == route('admin.usertypes') ? '' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Permissions</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
