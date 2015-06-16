$(function(){
    var search=$("#search"),
        search_btn=$("#search_btn"),
        selected=$("#selected"),
        picked=$("#picked"),
        add_btn=$("#add_btn"),
        remove_btn=$("#remove_btn"),
        add_all_btn=$("#add_all_btn"),
        remove_all_btn=$("remove_all_btn"),
        _token=$("#_token");

        search_btn.click(function(){
            $.ajax({
                dataType:"json",
                type:"post",
                url:"/manager/keyword/search",
                data:{
                    _token:_token.val(),
                    search:search.val()
                },
                success:function(res){
                    for(var v in res){
                        var op= $("<option>");
                        op.attr("value", res[v].id);
                        op.text(res[v].title);
                        var exist=$("#selected option[value="+res[v].id+"]");

                        if(exist.length==0)
                        {
                            selected.append(op);
                        }
                        else
                        {
                            console.log(exist);
                        }

                    }
                },
                complete:function(res){
                }
            })
        });

});