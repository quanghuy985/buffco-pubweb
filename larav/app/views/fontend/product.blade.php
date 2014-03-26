@extends("fontend.hometemplate")
@section("contenthomepage")
<script>
    function phantrang(page) {
        var request = jQuery.ajax({
            url: "{{URL::action('ProductController@postAjaxChuyenMuc')}}?slug={{$slugcate}}&page=" + page,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#hienthisanphams').html(msg);
        });
    }
</script>
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Portfolio</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>4 Columns</h2>
            </div>
        </div>
    </div>
</section>
<div class="container" id="hienthisanphams">


    <h2>Portfolio</h2>

    <hr />

    <div class="row">

        <ul class="portfolio-list sort-destination" data-sort-id="portfolio">
            @foreach($productdata as $item)
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
                    <a href="{{URL::action('ProductController@getChiTiet')}}/{{$item->productSlug}}" class="thumb-info">
                        <img alt="" class="img-responsive" src="{{Asset('timthumb.php')}}?src={{Asset($item->productUrlImage)}}&w=253&h=253&zc=0&q=100" alt="{{$item->productName}}">
                        <span class="thumb-info-title">
                            <span class="thumb-info-inner">{{$item->productName}}</span>
                            <span class="thumb-info-type">@if($item->productPrice==0) Miễn phí @else {{number_format($item->productPrice,0)}} vnđ @endif</span>
                        </span>
                        <span class="thumb-info-action">
                            <span title="Universal" href="#" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
                        </span>
                    </a>
                </div>
            </li>
            @endforeach           
        </ul>
    </div>
    @if($pargion!='')
    {{$pargion}}
    @endif
</div>

@endsection