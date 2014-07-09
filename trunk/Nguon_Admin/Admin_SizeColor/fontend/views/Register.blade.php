@extends("fontend.templatemain")
@section("contentfontend")
<section class="breadcrumbs">
    <div class="container">
        <ul class="horizontal_list clearfix bc_list f_size_medium">
            <li class="m_right_10 current"><a href="#" class="default_t_color">Home<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
            <li class="m_right_10 current"><a href="#" class="default_t_color">Checkout<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
            <li><a href="#" class="default_t_color">Shopping Cart</a></li>
        </ul>
    </div>
</section>
<div class="row clearfix">
    <section class="col-lg-6 col-md-6 col-sm-6 m_xs_bottom_30">
        <h2 class="color_dark tt_uppercase m_bottom_25">Đăng nhập</h2>

        <div class="bs_inner_offsets bg_light_color_3 shadow r_corners m_bottom_45">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h5 class="fw_medium m_bottom_15">I am Already Registered</h5>
                    {{Form::open(array('action' => 'App\Modules\Fontend\Controllers\UserController@postDangNhap','id'=>'fdangnhap'))}}
                    <ul>
                        <li class="clearfix m_bottom_15">
                            <div class="half_column type_2 f_left">
                                {{Form::label('username', 'E-mail', array('class' => 'm_bottom_5 d_inline_b'))}}
                                {{Form::text('username','', array('class' => 'r_corners full_width m_bottom_5','id'=>'username','placeholder'=>'E-mail'))}}      
                            </div>
                            <div class="half_column type_2 f_left">
                                {{Form::label('pass', 'Mật khẩu', array('class' => 'm_bottom_5 d_inline_b'))}}
                                {{Form::password('password', array('class' => 'r_corners full_width m_bottom_5','id'=>'pass','placeholder'=>'Mật khẩu'))}}      
                                <a href="#" class="color_dark f_size_medium">Quên mật khẩu ?</a>
                            </div>
                        </li>
                        <li class="m_bottom_15">
                            <input type="checkbox" class="d_none" name="checkbox_4" id="checkbox_4"><label for="checkbox_4">Ghi nhớ tài khoản</label>
                        </li>
                        <li><button class="button_type_4 r_corners bg_scheme_color color_light tr_all_hover">Đăng nhập</button></li>
                    </ul>
                    {{ Form::close() }}
                </div>

            </div>
        </div>
    </section>
    <section class="col-lg-6 col-md-6 col-sm-6 m_xs_bottom_30">
        <h2 class="color_dark tt_uppercase m_bottom_25">Đăng ký</h2>

        <div class="bs_inner_offsets bg_light_color_3 shadow r_corners m_bottom_45">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form>
                        <ul>
                            <li class="clearfix m_bottom_15">
                                <div class="half_column type_2 f_left">
                                    <label for="username" class="m_bottom_5 d_inline_b required">Họ</label>
                                    <input type="text" id="username" name="" class="r_corners full_width" placeholder="">

                                </div>
                                <div class="half_column type_2 f_left">
                                    <label for="pass" class="m_bottom_5 d_inline_b required">Tên</label>
                                    <input type="text" id="u_name" name="" class="r_corners full_width">
                                </div>
                            </li>
                            <li class="m_bottom_15">
                                <label for="d_name" class="d_inline_b m_bottom_5 required">Họ</label>
                                <input type="text" id="d_name" name="" class="r_corners full_width">
                            </li>
                            <li class="m_bottom_15">
                                <label for="u_name" class="d_inline_b m_bottom_5 required">Tên</label>
                                <input type="text" id="u_name" name="" class="r_corners full_width">
                            </li>
                            <li class="m_bottom_15">
                                <label for="u_email" class="d_inline_b m_bottom_5 required">Email</label>
                                <input type="email" id="u_email" name="" class="r_corners full_width">
                            </li>
                            <li class="m_bottom_15">
                                <label for="u_pass" class="d_inline_b m_bottom_5 required">Password</label>
                                <input type="password" id="u_pass" name="" class="r_corners full_width">
                            </li>
                            <li>
                                <label for="u_repeat_pass" class="d_inline_b m_bottom_15 required">Confirm Password</label>
                                <input type="password" id="u_repeat_pass" name="" class="r_corners full_width">
                            </li>
                            <li class="m_bottom_15 m_top_20">
                                <input type="checkbox" class="d_none" name="checkbox_6" id="checkbox_6"><label for="checkbox_6">Tôi đồng ý với các quy định của của trang web</label>
                            </li>
                            <li><button class="button_type_4 r_corners bg_scheme_color color_light tr_all_hover">Log In</button></li>
                        </ul>
                    </form> 
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


