var preventRunDefault = false;

function refreshSwatch() {
    var v = parseInt($("#slider").slider("value"));
    $("#imgPreview").iviewer('set_zoom', v);
}

function addPhoto(full, thumb) {
    $("#subject_logo").attr('src', thumb);
    $("#frm_input").bootstrapValidator('resetForm', false);
}

function send_notification() {
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'api/v1/push/send',
        data: {
        },
        dataType: 'json',
        success: function (data) {
        },
        error: function () {
        }
    });
}

function goto_list() {
    $("#form_move_list").submit();    
}

jQuery(document).ready(function () {
    
    $("#notes").val($("#notes_temp").val());
    showAlert($("#msg_alert").html());


    $('#takeFileUpload').fileupload({
        dataType: 'json',
        formData: {
        },
        beforeSend: function () {
            $('div#upload_progressbar>span').css('width', '0%');
            $('div#upload_progressbar').show();
        },
        done: function (e, data) {
            $('div#upload_progressbar').hide();
            if (data.result.errCode == 0) {

                $("#subject_logo").attr('src', data.result.url);
                $("#subject_logo").attr('data-filename', data.result.path);
            } else {
            }
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percentVal = progress + '%';
            $('div#upload_progressbar>span').css('width', percentVal);
        }
    });

    $('div#upload_progressbar').hide();
    $("#btn_add_logo").click(function () {
        $('#takeFileUpload').trigger('click');
    });

    $('#frm_input').bootstrapValidator({
        excluded: ':disabled',
        feedbackIcons: {
            valid: 'has-success',
            invalid: 'has-error',
            validating: ''
        }
    })
    .on('success.field.bv', function (e, data) {
        if (data.bv.isValid()) {
            data.bv.disableSubmitButtons(false);
        }
    });

    $("#frm_input").on("valid invalid submit", function (event) {
        event.stopPropagation();
        event.preventDefault();

        if (event.type == 'submit') {
            if ($("#frm_input .has-error").length == 0) {

                if ($("#subject_logo").attr('data-filename') == '') {
                    showAlert("Select quotes image!");
                    return false;
                }

                if (!preventRunDefault) {
                    preventRunDefault = true;

                    $.ajax({
                        type: "POST",
                        url: $("#basePath").val() + 'quotes/update.html',
                        data: {
                            kind: $("#edit_detail_kind").val(),
                            quotes_id: $("#edit_detail_id").val(),
                            image: $("#subject_logo").attr('data-filename'),
                            likes: $("#txt_likes").val()
                        },
                        dataType: 'json',
                        success: function (data) {
                            preventRunDefault = false;
                            showAlert(data.errMsg);
                            if (data.errCode == 0) {
                                if ($("#edit_detail_kind").val()=="add") {
                                    send_notification();
                                    
                                } else {
                                    
                                }
                                
                                setTimeout(goto_list, 600);
                            } else {
                            }
                        },
                        error: function () {
                            preventRunDefault = false;
                        }
                    });
                }
            }
        }

        return false;
    });
    
});
