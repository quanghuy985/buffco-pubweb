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