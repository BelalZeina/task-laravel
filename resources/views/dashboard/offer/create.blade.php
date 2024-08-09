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
                            <form action="{{ route('offers.store') }}" method="POST" class="row product-store"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6">
                                    @include('components.input', [
                                        'value' => old('name'),
                                        'name' => 'name',
                                        'type' => 'text',
                                        'label' => 'Name',
                                        'placeholder' => 'Package Name',
                                    ])
                                </div>
                                <div class="col-md-6">
                                    @include('components.input', [
                                        'value' => old('description'),
                                        'name' => 'description',
                                        'type' => 'text',
                                        'label' => 'Description',
                                        'placeholder' => 'Description',
                                    ])
                                </div>
                                <div class="col-md-6">
                                    @include('components.input', [
                                        'value' => old('stock'),
                                        'name' => 'stock',
                                        'type' => 'number',
                                        'label' => 'Stock',
                                        'placeholder' => 'Stock',
                                    ])
                                </div>
                                <div class="col-md-6">
                                    @include('components.input', [
                                        'value' => old('price'),
                                        'name' => 'price',
                                        'type' => 'number',
                                        'step' => '0.01',
                                        'label' => 'Price',
                                        'placeholder' => 'Price',
                                    ])
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="example-multiple-select">Select Categories</label>
                                    <select id="example-multiple-select" name="category_id[]" multiple="multiple"
                                        class="form-control">
                                        @foreach ($categories as $category)
                                            <option
                                                {{ isset($data) &&$data->categories()->where('category_id', $category->id)->first()? 'selected': '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
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
                                <div class="col-md-6">
                                    @include('components.input', [
                                        'value' => old('price_after_discount'),
                                        'name' => 'price_after_discount',
                                        'type' => 'number',
                                        'step' => '0.01',
                                        'label' => 'price_after_discount',
                                        'placeholder' => 'price_after_discount',
                                        'option' => 'readonly',
                                    ])
                                </div>
                                <input type="hidden" name="price_after_discount" value="0">

                                @include('components.input', [
                                    'value' => old('img'),
                                    'name' => 'img',
                                    'type' => 'file',
                                    'label' => 'Main Image',
                                    'placeholder' => '',
                                ])
                                  <!-- Dynamic Attributes Section -->
                                  <div id="attributes-section">
                                    <label for="attributes">Product Attributes</label>
                                    <div id="attributes-container">
                                        <!-- Dynamic Attribute Fields will be added here -->
                                    </div>
                                    <button type="button" id="add-attribute" class="btn btn-primary">Add Attribute</button>
                                </div>
                                <div class="card-body pt-0">
                                    <label for="images" class="form-label">{{ 'Images' }}</label>
                                    <div class="fv-row mb-2">
                                        <div class="dropzone" id="kt_dropzonejs_example_1"
                                            action="{{ route('dropzone.files') }}">
                                            <div class="dz-message needsclick align-items-center">
                                                <i class="bi bi-file-earmark-arrow-up text-success fs-3x"></i>
                                                <div class="ms-4">
                                                    <h3 class="fs-5 fw-bold text-gray-900 mb-0">
                                                        {{ __('Drag the images or click here') }}
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-7">
                                        {{ __('The appropriate size for the image is (394 width) * (330px height)') }}
                                    </div>
                                    <div id="preview-template" style="display: none;">
                                        <div class="dz-preview dz-file-preview">
                                            <div class="dz-image"><img data-dz-thumbnail=""></div>
                                            <div class="dz-details">
                                                <div class="dz-size"><span data-dz-size=""></span></div>
                                                <div class="dz-filename"><span data-dz-name=""></span></div>
                                            </div>
                                            <div class="dz-progress"><span class="dz-upload"
                                                    data-dz-uploadprogress=""></span></div>
                                            <div class="dz-error-message"><span data-dz-errormessage=""></span></div>
                                            <div class="dz-success-mark">
                                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                    <title>Check</title>
                                                    <desc>Created with Sketch.</desc>
                                                    <defs></defs>
                                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd" sketch:type="MSPage">
                                                        <path
                                                            d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                                            id="Oval-2" stroke-opacity="0.198794158" stroke="#747474"
                                                            fill-opacity="0.816519475" fill="#FFFFFF"
                                                            sketch:type="MSShapeGroup"></path>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="dz-error-mark">
                                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                    <title>error</title>
                                                    <desc>Created with Sketch.</desc>
                                                    <defs></defs>
                                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd" sketch:type="MSPage">
                                                        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup"
                                                            stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF"
                                                            fill-opacity="0.816519475">
                                                            <path
                                                                d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                                                id="Oval-2" sketch:type="MSShapeGroup"></path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <input type="hidden" name="images[]" class="file_uploaded">
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


        var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            init: function() {
                let thumbnailUrls = $("#images_product").length > 0 ? JSON.parse($("#images_product").val()) :
                    '';
                let myDropzone = this;
                if (thumbnailUrls) {
                    for (let i in thumbnailUrls) {
                        console.log(thumbnailUrls)
                        var mockFile = {
                            name: "old images",
                            type: 'image/jpeg',
                            status: Dropzone.ADDED,
                            url: hostUrl + '/image/' + thumbnailUrls[i].file_name
                        };
                        myDropzone.emit("addedfile", mockFile);
                        myDropzone.emit("thumbnail", mockFile, hostUrl + '/image/' + thumbnailUrls[i]
                            .file_name);
                        myDropzone.files.push(mockFile);
                        $(mockFile.previewElement).find('.main_image').val(thumbnailUrls[i].is_default)
                        if (thumbnailUrls[i].is_default == 1) {
                            $(mockFile.previewElement).find('.set-main-img').removeClass('bg-light').addClass(
                                'bg-success main text-light').text('تم التعيين كرئيسية');
                        }
                        $(mockFile.previewElement).find('.file_uploaded').attr('name', 'images[]').val(
                            thumbnailUrls[i].file_name);
                        // console.log(thumbnailUrls[i])
                        // $(mockFile.previewElement).find(".extra_ids").attr('name' , 'extra_ids[]').val(thumbnailUrls[i].id);
                        $(mockFile.previewElement).find(".dz-size").remove();
                        $(mockFile.previewElement).find(".dz-progress").remove();
                    }
                    $("#kt_modal_create_project_settings_logo").css('text-align', 'right');
                    $("#kt_modal_create_project_settings_logo").find('.dz-message').removeClass(
                        'flex-column align-items-center').addClass('flex-raw align-items-start');
                    // if($(".file_uploaded").length > 0) {
                    //     $("#files_main_check").val(1);
                    // }
                }
                this.on("removedfile", function(file) {
                    if (file.url && file.url.trim().length > 0) {
                        $("<input type='hidden'>").attr({
                            id: 'DeletedImageUrls',
                            name: 'DeletedImageUrls'
                        }).val(file.url).appendTo('#image-form');
                    }
                });
            },
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(file, response) {
                $(file.previewElement).parent().css('text-align', 'right');
                $(file.previewElement).parent().find('.dz-message').removeClass(
                    'flex-column align-items-center').addClass('flex-raw align-items-start');
                $(file.previewElement).find('.file_uploaded').attr('name', 'images[]').val(response);
                $(file.previewElement).find(".extra_ids").attr('name', 'extra_ids[]').val('');

                // $(file.previewElement).find(".main_image").attr('name' , 'main_image[]');
                if ($(".file_uploaded").length > 0) {
                    $("#files_main_check").val(1);
                    if ($(".set-main-img.main").length == 0) {
                        $("#files_main_image_check_default").val("");
                    }
                }
            },
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
                calculatePriceAfterDiscount();
            }

            function calculatePriceAfterDiscount() {
                let price = parseFloat($('input[name="price"]').val()) || 0;
                let priceAfterDiscount = price;

                if ($('#discount_percentage_radio').is(':checked')) {
                    let discountPercentage = parseFloat($('input[name="discount_percentage"]').val()) || 0;
                    priceAfterDiscount = price - (price * (discountPercentage / 100));
                } else if ($('#discount_fixed_radio').is(':checked')) {
                    let fixedDiscount = parseFloat($('input[name="fixed_discount"]').val()) || 0;
                    priceAfterDiscount = price - fixedDiscount;
                }

                $('input[name="price_after_discount"]').val(priceAfterDiscount.toFixed(2));
            }

            $('input[name="discount_type"]').change(toggleDiscountFields);
            $('input[name="price"], input[name="discount_percentage"], input[name="fixed_discount"]').on('input',
                calculatePriceAfterDiscount);

            // Initialize the form with the correct fields shown
            toggleDiscountFields();
        });
    </script>
       <script>
        $(document).ready(function() {
            let attributeIndex = 0;

            $('#add-attribute').on('click', function() {
                attributeIndex++;
                const attributeHtml = `
                    <div class="attribute-group d-flex mb-3 align-items-center" id="attribute-group-${attributeIndex}">
                        <div class="form-group flex-fill me-2">
                            <label for="attribute-type-${attributeIndex}" class="form-label">Attribute Type</label>
                            <div>
                                <label><input type="radio" name="attributes[${attributeIndex}][type]" value="text" checked> Text</label>
                                <label><input type="radio" name="attributes[${attributeIndex}][type]" value="color"> Color</label>
                            </div>
                        </div>
                        <div class="form-group flex-fill me-2">
                            <label for="attribute-name-${attributeIndex}" class="form-label">Attribute Name</label>
                            <input type="text" name="attributes[${attributeIndex}][name]" id="attribute-name-${attributeIndex}" class="form-control" placeholder="Attribute Name" >
                        </div>

                        <div class="form-group flex-fill me-2">
                            <label for="attribute-value-${attributeIndex}" class="form-label">Attribute Value</label>
                            <input type="text" name="attributes[${attributeIndex}][value]" id="attribute-value-${attributeIndex}" class="form-control attribute-input" placeholder="Attribute Value" >
                            <input type="color" name="attributes[${attributeIndex}][color]" id="attribute-color-${attributeIndex}" class="form-control attribute-color mt-2" placeholder="Color Picker" style="display: none;">
                        </div>
                        <div class="form-group flex-fill me-2">
                            <label for="attribute-price-${attributeIndex}" class="form-label">Price</label>
                            <input type="number" name="attributes[${attributeIndex}][price]" id="attribute-price-${attributeIndex}" class="form-control" placeholder="Price" step="0.01" >
                        </div>

                        <button type="button" class="btn btn-danger mt-4 remove-attribute" data-index="${attributeIndex}">Remove</button>
                    </div>
                `;
                $('#attributes-container').append(attributeHtml);

                // Event handler to toggle between text and color input
                $(`#attribute-group-${attributeIndex}`).on('change', `input[name="attributes[${attributeIndex}][type]"]`, function() {
                    const type = $(this).val();
                    const valueInput = $(`#attribute-value-${attributeIndex}`);
                    const colorInput = $(`#attribute-color-${attributeIndex}`);

                    if (type === 'color') {
                        valueInput.hide();
                        colorInput.show();
                    } else {
                        valueInput.show();
                        colorInput.hide();
                    }
                }).trigger('change'); // Trigger change event to set initial visibility
            });




            $(document).on('click', '.remove-attribute', function() {
                const index = $(this).data('index');
                $(`#attribute-group-${index}`).remove();
            });
        });
    </script>
@endsection
