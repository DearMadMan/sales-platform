$(function () {
    var remove_btn = $("a[data-dz-remove]"),
        _token = $("#_token").val(),
        _id = $("#id").val();
    _method = $("#_method").val();

    remove_btn.each(function () {

        $(this).click(function () {
            /* create or edit */
            if (_method == 'post') {
                var file_name = $(this).parent().find("span[data-dz-name]").text();
                file_name = file_name.substr(1);
                $.ajax({
                    url: '/manager/good-gallery',
                    type: 'post',
                    context: $(this),
                    data: {
                        _token: _token,
                        destroy: true,
                        method: _method,
                        file_name: file_name
                    },
                    success: function (res) {
                        if (res == 'true') {
                            $(this).parent().remove();
                        }
                    }
                });
            } else if (_method == 'put') {
                var file = $(this).parent().find("span[data-dz-name]").eq(0),
                    file_name = file.text(),
                    delete_file = $("#delete_file");
                    file_name = file_name.substr(1);
                if ($(this).attr('uploaded')) {
                    delete_file.val(delete_file.val() + ',' + file_name);
                    $(this).parent().remove();
                }
                else {
                    $.ajax({
                        url: '/manager/good-gallery',
                        type: 'post',
                        context: $(this),
                        data: {
                            id: _id,
                            _token: _token,
                            method: _method,
                            destroy: true,
                            file_name: file_name
                        },
                        success: function (res) {
                            if (res == 'true') {
                                $(this).parent().remove();
                            }
                        }
                    });
                }

            }
            else {

            }

        });
    });
});