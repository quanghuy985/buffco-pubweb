@extends("fontend.hometemplate")
@section("contenthomepage")
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="index.html">Trang chủ</a></li>
                    <li class="active">Dịch vụ</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Giá dịch vụ</h2>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <h2><strong>Dịch vụ</strong> giá trị gia tăng </h2>
    <div class="row">
        <div class="col-md-12">
            <p class="lead">
                Các bạn có thể tham khảo các dịch vụ dưới đây của chúng tôi, chúng tôi cam kết <span class="alternative-font" style="color: #2baab1">giá rẻ nhất, dịch vụ tốt nhất</span> cho quý khách.
            </p>
        </div>
    </div>
    <hr>
    @if(isset($thongbao))
    <div class="alert alert-warning" style="text-align: center;">
        <strong>Thông báo !</strong> {{$thongbao}}.
<!--        <p>Bấm <a href="{{Asset('')}}"> vào đây </a> để trở lại trang chủ</p>-->
    </div>
    @endif
    <div class="row featured-boxes" >
        <form action="{{URL::action('ServicesController@postServicesSignup')}}" method="POST">
            <div class="col-md-2" style="height: 450px;"></div>
            <div class="col-md-4">
                <div class="featured-box featured-box-tertiary" style="height: 450px !important;">
                    <div class="box-content">
                        <i class="icon-featured icon icon-bookmark"></i>
                        <h4>Quảng cáo</h4>
                        <div >
                            <p class="text-left">
                                Gỡ bỏ quảng cáo trên site của bạn. Dịch vụ này cung cấp chức năng gỡ bỏ quáng cáo gắn trên site của bạn, khi bạn đăng ký dịch vụ này phần quản lý quảng cáo sẽ do bạn tự quản lý.
                            </p>
                            <button type="submit" class="btn btn-success">Đăng ký <i class="icon icon-angle-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="featured-box featured-box-secundary" style="height: 450px !important;">
                    <div class="box-content">
                        <i class="icon-featured icon icon icon-floppy-o" style=" background-color: #2baab1"></i>
                        <h4 style="color:#2baab1 ">Dung lượng</h4>
                        <div>
                            <p class="text-left">
                                Dịch vụ này cung cấp giải pháp tăng dung lượng lưu trữ cho site của bạn, theo đó bạn có thể tải lên nhiều hơn nữa các sản phẩm, tin tức, thông tin của mình.
                            </p>
                            <button type="submit" class="btn" style="background: #2baab1;color: #FFF;">Đăng ký <i class="icon icon-angle-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2" style="height: 450px;"></div>
        </form>
    </div>
</div>
@endsection