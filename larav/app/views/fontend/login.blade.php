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
                <h2>Đăng nhập</h2>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row featured-boxes login">
                <div class="col-md-6">
                    <div class="featured-box featured-box-secundary default info-content">
                        <div class="box-content">
                            <h4>Đăng nhập khách hàng</h4>
                            @if(isset($messenge))
                            <div class="alert alert-warning">
                                <strong>Thông báo!</strong> {{$messenge}}
                            </div>
                            @endif
                            <form action="{{URL::action('LoginController@postDangNhap')}}" id="loginfrom" method="post">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Tài khoản hoặc Email</label>
                                            <input type="text" value="" name="userEmail" placeholder="Nhập Email" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <a class="pull-right" href="{{URL::action('LoginController@getForgotPassword')}}">(Quên mật khẩu?)</a>
                                            <label>Mật khẩu</label>
                                            <input type="password" value="" name="userPassword" placeholder="Nhập mật khẩu" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="remember-box checkbox">
                                            <label for="rememberme">
                                                <input type="checkbox" id="rememberme" name="rememberme">Nhớ đăng nhập
                                            </label>
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" value="Đăng nhập" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading...">
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