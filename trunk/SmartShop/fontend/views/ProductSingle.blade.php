@extends("fontend.templatemain")
@section("contentfontend")
<script>
    function danhgia(star, id) {
        urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postDanhGia')}}?total_value=" + star + "&id=" + id;
        var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery("#starvoite_" + id).html(msg);
        })
    }
     function themgiohang(id, name, code, price, sale,slug, qty, img) {   
         var colorid=jQuery("#product_color").val();
         var sizeid=jQuery("#product_size").val();
        jQuery("#ajaxloadproduct-"+id).css('display','block');
            urlpost = "{{URL::action('App\Modules\Fontend\Controllers\OrderController@postAddCart')}}";
            var request = jQuery.ajax({
            url: urlpost,
                    type: "POST",
                    dataType: "html",
                    data: { id: id, name: name, code:code, price:price, sale:sale, slug:slug, qty:qty, img:img,size:sizeid,color:colorid }
            }
            );
            request.done(function(msg) {
           jQuery('span.count.tr_delay_hover.type_2.circle.t_align_c').html(msg);
             jQuery("#ajaxloadproduct-"+id).css('display','none');
            })
    }
</script>
<div class="row clearfix">
    <!--left content column-->
    <section class="col-lg-9 col-md-9 col-sm-9 m_xs_bottom_30">
        <div class="clearfix m_bottom_30 t_xs_align_c">
            <div class="photoframe type_2 shadow r_corners f_left f_sm_none d_xs_inline_b product_single_preview relative m_right_30 m_bottom_5 m_sm_bottom_20 m_xs_right_0 w_mxs_full">
                @if(time() > $product[0]->startSales && time() > $product[0]->endSales) <span class="hot_stripe"><img src="{{Asset('')}}fontendlib/images/sale_product.png" alt="Giảm giá sản phẩm"></span>@endif
                <div class="relative d_inline_b m_bottom_10 qv_preview d_xs_block">

                    <img id="zoom_image" src="{{Asset('timthumb.php')}}?src=@if($product[0]->attachmentURL==null){{Asset('fontendlib/images/noimg.jpg')}} @else{{$product[0]->attachmentURL}}@endif&w=438&h=438&zc=0&q=100" data-zoom-image="{{Asset('timthumb.php')}}?src=@if($product[0]->attachmentURL==null){{Asset('fontendlib/images/noimg.jpg')}} @else{{$product[0]->attachmentURL}}@endif&w=720&h=720&zc=0&q=100" class="tr_all_hover" alt="">

                    <a href="{{Asset('timthumb.php')}}?src=@if($product[0]->attachmentURL==null){{Asset('fontendlib/images/noimg.jpg')}} @else{{$product[0]->attachmentURL}}@endif&w=720&h=720&zc=0&q=100" class="d_block button_type_5 r_corners tr_all_hover box_s_none color_light p_hr_0">
                        <i class="fa fa-expand"></i>
                    </a>
                </div>
                <!--carousel-->
                <div class="relative qv_carousel_wrap">
                    <button class="button_type_11 bg_light_color_1 t_align_c f_size_ex_large bg_cs_hover r_corners d_inline_middle bg_tr tr_all_hover qv_btn_single_prev">
                        <i class="fa fa-angle-left "></i>
                    </button>
                    <ul class="qv_carousel_single d_inline_middle">
                        @foreach($product as $img)
                        <a href="#" data-image="{{Asset('timthumb.php')}}?src=@if($img->attachmentURL==null){{Asset('fontendlib/images/noimg.jpg')}} @else{{$img->attachmentURL}}@endif&w=438&h=438&zc=0&q=100" data-zoom-image="{{Asset('timthumb.php')}}?src=@if($img->attachmentURL==null){{Asset('fontendlib/images/noimg.jpg')}} @else{{$img->attachmentURL}}@endif&w=720&h=720&zc=0&q=100"><img src="{{Asset('timthumb.php')}}?src=@if($img->attachmentURL==null){{Asset('fontendlib/images/noimg.jpg')}} @else{{$img->attachmentURL}}@endif&w=438&h=438&zc=0&q=100" alt="{{$img->productName}}"></a>  
                        @endforeach
                    </ul>
                    <button class="button_type_11 bg_light_color_1 t_align_c f_size_ex_large bg_cs_hover r_corners d_inline_middle bg_tr tr_all_hover qv_btn_single_next">
                        <i class="fa fa-angle-right "></i>
                    </button>
                </div>
            </div>
            <div class="p_top_10 t_xs_align_l">
                <!--description-->
                <h2 class="color_dark fw_medium m_bottom_10">{{$product[0]->productName}}</h2>
                <div class="m_bottom_10">
                    <!--rating-->
                    <ul id="starvoite_{{$product[0]->id}}" class="horizontal_list d_inline_middle type_2 clearfix rating_list tr_all_hover">
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            $j = $i + 1;
                            if ($i < @number_format($product[0]->total_value / $product[0]->total_votes, 1) - 0.5) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            echo '<li class="' . $class . '" onclick="danhgia(' . $j . ',' . $product[0]->id . ')">
                                    <i class="fa fa-star-o empty tr_all_hover"></i>
                                    <i class="fa fa-star active tr_all_hover"></i>
                                </li>';
                        }
                        ?>
                    </ul>
                    <a href="#" class="d_inline_middle default_t_color f_size_small m_left_5">{{ $product[0]->total_votes}} đánh giá </a>
                    <br/>
                    <p class="d_inline_middle">Chia sẻ:</p>
                    <div class="d_inline_middle m_left_5 addthis_widget_container">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                            <a class="addthis_button_preferred_1"></a>
                            <a class="addthis_button_preferred_2"></a>
                            <a class="addthis_button_preferred_3"></a>
                            <a class="addthis_button_preferred_4"></a>
                            <a class="addthis_button_compact"></a>
                            <a class="addthis_counter addthis_bubble_style"></a>
                        </div>
                        <!-- AddThis Button END -->
                    </div>
                </div>

                <hr class="m_bottom_10 divider_type_3">
                <table class="description_table m_bottom_10">
                    <tr>
                        <td>Nhà sản xuất:</td>
                        <td><a href="javascript:void(0);" class="color_dark">@if($product[0]->manufacturerName=='') Liên hệ @else {{ $product[0]->manufacturerName}} @endif</a></td>
                    </tr>
                    <tr>
                        <td>Số lượng:</td>
                        <td>{{$store[0]->soluong - $store[0]->daban}} sản phẩm</td>
                    </tr>
                    <tr>
                        <td>Màu sắc:</td>
                        <td>@if(isset($color)) Liên hệ @else @foreach($color as $cl)<span style="color:{{$cl->colorCode}}">{{$cl->colorName}}</span> @endforeach @endif</td>
                    </tr>
                    <tr>
                        <td>Size:</td>
                        <td> @if(isset($size)) Liên hệ @else @foreach($size as $sz)<span>{{$sz->sizeName}}</span> @endforeach @endif</td>
                    </tr>
                    <tr>
                        <td>Mã sản phẩm:</td>
                        <td>{{ $product[0]->productCode}}</td>
                    </tr>
                </table>

                <hr class="divider_type_3 m_bottom_15">
                <div class="m_bottom_15">
                    @if($product[0]->salesPrice==0)
                    <span class="v_align_b f_size_big m_left_5 scheme_color fw_medium">Liên hệ</span>
                    @else
                    @if(time() > $product[0]->startSales && time() > $product[0]->endSales)
                    <s class="v_align_b f_size_ex_large">{{$product[0]->productPrice}} vnđ</s><span class="v_align_b f_size_big m_left_5 scheme_color fw_medium">{{$product[0]->salesPrice}}</span>
                    @else
                    <span class="v_align_b f_size_big m_left_5 scheme_color fw_medium">{{$product[0]->productPrice}} vnđ</span>
                    @endif
                    @endif
                </div>
                <table class="description_table type_2 m_bottom_15">
                    <tr>
                        <td class="v_align_m">Cỡ:</td>
                        <td class="v_align_m">
                            @if(isset($size[0]))
                            <div class="custom_select f_size_medium relative d_inline_middle">
                                <div class="select_title r_corners relative color_dark">{{$size[0]->sizeName}}</div>
                                <ul class="select_list d_none"></ul>
                                <select name="product_size" id="product_size">
                                    @foreach($size as $item)
                                     <option value="{{$item->id}}">{{$item->sizeName}}</option>
                                    @endforeach
                                </select>  
                                    @else
                                    Không có cỡ
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="v_align_m">Màu sắc:</td>
                        <td class="v_align_m">
                             @if(isset($color[0]))
                            <div class="custom_select f_size_medium relative d_inline_middle">
                                <div class="select_title r_corners relative color_dark">{{$color[0]->colorName}}</div>
                                <ul class="select_list d_none"></ul>
                                <select name="product_color" id="product_color">
                                      @foreach($color as $item)
                                     <option value="{{$item->id}}">{{$item->colorName}}</option>
                                    @endforeach
                                </select>
                            </div>
                             @else
                             Một màu
                                    @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="v_align_m">Số lượng:</td>
                        <td class="v_align_m">
                            <div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark">
                                <button class="bg_tr d_block f_left" data-direction="down">-</button>
                                <input type="text" id="soluongsanpham" readonly value="1" class="f_left">
                                <button class="bg_tr d_block f_left" data-direction="up">+</button>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="d_ib_offset_0 m_bottom_20">
                    <button class="button_type_12 r_corners bg_scheme_color color_light tr_delay_hover d_inline_b f_size_large" onclick="themgiohang({{$product[0]->id}}, '{{$product[0]->productName}}', '{{$product[0]->productCode}}', {{$product[0]->productPrice}},  @if(time() > $product[0]->startSales && time() < $product[0]->endSales) {{$product[0]->salesPrice}} @else  '' @endif,'{{$product[0]->productSlug}}', jQuery('#soluongsanpham').val(), '{{$product[0]->attachmentURL}}')">Add to Cart</button>
                    <button class="button_type_12 bg_light_color_2 tr_delay_hover d_inline_b r_corners color_dark m_left_5 p_hr_0"><span class="tooltip tr_all_hover r_corners color_dark f_size_small">Wishlist</span><i class="fa fa-heart-o f_size_big"></i></button>   
               <div id="ajaxloadproduct-{{$product[0]->id}}" class="loader-ajax " style="display: none;float: left;width: 209px;margin-top: 10px;"></div>
                </div>

            </div>
        </div>
        <!--tabs-->
        <div class="tabs m_bottom_45">
            <!--tabs navigation-->
            <nav>
                <ul class="tabs_nav horizontal_list clearfix">
                    <li class="f_xs_none"><a href="#tab-1" class="bg_light_color_1 color_dark tr_delay_hover r_corners d_block">Mô tả</a></li>
                    <li class="f_xs_none"><a href="#tab-2" class="bg_light_color_1 color_dark tr_delay_hover r_corners d_block">Thông tin</a></li>
                    <li class="f_xs_none"><a href="#tab-3" class="bg_light_color_1 color_dark tr_delay_hover r_corners d_block">Bình luận</a></li>         
                </ul>
            </nav>
            <section class="tabs_content shadow r_corners">
                <div id="tab-1">
                    <p class="m_bottom_10">
                        @if($product[0]->productDescription=='') Đang chờ cập nhật . @else  {{$product[0]->productDescription}}@endif
                    </p>     
                    <hr class="m_bottom_15">
                    Tags:  {{$product[0]->productTag}}
                </div>
                <div id="tab-2">
                    <p class="m_bottom_10">
                        @if($product[0]->attributes=='') Đang chờ cập nhật . @else  {{$product[0]->attributes}}@endif
                    </p> 
                </div>
                <div id="tab-3">
                    <div class="m_bottom_10">

                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id))
                                    return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                        <div id="fb_chat" class="fb-comments" data-href="{{URL::current()}}"  data-send="true" data-numposts="10" data-colorscheme="light"></div>
         
                        <script>
                            j110('#fb_chat').attr('data-width', j110('#tab-3').width());
                        </script>
                    </div>
                </div>
            </section>
        </div>
        <div class="clearfix">
            <h2 class="color_dark tt_uppercase f_left m_bottom_15 f_mxs_none">Related Products</h2>
            <div class="f_right clearfix nav_buttons_wrap f_mxs_none m_mxs_bottom_5">
                <button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large t_align_c bg_light_color_1 f_left tr_delay_hover r_corners rp_prev"><i class="fa fa-angle-left"></i></button>
                <button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large t_align_c bg_light_color_1 f_left m_left_5 tr_delay_hover r_corners rp_next"><i class="fa fa-angle-right"></i></button>
            </div>
        </div>
        <div class="related_projects m_bottom_15 m_sm_bottom_0 m_xs_bottom_15">
            <figure class="r_corners photoframe shadow relative d_xs_inline_b tr_all_hover">
                <!--product preview-->
                <a href="#" class="d_block relative pp_wrap">
                    <!--hot product-->
                    <span class="hot_stripe type_2"><img src="{{Asset('')}}fontendlib/images/hot_product_type_2.png" alt=""></span>
                    <img src="{{Asset('')}}fontendlib/images/product_img_5.jpg" class="tr_all_hover" alt="">
                    <span data-popup="#quick_view_product" class="t_md_align_c button_type_5 box_s_none color_light r_corners tr_all_hover d_xs_none">Quick View</span>
                </a>
                <!--description and price of product-->
                <figcaption class="t_xs_align_l">
                    <h5 class="m_bottom_10"><a href="#" class="color_dark ellipsis">Eget elementum vel</a></h5>
                    <div class="clearfix">
                        <p class="scheme_color f_left f_size_large m_bottom_15">$102.00</p>
                        <!--rating-->
                        <ul class="horizontal_list f_right clearfix rating_list tr_all_hover">
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li>
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                        </ul>
                    </div>
                    <button class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0">Add to Cart</button>
                </figcaption>
            </figure>
            <figure class="r_corners photoframe shadow relative d_xs_inline_b tr_all_hover">
                <!--product preview-->
                <a href="#" class="d_block relative pp_wrap">
                    <img src="{{Asset('')}}fontendlib/images/product_img_7.jpg" class="tr_all_hover" alt="">
                    <span data-popup="#quick_view_product" class="t_md_align_c button_type_5 box_s_none color_light r_corners tr_all_hover d_xs_none">Quick View</span>
                </a>
                <!--description and price of product-->
                <figcaption class="t_xs_align_l">
                    <h5 class="m_bottom_10"><a href="#" class="color_dark ellipsis">Cursus eleifend elit aenean elit aenean</a></h5>
                    <div class="clearfix">
                        <p class="scheme_color f_left f_size_large m_bottom_15">$99.00</p>
                        <!--rating-->
                        <ul class="horizontal_list f_right clearfix rating_list tr_all_hover">
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li>
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                        </ul>
                    </div>
                    <button class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0">Add to Cart</button>
                </figcaption>
            </figure>
            <figure class="r_corners photoframe shadow relative d_xs_inline_b tr_all_hover">
                <!--product preview-->
                <a href="#" class="d_block relative pp_wrap">
                    <!--sale product-->
                    <span class="hot_stripe type_2"><img src="{{Asset('')}}fontendlib/images/sale_product_type_2.png" alt=""></span>
                    <img src="{{Asset('')}}fontendlib/images/product_img_8.jpg" class="tr_all_hover" alt="">
                    <span data-popup="#quick_view_product" class="t_md_align_c button_type_5 box_s_none color_light r_corners tr_all_hover d_xs_none">Quick View</span>
                </a>
                <!--description and price of product-->
                <figcaption class="t_xs_align_l">
                    <h5 class="m_bottom_10"><a href="#" class="color_dark ellipsis">Aliquam erat volutpat</a></h5>
                    <div class="clearfix">
                        <p class="scheme_color f_left f_size_large m_bottom_15">$36.00</p>
                        <!--rating-->
                        <ul class="horizontal_list f_right clearfix rating_list tr_all_hover">
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li>
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                        </ul>
                    </div>
                    <button class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0">Add to Cart</button>
                </figcaption>
            </figure>
            <figure class="r_corners photoframe shadow relative d_xs_inline_b tr_all_hover">
                <!--product preview-->
                <a href="#" class="d_block relative pp_wrap">
                    <!--hot product-->
                    <span class="hot_stripe type_2"><img src="{{Asset('')}}fontendlib/images/hot_product_type_2.png" alt=""></span>
                    <img src="{{Asset('')}}fontendlib/images/product_img_3.jpg" class="tr_all_hover" alt="">
                    <span data-popup="#quick_view_product" class="t_md_align_c button_type_5 box_s_none color_light r_corners tr_all_hover d_xs_none">Quick View</span>
                </a>
                <!--description and price of product-->
                <figcaption class="t_xs_align_l">
                    <h5 class="m_bottom_10"><a href="#" class="color_dark ellipsis">Eget elementum vel</a></h5>
                    <div class="clearfix">
                        <p class="scheme_color f_left f_size_large m_bottom_15">$102.00</p>
                        <!--rating-->
                        <ul class="horizontal_list f_right clearfix rating_list tr_all_hover">
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li>
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                        </ul>
                    </div>
                    <button class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0">Add to Cart</button>
                </figcaption>
            </figure>
            <figure class="r_corners photoframe shadow relative d_xs_inline_b tr_all_hover">
                <!--product preview-->
                <a href="#" class="d_block relative pp_wrap">
                    <img src="{{Asset('')}}fontendlib/images/product_img_1.jpg" class="tr_all_hover" alt="">
                    <span data-popup="#quick_view_product" class="t_md_align_c button_type_5 box_s_none color_light r_corners tr_all_hover d_xs_none">Quick View</span>
                </a>
                <!--description and price of product-->
                <figcaption class="t_xs_align_l">
                    <h5 class="m_bottom_10"><a href="#" class="color_dark ellipsis">Cursus eleifend elit aenean...</a></h5>
                    <div class="clearfix">
                        <p class="scheme_color f_left f_size_large m_bottom_15">$99.00</p>
                        <!--rating-->
                        <ul class="horizontal_list f_right clearfix rating_list tr_all_hover">
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li>
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                        </ul>
                    </div>
                    <button class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0">Add to Cart</button>
                </figcaption>
            </figure>
            <figure class="r_corners photoframe shadow relative d_xs_inline_b tr_all_hover">
                <!--product preview-->
                <a href="#" class="d_block relative pp_wrap">
                    <!--sale product-->
                    <span class="hot_stripe type_2"><img src="{{Asset('')}}fontendlib/images/sale_product_type_2.png" alt=""></span>
                    <img src="{{Asset('')}}fontendlib/images/product_img_9.jpg" class="tr_all_hover" alt="">
                    <span data-popup="#quick_view_product" class="t_md_align_c button_type_5 box_s_none color_light r_corners tr_all_hover d_xs_none">Quick View</span>
                </a>
                <!--description and price of product-->
                <figcaption class="t_xs_align_l">
                    <h5 class="m_bottom_10"><a href="#" class="color_dark ellipsis">Aliquam erat volutpat</a></h5>
                    <div class="clearfix">
                        <p class="scheme_color f_left f_size_large m_bottom_15">$36.00</p>
                        <!--rating-->
                        <ul class="horizontal_list f_right clearfix rating_list tr_all_hover">
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li class="active">
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                            <li>
                                <i class="fa fa-star-o empty tr_all_hover"></i>
                                <i class="fa fa-star active tr_all_hover"></i>
                            </li>
                        </ul>
                    </div>
                    <button class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0">Add to Cart</button>
                </figcaption>
            </figure>
        </div>
        <hr class="divider_type_3 m_bottom_15">
        <a href="category_grid.html" role="button" class="d_inline_b bg_light_color_2 color_dark tr_all_hover button_type_4 r_corners"><i class="fa fa-reply m_left_5 m_right_10 f_size_large"></i>Back to: Woman</a>
    </section>
      <!--right column-->
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