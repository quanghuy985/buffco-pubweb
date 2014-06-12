@extends("fontend.templatemain")
@section("contentfontend")
<script>
    function phantrang(page) {
        urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postTagsAjax')}}?page=" + page+"&tags={{$tagname}}";
        var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#productcategory').html('  <div class="loader-ajax"></div>').fadeOut(500);
            setTimeout(function() {
                jQuery(window).scrollTop(jQuery(".page_content_offset").offset().top);
                jQuery('#productcategory').html(msg).fadeIn(500);
            }, 400);
        });
           
    }
    function danhgia(star, id) {
        urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postDanhGia')}}?total_value=" + star + "&id=" + id;
        var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery("#starvoite_" + id).html(msg);
              jQuery("#starvoite1_" + id).html(msg);
        })
    }
    function themgiohang(id, name, code, price, sale, qty, img) {
        jQuery("#ajaxloadproduct-"+id).css('display','block');
            urlpost = "{{URL::action('App\Modules\Fontend\Controllers\OrderController@postAddCart')}}";
            var request = jQuery.ajax({
            url: urlpost,
                    type: "POST",
                    dataType: "html",
                    data: { id: id, name: name, code:code, price:price, sale:sale, qty:qty, img:img }
            }
            );
            request.done(function(msg) {
           jQuery('span.count.tr_delay_hover.type_2.circle.t_align_c').html(msg);
             jQuery("#ajaxloadproduct-"+id).css('display','none');
            })
    }
        function locdulieu() {
          
           //      var urlslugcat='@if(isset($slucat)){{$slucat}}@endif';
             urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postLocDuLieu')}}?"+jQuery("#fillterfrom").serialize();
var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#productcategory').html('  <div class="loader-ajax"></div>').fadeOut(500);
            setTimeout(function() {
                jQuery(window).scrollTop(jQuery(".page_content_offset").offset().top);
                jQuery('#productcategory').html(msg).fadeIn(500);
            }, 400);
        })
    }
</script>
<section class="breadcrumbs">
				<div class="container">
					<ul class="horizontal_list clearfix bc_list f_size_medium">
						<li class="m_right_10 current"><a href="#" class="default_t_color">Home<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
						<li class="m_right_10 current"><a href="#" class="default_t_color">Checkout<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
						<li><a href="#" class="default_t_color">Shopping Cart</a></li>
					</ul>
				</div>
			</section>
