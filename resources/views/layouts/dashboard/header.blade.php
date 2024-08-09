<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <h3 class="mb-0 "> <i class='@yield('header__icon') fs-2'></i> @yield('header__title')</h3>




        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">

            <li> @php
                $lang = config('app.locale');
            @endphp
                @if ($lang != 'ar')
            <li data-bs-toggle="dropdown">
                <div>
                    <a class="dropdown-item p-2 text-start " style="text-align: start" >
                        <img src="{{ asset('assets\img\us.svg') }}" alt="" class="img-fluid rounded-1"
                            width="20" height="20">
                        En
                    </a>
                </div>
            </li>
            <ul class="dropdown-menu  dropdown-menu-end">
                <li>
                    <a class="dropdown-item p-2 text-start" style="text-align: start"
                        href="{{ route('language', 'ar') }}">
                        <img src="{{ asset('assets/img/sa.svg') }}" alt="" class="img-fluid rounded-1"
                            width="20" height="20">
                        AR
                    </a>
                </li>
                <li>
                    <a class="dropdown-item p-2 text-start" style="text-align: start"
                        href="{{ route('language', 'en') }}">
                        <img src="{{ asset('assets\img\us.svg') }}" alt="" class="img-fluid rounded-1"
                            width="20" height="20">
                        En
                    </a>
                </li>



            </ul>
        @else
            <li class="" data-bs-toggle="dropdown">
                <a class="dropdown-item p-2 text-start" style="text-align: start">
                    <img src="{{ asset('assets/img/sa.svg') }}" alt="" class="img-fluid rounded-1"
                        width="20" height="20">
                    AR
                </a>
            </li>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item p-2 text-start" style="text-align: start"
                        href="{{ route('language', 'ar') }}">
                        <img src="{{ asset('assets/img/sa.svg') }}" alt="" class="img-fluid rounded-1"
                            width="20" height="20">
                        AR
                    </a>
                </li>
                <li>
                    <a class="dropdown-item p-2 text-start" style="text-align: start"
                        href="{{ route('language', 'en') }}">
                        <img src="{{ asset('assets\img\us.svg') }}" alt="" class="img-fluid rounded-1"
                            width="20" height="20">
                        En
                    </a>
                </li>



            </ul>
            @endif
            </li>
            <!-- Place this tag where you want the button to render. -->


            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src={{ image_url(auth('admin')->user()->img) }} alt
                            class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ image_url(auth('admin')->user()->img) }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ auth('admin')->user()->name }}</span>
                                    <small class="text-muted">Admin</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('settings.index')}}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('settings.index')}}">
                            <i class="bx bx-cog me-2"></i>
                            <span class="align-middle">Settings</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a class="dropdown-item" href="#">
                            <span class="d-flex align-items-center align-middle">
                                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                <span class="flex-grow-1 align-middle">Billing</span>
                                <span
                                    class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                            </span>
                        </a>
                    </li> --}}
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
