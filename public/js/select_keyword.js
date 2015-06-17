$(function () {
    var search = $("#search"),
        search_btn = $("#search_btn"),
        selected = $("#selected"),
        picked = $("#picked"),
        add_btn = $("#add_btn"),
        remove_btn = $("#remove_btn"),
        add_all_btn = $("#add_all_btn"),
        remove_all_btn = $("#remove_all_btn"),
        ids=$("#ids"),
        _submit=$("#update"),
        _token = $("#_token");

    search_btn.click(function () {
        $.ajax({
            dataType: "json",
            type: "post",
            url: "/manager/keyword/search",
            data: {
                _token: _token.val(),
                search: search.val()
            },
            success: function (res) {
                for (var v in res) {
                    var op = $("<option>");
                    op.attr("value", res[v].id);
                    op.text(res[v].title);
                    var exist = $("#selected option[value=" + res[v].id + "]");

                    if (exist.length == 0) {
                        selected.append(op);
                    }
                    else {
                        console.log(exist);
                    }

                }
            },
            complete: function (res) {
            }
        })
    });

    add_btn.click(function () {
        var op = selected.find("option:selected");
        if (op.length != 0) {
            /* search picked */
            temp = picked.find("option[value=" + op.attr("value") + "]");
            if (temp.length == 0) {
                if (picked.find("option").length < 7) {
                    picked.append(op);
                }
            }
        }
    });

    remove_btn.click(function () {
        var op = picked.find("option:selected");
        if (op.length != 0) {
            op.remove();
        }
    });

    add_all_btn.click(function () {
        var ops = selected.find("option");
        ops.each(function (i, op) {
            if (op.length != 0) {
                /* search picked */
                op=$(op);
                temp = picked.find("option[value=" + op.attr("value") + "]");
                if (temp.length == 0) {
                    if (picked.find("option").length < 7) {
                        picked.append(op);
                    }
                }
            }
        });
    });

    remove_all_btn.click(function () {
        picked.find("option").remove();
    });

    _submit.click(function(){
        var ops=picked.find("option");
        var str="";
        ops.each(function(i,el){
            str=str+$(el).attr("value")+",";
        });
        ids.val(str);
    });


});