var app = app || {};
$(function () {

    /* input:checkbox  */
    var areaMode = Backbone.Model.extend({
            defaults: {
                i: 0,
                n: 'NULL',
                check: true
            },
            initialize: function () {

            }
        }),
        areaCollection = Backbone.Collection.extend({
            model: areaMode,
            evetns: {
                'change': "changed"
            },
            changed: function () {
                console.log("AreaCollection Changed");
            }
        }),
        areaView = Backbone.View.extend({
            tagName: 'li',
            className: 'checkbox',
            events: {
                'change': "modify"
            },
            template: _.template($("#checkboxTemplate").html()),
            initialize: function () {
            },
            render: function () {
                app.c = this.model.toJSON();
                app.d = this.template;
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            modify: function () {

                this.model.set("check", !this.model.get('check'));

                console.log("Now is " + this.model.get("check"));
            }
        }),
    /* input:select */
        selectModel = Backbone.Model.extend({
            defaults: {
                i: 0,
                n: 'NULL'
            }
        }),
        selectCollection = Backbone.Collection.extend({
            model: selectModel
        }),
        selectView = Backbone.View.extend({
            tagName: 'option',

            initialize: function () {
                this.$el.val(this.model.get('i'));
                this.$el.text(this.model.get('n'));
            },
            render: function () {
                return this;
            }

        });
    /* initialize input:select */
    app.option = "<option> --- </option>";
    app.areaMode = areaMode;
    app.areaCollection = areaCollection;
    app.areaView = areaView;

    app.select = selectModel;
    app.selectCollection = selectCollection;
    app.selectView = selectView;

    app.areas = new app.areaCollection;
    app.selects = new app.selectCollection;   // collect cities model


    /* input:select  #province  View */
    var Province = Backbone.View.extend({
        el: $("#province"),
        events: {
            'change': 'changed'
        },
        initialize: function () {
            this.listenTo(app.selects, 'add', this.addOne);
            this.$el.html(app.option);
        },
        addOne: function (model) {

            if (model.get('p') == 1) {
                var s_view = new app.selectView({model: model});
                $("#province").append(s_view.render().el);
            }
        },
        changed: function (model) {
            $("#city").html(app.option);
            $("#area").html(app.option);
            this.trigger('change');
        }
    });

    var City = Backbone.View.extend({
        el: $("#city"),
        events: {
            'change': 'changed'
        },
        changed: function () {
            $("#area").html(app.option);
            this.trigger('change');
        },
        parentId: 0,
        render: function (model) {
            this.parentId = app.province.$el.find("option:selected").val();
            var where = app.selects.where({
                p: parseInt(this.parentId)
            });
            _.each(where, function (el) {
                var s_model = new app.select(el.toJSON()),
                    view = new app.selectView({model: s_model});
                this.$el.append(view.render().el);
            }, this);
        }

    });

    /* Area selector */
    var Area = Backbone.View.extend({
        el: $("#area"),
        events: {
            'change': 'changed'
        },
        changed: function () {
        },
        render: function () {
            var parentId = app.city.$el.find("option:selected").val();
            var where = app.selects.where({
                p: parseInt(parentId)
            });
            _.each(where, function (el) {
                var s_model = new app.select(el.toJSON()),
                    view = new app.selectView({model: s_model});
                this.$el.append(view.render().el);
            }, this);
        }
    });

    app.province = new Province;
    app.city = new City;
    app.area = new Area;

    app.city.listenTo(app.province, 'change', app.city.render);
    app.area.listenTo(app.city, 'change', app.area.render);


    /* Area checkbox */
    var Areas = Backbone.View.extend({
        el: $("#areas"),
        events: {
            "change": "changed"
        },
        initialize: function () {
            this.listenTo(app.areas, 'add', this.addOne);
            this.listenTo(app.areas, 'remove', this.remove);
            this.listenTo(app.areas, 'reset', this.removeAll);
        },
        changed: function (e) {
        },
        render: function () {

        },
        addOne: function (area) {
            var view = new app.areaView({model: area});
            this.$el.append(view.render().el);
        },
        remove: function (el) {
            this.$el.find("input[value=" + el.n + "]").remove();
        },
        removeAll: function () {
            this.$el.html('');
        }

    });

    app._areas = new Areas();


    /* selector options init */
    _.each(cities, function (el) {
        var s_model = new app.select(el);
        app.selects.add(s_model);
    });

    /* Add express Area */
    $("#addBtn").click(function () {
        var check = null,
            area = $("#area").find('option:selected').attr('value'),
            city = $("#city").find('option:selected').attr('value'),
            province = $("#province").find('option:selected').attr('value');
        check = area || city || province;
        if (!check) {
            app.showAlert('请选择正确的配送区域!');
            return false;
        }

        if (app.areas.findWhere({
                i: parseInt(check)
            })) {
            return false;
        }

        var name = app.selects.findWhere({
            i: parseInt(check)
        });
        app.areas.add({
            i: parseInt(check),
            n: name.get('n')
        });

    });

    /* app initialize */
    app.post = true;
    app.PUT = 'put';
    app.POST = 'post';
    app.express_id = $("#express_id").val();
    app.express_area_id = 0;
    app.wait = function () {
        $(".page-loading-overlay").removeClass('loaded');
    };
    app.wake = function () {
        $(".page-loading-overlay").addClass('loaded');
    };

    app.getPostUrl = function () {
        return $("#post_url").val();
    };
    app.getPutUrl = function () {
        return $("#url").val();
    };
    app.setMethod = function (method) {
        $("#_method").val(method);
    };
    app.showAlert = function (msg) {
        $("#alert-message").text(msg);
        $("#alert").modal("show", {});
    };
    app.inputCheck = function () {
        var form = $("#inputs"),
            off = true;
        form_inputs = form.find('input,select');
        form_inputs.each(function () {
            var val = $.trim($(this).val());
            if (_.isEmpty(val)) {
                var label = $(this).parents(".form-group").find("label").eq(0).text()
                app.showAlert(label + " 不能为空!");
                off = false;
                return off;
            }
        });
        return off;
    };

    app.initialize = function () {
        var form = $("#inputs");
        form.find('input').each(function () {
            $(this).val('');
        });
        app.areas.reset();
        app.province.$el.val(app.province.$el.children().eq(0).val());
        app.city.$el.html(app.option);
        app.area.$el.html(app.option);
        app.setMethod('post');


    };

    app.create = function () {
        app.initialize();
        $("#modal").modal("show", {});
    };
    app.close = function () {
        $("#modal").modal("hide");
    };


    /* Save the Config */

    $("#modal button.btn-info").click(function () {
        if (!app.inputCheck()) {
            return false;
        }
        var form = $("#inputs"),
            form_inputs = form.find('input,select'),
            keys = _.map(form_inputs, function (el) {
                return $(el).attr('name');
            }),
            values = _.map(form_inputs, function (el) {
                return $(el).val();
            }),
        /* add Areas */
            areas = app.areas.where({check: true}).map(function (el) {
                return el.get('i');
            }),
            areas_str = "";
        _.each(areas, function (el) {
            areas_str += el + ",";
        });
        var append_keys = ['areas', '_token', '_method'],
            _token = $("#_token").val(),
            _method = $("#_method").val(),
            append_values = [areas_str, _token, _method];
        if (app.post) {
            append_keys = append_keys.concat(['id']);
            append_values = append_values.concat([app.express_id]);
        } else {
            append_keys = append_keys.concat(['express_area_id']);
            append_keys = append_keys.concat([app.express_area_id]);
        }
        keys = keys.concat(append_keys);
        values = values.concat(append_values);
        var data = _.object(keys, values);


        /* request */
        app.wait();
        $.ajax({
            url: app.post ? app.getPostUrl() : app.getPutUrl(),
            data: data,
            type: "post",
            dataType: 'text',
            cache: false,
            success: function (res) {
                app.wake();
                if (res.code) {
                    app.showAlert(res.msg);
                } else {
                    app.showAlert("新增配送区域成功!");
                    app.close();
                }
            },
            error: function (res) {
                app.wake();
                app.showAlert("配送信息设置失败，请稍后尝试！");
                console.log(res);
            }
        });

    });

    /* add New DeliverRegion */
    $("#create").click(function () {
        app.create();
    });

    /* Edit DeliverRegion */




    /* table Model */

    app.trModel=Backbone.Model.extend({
        defaults:function(){
            return {
                'id':0,
                'name':'wang',
                'regionNames':'china'
            };
        }
    });
    app.trCollection=Backbone.Collection.extend({
        model:app.trModel
    });
    app.trView=Backbone.View.extend({
        tagName:'tr',
        template: _.template($("#trTemplate").html()),
        initialize:function(){
            this.listenTo(app.trCollection,'add',this.render);
            this.listenTo(app.trCollection,'remove',this.render)
        },
        render:function(){
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }
    });
    app.tbodyView=Backbone.View.extend({
       el:$("#tbody"),
        initialize:function(){
            this.render();
        },
        render:function(){

        }
    });
});