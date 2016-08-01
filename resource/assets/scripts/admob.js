function update() {
    Metronic.blockUI({target: 'body'});
    
    var data = new Array();
    $(".form-group").each(function(index, row) {
        var k = $(row).attr('data-kind');
        var s = $(row).find('.js-switch').attr('checked') ? 1 : 0;
        var f = $(row).find(".form-control").val();
        
        data[index] = { kind: k, status: s, frequency: f  };
    });
    
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'user/update_admob.html',
        data: {
            data : data
        },
        dataType: 'json',
        success: function (data) {
            showAlert("Successfully updated!");
            Metronic.unblockUI();
        },
        error: function () {
            Metronic.unblockUI();
        }
    });
}

jQuery(document).ready(function () {
    
    showAlert($("#msg_alert").html());
    
    $(".js-switch").on('click', function(e) {
        if ($(this).attr('checked')) {
            $(".js-switch").removeAttr('checked');
            $(this).attr('checked', 'checked');
        }
    });

    
    $("#btn_update").on('click', function(e) {
        e.preventDefault();
        update();
    });

});
