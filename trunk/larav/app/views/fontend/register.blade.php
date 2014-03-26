@extends("fontend.hometemplate")
@section("contenthomepage")

<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="index.html">Trang chủ</a></li>
                    <li class="active">Tài khoản</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Đăng ký</h2>
            </div>
        </div>
    </div>
</section>
@if (isset($thongbao))
<div class="container">
    <div class="row">
        <div class="alert alert-danger center">
            <strong>Thông báo! </strong>{{$thongbao}}
        </div>
    </div>
</div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row featured-boxes login">
                <div class="col-md-6">
                    <div class="featured-box featured-box-secundary default info-content">
                        <div class="box-content">
                            <h4>Đăng ký tài khoản</h4>
                            <form action="{{URL::action('LoginController@postDangKy')}}" id="registerForm" method="post">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Địa chỉ Email *</label>
                                            <input type="text" name="userEmail" id="userEmail" placeholder="Nhập địa chỉ Email" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label>Mật khẩu *</label>
                                            <input type="password" name="userPassword" id="userPassword" placeholder="Nhập mật khẩu" value="" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Nhập lại mật khẩu *</label>
                                            <input type="password" name="userRePassword" id="userRePassword" placeholder="Nhập lại mật khẩu" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label>Họ và đệm</label>
                                            <input type="text" name="userFirstName" id="userFirstName" placeholder="VD: Nguyễn Văn" value="" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Tên</label>
                                            <input type="text" name="userLastName" id="userLastName" placeholder="VD: A" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Địa chỉ</label>
                                            <input type="text" name="userAddress" id="userAddress" placeholder="Nhập địa chỉ khách hàng" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Điện thoại</label>
                                            <input type="text" name="userPhone" id="userPhone" placeholder="Vui lòng nhập đúng số điện thoại để nhân viên chúng tôi liên hệ lại" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Số CMND *</label>
                                            <input type="text" name="userIdentity" id="userIdentity" placeholder="Nhập số CMND" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label></label>
                                            <img id="captchaimg" style="-webkit-user-select: none" src="{{Asset('securimage/securimage_show.php')}}"/>
                                            <a href="#" style="color: #3b6f85;font-size: 13px;" onclick="document.getElementById('captchaimg').src = '{{Asset('securimage/securimage_show.php')}}?' + Math.random();
                                                                return false"><i class="icon icon-refresh"></i></a>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Mã kiểm tra</label>
                                            <input type="text" name="makiemtra" id="makiemtra" placeholder="" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" value="Đăng ký" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading...">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection