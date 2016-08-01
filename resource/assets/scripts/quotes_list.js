
function update(kind, id) {
    $("#edit_detail_kind").val(kind);
    $("#edit_detail_id").val(id);

    if (kind == 'edit' || kind == 'delete') {
        if (id == '')
            return;

        if (kind == 'delete') {
            bootbox.confirm("Are you sure to delete?", function (result) {
                if (result) {
                    $.ajax({
                        type: "POST",
                        url: $("#basePath").val() + 'quotes/delete.html',
                        data: {quotes_id: $("#edit_detail_id").val()},
                        dataType: 'json',
                        success: function (data) {
                            showAlert(data.errMsg);
                            if (data.errCode == 0) {
                                $('#table_content').dataTable().api().ajax.reload();
                            } else {
                            }
                        },
                        error: function () {
                        }
                    });
                }
            });
        }
    }

    if (kind != 'delete') {
        $("#form_move_edit").submit();
    }
}

jQuery(document).ready(function () {
    showAlert($("#msg_alert").html());

    $("#btn_add").on('click', function (e) {
        e.preventDefault();
        update('add', '');
    });

    $('#table_content').dataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": $("#basePath").val() + "quotes/load.html",
            "type": "POST"
        },
        'searching' : false,
        "order": [[2, "desc"]],
        "columnDefs": [
            {
                "targets": [0, -1],
                "orderable": false
            },
            {
                "targets": "_all",
                "searchable": false
            }
        ],
        "columns": [
            {
                "data": "url",
                "render": function (data, type, row, meta) {
                    return '<img src="'+ $("#resource_path").val() + data +'" alt="" style="max-width:200px;">';
                }
            },
            {
                "data": "rv",
            },
            {
                "data": "created_at",
                "render": function (data, type, row, meta) {
                    var d = "";
                    if (data != null)
                        d = data.substring(0, 4) + "-" + data.substring(4, 6) + "-" + data.substring(6, 8) + " " + data.substring(8, 10) + ":" + data.substring(10, 12);//+":"+data.substring(12,14);
                    return d;
                }
            },
            {
                "data": "action",
                "render": function (data, type, row, meta) {
                    var data = "";

                    data += '<div class="btn-group"> ' +
                            '<button type="button" class="btn default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true"> Action<i class="fa fa-angle-down"></i> </button>' +
                            '<ul class="dropdown-menu pull-right" role="menu">' +
                            '<li class="divider"></li>';

                        data += '' + 
                                '<li><a href="javascript:update(\'edit\', \'' + row.id + '\')"><i class="fa fa-pencil-square-o"></i> Edit</a></li>' +
                                '<li><a href="javascript:update(\'delete\', \'' + row.id + '\')"><i class="fa fa-times-circle"></i> Delete</a></li>' ;
                    
                    data += '<li class="divider"></li>';
                    data += '</ul>' +
                            '</div>' +
                            '';

                    return data;
                }
            }
        ]
    });

    $('#table_content').on('draw.dt', function () {
        $('#table_content').removeClass('display').addClass('table table-striped table-bordered');
        $('#table_content tr td:nth-child(1)').addClass('center');
        $('#table_content tr td:nth-child(2)').addClass('center');
        $('#table_content tr td:nth-child(3)').addClass('center');
        $('#table_content tr td:nth-child(4)').addClass('center');
    });

    $("#btn_import").on('click', function (e) {
        e.preventDefault();
        $("#form_move_import").submit();
    });


});
