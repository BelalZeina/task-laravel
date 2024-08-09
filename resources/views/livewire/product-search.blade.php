<section class="m-4">
    <div class="projects-masonry shop">
            <div class="input" style="background-color: #fff">
                <input type="text" wire:model.live="search" placeholder="{{ __('search') }}" />
                <img src="{{ asset('assets/img/MagnifyingGlass2.svg') }}" alt="" />
            </div>
            <br>
        <div class="row" id="productList">
            @if ($products)
            @include('website.products.partials', ['products' => $products])
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</section>
