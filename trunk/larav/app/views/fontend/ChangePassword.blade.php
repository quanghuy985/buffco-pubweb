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
                <h2>Đổi mật khẩu</h2>
            </div>
        </div>
    </div>
</section>
@if (isset($thongbao))
<div class="alert alert-danger center">
    <strong>Thông báo! </strong>{{$thongbao}}
</div>
@endif
@if (!isset($thongbao))
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row featured-boxes login">
                <div class="col-md-6">
                    <div class="featured-box featured-box-secundary default info-content">
                        <div class="box-content">
                            <h4>Đổi mật khẩu khách hàng</h4>
                            <form action="{{URL::action('LoginController@postNewPassword')}}" id="changePasswordForm" method="post">
                                <input type="hidden" value="@if(isset($userEmail)){{$userEmail}}@endif" name="userEmail" placeholder="Nhập Email" class="form-control">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Mật khẩu</label>
                                            <input type="password" value="" name="userPassword" id="userPassword" placeholder="Nhập mật khẩu" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Nhập lại Mật khẩu</label>
                                            <input type="password" value="" name="ReUserPassword" id="ReUserPassword" placeholder="Nhập lại mật khẩu" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="submit" value="Cập nhật" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading...">
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
@endif
@endsection
