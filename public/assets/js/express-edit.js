var app = app || {};
$(function () {

    /* input:checkbox  */
    var areaMode = Backbone.Model.extend({
            defaults: {
                i: 0,
                n: 'NULL',
                check: true
            }
        }),
        areaCollection = Backbone.Collection.extend({
            model: areaMode
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
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            modify: function () {
                this.model.set("check", !this.model.get('check'));
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
    app.cities = cities;


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
    _.each(app.cities, function (el) {
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
    app.DELETE='delete';
    app.put_id = 0;
    app.express_id=$("#express_id").val();
    app.POST = 'post';
    app.inputs = $("#inputs");
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
        app.post = method == app.POST;
        $("#_method").val(method);
    };
    app.showAlert = function (msg) {
        $("#alert-message").text(msg);
        $("#alert").modal("show", {});
    };
    app.inputCheck = function () {
        var form = $("#inputs"),
            off = true;
        var form_inputs = form.find('input,select');
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
        app.selectInit();
        app.setMethod(app.POST);
    };

    app.selectInit=function(){
        app.province.$el.val(app.province.$el.children().eq(0).val());
        app.city.$el.html(app.option);
        app.area.$el.html(app.option);
    }

    app.create = function () {
        app.initialize();
        $("#modal").modal("show", {});
    };
    app.close = function () {
        $("#modal").modal("hide");
    };
    app.show = function () {
        $("#modal").modal("show", {});
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

        var input_data = _.object(keys, values);
        /* log the input data for Edit */

        var append_keys = ['areas', '_token', '_method'],
            _token = $("#_token").val(),
            _method = $("#_method").val(),
            append_values = [areas_str, _token, _method];
        if (app.post) {
            append_keys = append_keys.concat(['id']);
            append_values = append_values.concat([app.express_id]);
        } else {
            append_keys = append_keys.concat(['express_area_id']);
            append_values = append_values.concat([app.put_id]);
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
            dataType: 'json',
            cache: false,
            success: function (res) {
                app.wake();
                if (res.code) {
                    if(res.code==100){
                        /* update success */
                        var tr=app.trs.get({
                            id:res.data.id
                        });
                        if(!_.isUndefined(tr)){
                            tr.set({
                                name:res.data.name,
                                regionNames:res.data.regionNames,
                                areas:app.areas.clone(),
                                inputData:input_data
                            });
                        }
                        app.close();
                    }else
                    {
                        app.showAlert(res.msg);
                    }
                } else {
                    /* store success */
                    /* Update Table View */
                    var new_tr = new app.trModel({
                        id: res.data.id,
                        name: res.data.name,
                        regionNames: res.data.regionNames,
                        areas: app.areas.clone(),
                        inputData: input_data
                    });
                    app.trs.add(new_tr);
                    app.showAlert("新增配送区域成功!");
                    app.close();
                }
            },
            error: function (res) {
                app.wake();
                app.showAlert("配送信息设置失败，请稍后尝试！");
            }
        });

    });

    /* add New DeliverRegion */
    $("#create").click(function () {
        app.create();
    });

    /* Edit DeliverRegion */


    /* table Model */

    app.trModel = Backbone.Model.extend({
        defaults: function () {
            return {
                'id': 0,
                'name': 'wang',
                'regionNames': 'china',
                areas: {},       // for DeliverRegions
                inputData: {}    // for Edit Event
            };
        }
    });
    app.trCollection = Backbone.Collection.extend({
        model: app.trModel
    });
    app.trView = Backbone.View.extend({
        tagName: 'tr',
        template: _.template($("#trTemplate").html()),
        events: {
            'click .btn-secondary': 'showUpdate',
            'click .btn-danger': 'showDelete'
        },
        initialize: function () {
            this.listenTo(app.trs, 'add', this.render);
            this.listenTo(app.trs, 'remove', this.render);
            this.listenTo(this.model,'change',this.render);
        },
        render: function () {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        },
        showUpdate: function () {
            app.setMethod(app.PUT);
            app.selectInit();
            app.put_id = this.model.get('id');
            /* set inputs value */
            _.each(this.model.get('inputData'), function (value, key, list) {
                var input = app.inputs.find('[name=' + key + ']');
                if (input.length) {
                    input.eq(0).val(value);
                }
            });
            /* set areas */
            app.areas.reset();
            this.model.get('areas').each(function (model) {
                app.areas.add(model);
            });
            /* show modal */
            app.show();
        },
        showDelete: function () {
            app.setMethod(app.DELETE);
            app.put_id = this.model.get('id');
            app.showAlert('确定要删除?');
        }
    });
    app.tbodyView = Backbone.View.extend({
        el: $("#tbody"),
        initialize: function () {
            this.listenTo(app.trs, 'add', this.addOne);
            this.listenTo(app.trs, 'remove', this.render);
            this.render();
        },
        render: function (model) {
            app.d = model;
            app.wait();
        },
        addOne: function (m) {
            var view = new app.trView({model: m});
            this.$el.append(view.render().el);
        }
    });

    app.trs = new app.trCollection();
    app.tbody = new app.tbodyView();

    /* fill the tr model */

    _.each(tr_array, function (value, key, list) {
        var areas = value.inputData.areas;
        areas = areas.split(',');
        var areas_collection = new app.areaCollection();
        _.each(areas, function (value, key, list) {
            if (value.length) {
                var area = _.findWhere(app.cities, {i: parseInt(value)});
                areas_collection.add({
                    i: area.i,
                    n: area.n
                });
            }
        });
        var new_tr = new app.trModel({
            id: value.id,
            name: value.name,
            regionNames: value.regionNames,
            areas: areas_collection,
            inputData: value.inputData
        });
        app.trs.add(new_tr);
    });

    /* test */


});