
jQuery(document).ready(function () {
    showAlert($("#msg_alert").html());

    $('#table_content').dataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": $("#basePath").val() + "quotes/load_likes.html",
            "type": "POST"
        },
        'searching' : false,
        "order": [[1, "desc"]],
        "columnDefs": [
            {
                "targets": [-2, -1],
                "orderable": false
            },
            {
                "targets": "_all",
                "searchable": false
            }
        ],
        "columns": [
            {
                "data": "user_id",
            },
            {
                "data": "rv",
                "render": function (data, type, row, meta) {
                    var r = parseInt(data);
                    if (r>=0)
                        return '<span class="label label-danger">Likes : '+data+'</span>';
                    return '<span class="label label-warning">Dislike : '+data+'</span>';
                }
            },
            {
                "data": "url",
                "render": function (data, type, row, meta) {
                    return '<img src="'+ $("#resource_path").val() + data +'" alt="" style="width:200px;">';
                }
            },
            {
                "data": "action",
                "render": function (data, type, row, meta) {
                    var data = "";
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


});
