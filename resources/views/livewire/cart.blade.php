<div class="container pt-12 pt-md-14 pb-14 pb-md-16">
    <div class="row gx-md-8 gx-xl-12 gy-12">
        <div class="col-lg-8">

            <div class="table-responsive">
                <h5 class="p-2 mb-0">{{ __('Cart') }}:</h5>
                <table class="table text-center shopping-cart">
                    <thead>
                        <tr>
                            <th class="ps-0">{{ __('Products') }}:</th>
                            <th>{{ __('Quantity') }}:</th>
                            <th>{{ __('Price') }}:</th>
                            <th>{{ __('Total') }}:</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($carts as $cart)
                        <tr>
                            <td class="text-start d-flex align-items-center ps-0">
                                <a href="#" wire:click.prevent="removeItem({{ $cart->id }})">
                                    <img src="{{ asset('assets/img/XCircle.svg') }}" alt="">
                                </a>
                                <figure class="rounded w-14 ms-2 mt-2">
                                    <a href="{{ route('products.show', $cart->product->id) }}">
                                        <img src="{{ image_url($cart->product->img) }}"
                                            alt="{{ $cart->product->title }}" class="img-fluid">
                                    </a>
                                </figure>
                                <div class="ms-2">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('products.show', $cart->product->id) }}"
                                            class="text-heading mb-0 h-6">
                                            {{ $cart->product->name }}
                                        </a>
                                        <small>{{ $cart->product->description }}</small>
                                        @if ($cart->attribute_values)
                                        @php
                                        $attribute_values = \App\Models\ProductAttributeValue::whereIn(
                                        'id',
                                        json_decode($cart->attribute_values),
                                        )->get();
                                        @endphp
                                        <small>
                                            @foreach ($attribute_values as $value)
                                            @if ($value->color)
                                            <span class="badge badge-secondary"
                                                style="background-color: {{ $value->color }};">
                                            </span>
                                            @else
                                            <span class="badge badge-secondary text-dark">
                                                {{ $value->value }}
                                            </span>
                                            @endif
                                            @endforeach
                                        </small>
                                        @endif

                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="count">
                                    <span wire:click="increaseQuantity({{ $cart->id }})"
                                        style="cursor: pointer">+</span>
                                    {{ $cart->quantity }}
                                    <span wire:click="decreaseQuantity({{ $cart->id }})"
                                        style="cursor: pointer">-</span>
                                </div>
                            </td>
                            <td>
                                <p class="price">{{ $cart->price }} $</p>
                            </td>
                            <td>
                                <p class="price">{{ $cart->price*$cart->quantity }} $</p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">{{ __('Your cart is empty') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="table-responsive">
                <h5 class="p-2 fs-14">{{ __('Cart Total') }}:</h5>
                <div class="table table-order">
                    <hr class="py-0 my-0" />
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="py-1">
                            <strong class="py-1 text-dark fs-13 fw-400 text-gray">{{ __('Grand Total') }}:</strong>
                        </div>
                        <div class="py-1 text-end">
                            <p class="price py-0 text-dark fs-13 fw-400 text-gray fw-bold">{{ $grandTotal}} $</p>
                        </div>
                    </div>
                </div>
                <button data-bs-toggle="modal" data-bs-target="#addressModal"
                    class="btn btn__shop py-2 rounded w-100 mt-4">{{ __('Confirm Order') }}</button>
            </div>
        </div>
    </div>
    <!-- Modal for Address Input -->
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">{{ __('Enter Your Address') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm" action="{{route("cart.order.store")}}" method="post" >
                        @csrf
                        <div class="mb-3">
                            <label for="address_line1" class="form-label">{{ __('Address Line 1') }}</label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1" required>
                            <div class="invalid-feedback">
                                {{ __('Please enter your address line 1.') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address_line2" class="form-label">{{ __('Address Line 2') }}</label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2">
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">{{ __('City') }}</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                            <div class="invalid-feedback">
                                {{ __('Please enter your city.') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">{{ __('State') }}</label>
                            <input type="text" class="form-control" id="state" name="state" required>
                            <div class="invalid-feedback">
                                {{ __('Please enter your state.') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="postal_code" class="form-label">{{ __('Postal Code') }}</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                            <div class="invalid-feedback">
                                {{ __('Please enter your postal code.') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">{{ __('Country') }}</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                            <div class="invalid-feedback">
                                {{ __('Please enter your country.') }}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('Confirm Order') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener("livewire:init", () => {
        Livewire.on("toast", (event) => {
            toastr[event.notify](event.message);
        });
    });

    </script>
</div>
