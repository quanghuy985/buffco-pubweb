<!doctype html>
<html lang="vi">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard | Amanda Admin Template</title>
        <link rel="stylesheet" href="{{Asset('adminlib2/css/style.default.css')}}" type="text/css" />
        <script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery-1.7.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery-ui-1.8.16.custom.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.cookie.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.uniform.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib2/js/custom/general.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib2/js/custom/tables.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.alerts.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/ckeditor/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/ckeditor/config.js')}}"></script>
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/plugins/excanvas.min.js"></script><![endif]-->
        <!--[if IE 9]>
            <link rel="stylesheet" media="screen" href="css/style.ie9.css"/>
        <![endif]-->
        <!--[if IE 8]>
            <link rel="stylesheet" media="screen" href="css/style.ie8.css"/>
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
                        <a class="count" href="adminlib2/ajax/notifications.html"><span>9</span></a>
                    </div>
                    <div class="userinfo">
                        <img src="adminlib2/images/thumbs/avatar.png" alt="" />
                        <span>Juan Dela Cruz</span>
                    </div><!--userinfo-->

                    <div class="userinfodrop">
                        <div class="avatar">
                            <a href="#"><img src="images/thumbs/avatarbig.png" alt="" /></a>
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
                    <li><a href="#newsSub" class="editor">Tin tức</a>
                        <span class="arrow"></span>
                        <ul id="newsSub">
                            <li><a href="">Tất cả tin tức</a></li>
                            <li><a href="">Thêm mới tin tức</a></li>
                            <li><a href="">Nhóm tin tức</a></li>
                        </ul>
                    </li>
                    <li><a href="#productsub" class="elements">Sản phẩm</a>
                        <span class="arrow"></span>
                        <ul id="productsub">
                            <li><a href="" >Tất cả sản phẩm</a></li>
                            <li><a href="" >Thêm mới</a></li>
                            <li><a href="">Nhóm sản phẩm</a></li>
                        </ul>
                    </li>
                    <li><a href="" class="widgets">Dịch vụ</a>
                    </li>
                    <li><a href="#ahshs" class="calendar">Danh sách đơn hàng</a>
                        <span class="arrow"></span>
                        <ul id="ahshs">
                            <li><a href="notfound.html">�?ơn hàng sản phẩm</a></li>
                            <li><a href="forbidden.html">�?ơn hàng dịch vụ</a></li>
                            <li><a href="internal.html">Internal Server Error</a></li>
                            <li><a href="offline.html">Offline</a></li>
                        </ul>
                    </li>
                    <li><a href="#userSub" class="support">Khách hàng</a>
                        <span class="arrow"></span>
                        <ul id="userSub">
                            <li><a href="">Tất cả khách hàng</a></li>
                            <li><a href="">Thêm mới khách hàng</a></li>
                        </ul>
                    </li>
                    <li><a href="#pageSub" class="typo">Nhà sản xuất</a>
                        <span class="arrow"></span>
                        <ul id="pageSub">
                           
                        </ul>
                    </li>
                    <li><a href="" class="buttons">phản hồi</a> </li>
                    <li><a href="#supporterSub" class="tables">Hỗ trợ viên</a>
                        <span class="arrow"></span>
                        <ul id="supporterSub">
                            <li><a href="">Danh sánh hỗ trợ viên</a></li>
                            <li><a href="">Nhóm hỗ trợ viên</a></li>
                        </ul>
                    </li>

                    <li><a href="" class="error">thanh menu</a>
                    </li>
                    <li><a href="" class="addons">Admin</a>

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
