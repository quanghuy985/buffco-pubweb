<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <title>Trang quản trị site</title>

        <link rel="stylesheet" href="{{Asset('adminlib/css/layout.css')}}" type="text/css" media="screen" />

        <!--[if lt IE 9]>
        <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="{{Asset('adminlib/js/jquery-1.5.2.min.js')}}" type="text/javascript"></script>
        <script src="{{Asset('adminlib/js/hideshow.js')}}" type="text/javascript"></script>
        <script src="{{Asset('adminlib/js/jquery.tablesorter.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/jquery.equalHeight.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/ckeditor/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/ckeditor/config.js')}}"></script>
        <script type="text/javascript">
$(document).ready(function()
{
    $(".tablesorter").tablesorter();
}
);
$(document).ready(function() {

    //When page loads...
    $(".tab_content").hide(); //Hide all content
    $("ul.tabs li:first").addClass("active").show(); //Activate first tab
    $(".tab_content:first").show(); //Show first tab content

    //On Click Event
    $("ul.tabs li").click(function() {

        $("ul.tabs li").removeClass("active"); //Remove any "active" class
        $(this).addClass("active"); //Add "active" class to selected tab
        $(".tab_content").hide(); //Hide all tab content

        var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
        $(activeTab).fadeIn(); //Fade in the active ID content
        return false;
    });
});</script>
        <script type="text/javascript">
            $(function() {
                $('.column').equalHeight();
            });</script>

    </head>
    <body>

        <header id="header">
            <hgroup>
                <h1 class="site_title"><a href="{{Asset('/')}}">Trang quản trị</a></h1>
                <h2 class="section_title">@yield('titlepage')</h2>
                <div class="btn_view_site"><a href="http://www.pubweb.com" target="_blank">Trang chủ</a></div>
            </hgroup>
        </header> <!-- end of header bar -->

        <section id="secondary_bar">
            <div class="user">
                <p>Xin chào , Tuấn Anh </p>
                <!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
            </div>
            <div class="breadcrumbs_container">
                <article class="breadcrumbs"><a href="index.html">Trang chủ</a> <div class="breadcrumb_divider"></div> <a class="current">Bài viết</a><div class="breadcrumb_divider"></div> <a class="current">Thêm bài viết mới</a></article>
            </div>
        </section><!-- end of secondary bar -->

        <aside id="sidebar" class="column">

            <h3>Bài viết</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="#">Tất cả bài viết</a></li>
                <li class="icn_edit_article"><a href="#">Viết bài mới</a></li>
                <li class="icn_categories"><a href="#">Chuyên mục</a></li>
                <li class="icn_tags"><a href="#">Thẻ</a></li>
            </ul>
            <h3>Thành viên</h3>
            <ul class="toggle">
                <li class="icn_add_user"><a href="#">Tất cả thành viên</a></li>
                <li class="icn_view_users"><a href="#">Thêm thành viên</a></li>
            </ul>
            <h3>Sản phẩm</h3>
            <ul class="toggle">
                <li class="icn_folder"><a href="#">Tất cả sản phẩm</a></li>
                <li class="icn_photo"><a href="#">Thêm sản phẩm</a></li>
                <li class="icn_audio"><a href="#">Nhóm sản phẩm</a></li>
            </ul>
            <h3>Dịch vụ</h3>
            <ul class="toggle">
                <li class="icn_settings"><a href="#">Tất cả dịch vụ</a></li>
                <li class="icn_security"><a href="#">Thêm dịch vụ</a></li>
            </ul>
            <h3>Đơn hàng</h3>
            <ul class="toggle">
                <li class="icn_settings"><a href="#">Đơn hàng sản phẩm</a></li>
                <li class="icn_security"><a href="#">Đơn hàng dịch vụ</a></li>
            </ul>
            <h3>Quản lý domain</h3>
            <ul class="toggle">
                <li class="icn_settings"><a href="#">Tất cả domain</a></li>
                <li class="icn_security"><a href="#">Thêm domain</a></li>
            </ul>
            <h3>Trình đơn</h3>
            <ul class="toggle">
                <li class="icn_folder"><a href="#">Danh sách trình đơn</a></li>
                <li class="icn_photo"><a href="#">Thêm trình đơn</a></li>
            </ul>
            <h3>Phản hồi</h3>
            <ul class="toggle">
                <li class="icn_settings"><a href="#">Tất cả phản hồi</a></li>
            </ul>
            <h3>Hỗ trợ</h3>
            <ul class="toggle">
                <li class="icn_settings"><a href="#">Tất cả thành viên</a></li>
                <li class="icn_settings"><a href="#">Thêm mới</a></li>
                <li class="icn_settings"><a href="#">Nhóm hỗ trợ</a></li>
            </ul>
            <h3>Thống kê</h3>
            <ul class="toggle">
                <li class="icn_settings"><a href="#">Theo ngày</a></li>
                <li class="icn_settings"><a href="#">Theo tháng</a></li>
                <li class="icn_settings"><a href="#">Theo năm</a></li>
            </ul>
            <h3>Quảng cáo</h3>
            <ul class="toggle">
                <li class="icn_settings"><a href="#">Tất cả quảng cáo</a></li>
                <li class="icn_settings"><a href="#">Thêm quảng cáo</a></li>
                <li class="icn_settings"><a href="#">Nhóm quảng cáo</a></li>
            </ul>
            <footer>
                <hr />
                <p><strong>Copyright &copy; 2014 Buffco JSC</strong></p>
                <p>Theme by <a href="http://www.pubweb.com">Pubweb</a></p>
            </footer>
        </aside><!-- end of sidebar -->

        <section id="main" class="column">
            @yield("contentadmin")
        </section>


    </body>

</html>