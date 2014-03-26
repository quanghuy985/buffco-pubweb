@extends("fontend.hometemplate")
@section("contenthomepage")
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{Asset('')}}">Trang chủ</a></li>
                    <li class="active">Giao diện</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>{{$backcate->cateName}}</h2>
            </div>
        </div>
    </div>
</section>

<div class="container">

    <div class="portfolio-title">
        <div class="row">
            <div class="portfolio-nav-all col-md-1">
                <a href="{{URL::action('ProductController@getChuyenMuc')}}/{{$backcate->cateSlug}}" rel="tooltip" data-original-title="Back to list"><i class="icon icon-th"></i></a>
            </div>
            <div class="col-md-9 center">
                <h2 class="shorter">{{$dataproductsingle->productName}}</h2>
            </div>
            <div class="portfolio-nav col-md-2">
                <button type="button" class="btn btn-primary" onclick="return window.location.href = '{{URL::action('ProductController@getDangKyWebsite')}}/{{$dataproductsingle->productSlug}}';">Đăng ký ngay</button>
            </div>
        </div>
    </div>

    <hr class="tall">

    <div class="row">
        <div class="col-md-4">
            <div>
                <div class="thumbnail">
                    <img src="{{Asset('timthumb.php')}}?src={{Asset($dataproductsingle->productUrlImage)}}&w=447&h=447&zc=0&q=100" alt="{{$dataproductsingle->productName}}" title="{{$dataproductsingle->productName}}" class="img-responsive" >
                </div>
            </div> 
        </div>

        <div class="col-md-8">

            <div class="portfolio-info">
                <div class="row">
                    <div class="col-md-12 center">
                        <ul>
                            <li>
                                <i class="icon icon-calendar"></i> {{date('d F Y',$dataproductsingle->productTime)}}
                            </li>
                            <li>
                                <i class="icon icon-tags"></i> <a href="#">Website miễn phí</a>, <a href="#">Bán hàng</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <h4> <strong>Chi tiết giao diện</strong></h4>
            <p class="taller">{{$dataproductsingle->productDescription}}</p>

            <a href="{{$dataproductsingle->productUrlDemo}}" class="btn btn-primary btn-icon"><i class="icon icon-external-link"></i>Dùng thử</a> <span class="arrow hlb" data-appear-animation="rotateInUpLeft" data-appear-animation-delay="800"></span>

            <ul class="portfolio-details">
                <li>
                    <p><strong>Tích hợp:</strong></p>

                    <ul class="list list-skills icons list-unstyled list-inline">
                        <li><i class="icon icon-check-circle"></i> Thiết kế</li>
                        <li><i class="icon icon-check-circle"></i> HTML5/CSS3</li>
                        <li><i class="icon icon-check-circle"></i> Javascript</li>
                        <br/>
                        <li><i class="icon icon-check-circle"></i> Quản lý</li>
                        <li><i class="icon icon-check-circle"></i> jQuery</li>
                        <li><i class="icon icon-check-circle"></i> PHP</li>                 <li><i class="icon icon-check-circle"></i> Bootstrap</li>
                    </ul>
                </li>
                <li>
                    <p><strong>Giá:</strong></p>
                    <p><strong> {{$dataproductsingle->productPrice}}</strong> Pcash</p>
                </li>
            </ul>

        </div>
    </div>

    <hr class="tall" />

    <div class="row">

        <div class="col-md-12">
            <h3>Các giao diện khác </h3>
        </div>

        <ul class="portfolio-list">
            @if(isset($relate))
            @foreach($relate as $item)
            <li class="col-md-3">
                <div class="portfolio-item thumbnail">
                    <a href="{{URL::action('ProductController@getChiTiet')}}/{{$item->productSlug}}" class="thumb-info">
                        <img alt="" class="img-responsive" src="{{Asset('timthumb.php')}}?src={{Asset($item->productUrlImage)}}&w=253&h=253&zc=0&q=100" alt="{{$item->productName}}">
                        <span class="thumb-info-title">
                            <span class="thumb-info-inner">{{$item->productName}}</span>
                            <span class="thumb-info-type">@if($item->productPrice==0) Miễn phí @else {{number_format($item->productPrice,0)}} Pcash @endif</span>
                        </span>
                        <span class="thumb-info-action">
                            <span title="Universal" href="#" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
                        </span>
                    </a>
                </div>
            </li>
            @endforeach
            @endif
        </ul>

    </div>

</div>
@endsection