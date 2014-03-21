@extends("fontend.hometemplate")
@section("contenthomepage")
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{Asset('')}}">Trang chủ</a></li>
                    <li class="active">Tài khoản</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Nạp <strong style="color: #2baab1;">Pcash</strong> vào tài khoản</h2>
            </div>
        </div>
    </div>
</section>
<div class="container">

    <div class="row" style="position: relative;">
        <div class="center">
            <img src="{{Asset('fontendlib/img/buoc1.png')}}"  style="width: 75%;"/>
        </div>
        <hr class="tall">
        <h2>Chọn gói thanh toán</h2>
        <div class="pricing-table">
            <div class="col-md-3">
                <div class="plan">
                    <h3>500 Pcash<span>425K</span></h3>
                    <a class="btn btn-lg btn-primary" href="{{URL::action('NapTienController@getNapTien')}}/2/{{md5('425')}}">Mua ngay</a>
                    <ul>
                        <li><b>500 Pcash</b></li>
                        <li>Giá :<b> 500.000 VNĐ</b></li>
                        <li>Khuyến mại :<b> 425.000 VNĐ</b></li>
                        <li>Tiết kiệm :<b> 15%</b></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 center">
                <div class="plan most-popular">
                    <div class="plan-ribbon-wrapper"><div class="plan-ribbon">Khuyên dùng</div></div>
                    <h3>200 Pcash<span>180K</span></h3>
                    <a class="btn btn-lg btn-primary" href="{{URL::action('NapTienController@getNapTien')}}/2/{{md5('180')}}">Mua ngay</a>
                    <ul>
                        <li><b>200 Pcash</b></li>
                        <li>Giá :<b> 200.000 VNĐ</b></li>
                        <li>Giá khuyến mại :<b> 180.000 VNĐ</b></li>
                        <li>Tiết kiệm :<b> 10%</b></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="plan">
                    <h3>100 Pcash<span>95K</span></h3>
                    <a class="btn btn-lg btn-primary" href="{{URL::action('NapTienController@getNapTien')}}/2/{{md5('95')}}">Mua ngay</a>
                    <ul>
                        <li><b>100 Pcash</b></li>
                        <li>Giá :<b> 95.000 VNĐ</b></li>
                        <li>Khuyến mại :<b> 100.000 VNĐ</b></li>
                        <li>Tiết kiệm :<b> 5%</b></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="plan">
                    <h3>50 Pcash<span>50K</span></h3>
                    <a class="btn btn-lg btn-primary" href="{{URL::action('NapTienController@getNapTien')}}/2/{{md5('50')}}">Mua ngay</a>
                    <ul>
                        <li><b>50 Pcash</b></li>
                        <li>Giá :<b> 50.000 VNĐ</b></li>
                        <li>Khuyến mại :<b> 50.000 VNĐ</b></li>
                        <li>Tiết kiệm :<b> 0%</b></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection