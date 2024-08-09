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
    var dt;
    var form = document.getElementById('form_post');
    var formjs = $('#form_post');

    var modal = $('#m_store_modal') || null;
    // Private functions
    var initDatatable = function () {
        dt = $('#kt_datatable_main').DataTable({
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
        table = dt.$;
        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on('draw', function () {
            if ($(".datatable-checkbox").length > 0) {
                initToggleToolbar();
                toggleToolbars();
            }
            handleDeleteRows();
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

        $(document).on('change', '#offer_type_d_select', e => {
            let $this = $(e.currentTarget);
            myData.offer_type_id = $this.val();
            dt.ajax.reload();
        });

        $(document).on('change', '#select_dt_type', e => {
            let $this = $(e.currentTarget);
            myData.type = $this.val();
            dt.ajax.reload();
        });

        $(document).on('change', '#category_d_select', e => {
            let $this = $(e.currentTarget);
            myData.category_d = $this.val();
            dt.ajax.reload();
        });

        $(document).on('change', '#country_d_select', e => {
            let $this = $(e.currentTarget);
            myData.country_d = $this.val();
            dt.ajax.reload();
        });

        $(document).on('change', '#user_d_select', e => {
            let $this = $(e.currentTarget);
            myData.user_d = $this.val();
            dt.ajax.reload();
        });

        $(document).on('keyup', '#search_dt_email', e => {
            let $this = $(e.currentTarget);
            myData.search_email = $this.val();
            dt.ajax.reload();
        });

        $(document).on('keyup', '#search_dt_mobile', e => {
            let $this = $(e.currentTarget);
            myData.search_mobile = $this.val();
            dt.ajax.reload();
        });

        $(document).on('keyup', '#search_dt_whats', e => {
            let $this = $(e.currentTarget);
            myData.search_whats = $this.val();
            dt.ajax.reload();
        });

    };

    var exportButtons = () => {
        let tableOr = document.querySelector('#kt_datatable_main');
        const documentTitle = $dataTableExportTitle ?? 'Customer Orders Report';
        var buttons = new $.fn.dataTable.Buttons(tableOr, {
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: [1,2,3,4,5,6] // indexes of the columns that should be printed,
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: documentTitle,
                    exportOptions: {
                        columns: $dataTableExportRows // indexes of the columns that should be printed,
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
        }).container().appendTo($('#kt_datatable_example_buttons'));

        // Hook dropdown menu click event to datatable export buttons
        const exportButtons = document.querySelectorAll('#kt_datatable_example_export_menu [data-kt-export]');
        exportButtons.forEach(exportButton => {
            exportButton.addEventListener('click', e => {
                e.preventDefault();

                // Get clicked export value
                const exportValue = e.target.getAttribute('data-kt-export');
                const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

                // Trigger click event on hidden datatable export buttons
                target.click();
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
    var handleCreateForm = () => {
        $(document).on('click', '#create_form', function (e) {
            e.preventDefault();
            let $this = $(this);
            let $action = $this.data('action');
            axios.get(`${$action}`).then(response => {

                if (response.data.status) {
                    $("#m_store_modal .modal-content").empty().append(response.data.item.form);
                    $('[data-control="select2"]').select2();

                    KTImageInput.createInstances();
                    if($(".start_date_input").length) {
                        $(".start_date_input").flatpickr();
                    }
                    if($(".end_date_input").length) {
                        $(".end_date_input").flatpickr();
                    }
                    initFormValidation();
                    $("#m_store_modal").modal("show");
                } else {
                    customSweetAlert(
                        'error',
                        response.message,
                        response.errors_object
                    );
                }
            }).catch(err => console.log(err));
        });
    };
    var handleStoreToDatatable = () => {
        $(document).on('click', '#form_submit', function (e) {
            e.preventDefault();
            let submitButton = $(this);
            if (validator) {
                validator.validate().then(function (status) {
                    if (status === 'Valid') {
                        submitButton.attr('data-kt-indicator', 'on');
                        submitButton.attr('disabled', true);
                        $('.summernote').each(function () {
                            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
                        });
                        if ($('.tiny').length) {
                            tinymce.triggerSave(true, true);
                        }

                        var formData = new FormData($('#form_post')[0]);
                        var url = $('#form_post').attr('action');
                        var _method = $('#form_post').attr('method');


                        $.ajax({
                            url: url,
                            method: _method,
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                if (response.status) {
                                    if (modal) {
                                        modal.modal('hide');
                                        modal.find(".modal-content").empty()
                                    }
                                    customSweetAlert(
                                        'success',
                                        response.message,
                                        response.item,
                                        function (event) {
                                            submitButton.attr('data-kt-indicator', 'off');
                                            submitButton.disabled = false;

                                            dt.draw();
                                        }
                                    );
                                } else {
                                    submitButton.attr('data-kt-indicator', 'off');
                                    submitButton.attr('disabled', false);


                                    customSweetAlert(
                                        'error',
                                        response.message,
                                        response.errors_object
                                    );
                                }
                            },
                            error: function (jqXhr) {
                                submitButton.attr('data-kt-indicator', 'off');
                                submitButton.attr('disabled', false);
                                getErrors(jqXhr, '/admin/login');
                            }
                        });
                    }
                });
            }
        });
        $(document).on('click' , '.form_submit' , function (e) {
            e.preventDefault();
            let $this = $(this);
            let $modal = $($this.data('modal'));
            let $form = $($this.data('form'));
            let $action = $form.attr('action');
            let $formData = new FormData($form[0]);
            $this.attr('disabled' , true);
            axios.post(`${$action}` , $formData).then(response => {
                $this.attr('disabled' , false);
                if(response.data.status) {
                    $form[0].reset();
                    customSweetAlert(
                        'success',
                        response.data.message,
                        '',
                        function (event) {
                            $modal.modal('hide');
                            dt.draw();
                        }
                    );
                }else {
                    customSweetAlert(
                        'error',
                        response.data.message,
                        ''
                    );
                }
            }).catch(err => {
                $this.attr('disabled' , false);
                customSweetAlert(
                    'error',
                    err,
                    ''
                );
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
    var handleDeleteRows = () => {
        $(document).on('click', '.destroy', function (e) {
            e.preventDefault();
            let $this = $(this);
            let $target_url = $this.data('action');
            let customerName = $this.closest('tr td').text();
            let $sub_table = $this.data('table');
            Swal.fire({
                text: `${$sweet_alert_do_u_wish_to_deletes} ${customerName} ؟`,
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: $sweet_alert_delete,
                cancelButtonText: $sweet_alert_close,
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    Swal.fire({
                        text: $sweet_alert_deleted_done + ' ' + customerName + '',
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                    });
                    axios.delete(`${$target_url}`).then(response => {
                        if (response.data.status == true) {
                            Swal.close();

                            Swal.fire({
                                text: "" + $sweet_alert_deleted_done + ' ' + customerName + "",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: $sweet_alert_done,
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function () {

                                if ($sub_table !== '' && $sub_table !== undefined && $sub_table !== null) {
                                    dt_city.draw();
                                } else {
                                    dt.draw();
                                }


                            });
                        } else {

                            Swal.close();
                            customSweetAlert(
                                'error',
                                response.data.message,
                                ''
                            );
                        }
                    }).catch(err => {
                        customSweetAlert(
                            'error',
                            err.response.data.message,
                            ''
                        );
                    });
                } else if (result.dismiss) {
                    Swal.fire({
                        text: $sweet_alert_was_not_deleted + ' ' + customerName,
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
    var handleChangeStatus = () => {
        $(document).on('click', '.change_status', function (e) {
            e.preventDefault();
            let $this = $(this);
            let $target_url = $this.data('action');
            axios.put(`${$target_url}`).then(response => {
                if (response.data.status == true) {
                    Swal.fire({
                        text: "" + $sweet_alert_status_was_changed_successfully,
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
                    customSweetAlert(
                        'error',
                        response.data.message,
                        ''
                    );
                }
            }).catch(err => {
                customSweetAlert(
                    'error',
                    err.response.data.message,
                    ''
                );
            });
        });

        $(document).on('click', '.send_email', function (e) {
            e.preventDefault();
            let $this = $(this);
            let $target_url = $this.data('action');
            axios.get(`${$target_url}`).then(response => {
                if (response.data.status == true) {
                    Swal.fire({
                        text: "" + $sweet_alert_done_success,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: response.data.message,
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function () {
                        dt.draw();
                    });
                } else {

                    Swal.close();
                    customSweetAlert(
                        'error',
                        response.data.message,
                        ''
                    );
                }
            }).catch(err => {
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
            if ($("#form_post").length > 0) {
                initFormValidation();
            }
            handleStoreToDatatable();
            handleSearchDatatable();
            if ($(".datatable-checkbox").length > 0) {
                initToggleToolbar();
            }

            handleActiveOperation();
            exportButtons();
            handleCreateForm();
            handleShowRows();
            handleDeleteRows();
            handleChangeStatus();
            getErrors();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});
