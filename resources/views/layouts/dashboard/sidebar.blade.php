<style>

    .menu-vertical .menu-sub .menu-link{
        padding-left: 3rem !important;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard.index') }}" class="app-brand-link d-flex align-items-center gap-2">
            <img src="{{ asset('asset/img/dashboard/dummy logo.png') }}" style="width: 50px" alt="">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ __('home.Dashboard') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <img src="{{ asset('asset/img/dashboard/dummy logo.png') }}" alt="">
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 pt-5">
        <!-- Dashboard -->
        <li class="menu-item {{ isActiveRoute(['dashboard.index']) }}">
            <a href="{{ route('dashboard.index') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fa-solid fa-house"></i>
                <div data-i18n="Analytics">{{ __('home.Dashboard') }}</div>
            </a>
        </li>
        <li class="menu-item {{ isActiveRoute(['admins.index','admins.create','admins.edit', 'users.index','users.create','users.edit','clubs.index','clubs.create','clubs.edit','vendors.index','vendors.create','vendors.edit']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle d-flex align-items-center gap-2">
                <i class="fa-solid fa-users"></i>
                <div data-i18n="Layouts">{{ __('home.Users') }}</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ isActiveRoute(['admins.index','admins.create','admins.edit']) }}">
                    <a href="{{ route('admins.index') }}" class="menu-link ">
                        <div data-i18n="Without menu">{{ __('home.Admins') }}</div>
                    </a>
                </li>

                <li class="menu-item {{ isActiveRoute(['user.index','user.create','user.edit']) }}">
                    <a href="{{ route('users.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">{{ __('home.Users') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ isActiveRoute(['payment.index']) }}">
            <a href="{{ route('payment.index') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fa-brands fa-paypal"></i>
                <div data-i18n="Analytics">{{ __('home.Payments') }}</div>
            </a>
        </li>





        <li class="menu-item {{ isActiveRoute(['orders.index','orders.show']) }}">
            <a href="{{ route('orders.index') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fa-solid fa-box"></i>
                <div data-i18n="Analytics">{{ __('home.orders') }}</div>
            </a>
        </li>






        <li class="menu-item {{ isActiveRoute(['category_products.index' ,'category_products.create','category_products.edit','products.index' ,'products.create','products.edit','offers.index' ,'offers.create','offers.edit']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle d-flex align-items-center gap-2">
                <i class='bx bx-list-ul'></i>
                <div data-i18n="Layouts">{{ __('home.porduct and catedory') }}</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ isActiveRoute(['category_products.index' ,'category_products.create','category_products.edit',]) }}">
                    <a href="{{ route('category_products.index') }}" class="menu-link d-flex align-items-center gap-2">
                        <div data-i18n="Without navbar">{{ __('home.category_products') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ isActiveRoute(['products.index' ,'products.create','products.edit']) }}">
                    <a href="{{ route('products.index') }}" class="menu-link d-flex align-items-center gap-2">
                        <div data-i18n="Without navbar">{{ __('home.products') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ isActiveRoute(['offers.index' ,'offers.create','offers.edit']) }}">
                    <a href="{{ route('offers.index') }}" class="menu-link d-flex align-items-center gap-2">
                        <div data-i18n="Without navbar">{{ __('home.offers') }}</div>
                    </a>
                </li>
            </ul>
        </li>







        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle d-flex align-items-center gap-2">
                <i class="fa-solid fa-gear"></i>
                <div data-i18n="Authentications">{{ __('home.Settings') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ isActiveRoute(['settings.index']) }}">
                    <a href="{{ route('settings.index') }}" class="menu-link">
                        <div data-i18n="Authentications">الإعدادات</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
