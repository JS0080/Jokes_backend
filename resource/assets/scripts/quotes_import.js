function send_notification(c) {
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'api/v1/push/send',
        data: {
            count: c
        },
        dataType: 'json',
        success: function (data) {
        },
        error: function () {
        }
    });
}

jQuery(document).ready(function () {
    showAlert($("#msg_alert").html());

    $('#takeFileUpload').fileupload({
        limitMultiFileUploads: 20,
        singleFileUploads: false,
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
                showAlert(data.result.upload_count + " Images are successfully uploaded!");
                
                send_notification(data.result.upload_count);
            } else {
                showAlert(data.result.errMsg);
            }
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var percentVal = progress + '%';
            $('div#upload_progressbar>span').css('width', percentVal);
        },
        fail: function(e, data) {
            $('div#upload_progressbar').hide();
            showAlert("Failed to upload!");
        }
    });

    $('div#upload_progressbar').hide();
    $("#btn_add_logo").click(function () {
        $('#takeFileUpload').trigger('click');
    });

});
