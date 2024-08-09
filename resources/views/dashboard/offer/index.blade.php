@extends('layouts.dashboard.app')

@section('header__title', __('home.offers'))
@section('header__icon', 'bx bx-list-ul')

@section('main')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="d-flex align-item-center p-4 justify-content-between w-100">
                <h5 class="card-header p-0">{{ __('home.offers') }}</h5>
                <div class="d-flex align-item-center gap-3">
                    <button id="deleteSelected" class="btn btn-danger">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                    <a href="{{ route('offers.create') }}">
                        <button type="button" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="fa-solid fa-plus"></i>{{ __('home.Add') }}
                        </button>
                    </a>
                    <a href="{{ route('offers.products') }}">
                        <button type="button" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="fa-solid fa-plus"></i>{{ __('home.offer_on_product') }}
                        </button>
                    </a>
                </div>
            </div>
            <div class="d-flex align-item-center justify-content-between gap-3 mb-4 px-4">
                <div class="d-flex groups__button align-item-center gap-3">
                    <input type="text" class="form-control" style="width:200px" id="search_input"
                           placeholder="{{ __('home.Search') }}" aria-describedby="defaultFormControlHelp" />
                    <select name="myTable_length" aria-controls="myTable" class="dt-input" id="dt-length-0"
                            fdprocessedid="0z9mam">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <div class="">
                        {{-- <input class="form-control" type="date" id="filter_date" /> --}}
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap px-4">
                <table class="table" id="myTable">
                    <thead>
                        <tr class="text-nowrap">
                            <th>
                                <div class="d-flex align-items-center gap-2">
                                    <input class="form-check-input row__check" type="checkbox" value=""
                                           id="check__box" />
                                    {{ __('home.image') }}
                                </div>
                            </th>
                            <th>{{ __('home.desc') }}</th>
                            <th>{{ __('home.stock') }}</th>
                            <th>{{ __('home.price') }}</th>
                            <th>{{ __('home.price_after_discount') }}</th>
                            <th>{{ __('home.discount') }}</th>
                            <th>{{ __('home.Joining Date') }}</th>
                            <th>{{ __('home.Edit') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $product)
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center gap-2">
                                        <input class="form-check-input row__check" type="checkbox" value="{{ $product->id }}" />
                                        <img src="{{ image_url($product->img) }}" alt
                                             class="w-px-50 h-auto rounded-circle" />
                                        {{ $product->name }}
                                    </div>
                                </th>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->price_after_discount }}</td>
                                <td>{{ $product->fixed_discount ?? $product->discount_percentage }} {{$product->fixed_discount?"SAR":"%"}}</td>
                                <td>{{ $product->created_at->format("m-d-Y") }}</td>
                                <td class="">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('offers.edit', $product->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i> {{ __('home.Edit') }}</a>
                                            <a class="dropdown-item cursor-pointer" data-bs-toggle="modal"
                                                data-bs-target="#modalToggle{{ $product->id }}"><i class="bx bx-trash me-1"></i>
                                                {{ __('home.Delete') }}</a>
                                        </div>
                                    </div>
                                    @include('components.modalDelete', [
                                        'action' => 'offers.destroy',
                                        'name' => $product->name,
                                        'title' => __('home.Are You Delete'),
                                        'modalToggle' => "modalToggle$product->id",
                                        'id' => $product->id,
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts-dashboard')
<link href="{{ asset('asset/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        // DataTable initialization with export buttons
        let table = $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "order": [], // Disable initial ordering
            "lengthMenu": [10, 25, 50, 100]
        });

        // Custom filter function for date
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var filterDate = $('#filter_date').val();
                var dateColumn = data[4]; // Adjusted the date column index

                if (filterDate === '') {
                    return true; // No filter applied
                }

                // Convert dates to comparable formats
                var filterDateObj = new Date(filterDate);
                var dateColumnObj = new Date(dateColumn);

                return dateColumnObj.getTime() === filterDateObj.getTime();
            }
        );

        // Event listener for the date input
        $('#filter_date').on('change', function() {
            table.draw();
        });

        // When the header checkbox is clicked
        $('#check__box').click(function() {
            var isChecked = $(this).prop('checked');
            $('#myTable tbody tr').each(function() {
                $(this).find('.form-check-input.row__check').prop('checked', isChecked);
            });
        });

        // Search functionality
        $('#search_input').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Delete selected rows
        $('#deleteSelected').click(function() {
            var selectedIds = [];
            $(".row__check:checked").each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                $.ajax({
                    url: "{{ route('offers.deleteSelected') }}",
                    type: "POST",
                    data: { ids: selectedIds },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                alert("Please select at least one item to delete.");
            }
        });

        // Handle page length change
        $('select[name="myTable_length"]').on('change', function() {
            var length = $(this).val();
            table.page.len(length).draw();
        });
    });
</script>
@endsection
