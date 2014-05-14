<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{Lang::get('backend/title.forgot_password')}}</title>
        <link rel="stylesheet" href="{{Asset('adminlib/css/style.default.css')}}" type="text/css" />
        <script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery-1.7.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery-ui-1.8.16.custom.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery.cookie.js')}}"></script>
        <script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery.uniform.min.js')}}"></script>
        <!--[if IE 9]>
            <link rel="stylesheet" media="screen" href="{{Asset('adminlib/css/style.ie9.css')}}"/>
        <![endif]-->
        <!--[if IE 8]>
            <link rel="stylesheet" media="screen" href="{{Asset('adminlib/css/style.ie8.css')}}"/>
        <![endif]-->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
    </head>

    <body class="loginpage">

        <div class="loginbox">
            <div class="loginboxinner">

                <div class="logo">
                    <p>{{Lang::get('backend/title.forgot_password')}}</p>
                </div><!--logo-->

                <br clear="all" /><br />
                @if(Session::has('forgot_message'))
                <div class="nopassword">
                    <div class="notibar msgalert"><p>{{Session::get('forgot_message')}}</p></div>
                </div><!--nopassword-->
                @endif
                <form id="login" action="{{URL::action('LoginController@postForgot')}}" method="post">
                    <div class="username">
                        <div class="usernameinner">
                            <input type="text" name="username" value="{{Input::old('username')}}" id="username" placeholder="{{Lang::get('placeholder.email')}}" />
                        </div>
                    </div>
                    <button>{{Lang::get('button.send_email')}}</button>

                    <div class="keep"> {{Lang::get('backend/user/messages.back_to_login')}} <a href="{{URL::action('LoginController@getDangNhap')}}">{{Lang::get('button.click_here')}}</a></div>
                </form>

            </div><!--loginboxinner-->
        </div><!--loginbox-->


    </body>

</html>
