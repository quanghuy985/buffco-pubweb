<!doctype html>
<html lang="{{Config::get('app.locale')}}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{Lang::get('backend/title.dashboard')}} :: @yield("titleAdmin")</title>
        <script type="text/javascript">
        function jAlertOk(){
			return "{{Lang::get('button.jAlertOk')}}";
        }
        function jAlertCancel(){
        	return "{{Lang::get('button.jAlertCancel')}}";
        }
        </script>
        <link rel="stylesheet" href="{{Asset('adminlib/css/style.default.css')}}" type="text/css" />
        <script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery-1.7.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery-ui-1.8.16.custom.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery.cookie.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery.uniform.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/custom/general.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/custom/tables.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery.alerts.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/colorpicker.js"></script>
        <script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/jquery.jgrowl.js"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/custom/elements.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/ckeditor/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/ckfinder/ckfinder.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/jquery.validate.min.js"></script>
        <script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/jquery.tagsinput.min.js"></script>
        <script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/charCount.js"></script>        
        <script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/jquery.smartWizard-2.0.min.js"></script>
        <script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/jquery.colorbox-min.js"></script>        
        <script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/ui.spinner.min.js"></script>
        <script type="text/javascript" src="{{Asset('adminlib')}}/js/custom/forms.js"></script>
         <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="adminlib/js/plugins/excanvas.min.js"></script><![endif]-->
        <!--[if IE 9]>
            <link rel="stylesheet" media="screen" href="adminlib/css/style.ie9.css"/>
        <![endif]-->
        <!--[if IE 8]>
            <link rel="stylesheet" media="screen" href="adminlib/css/style.ie8.css"/>
        <![endif]-->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
    </head>
    <body class="withvernav">
        <div class="bodywrapper">
            @include('templateadmin2.header')
            <div class="vernav2 iconmenu">
                <ul>
                    <li><a href="{{URL::action('FilemanagerController@getFileManager')}}" class="gallery">{{Lang::get('backend/dashboard.management_file')}}</a>
                    </li>
                    <li><a href="#newsSub" class="editor">{{Lang::get('backend/dashboard.news')}}</a>
                        <span class="arrow"></span>
                        <ul id="newsSub">
                            <li><a href="{{URL::action('NewsController@getNewsView')}}">{{Lang::get('backend/dashboard.all_news')}}</a></li>
                            <li><a href="{{URL::action('NewsController@getAddNews')}}">{{Lang::get('backend/dashboard.add_news')}}</a></li>
                            <li><a href="{{URL::action('cateNewsController@getCateNewsView')}}">{{Lang::get('backend/dashboard.group_news')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="#productsub" class="elements">{{Lang::get('backend/dashboard.product')}}</a>
                        <span class="arrow"></span>
                        <ul id="productsub">
                            <li><a href="{{URL::action('ProductController@getView')}}" >{{Lang::get('backend/dashboard.all_products')}}</a></li>
                            <li><a href="{{URL::action('ProductController@getAddProduct')}}" >{{Lang::get('backend/dashboard.add_product')}}</a></li>
                            <li><a href="{{URL::action('CategoryProductController@getCateProductView')}}">{{Lang::get('backend/dashboard.group_product')}}</a></li>
                            <li><a href="{{URL::action('SizeController@getSizeView')}}">{{Lang::get('backend/dashboard.management_size')}}</a></li>
                            <li><a href="{{URL::action('ColorController@getAddColor')}}">{{Lang::get('backend/dashboard.management_color')}}</a></li>
                            <li><a href="{{URL::action('ManufacturerController@getManufactureView')}}">{{Lang::get('backend/dashboard.management_manufacturers')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="{{URL::action('OrderController@getViewAll')}}" class="widgets">{{Lang::get('backend/dashboard.order')}}</a>
                    </li>
                    <li><a href="{{URL::action('StoreController@getView')}}" class="tables">{{Lang::get('backend/dashboard.store')}}</a>
                    </li>
                    <li><a href="{{URL::action('UserController@getUserView')}}" class="user">{{Lang::get('backend/dashboard.customer')}}</a>
                    </li>
                    <li><a href="#supportSub" class="support">{{Lang::get('backend/dashboard.management_supporter')}}</a>
                        <span class="arrow"></span>
                        <ul id="supportSub">
                            <li><a href="{{URL::action('SupporterController@getSupporterView')}}">{{Lang::get('backend/dashboard.management_supporter')}}</a>
                            </li>
                            <li><a href="{{URL::action('SupporterGroupController@getSupporterGroupView')}}">{{Lang::get('backend/dashboard.group_supporter')}}</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{URL::action('FeedbackController@getPhanHoi')}}" class="buttons">{{Lang::get('backend/dashboard.feedback')}}</a> </li>
                     <li><a href="#projectSub" class="calendar new">{{Lang::get('backend/dashboard.management_project')}}</a>
                        <span class="arrow"></span>
                        <ul id="projectSub">
                            <li><a href="{{URL::action('ProjectController@getProjectView')}}">{{Lang::get('backend/dashboard.management_project')}}</a></li>
                            <li><a href="{{URL::action('ProjectController@getAddProject')}}">{{Lang::get('backend/dashboard.add_project')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="#pageSub" class="buttons">{{Lang::get('backend/dashboard.management_page')}}</a>
                        <span class="arrow"></span>
                        <ul id="pageSub">
                            <li><a href="{{URL::action('PageController@getPageView')}}">{{Lang::get('backend/dashboard.management_page')}}</a></li>
                            <li><a href="{{URL::action('PageController@getAddPage')}}">{{Lang::get('backend/dashboard.add_page')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="{{URL::action('MenuController@getMenuView')}}" class="settings">{{Lang::get('backend/dashboard.management_menu')}}</a> </li>
                    <li><a href="#statisticSub" class="settings">{{Lang::get('backend/dashboard.statistic')}}</a>
                        <span class="arrow"></span>
                        <ul id="statisticSub">
                            <li><a href="{{URL::action('StatisticController@getThongKeUser')}}">{{Lang::get('backend/dashboard.statistic_user')}}</a></li>
                            <li><a href="{{URL::action('StatisticController@getThongKeOrder')}}">{{Lang::get('backend/dashboard.statistic_order')}}</a></li>
                        </ul>
                    </li>
                    <li><a href="#historySub" class="calendar">{{Lang::get('backend/dashboard.history')}}</a>
                        <span class="arrow"></span>
                        <ul id="historySub">
                            <li><a href="{{URL::action('HistoryUserController@getHistoryView')}}">{{Lang::get('backend/dashboard.customer_history')}}</a></li>
                            <li><a href="{{URL::action('HistoryAdminController@getHistoryView')}}">{{Lang::get('backend/dashboard.user_history')}}</a></li>
                        </ul>
                    </li>

                    <li><a href="{{URL::action('SettingController@getUpdateSetting')}}" class="error">{{Lang::get('backend/dashboard.setting')}}</a>
                    </li>
                    <li><a href="#adminSub" class="addons">{{Lang::get('backend/dashboard.user')}}</a>
                        <span class="arrow"></span>
                        <ul id="adminSub">
                            <li><a href="{{URL::action('AdminController@getAdminView')}}">{{Lang::get('backend/dashboard.management_user')}}</a></li>
                            <li><a href="{{URL::action('GroupAdminController@getGroupAdminView')}}">{{Lang::get('backend/dashboard.management_department')}}</a></li>
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
