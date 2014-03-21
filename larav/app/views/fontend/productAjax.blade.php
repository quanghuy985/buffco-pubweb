
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