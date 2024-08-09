@extends('layouts.website.app')

@section('head_title', $product->title)

@push('styles')
    <title>{{ $product->name }}</title>
@endpush
@section('content')
    <div class="content-wrapper">
        <section class="wrapper bg-light">
            <div class="container py-14 py-md-16">
                <div class="row gx-md-8 gx-xl-12 gy-8">
                    <div class="col-lg-6">
                        <div class="swiper-container swiper-thumbs-container" data-margin="10" data-dots="false"
                            data-nav="true" data-thumbs="true">
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <figure class="rounded"@style("height: 600px;")>
                                            <img src="{{ image_url($product->img) }}"
                                                srcset="{{ image_url($product->img) }}" alt="" /><a
                                                class="item-link" href="{{ image_url($product->img) }}"
                                                data-glightbox data-gallery="product-group"><i
                                                    class="uil uil-focus-add"></i></a>
                                        </figure>
                                    </div>
                                    @php
                                        $images=json_decode($product->images)??[];
                                    @endphp

                                    @if (is_array($images) && count($images) > 0)
                                        @foreach ($images as $image)
                                            <div class="swiper-slide">
                                                <figure class="rounded">
                                                    <img src="{{ image_url($image) }}"
                                                        srcset="{{ image_url($image) }}" alt="" /><a
                                                        class="item-link" href="{{ image_url($image) }}"
                                                        data-glightbox data-gallery="product-group"><i
                                                            class="uil uil-focus-add"></i></a>
                                                </figure>
                                            </div>
                                        @endforeach
                                    @endif

                                    <!--/.swiper-slide -->
                                </div>
                                <!--/.swiper-wrapper -->
                            </div>
                            <div class="swiper swiper-thumbs">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ image_url($product->img) }}"
                                            style="width: 100px; height:100px;"
                                            srcset="{{ image_url($product->img) }}" class="rounded"
                                            alt="" />
                                    </div>
                                    @php
                                    $images=json_decode($product->images)??[];
                                    @endphp
                                    @foreach ($images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ image_url($image) }}"
                                                style="width: 100px; height:100px;"
                                                srcset="{{ image_url($image) }}" class="rounded"
                                                alt="" />
                                        </div>
                                    @endforeach
                                </div>
                                <!--/.swiper-wrapper -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="post-header mb-5">
                            {{-- <a href="#" class="link-body ratings-wrapper"><span
                                    class="ratings four"></span><span>({{ __('Reviews') }})</span></a> --}}
                            <h3 class="post-title display-5 fs-15 mt-4">
                                <a href="#" class="link-dark fs-25">{{ $product->name }}</a>
                            </h3>
                            <div class="row py-4">
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <span class="desc">{{ __('available') }} :</span>
                                        <span
                                            class="text-success">{{ $product->stock > 0 ? __('available') : __('unavailable') }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <span class="desc">{{ __('category') }} :</span>
                                        <span class="text-success">{{ $product->categories()->first()?->name }}</span>
                                    </p>
                                </div>

                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <p class="price">
                                    @if ($product->price_after_discount != 0)
                                        <del><span class="amount fs-20 "
                                                style="line-height: 10px">{{ ($product->price) }}
                                                $</span></del>
                                    @endif
                                    <ins><span class="amount fs-20 product_price"
                                            style="line-height: 10px">{{ $product->price_after_discount == 0 ? ($product->price) : ($product->price_after_discount) }}
                                            </span> $</ins>
                                </p>

                            </div>
                        </div>
                        <p class="mb-6 description">
                            {{ substr($product->description, 0, 300) }}..
                        </p>


                        <form id="addToCartForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="product-info-list">


                                @if ($product->attributes && count($product->attributes))
                                    @foreach ($product->attributes as $attribute)
                                        <div class="item ">
                                            @if ($attribute->name == "Color")
                                                <div class="color-wrap">
                                                    <legend class="h6 fs-16 text-body mb-3">{{ $attribute->name }}:
                                                    </legend>
                                                    <fieldset class="picker">
                                                        @foreach ($attribute->values as $value)
                                                            <label for="color-{{ $value->id }}"
                                                                style="--color: {{ $value->color }}">
                                                                <input type="radio"
                                                                    name="attribute[{{ $attribute->id }}]"
                                                                    id="color-{{ $value->id }}"
                                                                    value="{{ $value->id }}"
                                                                    class="attribute-item"
                                                                    data-url="{{ route('website.products.get.price', $product->id) }}"
                                                                    {{ $loop->iteration == 1 ? 'checked' : null }} />
                                                                <span>{{ $value->name }}</span>
                                                            </label>
                                                        @endforeach
                                                    </fieldset>

                                                </div>
                                            @elseif ($attribute->name == "Size")
                                            {{-- <fieldset class="picker"> --}}

                                            <legend class="h6 fs-16 text-body mb-3">{{ $attribute->name }}:
                                            </legend>
                                                @foreach ($attribute->values as $value)
                                                    <div class="text-box {{ $loop->iteration == 1 ? 'active-select' : null }}"
                                                        @style('width:40px;     height: 30px;')>
                                                        <label class="form-label text-label"
                                                            for="">{{ $value->value }}
                                                            <input type="radio" required
                                                                {{ $loop->iteration == 1 ? 'checked' : null }}
                                                                name="attribute[{{ $attribute->id }}]"
                                                                class="text-input attribute-item p-2  "
                                                                data-url="{{ route('website.products.get.price', $product->id) }}"
                                                                value="{{ $value->id }}">
                                                        </label>
                                                    </div>
                                                @endforeach
                                            {{-- </fieldset> --}}
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-lg-12 flex-wrap gap-3 d-flex flex-row pt-2">
                                    <div class="flex-grow-1 mx-2">
                                                <button
                                                    class="btn btn__shop py-3 btn-icon btn-icon-start rounded w-100 flex-grow-1 add-to-cart-btn">
                                                    <i class="uil uil-shopping-bag"></i> {{ __('Add To Cart') }}
                                                </button>
                                    </div>
                                    <div>
                                        <div class="count">
                                            <span onclick="increaseValue()" style="cursor: pointer">+</span>
                                            <input type="number" name="quantity" class="value border-0 " min="1"
                                                style=" width:29%; margin-right: 22px;" value="1" readonly>
                                            <span onclick="decreaseValue()" style="cursor: pointer">-</span>
                                        </div>
                                        <!--/.form-select-wrapper -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <ul class="nav nav-tabs nav-tabs-basic mt-12 px-0">
                    <li class="nav-item">
                        <a class="nav-link me-0 ms-3 active" data-bs-toggle="tab" href="#tab1-1">{{("description")}}:</a>
                    </li>
                </ul>
                <div class="tab-content mt-0 mt-md-5">
                    <div class="tab-pane fade show active" id="tab1-1">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
        </section>




    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            // Listen for change event on radio buttons
            $('input[type="radio"]').change(function() {
                // Remove active-select class from all text-box elements
                $('.text-box').removeClass('active-select');
                // Add active-select class to the parent text-box if the radio button is checked
                if ($(this).is(':checked')) {
                    $(this).closest('.text-box').addClass('active-select');
                }
            });
        });

        const swiper2 = new Swiper('.swiper-product-info', {
            slidesPerView: 3,
            spaceBetween: 11,
            direction: "vertical",
            autoplay: {
                delay: 5000,
            },
            breakpoints: {
                // when window width is >= 575px
                575: {
                    slidesPerView: 2,
                    spaceBetween: 5
                },
                // when window width is >= 767px
                767: {
                    slidesPerView: 2,
                    spaceBetween: 8
                },
                // when window width is >= 992px
                992: {
                    slidesPerView: 3,
                    spaceBetween: 11
                }
            }
        });

        let swiperSlideImg = document.querySelectorAll(".product-info-slider .swiper-slide img");
        let mainImg = document.querySelector('.main-img img');
        swiperSlideImg.forEach(img => {
            img.onclick = function(e) {
                var currentActiveSlide = e.target.getAttribute('src');
                mainImg.setAttribute('src', currentActiveSlide);
                swiperSlideImg.forEach(i => i.parentElement.classList.remove('active'));
                e.target.parentElement.classList.add('active')
            }
        });

        let addToCart = document.querySelector('.add-to-cart');


        $(document).on('change', '.attribute-item', function() {
            let url = $(this).data('url');
            var form = $($(this).parents('form'));
            var formData = new FormData(form[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {

                        if ($('.product_price').length) {
                            // console.log(response);

                            $('.product_price').empty().append(response.item.price)
                        }
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(jqXhr) {
                    toastr.error(jqXhr?.responseJSON?.message);
                }
            });
        });

        if ($('.attribute-item').length) {
            $('.attribute-item').change();
        }


        $(".share-product-box").on("click", function(e) {
            $(this).toggleClass("active");
        });

        $('html').click(function(event) {
            if ($(event.target).closest('.share-product-btn, .share-product-list').length === 0) {
                $('.share-product-box').removeClass("active");
            }
        });

    </script>


<script>

    $(document).ready(function() {
        $('#addToCartForm').submit(function(event) {
            event.preventDefault(); // Prevent form submission

            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: "{{ route('cart.addToCart') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    // Handle success response
                    toastr.success(response.msg);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    toastr.error(error);
                }
            });
        });
    });
</script>

@endsection
