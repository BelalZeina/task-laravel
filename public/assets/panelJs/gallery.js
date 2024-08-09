let $filterUrl = $("#gallary-modal").data('url-filter');
let $firstUrl = $("#gallary-modal").data('url-first');

const Dashboard = Uppy.Dashboard
const uppy = Uppy.Core({
    debug: true,
    autoProceed: true,
    locale: Uppy.locales[$UppyLocaleJs],
    restrictions: {
        maxFileSize: 5000000,
        maxNumberOfFiles: 100,
        minNumberOfFiles: 1,
        allowedFileTypes: ['image/*']
    }
    // , 'video/*'
}).use(Uppy.XHRUpload,
    {
        endpoint: `${$galleryUrl}`,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        allowedMetaFields: ['name', 'caption']
    }).use(Dashboard, {
    trigger: '.UppyModalOpenerBtn',
    inline: true,
    locale: {
        strings: {
            dropPaste: $UppyDropFilesHere+" %{browse}",
            browse: $UppyBrowse,
        },
    },
    target: '#uppyBox',
    replaceTargetContent: true,
    showProgressDetails: true,

    // note: 'Images and video only, 2–3 files, up to 1 MB',
    height: 400,
    metaFields: [
        {id: 'name', name: `${$gallery_name_attr}`, placeholder: `${$gallery_image_name_attr}`},
        // {id: 'caption', name: 'Caption', placeholder: 'نص توضيحي'}
    ],
    browserBackButtonClose: true,
}).on('complete', (result) => {
    if (result.successful.length) {
        toastr.success(result.successful[0].response.body.message);
        $("#main_gallery_images_wrap").empty().append(result.successful[0].response.body.item.render_gallery)
        console.log()
    }
});

function fetch_data($page = 1) {
    axios.post(`${$firstUrl}` , {
        page: $page,
        sort_by: $("#sort_images_by").val()
    }).then(response => {
        if(response.data.status) {
            $("#main_gallery_images_wrap").empty().append(response.data.item.render_gallery);
        }else {
            toastr.error(response.data.message)
        }
    }).catch(err => toastr.error(err));
}

$(document).ready(() => {

    $(document).on('click', '#gallery_paginate a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];

        fetch_data(page);
    });
    $(document).on('click', '.custom-file', function (e) {
        e.preventDefault();
        axios.post(`${$firstUrl}`).then(response => {
            if(response.data.status) {
                $("#main_gallery_images_wrap").empty().append(response.data.item.render_gallery);
                $("#gallary-modal .img-box-item").removeClass('active');

                let dataMltiple = $(this).data('multiple');
                let $addButton = $(this).data('add-button');
                let $imageWrapper = $(this).data('image-wrapper');
                $("#gallary-modal").data('image-wrapper', $imageWrapper)
                $("#gallary-modal").data('multiple', dataMltiple);

                if ($addButton === false) {
                    $("#add_selected_images_to_crud").addClass('d-none');
                } else {
                    $("#add_selected_images_to_crud").removeClass('d-none');

                }
                $("#gallary-modal").modal('show');
            }else {
                toastr.error(response.data.message)
            }
        }).catch(err => toastr.error(err));




    });

    $(document).on('click', '.gallary-box .img-box-item', function () {
        let dataMltiple = $("#gallary-modal").data('multiple');
        if (dataMltiple == true) {
            $(this).toggleClass('active');
        } else {
            $(this).siblings().removeClass('active');
            $(this).toggleClass('active');
        }
    });

    $(document).on('click', '#add_selected_images_to_crud', function (e) {
        e.preventDefault();

        let dataMltiple = $("#gallary-modal").data('multiple');


        if (dataMltiple == true) {
            let $rows = '';
            $("#gallary-modal .img-box-item.active").each(function () {
                console.log($(this).data('imagesrc'));
                let imagesrc = $(this).data('imagesrc');
                let imageonly = $(this).data('onlyimage');
                let $name = $(this).data('name');
                let $mime_type = $(this).data('mime_type');
                let $size = $(this).data('size');
                $rows += imageHolderForImages(imagesrc , imageonly , $name , $mime_type , $size);
            });
            $("#images_upload_container").empty().append($rows);
        } else {
            let imagesrc = $("#gallary-modal .img-box-item.active").data('imagesrc');
            let imageonly = $("#gallary-modal .img-box-item.active").data('onlyimage');
            let $imageWrapper = $("#gallary-modal").data('image-wrapper');
            console.log($imageWrapper, $($imageWrapper).find('.gallery_grud_image_input'), imagesrc);
            $($imageWrapper).find('.gallery_grud_image_input').val(imageonly);
            $($imageWrapper).find('.image-input-wrapper').css('background-image', 'url(' + imagesrc + ')');
            // console.log($($imageWrapper).find('.gallery_grud_image_input').val())
        }
        $("#gallary-modal").modal('hide');
    });


    $(document).on('click', '.remove-img', function () {
        let $this = $(this);
        let $action = $this.data('action');
        axios.delete(`${$action}`).then(response => {
            if(response.data.status) {
                toastr.success(response.data.message);
                $this.parents('.img-box-item').remove();
            }else {
                toastr.error(response.data.message)
            }
        }).catch(err => toastr.error(err));

    });

    $(document).on('change', '#sort_images_by', function () {
        let $this = $(this);
        fetch_data();
        // axios.post(`${$filterUrl}`, {
        //     sort_by: $this.val()
        // }).then(response => {
        //     if (response.data.status) {
        //         $("#main_gallery_images_wrap").empty().append(response.data.item.render_gallery);
        //     } else {
        //         toastr.error(response.data.message);
        //     }
        // }).catch(err => toastr.error(err));
    });
});

function imageHolderForImages($src , $value , $display_name , $mime_type , $size) {
    return `<div class="img-box-item">
                                            <div class="img">
                                                <img
                                                    src="${$src}"
                                                    alt="" class="img-fluid w-100 h-100">
                                            </div>
                                            <h5 class="name mt-1 mb-3">
                                                <span class="title"> ${$display_name}</span>
                                                <span class="ext">.${$mime_type}</span>
                                            </h5>
                                            <p class="size mb-0">${$size}</p>
                                            <button
                                                class="btn btn-secondary btn-icon w-20px h-20px btn-circle remove-img">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                     viewBox="0 0 24 24">
                                                    <path fill="#888888"
                                                          d="M18.36 19.78L12 13.41l-6.36 6.37l-1.42-1.42L10.59 12L4.22 5.64l1.42-1.42L12 10.59l6.36-6.36l1.41 1.41L13.41 12l6.36 6.36z"/>
                                                </svg>
                                            </button>
                                            <input type="hidden" name="images[]" class="image_input" value="${$value}">
                                        </div>`;
}

