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
                <h2>Quên mật khẩu</h2>
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
                            <h4>Quên mật khẩu</h4>
                            @if(isset($messenge))
                            <div class="alert alert-warning">
                                <strong>Thông báo!</strong> {{$messenge}}
                            </div>
                            @endif
                            <form action="{{URL::action('LoginController@postForgotPassword')}}" id="" method="post">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Tài khoản hoặc Email</label>
                                            <input type="text" value="" name="userEmail" placeholder="Nhập Email" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="submit" value="Quên mật khẩu" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading...">
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