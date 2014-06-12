@extends("fontend.templatemain")
@section("contentfontend")
<script>
    function phantrang(page) {
    var sortbyluachon = jQuery('#product_name').val();
            if (sortbyluachon == 'Tăng dần') {
    sortbyluachon = 'asc';
    }
    if (sortbyluachon == 'Giảm dần') {
    sortbyluachon = 'desc';
    }
    if (jQuery("#fillterfrom").serialize() != 'catslugfillter=@if(isset($slucat)){{$slucat}}@endif') {
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postLocDuLieuAjax')}}?" + jQuery("#fillterfrom").serialize() + "&page=" + page + "&loctheogia=" + sortbyluachon;
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
    } else {
    var urlslugcat = '@if(isset($slucat)){{$slucat}}@endif';
            if (urlslugcat == '') {
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postSanPhamAjax')}}?page=" + page + "&loctheogia=" + sortbyluachon;
    } else {
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postSanPhamCatAjax')}}?page=" + page + '&slugcat=' + urlslugcat + "&loctheogia=" + sortbyluachon;
    }
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
    function loctheoluachon() {
    var sortbyluachon = jQuery('#product_name').val();
            if (sortbyluachon == 'Tăng dần') {
    sortbyluachon = 'asc';
    } else {
    sortbyluachon = 'desc';
    }
    if (jQuery('#loctheonhatangdan').hasClass('fa-sort-amount-asc')) {
    jQuery('#loctheonhatangdan').removeClass('fa-sort-amount-asc');
            jQuery('#loctheonhatangdan').addClass('fa-sort-amount-desc');
    } else {
    jQuery('#loctheonhatangdan').removeClass('fa-sort-amount-desc');
            jQuery('#loctheonhatangdan').addClass('fa-sort-amount-asc');
    }
    jQuery(".loader-ajax").css('display', 'block');
            var urlslugcat = '@if(isset($slucat)){{$slucat}}@endif';
            if (jQuery("#fillterfrom").serialize() != 'catslugfillter=@if(isset($slucat)){{$slucat}}@endif') {
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postLocDuLieuAjax')}}?" + jQuery("#fillterfrom").serialize() + "&loctheogia=" + sortbyluachon;
    } else {
    if (urlslugcat == '') {
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postLocTheoGiaSanPhamAjax')}}?loctheogia=" + sortbyluachon;
    } else {
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postLocTheoGiaSanPhamCatAjax')}}?loctheogia=" + sortbyluachon + '&slugcat=' + urlslugcat;
    }
    }
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
    function loctheonhatangdan() {
    var sortbyluachon;
            if (jQuery('#loctheonhatangdan').hasClass('fa-sort-amount-asc')) {
    jQuery('#loctheonhatangdan').removeClass('fa-sort-amount-asc');
            jQuery('#loctheonhatangdan').addClass('fa-sort-amount-desc');
            sortbyluachon = 'desc';
            jQuery('#product_name').val('Giảm dần');
    } else {
    jQuery('#loctheonhatangdan').removeClass('fa-sort-amount-desc');
            jQuery('#loctheonhatangdan').addClass('fa-sort-amount-asc');
            sortbyluachon = 'asc';
            jQuery('#product_name').val('Tăng dần');
    }
    var urlslugcat = '@if(isset($slucat)){{$slucat}}@endif';
            if (jQuery("#fillterfrom").serialize() != 'catslugfillter=@if(isset($slucat)){{$slucat}}@endif') {
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postLocDuLieuAjax')}}?" + jQuery("#fillterfrom").serialize() + "&loctheogia=" + sortbyluachon;
    } else {
    if (urlslugcat == '') {
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postLocTheoGiaSanPhamAjax')}}?loctheogia=" + sortbyluachon;
    } else {
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postLocTheoGiaSanPhamCatAjax')}}?loctheogia=" + sortbyluachon + '&slugcat=' + urlslugcat;
    }
    }
    var request = jQuery.ajax({
    url: urlpost,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#productcategory').html('<div class="loader-ajax"></div>').fadeOut(500);
                    setTimeout(function() {
                    jQuery(window).scrollTop(jQuery(".page_content_offset").offset().top);
                            jQuery('#productcategory').html(msg).fadeIn(500);
                    }, 400);
            })
    }
    function themgiohang(id, name, code, price, sale, qty, img) {
    jQuery("#ajaxloadproduct-" + id).css('display', 'block');
            urlpost = "{{URL::action('App\Modules\Fontend\Controllers\OrderController@postAddCart')}}";
            var request = jQuery.ajax({
            url: urlpost,
                    type: "POST",
                    dataType: "html",
                    data: {id: id, name: name, code: code, price: price, sale: sale, qty: qty, img: img}
            }
            );
            request.done(function(msg) {
            jQuery('span.count.tr_delay_hover.type_2.circle.t_align_c').html(msg);
                    jQuery("#ajaxloadproduct-" + id).css('display', 'none');
            })
    }
    function locdulieu() {

    //      var urlslugcat='@if(isset($slucat)){{$slucat}}@endif';
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\ProductController@postLocDuLieu')}}?" + jQuery("#fillterfrom").serialize();
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
    function capnhatgiohang(idcart, size, color, qty) {
    urlpost = "{{URL::action('App\Modules\Fontend\Controllers\OrderController@postUpdateCart')}}";
            var request = jQuery.ajax({
            url: urlpost,
                    type: "POST",
                    dataType: "html",
                    data: {idcart: idcart, size: size, color: color, quantity: qty}
            });
            request.done(function(msg) {
            jQuery('#cartcontent').html('  <div class="loader-ajax"></div>').fadeOut(500);
                    setTimeout(function() {
                    jQuery('#cartcontent').html(msg).fadeIn(500);
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
    <section class="col-lg-12 col-md-12 col-sm-12 m_xs_bottom_30">
        <h2 class="tt_uppercase color_dark m_bottom_25">Giỏ hàng</h2>
        <div class="table_wrap m_bottom_30">
            <!--cart table-->
            <table id="cartcontent" class="table_type_4 full_width r_corners wraper shadow t_align_l t_xs_align_c">
                <tr class="f_size_large">
                    <!--titles for td-->
                    <th>Anh &amp; Tên sản phẩm</th>
                    <th>Mã</th>
                    <th>Giá</th>
                    <th>Kích thước</th>
                    <th>Màu sắc</th>
                    <th>Số lượng</th>
                    <th>Tổng cộng</th>
                </tr>
                @foreach($listcart as $itemdel)

                <tr>
                    <!--Product name and image-->
                    <td class="t_md_align_c">
                        <img src="{{Asset('timthumb.php')}}?src=@if($itemdel->image==null || $itemdel->image==''){{Asset('fontendlib/images/noimg.jpg')}} @else{{$itemdel->image}}@endif&w=110&h=110&zc=0&q=100" alt="{{$itemdel->name}}" class="m_md_bottom_5 d_xs_block d_xs_centered">
                        <a href="{{URL::action('App\Modules\Fontend\Controllers\ProductController@getChiTiet')}}/{{$itemdel->slug}}" class="d_inline_b m_left_5 color_dark"> {{str_limit($itemdel->name,20)}}</a>
                    </td>
                    <!--product key-->
                    <td>{{$itemdel->productcode}}</td>
                    <!--product price-->
                    <td>
                <s>@if($itemdel->sale!=''){{$itemdel->price}}@endif</s>
                <p class="f_size_large color_dark">@if($itemdel->sale!=''){{$itemdel->sale}} @else {{$itemdel->price}} @endif</p>
                </td>
                <td>
                    <?php
                    $exid = explode('-', $itemdel->id);
                    $listsize = array();
                    $listcolor = array();
                    ?>
                    @foreach($size as $item)
                    @if($item['productid']==$exid[0])
                    <?php $listsize = $item['value']; ?>
                    @endif
                    @endforeach
                    @if(count($listsize)==0)
                    Không có
                    @else
                    <div class="custom_select f_size_medium relative d_inline_middle">
                        <div class="select_title r_corners relative color_dark">@if($itemdel->size=='') Chọn @else @foreach($listsize as $itemval)
                            @if($itemval->id==$itemdel->size) {{$itemval->sizeName}}@endif
                            @endforeach @endif</div>
                        <ul class="select_list d_none"></ul>
                        <select name="product_size" id="product_size-{{$itemdel->id}}">
                            @foreach($listsize as $itemval)
                            <option value="{{$itemval->id}}" @if($itemval->id==$itemdel->size) selected @endif>{{$itemval->sizeName}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </td>
                <td>
                    @foreach($color as $item)
                    @if($item['productid']==$exid[0])
                    <?php $listcolor = $item['value']; ?>
                    @endif
                    @endforeach
                    @if(count($listcolor)==0)
                    Không có
                    @else
                    <div class="custom_select f_size_medium relative d_inline_middle"> 
                        <div class="select_title r_corners relative color_dark">@if($itemdel->color=='') Chọn @else @foreach($listcolor as $itemval)
                            @if($itemval->id==$itemdel->color) {{$itemval->colorName}}@endif
                            @endforeach @endif</div>
                        <ul class="select_list d_none"></ul>
                        <select name="product_color" id="product_color-{{$itemdel->id}}">
                            @foreach($listcolor as $itemval)
                            <option  value="{{$itemval->id}}"  @if($itemval->id==$itemdel->color) selected @endif>{{$itemval->colorName}}</option>
                            @endforeach 

                        </select>
                    </div>
                    @endif
                </td>
                <!--quanity-->
                <td>
                    <div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark m_bottom_10">
                        <button class="bg_tr d_block f_left" data-direction="down">-</button>
                        <input type="text" name="" readonly id="quantity-{{$itemdel->id}}" value="{{$itemdel->quantity}}" class="f_left">
                        <button class="bg_tr d_block f_left" data-direction="up">+</button>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="color_dark" onclick="capnhatgiohang('{{$itemdel->id}}',jQuery('#product_size-{{$itemdel->id}}').val(),jQuery('#product_color-{{$itemdel->id}}').val(),jQuery('#quantity-{{$itemdel->id}}').val())"><i class="fa fa-check f_size_medium m_right_5"></i>Cập nhật</a><br>
                        <a href="#" class="color_dark"><i class="fa fa-times f_size_medium m_right_5"></i>Xóa</a><br>
                    </div>
                </td>
                <!--subtotal-->
                <td>
                    <p class="f_size_large fw_medium scheme_color">@if($itemdel->sale!=''){{$itemdel->sale*$itemdel->quantity}} @else {{$itemdel->price*$itemdel->quantity}} @endif</p>
                </td>
                </tr>
                @endforeach

                <!--prices-->
                <tr>
                    <td colspan="6">
                        <p class="fw_medium f_size_large t_align_r">Tổng tiền:</p>
                    </td>
                    <td>
                        <p class="fw_medium f_size_large color_dark">{{$tongcong}}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <p class="fw_medium f_size_large t_align_r">Tiết kiệm:</p>
                    </td>
                    <td>
                        <p class="fw_medium f_size_large color_dark">{{$tongcong-$tongtien}}</p>
                    </td>
                </tr>	
                <!--total-->
                <tr>
                    <td colspan="6">

                        <p class="fw_medium f_size_large t_align_r scheme_color">Total:</p>
                    </td>
                    <td class="v_align_m">
                        <p class="fw_medium f_size_large scheme_color m_xs_bottom_10">{{$tongtien}}</p>
                    </td>
                </tr>
            </table>
        </div>

        <h2 class="color_dark tt_uppercase m_bottom_25">Thông tin mua hàng</h2>
        <div class="bs_inner_offsets bg_light_color_3 shadow r_corners m_bottom_45">
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-6 m_xs_bottom_30">
                    <form>
                        <ul>
                            <li class="m_bottom_15">
                                <label for="c_name_1" class="d_inline_b m_bottom_5">Người nhận:</label>
                                <input type="text" id="c_name_1" name="" class="r_corners full_width">
                            </li>

                        </ul>
                    </form>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">

                    <label for="notes" class="d_inline_b m_bottom_5">Địa chỉ nhận hàng:</label>
                    <textarea id="notes" class="r_corners notes full_width"></textarea>
                </div>
            </div>
        </div>
        <h2 class="tt_uppercase color_dark m_bottom_30">Hình thức thanh toán</h2>
        <div class="bs_inner_offsets bg_light_color_3 shadow r_corners m_bottom_45">
            <figure class="block_select clearfix relative m_bottom_15">
                <input type="radio" checked name="radio_2" class="d_none" value="0">
                <img src="images/payment_logo.jpg" alt="" class="f_left m_right_20 f_mxs_none m_mxs_bottom_10">
                <figcaption>
                    <div class="d_table_cell d_sm_block p_sm_right_0 p_right_45 m_mxs_bottom_5">
                        <h5 class="color_dark fw_medium m_bottom_15 m_sm_bottom_5">Thanh toán trực tiếp</h5>
                        <p>Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis ac turp. Donec sit amet eros. </p>
                    </div>

                </figcaption>
            </figure>
            <hr class="m_bottom_20">
            <figure class="block_select clearfix relative">
                <input type="radio" name="radio_2" class="d_none" value="1">
                <img src="images/payment_logo.jpg" alt="" class="f_left m_right_20 f_mxs_none m_mxs_bottom_10">
                <figcaption>
                    <h5 class="color_dark fw_medium m_bottom_15 m_sm_bottom_5">Thanh toán an toàn bảo kim</h5>
                    <p>Lorem ipsum dolor sit amet, consecvtetuer adipiscing elit. Mauris fermentum dictum magna. 
                        Sed laoreet aliquam leo. Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit.</p>
                </figcaption>
            </figure>
            <hr class="m_bottom_20">
            <figure class="block_select clearfix relative">
                <input type="radio" name="radio_2" class="d_none" value="2">
                <img src="images/payment_logo.jpg" alt="" class="f_left m_right_20 f_mxs_none m_mxs_bottom_10">
                <figcaption>
                    <h5 class="color_dark fw_medium m_bottom_15 m_sm_bottom_5">Thanh toán an toàn ngân lượng</h5>
                    <p>Lorem ipsum dolor sit amet, consecvtetuer adipiscing elit. Mauris fermentum dictum magna. 
                        Sed laoreet aliquam leo. Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit.</p>
                </figcaption>
            </figure>
        </div>
        <h2 class="tt_uppercase color_dark m_bottom_30">Điều khoản mua hàng</h2>
        <div class="bs_inner_offsets bg_light_color_3 shadow r_corners m_bottom_45">
            <p class="m_bottom_10">Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis ac turpis. Donec sit amet eros. Lorem ipsum dolor sit amet, consecvtetuer adipiscing elit. Mauris fermentum dictum magna. Sed laoreet aliquam leo. Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis ac turpis. Integer rutrum ante eu lacus.Vestibulum libero nisl, porta vel, scelerisque eget, malesuada at, neque. </p>
            <p>Vivamus eget nibh. Etiam cursus leo vel metus. Nulla facilisi. Aenean nec eros. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse sollicitudin velit sed leo. Ut pharetra augue nec augue. Nam elit agna,endrerit sit amet, tincidunt ac, viverra sed, nulla. Donec porta diam eu massa. Quisque diam lorem, interdum vitae,dapibus ac, scelerisque vitae, pede. Donec eget tellus non erat lacinia fermentum. Donec in velit vel ipsum auctor pulvinar. </p>
        </div>
        <h2 class="tt_uppercase color_dark m_bottom_30">Ghi chú và thanh toán</h2>
        <!--requests table-->
        <table class="table_type_5 full_width r_corners wraper shadow t_align_l  m_bottom_45">
            <tr>
                <td colspan="2">
                    <label for="notes" class="d_inline_b m_bottom_5">Ghi chú:</label>
                    <textarea id="notes" class="r_corners notes full_width"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button class="button_type_6 bg_scheme_color f_size_large r_corners tr_all_hover color_light m_bottom_20">Đặt hàng</button>
                </td>
            </tr>
        </table>
    </section>

</div>
@endsection