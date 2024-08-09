const form = document.querySelector('#form_post');
var formjs = $('#form_post');
var formjs2 = $('#form_post2');

var validator = FormValidation.formValidation(
    form, {
        plugins: {
            // declarative: new FormValidation.plugins.Declarative({
            //     html5Input: true,
            //     prefix: 'data-fv-',
            // }),
            // trigger: new FormValidation.plugins.Trigger(),
            // bootstrap: new FormValidation.plugins.Bootstrap5({
            //     rowSelector: '.fv-row',
            //     eleInvalidClass: '',
            //     eleValidClass: ''
            // }),
        }
    }
);
const submitButton = document.querySelector('#form_submit');
$(document).on('click', '#form_submit', function(e) {
    // Prevent default button action
    const form = $('#form_post');

    e.preventDefault();
    if (validator) {
        validator.validate().then(function(status) {

            if (status == 'Valid') {
                submitButton.setAttribute('data-kt-indicator', 'on');

                submitButton.disabled = true;

                $(form).each(function() {
                    if ($(this).data('validator'))
                        $(this).data('validator').settings.ignore = ".note-editor *";
                });
                var formData = new FormData(formjs[0]);
                var url = formjs.attr('action');
                var redirectUrl = formjs.attr('to');
                var _method = formjs.attr('method');

                $.ajax({
                    url: url,
                    method: _method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        submitButton.disabled = false;
                        if (response.status) {
                            if(response.item != undefined && response.item.url != undefined) {
                                customSweetAlert(
                                    'success',
                                    response.message,
                                    null,
                                    function(event) {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;
                                        window.location.href = response.item.url;
                                    }
                                );
                            } else {
                                customSweetAlert(
                                    'success',
                                    response.message,
                                    response.item,
                                    function(event) {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;
                                        window.location.href = redirectUrl;
                                    }
                                );
                            }
                        } else {
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;
                            customSweetAlert(
                                'error',
                                response.message,
                                response.errors_object
                            );
                        }
                    },
                    error: function(jqXhr) {
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                        customSweetAlert(
                            'error',
                            jqXhr?.responseJSON?.message
                        );
                    }
                });

            }
        });
    }
});


const submitButton2 = document.getElementById('form_submit2');
if (submitButton2) {
    submitButton2.addEventListener('click', function(e) {
        // Prevent default button action
        e.preventDefault();
        if (validator) {
            validator.validate().then(function(status) {

                if (status == 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    submitButton.disabled = true;

                    $(form).each(function() {
                        if ($(this).data('validator'))
                            $(this).data('validator').settings.ignore = ".note-editor *";
                    });
                    var formData = new FormData(formjs2[0]);
                    var url = formjs2.attr('action');
                    var redirectUrl = formjs2.attr('to');
                    var _method = formjs2.attr('method');

                    $.ajax({
                        url: url,
                        method: _method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            submitButton.disabled = false;
                            if (response.status) {
                                if(response.item != undefined && response.item.url != undefined) {
                                    customSweetAlert(
                                        'success',
                                        response.message,
                                        null,
                                        function(event) {
                                            submitButton.removeAttribute('data-kt-indicator');
                                            submitButton.disabled = false;
                                            window.location.href = response.item.url;
                                        }
                                    );
                                } else {
                                    customSweetAlert(
                                        'success',
                                        response.message,
                                        response.item,
                                        function(event) {
                                            submitButton.removeAttribute('data-kt-indicator');
                                            submitButton.disabled = false;
                                            window.location.href = redirectUrl;
                                        }
                                    );
                                }
                            } else {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;
                                customSweetAlert(
                                    'error',
                                    response.message,
                                    response.errors_object
                                );
                            }
                        },
                        error: function(jqXhr) {
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;
                            customSweetAlert(
                                'error',
                                jqXhr?.responseJSON?.message
                            );
                        }
                    });

                }
            });
        }
    });

}
