@extends('layouts.website.app')

@section('head_title')
    {{ __('login') }}
@endsection
@section('content')
    <section class="wrapper bg-light">
        <div class="container pt-12 pt-md-14 pb-14 pb-md-16">
            <div class="auth">
                <div class="top">
                    <a href="#" class="active">{{ __('login') }}</a>
                    <a href="{{ route('user.register') }}">{{ __('register') }}</a>
                </div>
                <form id="loginForm" action="{{ route('user.auth.login') }}" method="POST">
                    @csrf
                    <span>{{__("email")}}</span>
                    <div class="form- mb-3">
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span>{{__("password")}}</span>
                    </div>
                    <div class="form- mb-3">
                        <input type="password" name="password" class="form-control" placeholder="{{__("password")}}" />
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button class="btn__shop w-100">
                        {{__("login")}}<img src="{{ asset('asset/img/ArrowRight.svg') }}" alt="" />
                    </button>


                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const productsSection = new Swiper('.products-section-slider', {
            slidesPerView: 1,
            spaceBetween: 0,
            autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: '.products-section-slider .swiper-button-next',
                prevEl: '.products-section-slider .swiper-button-prev',
            },
        });

        const productsSlider = () => {
            let productsSliders = document.querySelectorAll('.best-seller-slider')
            let nextArrow = document.querySelectorAll('.products-slider__inner .swiper-button-next')
            let prevArrow = document.querySelectorAll('.products-slider__inner .swiper-button-prev')
            productsSliders.forEach((slider, index) => {
                const swiper = new Swiper(slider, {
                    slidesPerView: 2,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: nextArrow[index],
                        prevEl: prevArrow[index],
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 10
                        },
                        992: {
                            slidesPerView: 3,
                            spaceBetween: 20
                        },
                        1200: {
                            slidesPerView: 4,
                            spaceBetween: 55
                        }
                    }
                });
            })
        }

        window.addEventListener('load', productsSlider)
    </script>
@endpush
