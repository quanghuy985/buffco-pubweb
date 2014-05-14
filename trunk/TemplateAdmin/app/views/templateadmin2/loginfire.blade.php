<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{Lang::get('backend/title.login')}}</title>
    <link rel="stylesheet" href="{{Asset('adminlib/css/style.default.css')}}" type="text/css"/>
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
            <p class="uppercase">{{Lang::get('backend/title.login')}}</p>
        </div>
        <br clear="all"/><br/>
        @if(Session::has('login_message'))
        <div class="nopassword">
            <div class="notibar msgalert"><p>{{Session::get('login_message')}}</p></div>
        </div>
        <!--nopassword-->
        @endif
        {{Form::open(array('action'=>'LoginController@postDangNhap', 'id'=>'login'))}}
        <div class="username">
            <div class="usernameinner">
                <input type="text" name="username" value="{{Input::old('username')}}" id="username" placeholder="{{Lang::get('placeholder.email')}}"/>
            </div>
        </div>
        <div class="password">
            <div class="passwordinner">
                <input type="password" name="password" id="password" placeholder="{{Lang::get('placeholder.password')}}"/>
            </div>
        </div>
        <button>{{Lang::get('button.login')}}</button>
        <div class="keep"> {{Lang::get('button.forgot_password')}}? <a href="{{URL::action('LoginController@getForgot')}}"
                                              title="{{Lang::get('button.forgot_password')}}">{{Lang::get('button.click_here')}}.</a></div>
        {{Form::close()}}
    </div>
    <!--loginboxinner-->
</div>
<!--loginbox-->


</body>

</html>
