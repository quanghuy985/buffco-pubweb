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
                        <h2 class="title">Đăng ký</h2>
                        {{Form::open(array('action' => '\FontEnd\UsersController@postDangKy','id'=>'fdangky'))}}
                        <fieldset >
                            <div class="full_width">
                                <label>E-mail<span class="required" >*</label><br />
                                {{Form::email('email','', array('id'=>'email','class'=>'two_col_reg','placeholder'=>'E-mail...'))}} <br />
                                @if($errors->has('firstname'))
                                <label for="email"  class="error">Email không được để trống và phải đúng định dạng.</label >
                                @endif
                                <label>Mật khẩu<span class="required" >*</label><br />
                                {{Form::password('r_password', array('id'=>'r_password','class'=>'two_col_reg','placeholder'=>'Mật khẩu...'))}}      <br />
                                @if($errors->has('r_password'))
                                <label for="r_password"  class="error" >Mật khẩu dài hơn 6 ký tự.</label >
                                @endif
                                <label>Nhập lại mật khẩu<span class="required" >*</label><br />
                                {{Form::password('r_password_confirmation', array('id'=>'r_password_confirmation','class'=>'two_col_reg','placeholder'=>'Nhập lại mật khẩu...'))}} <br />
                                @if($errors->has('r_password_confirmation'))
                                <label for="r_password_confirmation"  class="error" >Mật khẩu nhập không khớp.</label >
                                @endif
                                <label >Họ<span class="required" >*</span></label><br />
                                {{Form::text('firstname','', array('id'=>'firstname','class'=>'two_col_reg','placeholder'=>'Họ...'))}} <br />
                                @if($errors->has('firstname'))
                                <label for="firstname"  class="error" >Họ không được để trống.</label >
                                @endif
                                <label>Tên<span class="required" >*</label><br />
                                {{Form::text('lastname','', array('id'=>'lastname','class'=>'two_col_reg','placeholder'=>'Tên...'))}} <br />
                                @if($errors->has('lastname'))
                                <label for="lastname"  class="error" >Tên không được để trống.</label >
                                @endif
                                <label>Điện thoại</label><br />
                                {{Form::text('phone','', array('id'=>'phone','class'=>'two_col_reg','placeholder'=>'Điện thoại...'))}} <br />
                                <label>Địa chỉ</label><br />
                                <textarea  rows="5" name="r_address" id="r_address" placeholder="Nhập địa chỉ"></textarea>
                                <label>Mã bảo vệ<span class="required" >*</label><br />
                                {{Form::captcha()}}<br />
                                @if($errors->has('recaptcha_response_field'))
                                <label for="recaptcha_response_field"  class="error" >Mã xác nhận không đúng.</label >
                                @endif
                                {{Form::submit('Đăng ký', array('class' => 'button','style'=>'margin-top: 10px;clear:both;float: left;'))}}
                            </div>
                        </fieldset>
                        {{ Form::close() }}
                        <script type="text/javascript" src="{{Asset('fontend')}}/js/jquery-1.10.2.min.js"></script>
                        <script>
jQuery(document).ready(function() {
    jQuery("#fdangky").validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: "{{action('\FontEnd\UsersController@postKiemTraTaiKhoan')}}",
                    type: "POST"
                }
            },
            r_password: {
                required: true,
                minlength: 6
            },
            r_password_confirmation: {
                equalTo: "#r_password"
            },
            firstname: {
                required: true,
            },
            lastname: {
                required: true,
            },
            recaptcha_response_field: {
                required: true,
            },
        },
        messages: {
            email: {
                required: 'Email là trường bắt buộc.',
                email: 'Email không đúng định dạng.',
                remote: 'E-mail đã tồn tại trên hệ thông.'
            },
            r_password: {
                required: "Mật khẩu là trường bắt buộc.",
                minlength: "Mật khẩu không ngắn hơn 6 ký tự."
            },
            r_password_confirmation: {
                equalTo: 'Mật khẩu không khớp.'
            },
            firstname: {
                required: 'Họ là trường bắt buộc.'
            },
            lastname: {
                required: 'Tên là trường bắt buộc.'
            },
            recaptcha_response_field: {
                required: 'Vui lòng nhập mã bảo vệ',
            },
        }
    });
});
                        </script>
                    </div>

                </div>
            </section>
            <aside id="sidebar" class="positionright three columns omega">
                <ul>
                    <li class="widget-container">
                        <h2 class="widget-title">Categories</h2>
                        <ul>
                            <li><a href="#">Limited Edition</a><span>15</span></li>
                            <li><a href="#">On Sale</a><span>27</span></li>
                            <li><a href="#">New Product</a><span>10</span></li>
                            <li><a href="#">Furniture</a><span>23</span></li>
                            <li><a href="#">Electronic</a><span>25</span></li>
                            <li><a href="#">Other</a><span>70</span></li>
                        </ul>
                    </li>
                    <li class="widget-container">
                        <div class="textwidget"><img src="{{Asset('fontend')}}/images/content/banner.gif" alt="" class="scale-with-grid"/></div>
                    </li>
                    <li class="widget-container">
                        <h2 class="widget-title">Top Rated Product</h2>
                        <ul class="lp-widget">
                            <li>
                                <img src="{{Asset('fontend')}}/images/content/product/small-img1.jpg" alt="" class="alignleft imgborder" />
                                <h3><a href="#">Smart Strip Armchair</a></h3>
                                <div class="price">$120.00</div>
                                <div class="star">
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt=""/>
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                </div>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <img src="{{Asset('fontend')}}/images/content/product/small-img2.jpg" alt="" class="alignleft imgborder" />
                                <h3><a href="#">Smart Chair</a></h3>
                                <div class="price">$200.00</div>
                                <div class="star">
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt=""/>
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                </div>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <img src="{{Asset('fontend')}}/images/content/product/small-img3.jpg" alt="" class="alignleft imgborder" />
                                <h3><a href="#">Smart Camera SLR</a></h3>
                                <div class="price">$120.00</div>
                                <div class="star">
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt=""/>
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                </div>
                                <div class="clear"></div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>

            <div class="clear"></div><!-- clear float --> 
        </section>
    </div>
</div>
<!-- END MAIN CONTENT -->
@endsection
