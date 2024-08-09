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
let activeRecord = (url, ...args) => {
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
        text: "هل أنت متأكد من عملية ؟",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "موافق",
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
            axios.post(`${url}`, data).then(response => {
                if (response.data.status == true) {
                    Swal.close();

                    Swal.fire({
                        text: response.data.message,
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
let initMyTinySliders = (...args) => {
    let sliders;
    args.find(x => {
        sliders = x.sliders ?? null;
    });
    var initSlider = function (el) {
        if (!el) {
            return;
        }

        const tnsOptions = {};

        // Convert string boolean
        const checkBool = function (val) {
            if (val === 'true') {
                return true;
            }
            if (val === 'false') {
                return false;
            }
            return val;
        };

        // get extra options via data attributes
        el.getAttributeNames().forEach(function (attrName) {
            // more options; https://github.com/ganlanyuan/tiny-slider#options
            if ((/^data-tns-.*/g).test(attrName)) {
                let optionName = attrName.replace('data-tns-', '').toLowerCase().replace(/(?:[\s-])\w/g, function (match) {
                    return match.replace('-', '').toUpperCase();
                });

                if (attrName === 'data-tns-responsive') {
                    // fix string with a valid json
                    const jsonStr = el.getAttribute(attrName).replace(/(\w+:)|(\w+ :)/g, function (matched) {
                        return '"' + matched.substring(0, matched.length - 1) + '":';
                    });
                    try {
                        // convert json string to object
                        tnsOptions[optionName] = JSON.parse(jsonStr);
                    } catch (e) {
                    }
                } else {
                    tnsOptions[optionName] = checkBool(el.getAttribute(attrName));
                }
            }
        });

        const opt = Object.assign({}, {
            container: el,
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
        }, tnsOptions);

        if (el.closest('.tns')) {
            KTUtil.addClass(el.closest('.tns'), 'tns-initiazlied');
        }

        return tns(opt);
    }
    sliders.forEach(slide => {
        const elements = Array.prototype.slice.call(document.querySelectorAll(`[data-tns-class=${slide}]`), 0);

        if (!elements && elements.length === 0) {
            return;
        }

        elements.forEach(function (el) {
            initSlider(el);
        });
    });

}
let showMoreButtons = (...args) => {
    let buttons,
        sliders;
    args.find(x => {
        buttons = x.buttons ?? null;
        sliders = x.sliders ?? null;
    });
    buttons.forEach(button => {
        let showMoreButton = document.getElementById(button.button);
        let showMoreCards = document.getElementById(button.section);
        let showMoreJsButton = $("#" + button.button);
        let showMoreJsSection = $("#" + button.section);
        $(document).on('click', '#' + button.button, e => {
            e.preventDefault();
            let $this = $(e.currentTarget);
            let target_url = $this.data('url');
            let page = $this.data('page');
            if (showMoreFollowersButton) {
                showMoreFollowersButton.setAttribute('data-kt-indicator', 'on');
            }
            $this.attr('data-kt-indicator', 'on');
            $this.attr('disabled', true);

            axios.get(`${target_url}`, {
                params: {
                    page: page
                }
            }).then(response => {
                if (response.data.status == true) {
                    // button.data('page' , response.data.item.page);
                    $this.attr('data-kt-indicator', 'off');

                    $this.attr('disabled', false);
                    $this.data('page', response.data.item.data_page);

                    if (response.data.item.parent == true) {
                        if (response.data.item.data_count != 6) {
                            showMoreButton.classList.add('d-none');
                        }
                        showMoreJsSection.empty().append(response.data.item.render);
                        if (sliders) {
                            initMyTinySliders({sliders: sliders});
                        }
                        KTMenu.createInstances();
                        // initMyTinySliders({ sliders: ['favorites-slider-'+response.data.item.data_page]});
                    } else {
                        if (!response.data.item.data_show_more) {
                            showMoreButton.classList.add('d-none');
                        }

                        showMoreJsSection.append(response.data.item.render);
                        initMyTinySliders({sliders: ['favorites-slider-' + response.data.item.data_page]});
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                        tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl)
                        })
                    }
                    showMoreCards.classList.remove('d-none');
                    KTUtil.scrollTo(showMoreCards, 200);
                }
            }).catch(err => {
                customSweetAlert(
                    'error',
                    err.response.data.message,
                    ''
                );
                $this.attr('data-kt-indicator', 'off');
                $this.attr('disabled', false);
                showMoreButton.removeAttribute('data-kt-indicator');
                showMoreButton.disabled = false;

            });
        });

    });


    // Public methods
    // return {
    //     init: function () {
    //         handleShowMore();
    //     }
    // }
};

let blockRecord = (url, ...args) => {
    let data,
        to;
    args.find(x => {
        data = x.data ?? null;
        to = x.to ?? null;
    });
    // (url , data = null , section = null , to = null)
    Swal.fire({
        text: "هل أنت متأكد من عملية ؟",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "موافق",
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

            axios.post(`${url}`, {
                data: data
            }).then(response => {
                if (response.data.status == true) {
                    Swal.close();
                    Swal.fire({
                        text: response.data.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "تم",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function () {

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
                    err.data.message,
                    ''
                );
            });
        }
    });
}


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
let confirmStoreProcess = (type, ...args) => {
    let data,
        to,
        redirect_to,
        formSubmit,
        button;
    console.log(type)
    args.find(x => {
        data = x.data ?? null;
        to = x.to ?? null;
        redirect_to = x.redirect_to ?? null;
        button = x.button ?? null;
        formSubmit = x.formSubmit ?? null;
    });

    if (type === 'confirm_as_sections') {
        let $ids = [];
        $(".datatable-checkbox").each(function () {
            if ($(this).is(':checked')) {
                $ids.push($(this).val());
            }
        });
        if ($ids.length) {
            $(".add-class-modal").modal('show');
            $(".add-class-modal .confirm_multi_add").attr('data-action', to);
            $(".add-class-modal .confirm_multi_add").attr('data-reload', true);
        } else {
            customSweetAlert(
                'error',
                $sweet_alert_you_need_to_check_at_least_one,
                ''
            );
        }
        return false;
    }

    if (type === 'confirm') {
        $(".add-class-modal").modal('hide');
        $(".add-class-modal").modal('show');
        $(".add-class-modal .confirm_multi_add").attr('data-action', to);
        return false;
    }

    console.log({to})
    console.log({redirect_to})

    if (type === 'confirm_single_sections') {
        $(".add-class-modal").modal('show');
        $(".add-class-modal .confirm_multi_add").attr('data-action', to);
        $(".add-class-modal .confirm_multi_add").attr('data-redirect_to', redirect_to);
        $(".add-class-modal .confirm_multi_add").attr('data-method', 'delete');
        $(".add-class-modal .confirm_multi_add").attr('data-form', formSubmit);
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
        axios.post(`${$target_url}`, {
            id: $ids
        }).then(response => {
            if (response.data.status) {
                $(".add-class-modal").modal('hide');
                Swal.fire({
                    text: response?.data?.message,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: $sweet_alert_done,
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                    }
                }).then(function () {
                    $(".add-class-modal").modal('hide');
                    if ($reload) {
                        window.location.reload();
                    }

                });
            } else {
                customSweetAlert(
                    'error',
                    response?.data?.message,
                    ''
                );
            }
        }).catch(err => {
            console.log(err)
            customSweetAlert(
                'error',
                err.response?.data?.message,
                ''
            );
        });

        return false;
    }

    if(type === 'form_submit') {
        $(".add-class-modal").modal('hide');
        $($(button).data('form')).click()
    }
}

function checkIfEmotyDataTable() {

    // console.log($("#kt_datatable_example_1 tbady tr").length)
    setTimeout(() => {
        if ($("#no_data").length == 1 && $("#kt_datatable_example_1 tbody tr td.dataTables_empty").length == 1) {
            $("#no_data").removeClass('d-none');
            $("#main_table").addClass('d-none');
        } else {
            $("#no_data").addClass('d-none');
            $("#main_table").removeClass('d-none');
        }
    }, 1000);

}
