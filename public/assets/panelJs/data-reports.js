"use strict";
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var validator;
var myData = {};

var form_poost = $('#form_post');

var KTDatatablesServerSide = function () {
    var table;
    var table2;
    var table3;
    var table4;
    var dt;
    var dt2;
    var dt3;
    var dt4;
    var form = document.getElementById('form_post');
    var formjs = $('#form_post');

    var modal = $('#m_store_modal') || null;
    // Private functions
    var initDatatable = function () {
        dt = $('#kt_datatable_first').DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            language: {
                info: ` ${$view_datatable} _START_ ${$to_datatable} _END_ ${$from_datatable} _TOTAL_`,
                emptyTable: `${$no_data_datatable}`,
                infoEmpty: `${$no_data_show_datatable}`,
                // search: 'البحث'
            },
            // order: [[0, 'desc']],
            // stateSave: true,
            select: {
                style: 'os',
                selector: 'td:first-child',
                className: 'row-selected'
            },
            ajax: {
                url: window.datatable,
                data: function (d) {
                    return $.extend(d, myData);
                },
            },
            columns: window.columns,
            columnDefs: window.columnDefs,
            // Add data-filter attribute
        });
        dt2 = $('#kt_datatable_second').DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            language: {
                info: ` ${$view_datatable} _START_ ${$to_datatable} _END_ ${$from_datatable} _TOTAL_`,
                emptyTable: `${$no_data_datatable}`,
                infoEmpty: `${$no_data_show_datatable}`,
                // search: 'البحث'
            },
            // order: [[0, 'desc']],
            // stateSave: true,
            select: {
                style: 'os',
                selector: 'td:first-child',
                className: 'row-selected'
            },
            ajax: {
                url: window.datatable2,
                data: function (d) {
                    return $.extend(d, myData);
                },
            },
            columns: window.columns2,
            columnDefs: window.columnDefs2,
            // Add data-filter attribute
        });
        dt3 = $('#kt_datatable_third').DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            language: {
                info: ` ${$view_datatable} _START_ ${$to_datatable} _END_ ${$from_datatable} _TOTAL_`,
                emptyTable: `${$no_data_datatable}`,
                infoEmpty: `${$no_data_show_datatable}`,
                // search: 'البحث'
            },
            // order: [[0, 'desc']],
            // stateSave: true,
            select: {
                style: 'os',
                selector: 'td:first-child',
                className: 'row-selected'
            },
            ajax: {
                url: window.datatable3,
                data: function (d) {
                    return $.extend(d, myData);
                },
            },
            columns: window.columns3,
            columnDefs: window.columnDefs3,
            // Add data-filter attribute
        });
        dt4 = $('#kt_datatable_fourth').DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            language: {
                info: ` ${$view_datatable} _START_ ${$to_datatable} _END_ ${$from_datatable} _TOTAL_`,
                emptyTable: `${$no_data_datatable}`,
                infoEmpty: `${$no_data_show_datatable}`,
                // search: 'البحث'
            },
            // order: [[0, 'desc']],
            // stateSave: true,
            select: {
                style: 'os',
                selector: 'td:first-child',
                className: 'row-selected'
            },
            ajax: {
                url: window.datatable4,
                data: function (d) {
                    return $.extend(d, myData);
                },
            },
            columns: window.columns4,
            columnDefs: window.columnDefs4,
            // Add data-filter attribute
        });
        table = dt.$;
        table2 = dt2.$;
        table3 = dt3.$;
        table4 = dt4.$;
        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on('draw', function () {
            if ($(".datatable-checkbox").length > 0) {
                initToggleToolbar();
                toggleToolbars();
            }
            KTMenu.createInstances();

        });
        dt2.on('draw', function () {
            if ($(".datatable-checkbox").length > 0) {
                initToggleToolbar();
                toggleToolbars();
            }
            KTMenu.createInstances();

        });
        dt3.on('draw', function () {
            if ($(".datatable-checkbox").length > 0) {
                initToggleToolbar();
                toggleToolbars();
            }
            KTMenu.createInstances();

        });
        dt4.on('draw', function () {
            if ($(".datatable-checkbox").length > 0) {
                initToggleToolbar();
                toggleToolbars();
            }
            KTMenu.createInstances();

        });
    };
    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-filter="search"]');
        if (filterSearch) {
            filterSearch.addEventListener('keyup', function (e) {
                dt.search(e.target.value).draw();
            });
        }

        $(document).on('change', '#date_request', e => {
            let $this = $(e.currentTarget);
            myData.date_request = $this.val();
            dt.ajax.reload();
        });



    };
    function initializeDataTableAndButtons(tableElement, index) {
        const documentTitle = $dataTableExportRows[index].title ?? 'Customer Orders Report';

        const buttons = new $.fn.dataTable.Buttons(tableElement, {
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6] // indexes of the columns that should be printed,
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: $dataTableExportRows[index].columns // indexes of the columns that should be printed,
                    }
                },
                {
                    extend: 'csvHtml5',
                    title: documentTitle
                },
                {
                    extend: 'pdfHtml5',
                    title: documentTitle
                }
            ]
        });

        buttons.container().appendTo($('#kt_datatable_example_buttons_' + index)); // Use a unique identifier for each DataTable's button container
    }
    const tables = document.querySelectorAll('.table'); // Change '.datatable' to the appropriate selector for your DataTables

    var exportButtons = () => {
        // Loop through each DataTable
        tables.forEach((table, index) => {
            initializeDataTableAndButtons(table, index);

            // Hook dropdown menu click event to datatable export buttons
            const exportButtons = document.querySelectorAll('#kt_datatable_example_export_menu_' + index + ' [data-kt-export]'); // Use a unique identifier for each DataTable's export menu
            exportButtons.forEach(exportButton => {
                exportButton.addEventListener('click', e => {
                    e.preventDefault();

                    // Get clicked export value
                    const exportValue = e.target.getAttribute('data-kt-export');
                    console.log({exportValue})
                    const target = document.querySelector('#kt_datatable_example_buttons_' + index + ' .dt-buttons .buttons-' + exportValue); // Use a unique identifier for each DataTable's button

                    // Trigger click event on hidden datatable export buttons
                    target.click();
                });
            });
        });
    }

    var initFormValidation = () => {

        if ($("#form_post").length > 0) {
            validator = FormValidation.formValidation(
                document.getElementById('form_post'),
                {
                    plugins: {
                        declarative: new FormValidation.plugins.Declarative({
                            html5Input: true,
                            prefix: 'data-fv-',
                        }),
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        }),
                    }
                }
            );
        }

    };
    var handleActiveOperation = () => {
        $(document).on('change', '.active_operation', function (e) {
            e.preventDefault();
            let $this = $(this);
            let target_url = $this.data('action');
            let customerName = $this.data('title');
            let textCheck;
            let confirmActive;
            if ($this.is(':checked')) {
                $this.prop('checked', false);
                textCheck = `${$do_u_wish_to_active} ${customerName} ?`;
                confirmActive = $sweet_alert_activate;
            } else {
                $this.prop('checked', true);
                textCheck = `${$sweet_alert_do_u_wish_to_deactivate} ${customerName} ؟`;
                confirmActive = $sweet_alert_deactivate;
            }
            Swal.fire({
                text: textCheck,
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: confirmActive,
                cancelButtonText: $sweet_alert_close,
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    Swal.fire({
                        text: $sweet_alert_please_wait,
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                    });
                    axios.post(`${target_url}`).then(response => {
                        if (response.data.status == true) {
                            Swal.close();
                            if ($this.is(':checked')) {
                                $this.prop('checked', false);
                            } else {
                                $this.prop('checked', true);
                            }
                            Swal.fire({
                                text: $sweet_alert_status_was_changed_successfully,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: $sweet_alert_done,
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function () {

                                dt.draw();
                            });
                        } else {
                            Swal.close();
                        }
                    }).catch(err => {
                        customSweetAlert(
                            'error',
                            err.response.data.message,
                            ''
                        );
                    });

                } else if (result.dismiss) {
                    Swal.close();
                    Swal.fire({
                        text: $sweet_alert_status_was_not_changed + " " + customerName,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: $sweet_alert_done,
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });
        });

    };
    // Filter Datatable
    // Delete customer
    var handleShowRows = () => {
        $(document).on('click', '.edit', function (e) {
            e.preventDefault();
            let $this = $(this);
            let target_url = $this.data('action');
            axios.get(`${target_url}`).then(response => {
                if (response.data.status == true) {
                    $("#m_store_modal .modal-content").empty().append(response.data.item.render);
                    KTImageInput.createInstances();
                    $('[data-control="select2"]').select2();
                    if($(".start_date_input").length) {
                        $(".start_date_input").flatpickr();
                    }
                    if($(".end_date_input").length) {
                        $(".end_date_input").flatpickr();
                    }
                    if($('.summernote').length) {
                        $('.summernote').summernote({
                            placeholder: '',
                            height: 300
                        });
                    }

                    initFormValidation();
                    $("#m_store_modal").modal("show");
                }
            }).catch(err => {
                console.log(err)
                customSweetAlert(
                    'error',
                    err.response.data.message,
                    ''
                );
            });
        });
        $(document).on('click', '.get_sections', function (e) {
            e.preventDefault();
            let $this = $(this);
            let target_url = $this.data('action');
            axios.get(`${target_url}`).then(response => {
                if (response.data.status) {
                    $("#m_store_modal .modal-content").empty().append(response.data.item.render);
                    KTImageInput.createInstances();
                    $('[data-control="select2"]').select2();
                    initFormValidation();
                    $("#m_store_modal").modal("show");
                }
            }).catch(err => {
                console.log(err)
                customSweetAlert(
                    'error',
                    err.response.data.message,
                    ''
                );
            });
        });
    };


    var getErrors = (jqXhr, path) => {
        if (jqXhr != null)
            switch (jqXhr.status) {
                case 401 :
                    customSweetAlert(
                        'error',
                        jqXhr.responseJSON.message,
                        ''
                    );
                case 400 :
                    customSweetAlert(
                        'error',
                        jqXhr.responseJSON.message,
                        ''
                    );
                    break;
                case 422 :
                    (function ($) {
                        var $errors = jqXhr.responseJSON.errors;
                        var errorsHtml = '<ul style="list-style-type: none">';
                        $.each($errors, function (key, value) {
                            // form.find(".my-validate")
                            errorsHtml += '<li style="font-family: \'Droid.Arabic.Kufi\' !important; text-align: right">' + value[0] + '</li>';

                        });

                        errorsHtml += '</ul>';
                        customSweetAlert(
                            'error',
                            'حدث خطأ أثناء العملية',
                            errorsHtml
                        );
                    })(jQuery);

                    break;
                default:
                    errorCustomSweet();
                    break;
            }
        return false;
    }
    // Init toggle toolbar
    var initToggleToolbar = function () {
        $(document).on('click', '.check-all-datatable', e => {
            let $this = $(e.currentTarget);
            if ($this.is(':checked')) {
                $this.prop('checked', true);
                $(".datatable-checkbox").prop('checked', true);
                toggleToolbars();
            } else {
                $this.prop('checked', false);
                $(".datatable-checkbox").prop('checked', false);
                toggleToolbars();
            }
        });
        $(document).on('click', '.datatable-checkbox', () => {
            setTimeout(function () {
                toggleToolbars();
            }, 50);
        });

    };
    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector('#kt_datatable_main');
        const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');
        // Select refreshed checkbox DOM elements
        const allCheckboxes = container.querySelectorAll('tbody .datatable-checkbox');
        let checkedState = false;
        let count = 0;
        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });
        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    };
    return {
        init: function () {
            initDatatable();

            handleSearchDatatable();
            if ($(".datatable-checkbox").length > 0) {
                initToggleToolbar();
            }

            handleActiveOperation();
            exportButtons();
            handleShowRows();
            getErrors();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});
