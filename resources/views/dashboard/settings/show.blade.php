@extends('layouts.dashboard.app')

@section('main')
    <div class="content-wrapper">
        <!-- Content -->


        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="row">
                <div class="col-md-12">

                    <div class="card mb-4">
                        <h5 class="card-header">User Details</h5>
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src={{ asset('/asset/img/avatars/1.png') }} alt="user-avatar" class="d-block rounded"
                                    height="100" width="100" id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <h3>Ebrahim Mohamed</h3>
                                    <div class="mb-3 col-md-6 ">
                                        <label for="firstName" class="form-label">Status :</label>
                                        <span class="bg-label-primary p-1 rounded">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <form id="formAccountSettings" method="POST" onsubmit="return false">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">Name :</label>
                                        <h4>Ebrahim Mohamed</h4>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">Phone :</label>
                                        <h4>01019092115</h4>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">Email :</label>
                                        <h4>a@a.com</h4>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">Country :</label>
                                        <h4>Egypt</h4>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">City :</label>
                                        <h4>Mutbis</h4>
                                    </div>



                                </div>

                            </form>
                        </div>
                        <!-- /Account -->
                    </div>
                    <div class="card">

                        <div class=" d-flex align-item-center justify-content-between gap-3  p-4  ">

                            <div class="d-flex groups__button align-item-center gap-3">
                                <input type="text" class="form-control" style="width:200px" id="search_input"
                                    placeholder="Search ..." aria-describedby="defaultFormControlHelp" />
                                <select name="myTable_length" aria-controls="myTable" class="dt-input" id="dt-length-0"
                                    fdprocessedid="0z9mam">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <select class="form-select" id="exampleFormControlSelect1"
                                    aria-label="Default select example">
                                    <option selected>select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <div class="">
                                    <input class="form-control" type="date" value="2021-06-18" id="html5-date-input" />
                                </div>
                                <div class="exports mx-0 px-0">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:void(0);"> <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 24 24">
                                                    <path fill="#888888"
                                                        d="M19 7h-1V2H6v5H5c-1.654 0-3 1.346-3 3v7c0 1.103.897 2 2 2h2v3h12v-3h2c1.103 0 2-.897 2-2v-7c0-1.654-1.346-3-3-3M8 4h8v3H8zm8 16H8v-4h8zm4-3h-2v-3H6v3H4v-7c0-.551.449-1 1-1h14c.552 0 1 .449 1 1z" />
                                                    <path fill="#888888" d="M14 10h4v2h-4z" />
                                                </svg> print</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);"> <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm8 7h-1V4l5 5h-4z"
                                                        fill="#888888" />
                                                </svg>Csv</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M8.267 14.68c-.184 0-.308.018-.372.036v1.178c.076.018.171.023.302.023c.479 0 .774-.242.774-.651c0-.366-.254-.586-.704-.586zm3.487.012c-.2 0-.33.018-.407.036v2.61c.077.018.201.018.313.018c.817.006 1.349-.444 1.349-1.396c.006-.83-.479-1.268-1.255-1.268z"
                                                        fill="#888888" />
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM9.498 16.19c-.309.29-.765.42-1.296.42a2.23 2.23 0 0 1-.308-.018v1.426H7v-3.936A7.558 7.558 0 0 1 8.219 14c.557 0 .953.106 1.22.319c.254.202.426.533.426.923c-.001.392-.131.723-.367.948zm3.807 1.355c-.42.349-1.059.515-1.84.515c-.468 0-.799-.03-1.024-.06v-3.917A7.947 7.947 0 0 1 11.66 14c.757 0 1.249.136 1.633.426c.415.308.675.799.675 1.504c0 .763-.279 1.29-.663 1.615zM17 14.77h-1.532v.911H16.9v.734h-1.432v1.604h-.906V14.03H17v.74zM14 9h-1V4l5 5h-4z"
                                                        fill="#888888" />
                                                </svg> Pdf </a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);"> <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M14 8H4c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2h10c1.103 0 2-.897 2-2V10c0-1.103-.897-2-2-2z"
                                                        fill="#888888" />
                                                    <path
                                                        d="M20 2H10a2 2 0 0 0-2 2v2h8a2 2 0 0 1 2 2v8h2a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"
                                                        fill="#888888" />
                                                </svg>Copy</a></li>

                                    </ul>
                                </div>

                            </div>


                        </div>
                        <div class="table-responsive text-nowrap px-4">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>
                                            <div class="d-flex align-items-center gap-2"><input
                                                    class="form-check-input row__check" type="checkbox" value=""
                                                    id="check__box" />
                                                اسم المستخدم </div>
                                        </th>
                                        <th>البريد الإلكترونى</th>
                                        <th>رقم الجوال</th>
                                        <th>تاريخ الإنضمام</th>
                                        <th>التفعيل</th>
                                        <th>التعديل</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center gap-2">
                                                <input class="form-check-input row__check" type="checkbox" value=""
                                                    id="defaultCheck3" />
                                                <img src={{ asset('asset/img/avatars/Rectangle.png') }} alt
                                                    class="w-px-30 h-auto rounded-circle" />
                                                محمد سعيد ابراهيم
                                            </div>
                                        </th>
                                        <td>mohamed@gmail.com</td>
                                        <td>966 123456789</td>
                                        <td>25/10/2023</td>
                                        <td class="">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-switch ">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" />
                                                </div>

                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('users.edit', 1) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item cursor-pointer" data-bs-toggle="modal"
                                                        data-bs-target="#modalToggle"><i class="bx bx-trash me-1"></i>
                                                        Delete</a>
                                                    <a class="dropdown-item" href="{{ route('users.show', 1) }}"><i
                                                            class="bx bx-show me-1"></i> Show</a>
                                                </div>
                                            </div>
                                            @include('components.modalDelete', [
                                                'action' => 'users.destroy',
                                                'name' => 'Ebrahim',
                                                'title' => 'Are You Delete',
                                                'modalToggle' => 'modalToggle',
                                                'id' => 1,
                                            ])
                                        </td>


                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center gap-2">
                                                <input class="form-check-input row__check" type="checkbox" value=""
                                                    id="defaultCheck3" />
                                                <img src={{ asset('asset/img/avatars/Rectangle.png') }} alt
                                                    class="w-px-30 h-auto rounded-circle" />
                                                محمد سعيد ابراهيم
                                            </div>
                                        </th>
                                        <td>mohamed@gmail.com</td>
                                        <td>966 123456789</td>
                                        <td>25/10/2023</td>
                                        <td class="">
                                            <div class="d-flex">
                                                <div class="form-check form-switch m align-items-centerb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" />
                                                </div>

                                            </div>
                                        </td>
                                        <td class="">
                                            {{-- <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-trash me-1"></i> Delete</a>
                                                    < class="dropdown-item" href="javascript:void(0);"
                              ><i class="bx bx-trash me-1"></i> Show</                   >
                                        </div>
                                    </div> --}}
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-show me-1"></i> Show</a>
                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center gap-2">
                                                <input class="form-check-input row__check" type="checkbox" value=""
                                                    id="defaultCheck3" />
                                                <img src={{ asset('asset/img/avatars/Rectangle.png') }} alt
                                                    class="w-px-30 h-auto rounded-circle" />
                                                محمد سعيد ابراهيم
                                            </div>
                                        </th>
                                        <td>mohamed@gmail.com</td>
                                        <td>966 123456789</td>
                                        <td>25/10/2023</td>
                                        <td class="">
                                            <div class="d-flex">
                                                <div class="form-check form-switch m align-items-centerb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" />
                                                </div>

                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-show me-1"></i> Show</a>
                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center gap-2">
                                                <input class="form-check-input row__check" type="checkbox" value=""
                                                    id="defaultCheck3" />
                                                <img src={{ asset('asset/img/avatars/Rectangle.png') }} alt
                                                    class="w-px-30 h-auto rounded-circle" />
                                                محمد سعيد ابراهيم
                                            </div>
                                        </th>
                                        <td>mohamed@gmail.com</td>
                                        <td>966 123456789</td>
                                        <td>25/10/2023</td>
                                        <td class="">
                                            <div class="d-flex">
                                                <div class="form-check form-switch m align-items-centerb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" />
                                                </div>

                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-show me-1"></i> Show</a>
                                                </div>
                                            </div>
                                        </td>


                                    </tr>

                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center gap-2">
                                                <input class="form-check-input row__check" type="checkbox" value=""
                                                    id="defaultCheck3" />
                                                <img src={{ asset('asset/img/avatars/Rectangle.png') }} alt
                                                    class="w-px-30 h-auto rounded-circle" />
                                                محمد سعيد ابراهيم
                                            </div>
                                        </th>
                                        <td>mohamed@gmail.com</td>
                                        <td>966 123456789</td>
                                        <td>25/10/2023</td>
                                        <td class="">
                                            <div class="d-flex">
                                                <div class="form-check form-switch m align-items-centerb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" />
                                                </div>

                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-show me-1"></i> Show</a>
                                                </div>
                                            </div>
                                        </td>


                                    </tr>


                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center gap-2">
                                                <input class="form-check-input row__check" type="checkbox" value=""
                                                    id="defaultCheck3" />
                                                <img src={{ asset('asset/img/avatars/Rectangle.png') }} alt
                                                    class="w-px-30 h-auto rounded-circle" />
                                                محمد سعيد ابراهيم
                                            </div>
                                        </th>
                                        <td>mohamed@gmail.com</td>
                                        <td>966 123456789</td>
                                        <td>25/10/2023</td>
                                        <td class="">
                                            <div class="d-flex">
                                                <div class="form-check form-switch m align-items-centerb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" />
                                                </div>

                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-show me-1"></i> Show</a>
                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center gap-2">
                                                <input class="form-check-input row__check" type="checkbox" value=""
                                                    id="defaultCheck3" />
                                                <img src={{ asset('asset/img/avatars/Rectangle.png') }} alt
                                                    class="w-px-30 h-auto rounded-circle" />
                                                محمد سعيد ابراهيم
                                            </div>
                                        </th>
                                        <td>mohamed@gmail.com</td>
                                        <td>966 123456789</td>
                                        <td>25/10/2023</td>
                                        <td class="">
                                            <div class="d-flex">
                                                <div class="form-check form-switch m align-items-centerb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" />
                                                </div>

                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i
                                                            class="bx bx-show me-1"></i> Show</a>
                                                </div>
                                            </div>
                                        </td>


                                    </tr>

                                </tbody>
                            </table>
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
