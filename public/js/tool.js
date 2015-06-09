function checked() {
    var checkbox = $("input[type=checkbox]");
    checkbox.attr('checked', 'checked');
    updateCheckStatus(true);
}

function unCheck() {
    var checkbox = $("input[type=checkbox]");
    checkbox.removeAttr('checked');
    updateCheckStatus(false);
}

function updateCheckStatus(bool) {
    var checkbox = $("input[type=checkbox]");
    if (bool) {
        checkbox.prop('checked', true).trigger('change');
    }
    else {
        checkbox.prop('checked', false).trigger('change');
    }

}

function checkToggle() {
    var leader = $("#checkbox_leader");
    var checkbox = $("input[type=checkbox]");
    if (leader.is(":checked")) {
        checkbox.prop('checked', true).trigger('change');

    }
    else {
        checkbox.prop('checked', false).trigger('change');

    }
}


function DeleteOne() {

}

function DeleteAll() {

}

$(function () {
    /* checkbox */
    var leader = $("#checkbox_leader");
    leader.on('change', function (ev) {

        var checkbox = $("input[type=checkbox]:not(#checkbox_leader)");
        if (leader.is(":checked")) {
            checkbox.prop('checked', true).trigger('change');

        }
        else {
            checkbox.prop('checked', false).trigger('change');
        }
    });

    /* Delete */

    $("td a.btn-danger").each(function () {
        $(this).bind('click', function () {
            if (confirm('确认要进行删除操作吗 ?')) {
                $.ajax({
                    url: post_url + $(this).attr("data"),
                    type: 'delete',
                    dataType: "text",
                    context: this,
                    data: {"_token": $("#_token").val(), '_method': 'delete'},
                    success: function (res) {
                        if (res) {
                            /* 删除子元素 */
                            var name = $(this).parents("tr").eq(0).children("td").eq(4).text().trim();
                            $("tr").each(function () {
                                var belongs = $(this).children('td').eq(3).text().trim();
                                console.log(name+":"+belongs);
                                if (name == belongs) {
                                    $(this).remove();
                                }
                            });
                        }
                        $(this).parents('tr').eq(0).remove();
                    },
                    complete: function (res) {
                        console.log(res.responseText);
                    }
                });
            }

        });
    });

    /* Delete All */

    $("#delete_all").bind('click', function () {
        if (!confirm('确定要对所选内容进行删除操作吗？')) {
            return false;
        }
        var checkbox = $("input[type=checkbox]:not(#checkbox_leader)");
        checkbox.each(function () {
            if ($(this).is(":checked")) {
                $.ajax({
                    url: post_url + $(this).attr("data"),
                    type: 'delete',
                    dataType: "text",
                    context: this,
                    data: {"_token": $("#_token").val(), '_method': 'delete'},
                    success: function (res) {
                        if (res) {
                            /* 删除子元素 */
                            var name = $(this).parents("tr").eq(0).children("td").eq(4).text().trim();
                            $("tr").each(function () {
                                var belongs = $(this).children('td').eq(3).text().trim();
                                console.log(name+":"+belongs);
                                if (name == belongs) {
                                    $(this).remove();
                                }
                            });
                        }
                        $(this).parents('tr').eq(0).remove();
                    },
                    complete: function (res) {
                        console.log('111');
                    }
                });
            }
        });
    });

});
