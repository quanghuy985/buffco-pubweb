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

    <hr class="tall">
    <div class="row">
        <h2>Các gói dịch vụ tăng dung lượng trang web của bạn</h2>
        <div class="pricing-table">
            @foreach($arrayServices as $item1)
            @if ($item1->servicesSlug == 1)

            <div class="col-md-2">
                <div class="plan">
                    <h3>{{$item1->servicesName}}<span>{{$item1->servicesPrices - $item1->servicesPromotion }}K</span></h3>
                    <a class="btn btn-lg btn-primary" href="#">Đăng ký</a>
                    <ul>
                        <li> <b> VNĐ/Tháng</b> </li>
                        <li> Khuyến mại <b>{{$item1->servicesPromotion}}</b> </li>
                        <li> Tiết kiệm <b>{{number_format($item1->servicesPromotion/$item1->servicesPrices * 100, 2) }}%</b> </li>
                        <li> Dung lượng <b>{{$item1->servicesPrices/15 * 100}} MB</b> </li>
                    </ul>
                </div>
            </div>

            @endif
            @endforeach
        </div>
    </div>

    <hr class="tall">
    <div class="row">
        <h2>Mua điểm thanh toán trên PUBweb</h2>

        <div class="pricing-table">
            @foreach($arrayServices as $item)
            @if ($item->servicesSlug == 2)

            <div class="col-md-4">
                <div class="plan">
                    <h3>{{$item->servicesName}}<span>{{$item->servicesPrices - $item->servicesPromotion }}K</span></h3>
                    <a class="btn btn-lg btn-primary" href="#">Đăng ký</a>
                    <ul>
                        <li> Khuyến mại <b>{{$item->servicesPromotion}}</b> </li>
                        <li> Tiết kiệm <b>{{$item->servicesPromotion/$item->servicesPrices * 100 }}%</b> </li>
                        <li> <b>{{$item->servicesContent}}</b> </li>
                    </ul>
                </div>
            </div>

            @endif
            @endforeach
        </div>
    </div>
</div>
@endsection