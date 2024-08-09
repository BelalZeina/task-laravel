function customSweetAlert(type, title, html, func, done_btn = null) {
    console.log(done_btn)
    var then_function = func || function () {
    };
    if (done_btn == false) {
        swal.fire({
            title: '<span class="' + type + '">' + title + '</span>',
            icon: type,
            html: html,
            showConfirmButton: false
        }).then(then_function);
    } else {
        swal.fire({
            title: '<span class="' + type + '">' + title + '</span>',
            icon: type,
            html: html,
            confirmButtonText: `${$sweet_alert_done}`,
            // confirmButtonColor: '#56ace0',
            customClass: {
                confirmButton: "btn btn-primary"
            }
            // confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"

        }).then(then_function);
    }

}

function errorCustomSweet() {
    customSweetAlert(
        'error',
        'Something went wrong!'
    );
}

function successCustomSweet(text) {
    customSweetAlert(
        'success',
        text
    );
}

function getErrorsData(jqXhr, path) {
    if (jqXhr != null)
        switch (jqXhr.status) {
            case 401 :
                // $(location).prop('pathname', path);
                // break;
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
                    var $errors = jqXhr.responseJSON;
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

let deleteRecord = (url, ...args) => {
    let data,
        section,
        removeing,
        sliders,
        to;
    args.find(x => {
        data = x.data ?? null;
        section = x.section ?? null;
        removeing = x.removeing ?? null;
        sliders = x.sliders ?? null;
        to = x.to ?? null;
    });
    // return false;
    // (url , data = null , section = null , to = null)
    Swal.fire({
        text: "هل أنت متأكد من عملية الحذف ؟",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "قم بالحذف",
        cancelButtonText: "إغلاق",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    }).then(function (result) {
        if (result.value) {
            Swal.fire({
                text: 'الرجاء الإنتظار',
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
            });
            axios.delete(`${url}`, {
                data: data
            }).then(response => {
                if (response.data.status == true) {
                    Swal.close();

                    Swal.fire({
                        text: "تم الحذف بنجاح",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "تم",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function () {
                        if (section) {
                            $(section).empty().append(response.data.item.render);
                            KTMenu.createInstances();
                        }
                        if (sliders) {
                            initMyTinySliders({sliders: sliders});
                        }
                        if (removeing) {
                            removeing.remove();
                        }
                        if (to) {
                            window.location = to;
                        }
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
        }
    });
}

let changeEvent = (url , ...args) => {
    let operation,
        select_to,
        default_option,
        value;
    args.find(x => {
        operation = x.operation ?? null;
        select_to = x.select_to ?? null;
        default_option = x.default_option ?? null;
        value = x.value_of_select ?? null;
    });
    if(operation === 'get_to_select') {
        axios.get(`${url}` , {
            params: {
                item: value
            }
        }).then(response => {
            if(response.data.status) {
                let $rows = '<option value=""></option>';
                if(default_option) {
                    $rows = default_option;
                }
                let $dataReturn = response.data.item.items;
                for(let $i in $dataReturn) {
                    $rows += `<option value="${$dataReturn[$i].id}">${$dataReturn[$i].name}</option>`;
                }
                $(select_to).empty().append($rows);
            }else {
                toastr.error(response.data.message);
            }
        }).catch(err => {
            toastr.error(err);
        });
    }
}


$(document).on('click', '.destroy_data', function (e) {
    e.preventDefault();
    let $this = $(this);
    let $target_url = $this.data('action');
    let customerName = $this.data('title');
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

                        if ($('#load_carts').length) {
                            $('#load_carts').empty().append(response.data.item.load_carts)
                        }

                        if ($('#carts_count').length) {
                            $('#carts_count').empty().append(response.data.item.load_carts_count)
                        }

                        if ($('#favorites_count').length) {
                            $('#favorites_count').empty().append(response.data.item.load_favorites_count)
                        }

                        if ($('#load_favorites').length) {
                            $('#load_favorites').empty().append(response.data.item.load_favorites)
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


let confirmDeleteProcess = (type, ...args) => {
    let data,
        to,
        redirect_to,
        button;
    args.find(x => {
        data = x.data ?? null;
        to = x.to ?? null;
        redirect_to = x.redirect_to ?? null;
        button = x.button ?? null;
    });
    if (type === 'confirm') {
        $(".delete-class-modal").modal('show');
        $(".delete-class-modal .confirm_multi_delete").attr('data-action', to);
        return false;
    }

    if (type === 'confirm_as_sections') {
        let $ids = [];
        $(".datatable-checkbox").each(function () {
            if ($(this).is(':checked')) {
                $ids.push($(this).val());
            }
        });
        console.log($ids)
        if ($ids.length) {
            $(".delete-class-modal").modal('show');
            $(".delete-class-modal .confirm_multi_delete").attr('data-action', to);
            $(".delete-class-modal .confirm_multi_delete").attr('data-reload', true);
        } else {
            customSweetAlert(
                'error',
                $sweet_alert_you_need_to_check_at_least_one,
                ''
            );
        }
        return false;
    }

    if (type === 'confirm_single_sections') {
        $(".delete-class-modal").modal('show');
        $(".delete-class-modal .confirm_multi_delete").attr('data-action', to);
        $(".delete-class-modal .confirm_multi_delete").attr('data-redirect_to', redirect_to);
        $(".delete-class-modal .confirm_multi_delete").attr('data-method', 'delete');
        return false;
    }

    if (type === 'confirmed') {
        let $ids = [];
        $(".datatable-checkbox").each(function () {
            if ($(this).is(':checked')) {
                $ids.push($(this).val());
            }
        });
        let $target_url = $(button).data('action');
        let $reload = $(button).data('reload');
        let $redirect_to = $(button).data('redirect_to');
        let $method = $(button).data('method');
        if ($method === 'delete') {
            axios.delete(`${$target_url}`).then(response => {
                if (response.data.status) {
                    Swal.close();

                    Swal.fire({
                        text: "" + $sweet_alert_deleted_done,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: $sweet_alert_done,
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function () {
                        $(".delete-class-modal").modal('hide');

                        window.location.href = $redirect_to;
                        // $this.parents('.parent_section').remove();
                        // dt.draw();
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
                    err,
                    ''
                );
            });
        } else {
            axios.post(`${$target_url}`, {
                id: $ids
            }).then(response => {
                if (response.data.status) {
                    Swal.fire({
                        text: response.data.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: $sweet_alert_done,
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function () {
                        $(".delete-class-modal").modal('hide');
                        if ($reload) {
                            window.location.reload();
                        } else {
                            dt.draw();
                        }

                    });
                } else {
                    customSweetAlert(
                        'error',
                        response.data.message,
                        ''
                    );
                }
            }).catch(err => {
                console.log(err)
                customSweetAlert(
                    'error',
                    err.response.data.message,
                    ''
                );
            });
        }

        return false;
    }
}


$(document).ready(() => {
    $(document).on('click' , '.change_delivery_status' , function (e) {
        e.preventDefault();
        let $this = $(this);
        let $action = $this.data('action');
        axios.post(`${$action}`).then(response => {
            if(response.data.status) {
                toastr.success(response.data.message)
                setTimeout(() => {
                    window.location.reload();
                } , 1000);
            }else {
                toastr.error(response.data.message)
            }
        }).catch(err => toastr.error(err));
    });
});
