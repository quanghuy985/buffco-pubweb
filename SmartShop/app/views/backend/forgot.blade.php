<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{Lang::get('backend/title.forgot_password')}}</title>
        <link rel="stylesheet" href="{{Asset('backend/css/style.default.css')}}" type="text/css" />
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery-1.7.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery-ui-1.8.16.custom.min.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery.cookie.js')}}"></script>
        <script type="text/javascript" src="{{Asset('backend/js/plugins/jquery.uniform.min.js')}}"></script>
        <!--[if IE 9]>
            <link rel="stylesheet" media="screen" href="{{Asset('backend/css/style.ie9.css')}}"/>
        <![endif]-->
        <!--[if IE 8]>
            <link rel="stylesheet" media="screen" href="{{Asset('backend/css/style.ie8.css')}}"/>
        <![endif]-->
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
    </head>

    <body class="loginpage">

        <div class="loginbox">
            <div class="loginboxinner">

                <div class="logo">
                    <p class="uppercase">{{Lang::get('backend/title.forgot_password')}}</p>
                </div><!--logo-->

                <br clear="all" /><br />
                @if($errors->has())
                <div class="nopassword">
                    <div class="notibar msgalert"><p>{{$errors->first()}}</p></div>
                </div>
                <!--nopassword-->
                @endif

                {{Form::open(array('action'=>'\BackEnd\LoginController@postForgot', 'id'=>'forgotpass'))}}
                <div class="username">
                    <div class="usernameinner">
                        {{Form::email('email','', array('id'=>'email','placeholder'=>Lang::get('placeholder.email')))}}
                    </div>
                </div>
                <button>{{Lang::get('button.send_email')}}</button>

                <div class="keep"> {{Lang::get('backend/user/messages.back_to_login')}} <a href="{{URL::action('\BackEnd\LoginController@getLogin')}}">{{Lang::get('button.click_here')}}</a></div>
                {{Form::close()}}

            </div><!--loginboxinner-->
        </div><!--loginbox-->


    </body>

</html>
