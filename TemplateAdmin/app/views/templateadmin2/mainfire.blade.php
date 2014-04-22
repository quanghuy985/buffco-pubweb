<!doctype html>
<html lang="vi">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard | Amanda Admin Template</title>
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
            <div class="topheader">
                <div class="left">
                    <h1 class="logo">PUBWEB.<span>vn</span></h1>
                    <span class="slogan">Thiết kế bởi <a href="http://Pubweb.vn" target="_blabk">Pubweb.vn</a></span>
                    <br clear="all" />

                </div><!--left-->

                <div class="right">
                    <div class="notification">
                        <a class="count" href="adminlib/ajax/notifications.html"><span>9</span></a>
                    </div>
                    <div class="userinfo">
                        <img src="adminlib/images/thumbs/avatar.png" alt="" />
                        <span>Juan Dela Cruz</span>
                    </div><!--userinfo-->

                    <div class="userinfodrop">
                        <div class="avatar">
                            <a href="#"><img src="adminlib/images/thumbs/avatarbig.png" alt="" /></a>
                            <div class="changetheme">
                                Change theme: <br />
                                <a class="default"></a>
                                <a class="blueline"></a>
                                <a class="greenline"></a>
                                <a class="contrast"></a>
                                <a class="custombg"></a>
                            </div>
                        </div><!--avatar-->
                        <div class="userdata">
                            <h4>Juan Dela Cruz</h4>
                            <span class="email">youremail@yourdomain.com</span>
                            <ul>
                                <li><a href="editprofile.html">Edit Profile</a></li>
                                <li><a href="accountsettings.html">Account Settings</a></li>
                                <li><a href="help.html">Help</a></li>
                                <li><a href="index.html">Sign Out</a></li>
                            </ul>
                        </div><!--userdata-->
                    </div><!--userinfodrop-->
                </div><!--right-->
            </div><!--topheader-->


            <div class="header">


            </div><!--header-->

            <div class="vernav2 iconmenu">
                <ul>
                    <li><a href="#newsSub" class="gallery">Quản lý tập tin</a>  
                    </li>
                    <li><a href="#newsSub" class="editor">Tin tức</a>
                        <span class="arrow"></span>
                        <ul id="newsSub">
                            <li><a href="{{URL::action('NewsController@getNewsView')}}">Tất cả tin tức</a></li>
                            <li><a href="{{URL::action('NewsController@getAddNews')}}">Thêm mới tin tức</a></li>
                            <li><a href="{{URL::action('cateNewsController@getCateNewsView')}}">Nhóm tin tức</a></li>
                        </ul>
                    </li>
                    <li><a href="#productsub" class="elements">Sản phẩm</a>
                        <span class="arrow"></span>
                        <ul id="productsub">
                            <li><a href="{{URL::action('ProductController@getView')}}" >Tất cả sản phẩm</a></li>
                            <li><a href="{{URL::action('ProductController@getAddProduct')}}" >Thêm mới sản phẩm</a></li>
                            <li><a href="{{URL::action('CategoryProductController@getCateProductView')}}">Nhóm sản phẩm</a></li>
                            <li><a href="{{URL::action('SizeController@getSizeView')}}">Quản lý size</a></li>
                            <li><a href="{{URL::action('ColorController@getAddColor')}}">Quản lý màu</a></li>
                            <li><a href="{{URL::action('ManufacturerController@getManufactureView')}}">Nhà sản xuất</a></li>
                        </ul>
                    </li>
                    <li><a href="{{URL::action('OrderController@getViewAll')}}" class="widgets">Đơn hàng</a>
                    </li>
                    <li><a href="{{URL::action('StoreController@getStoreView')}}" class="tables">Kho hàng</a>
                    </li>
                    <li><a href="{{URL::action('UserController@getUserView')}}" class="user">Khách hàng</a>
                    </li>
                    <li><a href="#supportSub" class="support">Quản lý hỗ trợ viên</a>
                        <span class="arrow"></span>
                        <ul id="supportSub">
                            <li><a href="{{URL::action('SupporterController@getSupporterView')}}" class="support">Quản lý hỗ trợ viên</a>
                            </li>
                            <li><a href="{{URL::action('SupporterGroupController@getSupporterGroupView')}}" class="support">Nhóm hỗ trợ viên</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{URL::action('FeedbackController@getPhanHoi')}}" class="buttons">Phản hồi</a> </li>
                    <li><a href="{{URL::action('ProjectController@getProjectView')}}" class="calendar new">Quản lý dự án</a> </li>
                    <li><a href="{{URL::action('PageController@getPageView')}}" class="buttons">Quản lý các trang</a> </li>
                    <li><a href="{{URL::action('PageController@getPageView')}}" class="settings">Quản lý thanh menu</a> </li>
                    <li><a href="{{URL::action('PageController@getPageView')}}" class="settings">Thống kê</a> </li>
                    <li><a href="#historySub" class="calendar">Lịch sử</a>
                        <span class="arrow"></span>
                        <ul id="historySub">
                            <li><a href="{{URL::action('HistoryUserController@getHistoryView')}}">Lịch sử khách hàng</a></li>
                            <li><a href="{{URL::action('HistoryAdminController@getHistoryView')}}">Lịch sử nhân viên</a></li>
                        </ul>
                    </li>

                    <li><a href="{{URL::action('SettingController@getUpdateSetting')}}" class="error">Cấu hình</a>
                    </li>
                    <li><a href="#adminSub" class="addons">Nhân viên</a>
                        <span class="arrow"></span>
                        <ul id="adminSub">
                            <li><a href="{{URL::action('AdminController@getAdminView')}}">Quản lý nhân viên</a></li>
                            <li><a href="{{URL::action('GroupAdminController@getGroupAdminView')}}">Quản lý phòng ban</a></li>
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
