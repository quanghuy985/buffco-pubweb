<!doctype html>
<html lang="{{Config::get('app.locale')}}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{Lang::get('backend/title.dashboard')}} :: @yield("titleAdmin")</title>
        <script type="text/javascript">
            function jAlertOk() {
                return "{{Lang::get('button.jAlertOk')}}";
            }
            function jAlertCancel() {
                return "{{Lang::get('button.jAlertCancel')}}";
            }
            function LocalSetting() {
                return "{{Config::get('app.url')}}";
            }
        </script>
        <link rel="stylesheet" href="{{Asset('backend/css/style.default.css')}}" type="text/css" />
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery-1.7.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery-ui-1.8.16.custom.min.js')}}"></script>
        <?php
        if (isset($jsmenu)) {
            ?>
            <script>var j121212 = jQuery.noConflict(true);</script>
        <?php } ?>
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery.cookie.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery.uniform.min.js')}}"></script>
        <?php if (isset($jsmenu)) {
            ?>
            <script type="text/javascript" src="{{Asset('backend/js/custom/general1.js')}}"></script>
        <?php } else { ?>
            <script type="text/javascript" src="{{Asset('backend/js/custom/general.js')}}"></script>
        <?php } ?>
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery.slimscroll.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend/js/custom/tables.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery.alerts.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend')}}/js/plugins/colorpicker.js"></script>
        <script type="text/javascript" src="{{Asset('backend')}}/js/plugins/jquery.jgrowl.js"></script>
        <script type="text/javascript" src="{{Asset('backend/js/custom/elements.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend/ckeditor/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend/ckfinder/ckfinder.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend')}}/js/plugins/jquery.validate.min.js"></script>
        <script type="text/javascript" src="{{Asset('backend')}}/js/plugins/localization/messages_{{Config::get('app.locale')}}.js"></script>
        <script type="text/javascript" src="{{Asset('backend')}}/js/plugins/jquery.tagsinput.min.js"></script>
        <script type="text/javascript" src="{{Asset('backend')}}/js/plugins/charCount.js"></script>        
        <script type="text/javascript" src="{{Asset('backend')}}/js/plugins/jquery.smartWizard-2.0.min.js"></script>
        <script type="text/javascript" src="{{Asset('backend')}}/js/plugins/jquery.colorbox-min.js"></script>        
        <script type="text/javascript" src="{{Asset('backend')}}/js/plugins/ui.spinner.min.js"></script>
        <script type="text/javascript" src="{{Asset('backend')}}/js/custom/forms.js"></script>
        <script type="text/javascript" src="{{Asset('backend')}}/js/plugins/nprogress.js"></script>
        <script>        NProgress.start();</script>
        <script type="text/javascript" src="{{Asset('backend')}}/js/custom/custom-admin.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{Asset('backend')}}/js/plugins/excanvas.min.js"></script><![endif]-->
        <!--[if IE 9]>
            <link rel="stylesheet" media="screen" href="{{Asset('backend')}}/css/style.ie9.css"/>
        <![endif]-->
        <!--[if IE 8]>
            <link rel="stylesheet" media="screen" href="{{Asset('backend')}}/css/style.ie8.css"/>
        <![endif]-->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
    </head>
    <body class="withvernav">

        <div class="bodywrapper">
            @include('backend.header')
            <div class="vernav2 iconmenu">
                <ul>
                    <li><a href="{{action('\BackEnd\FilemanagerController@getFileManager')}}" class="gallery">{{Lang::get('backend/dashboard.management_file')}}</a>
                    </li>
                    <li><a href="#newsSub" class="editor">{{Lang::get('backend/dashboard.news')}}</a>
                        <span class="arrow"></span>
                        <ul id="newsSub">
                            <li><a href="{{action('\BackEnd\NewsController@getNewsView')}}">{{Lang::get('backend/dashboard.all_news')}}</a></li>
                            <li><a href="{{URL::action('\BackEnd\NewsController@getAddNews')}}">{{Lang::get('backend/dashboard.add_news')}}</a></li>
                            <li><a href="{{URL::action('\BackEnd\CateNewsController@getCateNewsView')}}">{{Lang::get('backend/dashboard.group_news')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="#productsub" class="elements">{{Lang::get('backend/dashboard.product')}}</a>
                        <span class="arrow"></span>
                        <ul id="productsub">
                            <li><a href="{{URL::action('\BackEnd\ProductController@getProductView')}}" >{{Lang::get('backend/dashboard.all_products')}}</a></li>
                            <li><a href="{{URL::action('\BackEnd\ProductController@getProductAdd')}}" >{{Lang::get('backend/dashboard.add_product')}}</a></li>
                            <li><a href="{{URL::action('\BackEnd\CategoryProductController@getCateProductView')}}">{{Lang::get('backend/dashboard.group_product')}}</a></li>
                            <li><a href="{{URL::action('\BackEnd\ManufacturerController@getManufactureView')}}">{{Lang::get('backend/dashboard.management_manufacturers')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="{{URL::action('\BackEnd\OrderController@getViewAll')}}" class="widgets">{{Lang::get('backend/dashboard.order')}}</a>
                    </li>
                    <li><a href="" class="tables">{{Lang::get('backend/dashboard.store')}}</a>
                    </li>
                    <li><a href="{{URL::action('\BackEnd\UserController@getUserView')}}" class="user">{{Lang::get('backend/dashboard.customer')}}</a>
                    </li>
                    <li><a href="#supportSub" class="support">{{Lang::get('backend/dashboard.management_supporter')}}</a>
                        <span class="arrow"></span>
                        <ul id="supportSub">
                            <li><a href="{{URL::action('\BackEnd\SupporterController@getSupporterView')}}">{{Lang::get('backend/dashboard.management_supporter')}}</a>
                            </li>
                            <li><a href="{{URL::action('\BackEnd\SupporterGroupController@getSupporterGroupView')}}">{{Lang::get('backend/dashboard.group_supporter')}}</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{URL::action('\BackEnd\FeedbackController@getFeedBack')}}" class="buttons">{{Lang::get('backend/dashboard.feedback')}}</a> </li>
                    <li><a href="#projectSub" class="calendar new">{{Lang::get('backend/dashboard.management_project')}}</a>
                        <span class="arrow"></span>
                        <ul id="projectSub">
                            <li><a href="{{URL::action('\BackEnd\ProjectController@getProjectView')}}">{{Lang::get('backend/dashboard.management_project')}}</a></li>
                            <li><a href="{{URL::action('\BackEnd\ProjectController@getAddProject')}}">{{Lang::get('backend/dashboard.add_project')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="#pageSub" class="buttons">{{Lang::get('backend/dashboard.management_page')}}</a>
                        <span class="arrow"></span>
                        <ul id="pageSub">
                            <li><a href="{{URL::action('\BackEnd\PageController@getPageView')}}">{{Lang::get('backend/dashboard.management_page')}}</a></li>
                            <li><a href="{{URL::action('\BackEnd\PageController@getAddPage')}}">{{Lang::get('backend/dashboard.add_page')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="{{URL::action('\BackEnd\MenusController@getMenus')}}" class="settings">{{Lang::get('backend/dashboard.management_menu')}}</a> </li>
                    <li><a href="#statisticSub" class="settings">{{Lang::get('backend/dashboard.statistic')}}</a>
                        <span class="arrow"></span>
                        <ul id="statisticSub">
                            <li><a href="">{{Lang::get('backend/dashboard.statistic_user')}}</a></li>
                            <li><a href="">{{Lang::get('backend/dashboard.statistic_order')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="{{URL::action('\BackEnd\SettingController@getUpdateSetting')}}" class="error">{{Lang::get('backend/dashboard.setting')}}</a>
                    </li>
                    <li><a href="#adminSub" class="addons">{{Lang::get('backend/dashboard.user')}}</a>
                        <span class="arrow"></span>
                        <ul id="adminSub">
                            <li><a href="{{URL::action('\BackEnd\AdminController@getAdminView')}}">{{Lang::get('backend/dashboard.management_user')}}</a></li>
                        </ul>
                    </li>
                </ul>
                <a class="togglemenu"></a>
                <br /><br />
            </div><!--leftmenu-->
            <div class="centercontent">
                @yield("contentadmin")
                <br clear="all" />
            </div><!-- centercontent -->
        </div><!--bodywrapper-->
    </body>

</html>