<div class="row clearfix">
    <!--left content column-->
    <section class="col-lg-9 col-md-9 col-sm-9" >
        <h2 class="tt_uppercase color_dark m_bottom_25">@if(isset($tagname)){{$tagname}}@else Tất cả @endif</h2>
        <hr class="m_bottom_10 divider_type_3">
        <!--products-->
        <section  id="productcategory">
            <section class="products_container category_grid clearfix m_bottom_15">
               @if(count($arrProduct)==0)<span style="margin-left: 30px;">Không có dữ liệu</span> @endif
                @foreach($arrProduct as $item)
                <!--product item-->
                <div class="product_item hit w_xs_full">
                    <figure class="r_corners photoframe type_2 t_align_c tr_all_hover shadow relative">
                        @if(time() > $item->startSales && time() < $item->endSales) <span class="hot_stripe"><img src="{{Asset('')}}fontendlib/images/sale_product.png" alt=""></span>@endif
                        <!--product preview-->
                        <a href="{{URL::action('App\Modules\Fontend\Controllers\ProductController@getChiTiet')}}/{{$item->productSlug}}" class="d_block relative wrapper pp_wrap m_bottom_15">
                            <img src="{{Asset('timthumb.php')}}?src=@if($item->attachmentURL==null){{Asset('fontendlib/images/noimg.jpg')}} @else{{$item->attachmentURL}}@endif&w=242&h=242&zc=0&q=100" class="tr_all_hover" alt="">

                        </a>
                        <!--description and price of product-->
                        <figcaption>

                            <h5 class="m_bottom_10"><a href="{{URL::action('App\Modules\Fontend\Controllers\ProductController@getChiTiet')}}/{{$item->productSlug}}" class="color_dark">{{$item->productName}}</a></h5>
                            <!--rating-->
                            <ul id="starvoite_{{$item->id}}" class="horizontal_list d_inline_b m_bottom_10 clearfix rating_list type_2 tr_all_hover">                         
                                <?php
                                for ($i = 0; $i < 5; $i++) {
                                    $j = $i + 1;
                                    if ($i < @number_format($item->total_value / $item->total_votes, 1) - 0.5) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    echo '<li class="' . $class . '" onclick="danhgia(' . $j . ',' . $item->id . ')">
                                    <i class="fa fa-star-o empty tr_all_hover"></i>
                                    <i class="fa fa-star active tr_all_hover"></i>
                                </li>';
                                }
                                ?>

                            </ul>
                            <span style="line-height: 10px;">({{$item->total_votes}} đánh giá)</span>
                            <br>
                            @if($item->productPrice==0)
                            <p class="scheme_color f_size_large m_bottom_15">Liên hệ</p>
                            @else
                            @if(time() > $item->startSales && time() < $item->endSales) <s class="v_align_b f_size_medium">{{$item->productPrice}} vnđ</s><p class="scheme_color f_size_large m_bottom_15">{{$item->salesPrice}} vnđ</p>@else
                            <p class="scheme_color f_size_large m_bottom_15">{{$item->productPrice}} vnđ</p>
                            @endif
                            @endif
                            <button class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0 m_bottom_15" onclick="themgiohang({{$item->id}},'{{$item->productName}}','{{$item->productCode}}',{{$item->productPrice}}, @if(time() > $item->startSales && time() < $item->endSales) {{$item->salesPrice}} @else  '' @endif, 1, @if($item->attachmentURL == null)'{{Asset('fontendlib/images/noimg.jpg')}}' @else'{{$item->attachmentURL}}' @endif)">Chọn mua</button>
                            <div id="ajaxloadproduct-{{$item->id}}" class="loader-ajax" style="display: none;"></div>
                        </figcaption>
                    </figure>
                </div>
                @endforeach

            </section>
            <hr class="m_bottom_10">
            <div class="loader-ajax" style="display: none;"></div>
            @if(isset($link))
            <div class="row clearfix m_bottom_15 m_xs_bottom_30  w_xs_full"> 
                <div class="col-lg-5 col-md-5 col-sm-4 t_align_l t_xs_align_l">
                    <!--pagination-->
                    {{$link}}
                </div>
            </div>

            @endif
        </section>
    </section>
     <aside class ="col-lg-3 col-md-3 col-sm-3">
    <!--widgets-->
       <figure class="widget shadow r_corners wrapper m_bottom_30">
        <figcaption>
            <h3 class="color_light">Danh mục sản phẩm</h3>
        </figcaption>
        <div class="widget_content">
            <!--Categories list-->
            <ul class="categories_list">
                 @foreach($catarray as $item)
                 @if($item->cateParent==0)
                    <li class="active">
                        <a href="#" class="f_size_large scheme_color d_block relative">
                            <b>{{$item->cateName}}</b>
                            <span class="bg_light_color_1 r_corners f_right color_dark talign_c"></span>
                        </a>
                        <!--second level-->
                        <ul>
                              @foreach($catarray as $item1)
                                      @if($item1->cateParent==$item->id)
                            <li>
                                <a href="{{\URL::action('App\Modules\Fontend\Controllers\ProductController@getSanPham')}}/{{$item1->cateSlug}}" class="d_block f_size_large color_dark relative">
                                    {{$item1->cateName}}
                                </a>
                            </li>
                                      @endif
                                     @endforeach
                           
                        </ul>
                    </li>
                    @endif
                    @endforeach
            </ul>
        </div>
    </figure>
    <!--Bestsellers-->
    <figure class="widget shadow r_corners wrapper m_bottom_30">
        <figcaption>
            <h3 class="color_light">Sản phẩm bán chạy</h3>
        </figcaption>
        <div class="widget_content">
            <?php $i=1; ?>
            @foreach($bestsalse as $item)
            @if($i!=1)
              <hr class="m_bottom_15">
              @endif
              <div class="clearfix m_bottom_15">
                <img src="{{Asset('timthumb.php')}}?src=@if($item->attachmentURL==null){{Asset('fontendlib/images/noimg.jpg')}} @else{{$item->attachmentURL}}@endif&w=80&h=90&zc=0&q=100" alt="" class="f_left m_right_15 m_sm_bottom_10 f_sm_none f_xs_left m_xs_bottom_0">
                <a href="{{URL::action('App\Modules\Fontend\Controllers\ProductController@getChiTiet')}}/{{$item->productSlug}}" class="color_dark d_block bt_link">{{ str_limit($item->productName,18)}}</a>
                <!--rating-->
                <ul id="starvoite1_{{$item->id}}" class="horizontal_list clearfix d_inline_b rating_list type_2 tr_all_hover m_bottom_10">                         
                                <?php
                                for ($i = 0; $i < 5; $i++) {
                                    $j = $i + 1;
                                    if ($i < @number_format($item->total_value / $item->total_votes, 1) - 0.5) {
                                        $class = "active";
                                    } else {
                                        $class = "";
                                    }
                                    echo '<li class="' . $class . '" onclick="danhgia(' . $j . ',' . $item->id . ')">
                                    <i class="fa fa-star-o empty tr_all_hover"></i>
                                    <i class="fa fa-star active tr_all_hover"></i>
                                </li>';
                                }
                                ?>

                            </ul>
                <br/>
                   @if($item->productPrice==0)
                            <p class="scheme_color">Liên hệ</p>
                            @else
                            @if(time() > $item->startSales && time() < $item->endSales) <s class="v_align_b f_size_small">{{$item->productPrice}} vnđ</s><p class="scheme_color">{{$item->salesPrice}} vnđ</p>@else
                            <p class="scheme_color">{{$item->productPrice}} vnđ</p>
                            @endif
                            @endif
            </div>
                <?php $i++; ?>
            @endforeach
        </div>
    </figure>
    <!--tags-->
   <figure class="widget shadow r_corners wrapper m_bottom_30">
        <figcaption>
            <h3 class="color_light">Thẻ</h3>
        </figcaption>
        <div class="widget_content">
            <div class="tags_list">
                <?php 
                $classCss=  array('color_dark d_inline_b v_align_b','color_dark d_inline_b f_size_ex_large v_align_b','color_dark d_inline_b f_size_big v_align_b','color_dark d_inline_b f_size_large v_align_b');
               foreach ($tags as $tag){
                   ?>
                 <a href="{{URL::action('App\Modules\Fontend\Controllers\ProductController@getTags')}}/{{$tag}}" class="{{$classCss[array_rand($classCss)]}}">{{$tag}}</a>
                <?php 
               }
                ?>
                
            </div>
        </div>
    </figure>
</aside>
</div>
@endsection