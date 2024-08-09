@extends('layouts.dashboard.app')
@section('header__title', __('home.Settings'))
@section('header__icon', 'fa-solid fa-gear')
@section('main')
    <div class="content-wrapper">
        <!-- Content -->


        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row ">
                <div class="col-md-12 ">
                    <div class="card mb-4 ">
                        <div class="d-flex p-3 px-4 align-items-center justify-content-between w-100">
                            <h5 class="card-header p-0"> {{ __('home.Settings') }}</h5>
                        </div>

                        <div class="card-body">

                            <form action="" class="row">

                                <div class="col-md-6">
                                    @include('components.input', [
                                        'value' => old('name'),
                                        'name' => 'name',
                                        'type' => 'text',
                                        'label' => 'Name',
                                        'placeholder' => 'Ebrahim Elbarody',
                                    ])

                                </div>
                                <div class="col-md-6">
                                    @include('components.input', [
                                        'value' => old('email'),
                                        'name' => 'Email',
                                        'type' => 'email',
                                        'label' => 'Email',
                                        'placeholder' => 'a@a.com',
                                    ])

                                </div>
                                <div class="col-md-6">
                                    @include('components.input', [
                                        'value' => old('phone'),
                                        'name' => 'phone',
                                        'type' => 'tel',
                                        'label' => 'phone',
                                        'placeholder' => '01019092115',
                                    ])

                                </div>
                                <div class="col-md-6">
                                    @include('components.select', [
                                        'value' => old('gender'),
                                        'name' => 'gender',
                                    
                                        'placeholder' => 'Choose Gender',
                                        'options' => $data,
                                    ])

                                </div>
                                <div class="col-md-6">
                                    @include('components.select', [
                                        'value' => old('country'),
                                        'name' => 'country',
                                    
                                        'placeholder' => 'Choose Country',
                                        'options' => $data,
                                    ])

                                </div>
                                <div class="col-md-6">
                                    @include('components.select', [
                                        'value' => old('city'),
                                        'name' => 'city',
                                    
                                        'placeholder' => 'Choose City',
                                        'options' => $data,
                                    ])

                                </div>

                                @include('components.input', [
                                    'value' => old('email'),
                                    'name' => 'Email',
                                    'type' => 'file',
                                    'label' => 'Image',
                                    'placeholder' => 'a@a.com',
                                ])



                                <div class="d-flex align-items justify-content-end">
                                    @include('components.button', [
                                        'name' => 'Add',
                                    ])
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts-dashboard')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script>
        $('#search_input').on('keyup', function() {
            table.search(this.value).draw();
        });
        $(document).ready(function() {
            // When the header checkbox is clicked
            $('#check__box').click(function() {
                // Check if it's checked or not
                var isChecked = $(this).prop('checked');

                // Iterate through each row in the table
                $('#myTable tbody tr').each(function() {
                    // Set the checkbox in each row to the same state as the header checkbox
                    $(this).find('.form-check-input.row__check').prop('checked', isChecked);
                });
            });
        });
    </script>
    <script>
        let table = new DataTable('#myTable');
    </script>
@endsection
