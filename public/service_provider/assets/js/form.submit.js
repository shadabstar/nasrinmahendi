function submitForm(form) {
    // alert('submitted');
    var formid = '#' + $(form).attr('id');
    var action = $(form).attr('action');
    var type = $(form).attr('method');
    var formData = new FormData($(form)[0]);

    $.ajax({
        type: type,
        url: action,
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {

            //
            $(formid).find('.alert').removeClass('alert-info').removeClass('alert-success').removeClass('alert-danger');
            $(formid).find('.alert').addClass('alert-info');
            $(formid).find('.ajax_message').html('<strong>Please Wait ! <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></strong>');
            $(formid).find('.alert').fadeIn(200);
            $('html, body').animate({
                scrollTop: $(formid).offset().top - 150
            }, 1000);
        },
        success: function (response) {

            if (response.status == 'success') {
                // page slide to top
                if (response.slideToTop) {
                    $('html, body').animate({
                        scrollTop: $(formid).offset().top - 150
                    }, 1000);
                }
                // display alert message
                if (response.message) {
                    $(formid).find('.alert').removeClass('alert-info').removeClass('alert-success').removeClass('alert-danger');
                    $(formid).find('.alert').addClass('alert-success').children('.ajax_message').html(response.message);
                    $(formid).find('.alert').fadeIn(200);
                }
                // redirect on given url
                if (response.redirect) {
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1000);
                }
                // self reload current url
                if (response.selfReload) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }

            }
            else {
                // display alert message
                $(formid).find('.alert').removeClass('alert-info').removeClass('alert-success').removeClass('alert-danger');
                $(formid).find('.alert').addClass('alert-danger').children('.ajax_message').html(response.message);
                $(formid).find('.alert').fadeIn(200);
            }
        }
    });
}

$(document).on('click', '.close', function () {
    $(this).closest('div.alert').fadeOut();
});
