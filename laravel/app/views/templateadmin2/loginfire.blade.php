<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>PUBWEB.VN | HỆ THỐNG QUẢN LÝ</title>
        <link rel="stylesheet" href="{{Asset('adminlib2/css/style.default.css')}}" type="text/css" />
        <script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery-1.7.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery-ui-1.8.16.custom.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.cookie.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.uniform.min.js')}}"></script>
        <!--[if IE 9]>
            <link rel="stylesheet" media="screen" href="{{Asset('adminlib2/css/style.ie9.css')}}"/>
        <![endif]-->
        <!--[if IE 8]>
            <link rel="stylesheet" media="screen" href="{{Asset('adminlib2/css/style.ie8.css')}}"/>
        <![endif]-->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
    </head>

    <body class="loginpage">

        <div class="loginbox">
            <div class="loginboxinner">

                <div class="logo">
                    <h1><span>PUBWEB.</span>VN</h1>
                    <p>TRANG HỆ THỐNG</p>
                </div><!--logo-->

                <br clear="all" /><br />
                @if(isset($messenge))
                <div class="nopassword">
                    <div class="notibar msgalert"><p>{{$messenge}}</p></div>                  
                </div><!--nopassword-->
                @endif
                <form id="login" action="{{URL::action('AdminController@postDangNhap')}}" method="post">

                    <div class="username">
                        <div class="usernameinner">
                            <input type="text" name="username" id="username" placeholder="Nhập email ..." />
                        </div>
                    </div>

                    <div class="password">
                        <div class="passwordinner">
                            <input type="password" name="password" id="password" placeholder="Nhập mật khẩu ..." />
                        </div>
                    </div>

                    <button>Đăng nhập</button>

                    <div class="keep"> Quên mật khẩu ? <a href="{{URL::action('AdminController@getForgot')}}" title="Quên mật khẩu ">Click here.</a></div>

                </form>

            </div><!--loginboxinner-->
        </div><!--loginbox-->


    </body>

</html>
