@extends("fontend.template")
@section("content")   
<!-- BEFORE CONTENT -->
<div id="outerbeforecontent">
    <div class="container">
        <section id="beforecontent" class="twelve columns">
            <h1 class="pagetitle">Tài khoản</h1>
            <div class="clear"></div>
        </section>
    </div>
</div>
<!-- END BEFORE CONTENT -->
<!-- MAIN CONTENT -->
<div id="outermain">
    <div class="container">
        <section id="maincontent" class="twelve columns">
            <section id="content" class="positionleft nine columns alpha"> 
                <div class="padcontent">

                    <div class="full_width">
                        <h2 class="title">Đăng nhập</h2>
                        {{Form::open(array('action' => '\FontEnd\UsersController@postDangNhap','class'=>'one_half firstcols','id'=>'loginform'))}}
                        <fieldset>
                            @if($errors->has())
                            <label for="email" class="error">{{$errors->first()}}</label>
                            @endif
                            <label>E-mail</label><br />
                            <input type="text" name="email" id="email"/><br />
                            <label>Mật khẩu</label><br />
                            <input type="password" class="text-input" name="password" id="password" /><br />
                            {{Form::checkbox('remember_me', 'remember_me',false, array('id' => 'remember_me','style'=>' float: left;margin-right: 5px;margin-top: 3px;'))}} <span>Ghi nhớ đăng nhập</span><br />
                            {{Form::submit('Đăng nhập', array('class' => 'button','style'=>'margin-top: 10px;clear:both;float: left;'))}}
                        </fieldset>
                        {{ Form::close() }}
                        <div class="one_half lastcols" style="margin-top:30px;"><a class="button" href="{{action('\FontEnd\UsersController@postDangKy')}}">Đăng ký ngay</a></div>
                        <script type="text/javascript" src="{{Asset('fontend')}}/js/jquery-1.10.2.min.js"></script>
                        <script>
jQuery(document).ready(function() {
    jQuery("#loginform").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
        },
        messages: {
            email: {
                required: 'Email là trường bắt buộc.',
                email: 'Email không đúng định dạng.'

            },
            password: {
                required: "Mật khẩu là trường bắt buộc.",
                minlength: "Mật khẩu không ngắn hơn 6 ký tự."
            },
        }
    });
});
                        </script>
                    </div>

                </div>
            </section>

            @include('fontend.sidebar_right')
            <div class="clear"></div><!-- clear float --> 
        </section>
    </div>
</div>
<!-- END MAIN CONTENT -->
@endsection