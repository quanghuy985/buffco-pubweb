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
                <script src="{{Asset('fontendlib')}}/js/scripts.js"></script>
    </td>
</tr>