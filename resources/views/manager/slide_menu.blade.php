<!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
<!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
<!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
<div class="sidebar-menu toggle-others fixed">

    <div class="sidebar-menu-inner">

        <header class="logo-env">

            <!-- logo -->
            <div class="logo">
                <a href="{{url('manager')}}" class="logo-expanded">
                    <img src="{{url('/')}}/assets/images/logo-white-bg@2x.png" width="80" alt="" />
                </a>

                <a href="{{url('manager')}}" class="logo-collapsed">
                    <img src="{{url('/')}}/assets/images/logo-collapsed@2x.png" width="40" alt="" />
                </a>
            </div>

            <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
            <div class="mobile-menu-toggle visible-xs">
                <a href="#" data-toggle="user-info-menu">
                    <i class="fa-bell-o"></i>
                    <span class="badge badge-success">7</span>
                </a>

                <a href="#" data-toggle="mobile-menu">
                    <i class="fa-bars"></i>
                </a>
            </div>

            <!-- This will open the popup with user profile settings, you can use for any purpose, just be creative -->
            <div class="settings-icon">
                <a href="#" data-toggle="settings-pane" data-animate="true">
                    <i class="linecons-cog"></i>
                </a>
            </div>


        </header>



        <ul id="main-menu" class="main-menu">
            <!-- add class "multiple-expanded" to allow multiple submenus to open -->
            <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
            <li>
                <a href="dashboard-1.html">
                    <i class="linecons-cog"></i>
                    <span class="title">控制中心</span>
                </a>
                <ul>
                    <li>
                        <a href="{{url('manager/system')}}">
                            <span class="title">系统设置</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/pay-type')}}">
                            <span class="title">支付方式</span>
                        </a>
                    </li>
                    <li>
                            <a href="{{url('manager/shipping-type')}}">
                            <span class="title">配送方式</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="layout-variants.html">
                    <i class="linecons-desktop"></i>
                    <span class="title">商品管理</span>
                </a>
                <ul>
                    <li>
                        <a href="{{url('manager/goods-list')}}">
                            <span class="title">商品列表</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{url('manager/add-goods')}}">
                            <span class="title">添加商品</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/goods-recycle')}}">
                            <span class="title">商品回收站</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/good-types')}}">
                            <span class="title">商品分类</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/add-good-type')}}">
                            <span class="title">添加分类</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="ui-panels.html">
                    <i class="linecons-note"></i>
                    <span class="title">订单管理</span>
                </a>
                <ul>
                    <li>
                        <a href="ui-other-elements.html">
                            <span class="title">订单列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="ui-other-elements.html">
                            <span class="title">订单回收站</span>
                        </a>
                    </li>
                    <li>
                        <a href="ui-other-elements.html">
                            <span class="title">发货单列表</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="ui-widgets.html">
                    <i class="linecons-star"></i>
                    <span class="title">微信中心</span>
                </a>
                <ul>
                    <li>
                        <a href="{{url('manager/fans-list')}}">
                            <span class="{{url('manager/wechat-menu')}}">粉丝管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/wechat-menu')}}">
                            <span class="title">菜单管理</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/subscribe')}}">
                            <span class="title">关注回复</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/keyword')}}">
                            <span class="title">关键词</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/fans-ranking')}}">
                            <span class="title">粉丝排行</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/shipping-notify')}}">
                            <span class="title">发货提醒</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/paid-notify')}}">
                            <span class="title">付款提醒</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/order-notify')}}">
                            <span class="title">订单提醒</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/oauth-list')}}">
                            <span class="title">微信OAuth</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{url('manager/article-list')}}">
                    <i class="fa-mortar-board"></i>
                    <span class="title">文章中心</span>
                  {{--  <span class="label label-success pull-right">3</span>--}}
                </a>
                <ul>
                    <li>
                        <a href="{{url('manager/article-list')}}">
                            <span class="title">文章列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/add-article')}}">
                            <span class="title">添加文章</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/article-type-list')}}">
                            <span class="title">文章分类</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/add-article-type-list')}}">
                            <span class="title">添加分类</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('manager/article-recycle')}}">
                            <span class="title">文章回收站</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#">
                    <i class="linecons-money"></i>
                    <span class="title">提现管理</span>
                </a>
                <ul>
                    <li><a href=""><span class="title">提现列表</span></a></li>
                    <li><a href=""><span class="title">发放记录</span></a></li>
                </ul>
            </li>


            <li>
                <a href="#">
                    <i class="fa-line-chart"></i>
                    <span class="title">数据统计</span>
                </a>
            </li>

            <li>
                <a href="{{url('manager/logout')}}">
                    <i class="fa-send-o"></i>
                    <span class="title">退出登录</span>
                </a>
                </ul>
            </li>
        </ul>

    </div>

</div>