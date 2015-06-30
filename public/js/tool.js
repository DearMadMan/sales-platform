/*
 *  tool.js
 *  create By : wang
 *  email: 2034906607@qq.com
 *  github: https://github.com/Dearmadman
 * */

/*
 * usage:
 *  var post_url="{{url('manager/good')}}"+"/";   //some delete method route
 *    <th class="no-sorting">
 *    <input type="checkbox" id="checkbox_leader" class="cbr">    // leader
 *    </th>
 *
 *   <input type="checkbox" data="{{$v->id}}"  class="cbr">     // tr>td:first-child input[type=checkbox]
 *
 *    <a href="javascript:;"  data="{{$v->id}}" class="btn btn-danger btn-sm btn-icon icon-left">
 *      Delete
 *    </a>                                                        //delete button
 *
 *     <div class="tool-btn">    //if !paginate class="";
 *    <button class="btn btn-info btn-sm" onclick="checked();">全选</button>
 *    <button class="btn btn-info btn-sm" onclick="unCheck();">全不选</button>
 *    <button class="btn btn-danger btn-sm" id="delete_all">删除</button>
 *    </div>
 * */


function checked() {
    var checkbox = $("tr>td>:first-child input[type=checkbox]");
    checkbox.attr('checked', 'checked');

    updateCheckStatus(true);
    leaderCheckStatus(true);

}

function leaderCheckStatus(bool) {
    var leader_box = $("#checkbox_leader");
    if (bool) {
        leader_box.attr('checked', 'checked');
    } else {
        leader_box.removeAttr('checked');
    }
    leader_box.prop('checked', bool).trigger('change');

}


function unCheck() {
    var checkbox = $("tr>td>:first-child input[type=checkbox]");
    checkbox.removeAttr('checked');
    updateCheckStatus(false);
    leaderCheckStatus(false);
}

function updateCheckStatus(bool) {
    var checkbox = $("tr>td>:first-child input[type=checkbox]");
    if (bool) {
        checkbox.prop('checked', true).trigger('change');
    }
    else {
        checkbox.prop('checked', false).trigger('change');
    }

}

function checkToggle() {
    var leader = $("#checkbox_leader");
    var checkbox = $("tr>td>:first-child input[type=checkbox]");
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

        var checkbox = $("tr>td>:first-child input[type=checkbox]:not(#checkbox_leader)");
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
                    data: {_token: $("#_token").val(), _method: 'delete'},
                    success: function (res) {
                        if (res == "true") {
                            $(this).parents('tr').eq(0).remove();
                        }

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
        var checkbox = $("tr>td>:first-child input[type=checkbox]:checked");
        checkbox.each(function () {
            if ($(this).is(":checked")) {
                $.ajax({
                    url: post_url + $(this).attr("data"),
                    type: 'delete',
                    dataType: "text",
                    context: this,
                    data: {_token: $("#_token").val(), _method: 'delete'},
                    success: function (res) {
                        if (res == "true") {
                            $(this).parents('tr').eq(0).remove();
                        }
                    },
                    complete: function (res) {
                        console.log(this);
                        console.log(res);
                    }
                });
            }
        });
    });

});
