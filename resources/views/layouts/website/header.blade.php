<header class="wrapper bg-light">
    <div class="bg-dark py-1 text-white fw-bold fs-15 d-none d-md-flex">
        <div class="container d-md-flex flex-md-row justify-content-between">
            <div class="d-flex gap-1 flex-row align-items-center">
                <address class="mb-0">Friday</address>
                <div class="new__yellow py-0 fs-12" style="transform: rotate(-10deg)">
                    Black
                </div>
            </div>
            <div class="d-flex flex-row align-items-center gap-1">
                <p class="mb-0">خصم</p>
                <span class="fs-10">يصل إلى</span>
                <h6 class="fs-17 text-yellow mb-0">59%</h6>
            </div>
            <div class="d-flex flex-row align-items-center">
                <button class="btn__yellow text-white" style="color: #fff !important">
                    اشتري <img src="assets/img/ArrowRight.svg" alt="" />
                </button>
            </div>
            <img src="assets/img/Close Button.svg" alt="" style="width: 25px" />
        </div>
    </div>

    <nav class="navbar navbar-expand-lg flex-column center-nav transparent bg-primary d-none d-md-flex">
        <div style="box-shadow: 0px -1px 0px 0px #ffffff29 inset" class="w-100">
            <div class="container flex-lg-row d-flex flex-nowrap align-items-center justify-content-between">
                <div class="navbar-brand w-100">
                    <span class="text-white"> {{ __('Welcome to your purchases website') }}</span>
                </div>

                <div class="navbar-other w-100">
                    <ul class="navbar-nav flex-row align-items-center justify-content-end">
                        {{-- <li class="nav-item dropdown language-select text-uppercase">
                            <a class="nav-link text-white dropdown-item dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USD</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="dropdown-item" href="#">USD</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="#">USD</a>
                                </li>
                            </ul>
                        </li> --}}

                        {{-- <li class="nav-item dropdown language-select text-uppercase">
                            <a class="text-white nav-link dropdown-item dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">{{ LaravelLocalization::getCurrentLocale() == 'ar' ? __('ENG') : __('AR') }}</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('ar') }}">
                                        <img src="{{ asset('websiteAsset/img/ar.svg') }}"
                                            alt="{{ __('Arabic') }}" class="img-fluid">
                                        <span>{{ __('Arabic') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('en') }}">
                                        <img src="{{ asset('websiteAsset/img/en.svg') }}"
                                            alt="{{ __('English') }}" class="img-fluid">
                                        <span>{{ __('English') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}

                        <li class="d-flex align-items-center text-white">
                            تابعنا:
                            <nav class="nav social header">
                                <a href="#"><i class="uil uil-twitter"></i></a>
                                <a href="#"><i class="uil uil-facebook-f"></i></a>
                                <a href="#"><i class="uil uil-dribbble"></i></a>
                                <a href="#"><i class="uil uil-instagram"></i></a>
                                <a href="#"><i class="uil uil-youtube"></i></a>
                            </nav>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container py-2 flex-lg-row flex-nowrap align-items-center justify-content-between">
            <div class="navbar-brand w-100">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('asset/img/Logo.svg') }}" srcset="{{ asset('asset/img/Logo.svg') }}"
                        alt="" />
                </a>
            </div>

            <div class="navbar-other icons w-100">
                <ul class="navbar-nav flex-row align-items-center justify-content-end">

                    <li class="nav-item">
                        @if (auth()->check())
                        <a class="nav-link d-flex align-items-center gap-2" href="{{route("user.logout")}}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">logout</span>
                        </a>
                            @else
                            <a class="nav-link d-flex align-items-center gap-2" href="{{route("user.login")}}">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">login</span>
                            </a>
                        @endif
                    </li>

                    <li class="nav-item">
                        <a class="nav-link position-relative d-flex flex-row align-items-center"
                            href="{{ route('cart.index') }}">
                            <i class="uil uil-shopping-cart"></i>
                            @if (auth()->check())
                                <span class="badge badge-cart cart-badge"
                                    style="
                                        position: absolute;
                                        background: #ffffff;
                                        width: 20px;
                                        height: 20px;
                                        color: #000;
                                        top: -4px;
                                        right: -6px;
                    ">{{ $carts_count = auth()->user()->carts?->count() ?? 0 }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- search -->
    <div class="offcanvas offcanvas-top bg-light" id="offcanvas-search" data-bs-scroll="true">
        <div class="container d-flex flex-row py-6">
            <form class="search-form w-100">
                <input id="search-form" type="text" class="form-control" placeholder="Type keyword and hit enter" />
            </form>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>
    <nav style="box-shadow: 0px -1px 0px 0px #e4e7e9 inset"
        class="navbar navbar-expand-lg center-nav transparent bg-light py-0">
        <div class="container flex-lg-row py-0 flex-nowrap align-items-center justify-content-between">
            <div class="nav-item d-lg-none">
                <img src="assets/img/burger-bar (1) 1.svg" style="width: 30px" class="offcanvas-nav-btn" alt="" />
            </div>
            <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
                <div class="offcanvas-header d-lg-none">
                    <h3 class="fs-30 mb-0 text-white">مشترياتك</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <div class="offcanvas-body links__header ms-lg-auto d-flex flex-column h-100">
                    <ul class="navbar-nav m-0 p-0">
                        <li class="nav-item head dropdown-mega">
                            <a class="nav-link p-1" href="{{route("website.products.index")}}">{{ __('all') }}</a>
                        </li>
                        @foreach ($categories as $category)
                            <li class="nav-item head dropdown-mega">

                                <a href="{{ route('website.categories.show', $category->id) }}" class="nav-link p-0">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="offcanvas-footer d-lg-none">
                        <div>
                            <a href="mailto:first.last@email.com" class="link-inverse">info@email.com</a>
                            <br />
                            00 (123) 456 78 90 <br />
                            <nav class="nav social social-white mt-4">
                                <a href="#"><i class="uil uil-twitter"></i></a>
                                <a href="#"><i class="uil uil-facebook-f"></i></a>
                                <a href="#"><i class="uil uil-dribbble"></i></a>
                                <a href="#"><i class="uil uil-instagram"></i></a>
                                <a href="#"><i class="uil uil-youtube"></i></a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-other w-100 d-flex">
                <ul class="navbar-nav flex-row align-items-center w-100 justify-content-end">
                    <li>
                        <div class="d-flex flex-row align-items-center me-6 ms-auto">
                            <div class="icon text-white fs-22 mt-1 me-2">
                                <i class="uil uil-phone-volume text-dark"></i>
                            </div>
                            <p class="mb-0">00 (123) 456 78 90</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
