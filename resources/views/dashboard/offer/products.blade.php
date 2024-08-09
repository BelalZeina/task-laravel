@extends('layouts.dashboard.app')

@section('header__title', __('home.offers'))
@section('header__icon', 'bx bx-list-ul')

@section('main')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="d-flex p-3 px-4 align-items-center justify-content-between w-100">
                            <h5 class="card-header p-0">{{ __('home.Add') }} {{ __('home.offers') }}</h5>
                            <a href="{{ route('offers.index') }}" style="width: fit-content">
                                <button type="button" class="btn btn-dark d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-backward"></i>
                                    {{ __('home.Back') }}
                                </button>
                            </a>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('offers.products.store') }}" method="POST" class="row product-store"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3 col-md-12">
                                    <label for="example-multiple-select">{{ __('home.products') }}</label>
                                    <select id="example-multiple-select" name="product_id[]" multiple="multiple"
                                        class="form-control">
                                        @foreach ($products as $product)
                                            <option {{ isset($data) && $data->id == $product->id ? 'selected' : '' }}
                                                value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="discount_type">{{ __('models.Discount Type') }}</label><br>
                                    <input type="radio" name="discount_type" value="percentage"
                                        id="discount_percentage_radio" checked> {{ __('models.Percentage') }}
                                    <input type="radio" name="discount_type" value="fixed" id="discount_fixed_radio">
                                    {{ __('models.Fixed') }}
                                </div>
                                <div class="col-md-6" id="percentage_discount_div">
                                    @include('components.input', [
                                        'value' => old('discount_percentage'),
                                        'name' => 'discount_percentage',
                                        'type' => 'number',
                                        'step' => '1',
                                        'label' => 'discount_percentage',
                                        'placeholder' => 'discount_percentage',
                                    ])
                                </div>
                                <div class="col-md-6" id="fixed_discount_div" style="display: none;">
                                    @include('components.input', [
                                        'value' => old('fixed_discount'),
                                        'name' => 'fixed_discount',
                                        'type' => 'number',
                                        'step' => '0.01',
                                        'label' => 'fixed_discount',
                                        'placeholder' => 'fixed_discount',
                                    ])
                                </div>

                        </div>
                    </div>
                    <br>
                    <div class="d-flex align-items justify-content-end">
                        @include('components.button', [
                            'type' => 'submit',
                            'name' => 'Add',
                        ])
                    </div>
                    </form>


                    <!--begin::Card body-->

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-dashboard')
    @include('dashboard.clubs.mab')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Select2 JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example-multiple-select').select2({
                placeholder: "Select options",
                allowClear: true
            });
        });

    </script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            function toggleDiscountFields() {
                if ($('#discount_percentage_radio').is(':checked')) {
                    $('#percentage_discount_div').show();
                    $('input[name="fixed_discount"]').val(null)
                    $('#fixed_discount_div').hide();
                } else if ($('#discount_fixed_radio').is(':checked')) {
                    $('#percentage_discount_div').hide();
                    $('input[name="discount_percentage"]').val(null)
                    $('#fixed_discount_div').show();
                }
                // calculatePriceAfterDiscount();
            }


            $('input[name="discount_type"]').change(toggleDiscountFields);


            // Initialize the form with the correct fields shown
            toggleDiscountFields();
        });
    </script>

@endsection
