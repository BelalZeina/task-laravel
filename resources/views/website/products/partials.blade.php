@foreach ($products as $product)
<div class="p-2 col-md col-xl-3 product-item">
    <div class="project item pt-0">
        <figure class="rounded mb-1">
            <img src="{{ image_url($product->img) }}" style="    height: 241px !important;"
                srcset="{{ image_url($product->img) }}" alt="" />
            <a class="item-like" href="#" data-bs-toggle="white-tooltip" title="Add to wishlist"><i
                    class="uil uil-heart"></i></a>
            <a class="item-view" href="{{ route('website.products.show', $product->id) }}"
                data-bs-toggle="white-tooltip" title="Quick view"><i class="uil uil-eye"></i></a>
            <form class="addToCartForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button class="item-cart">
                    <i class="uil uil-shopping-cart"></i> {{ __('Add to cart') }}
                </button>
            </form>

        </figure>
        <div class="post-header">
            <h2 class="post-title h3 fs-17">
                <a href="{{ route('website.products.show', $product->id) }}" class="link-dark">
                    {{ $product->name }}
                </a>
            </h2>
            <p class="price">
                @if ($product->price_after_discount != 0)
                <del><span class="amount">{{ ($product->price) }}
                        $</span></del>
                @endif
                <ins><span class="amount">{{
                        $product->price_after_discount==0?($product->price):($product->price_after_discount) }}
                        $</span></ins>
            </p>
        </div>
    </div>
</div>
@endforeach
