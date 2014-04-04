@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ ĐƠN HÀNG</h1>
    <span class="pagedesc">Quản lý đơn hàng</span>
</div>
<div class="contentwrapper">

    <div class="contenttitle2">
        <h3>Thông tin đơn hàng</h3>
    </div>
    @if(isset($thongbao))
    <div class="notibar msgalert">
        <a class="close"></a>
        <p>{{$thongbao}}</p>
    </div>
    @endif
    <form class="stdform" accept-charset="UTF-8" action="#" method="post">
        <p>
            <label>Tài khoản :</label>
            <span class="field">         
                <input type="hidden" name="idOrderCode" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->orderCode}}@endif">
                <input type="text" name="username" placeholder="Nhập Email người mua hàng" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->userEmail}}@endif" disabled>
            </span>
        </p>
        <p>
            <label>Mã Đơn Hàng :</label>
            <span class="field">         
                <input type="text" name="orderCode" placeholder="Nhập tên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->orderCode}}@endif" disabled>
            </span>
        </p>
        <p>
            <label>Người mua :</label>
            <span class="field">         
                <input type="text" name="orderCode" placeholder="Nhập tên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->userFirstName.' '.$objOrder[0]->userLastName}}@endif" disabled>
            </span>
        </p>
        <p>
            <label>Người nhận :</label>
            <span class="field">         
                <input type="text" name="orderCode" placeholder="Nhập tên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->receiverName}}@endif" disabled>
            </span>
        </p>
        <p>
            <label>Địa chỉ nhận hàng :</label>
            <span class="field">         
                <input type="text" name="orderCode" placeholder="Nhập tên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->orderAddress}}@endif" disabled>
            </span>
        </p>
        <div class="contenttitle2">
            <h3>Thông tin sản phẩm</h3>
        </div>
    </form>
    <table cellpadding="0" cellspacing="0" border="0"  class="stdtable">
        <colgroup>
            <col class="con0" style="width: 5%">
            <col class="con1" style="width: 15%">
            <col class="con0" style="width: 15%">
            <col class="con1" style="width: 10%">
            <col class="con0" style="width: 15%">
            <col class="con1" style="width: 10%">
            <col class="con0" style="width: 10%">
            <col class="con1" style="width: 5%">
            <col class="con0" style="width: 5%">
            <col class="con1" style="width: 10%">
        </colgroup>
        <thead>
            <tr>

                <th class="head0">STT</th>
                <th class="head1">Mã sản phẩm</th>
                <th class="head0">Tên sản phẩm</th>
                <th class="head1">Size</th>
                <th class="head0">Màu</th>
                <th class="head1">Giá</th>
                <th class="head0">Khuyến mại</th>
                <th class="head1">Số lượng</th>
                <th class="head0">Kho</th>
                <th class="head1">Tổng tiền</th>
            </tr>
        </thead>
        <tbody id="tableproduct">
            <?php $i = 1; ?>

            @foreach($objOrder as $item)
            <tr>   
                <td><label value="cateNews"> {{$i++}} </label></td> 
                <td><label value="cateNews">{{str_limit( $item->productCode, 30, '...')}}</label></td> 
                <td><label value="cateNews">{{str_limit( $item->productName, 30, '...')}}</label></td>
                <td><label value="cateNews">{{str_limit( $item->sizeName, 30, '...')}}</label></td>
                <td><label value="cateNews">{{str_limit( $item->colorName, 30, '...')}}</label></td> 
                <td><label value="cateNews">{{number_format($item->productPrice,0,'.', ',')}}</label></td> 
                <td><label value="cateNews">{{str_limit($item->promotionAmount, 30, '...')}} </label></td>
                <td><label value="cateNews">{{number_format($item->amount,0,'.', ',')}} </label></td>
                <td><label value="cateNews">@foreach($arrayStore as $itemStore)@if ($itemStore->productID == $item->productID && $itemStore->sizeID == $item->sizeID && $itemStore->colorID == $item->colorID)  {{number_format(($itemStore->soluongnhap - $itemStore->soluongban),0,'.', ',')}} @endif @endforeach </label></td>
                <td><label value="cateNews">{{number_format($item->total,0,'.', ',')}} </label></td>
            </tr> 

            @endforeach
            <?php
            $total = 0;
            foreach ($objOrder as $item) {
                $total = $item->total + $total;
            };
            ?>
            <tr>
                <td colspan="9" style="text-align: right;"><strong><label>Tổng giá trị đơn hàng :</label></strong></td>
                <td><label value="cateNews">{{$total}}</label></td>
            </tr>
        </tbody>
    </table>
    <form  id="fdgfdkjghdkf" method="post" action="{{URL::action('OrderController@postUpdateOrder')}}">
        <p>
            <label>Trạng thái :</label>
            @if(isset($objOrder)&& $objOrder[0]->orderStatus==0)
            Chờ kích hoạt
            @endif
            <span class="field">         
                <input type="hidden" name="idOrderCode" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->orderCode}}@endif">
                <span class="field">
                    @if(isset($objOrder)&& $objOrder[0]->orderStatus==1)
                    Đã hoàn thành đơn hàng
                    @else
                    <br>
                    <select name="status">
                        <option value="1" @if(isset($objOrder)&& $objOrder[0]->orderStatus==1)selected @endif>Kích hoạt</option>
                        <option value="2" @if(isset($objOrder)&& $objOrder[0]->orderStatus==2)selected @endif>Xóa</option>
                    </select>
                    @endif
                </span>
            </span>
        </p>
        <p>
            @if(isset($objOrder)&& $objOrder[0]->orderStatus!=1)
            <?php $check = FALSE ?>
            @foreach($objOrder as $item)
            @foreach($arrayStore as $itemStore)
            @if ($itemStore->productID == $item->productID && $itemStore->sizeID == $item->sizeID && $itemStore->colorID == $item->colorID)
            @if (($itemStore->soluongnhap - $itemStore->soluongban) < $item->amount) $check == TRUE 
            @endif 
            @endif 
            @endforeach
            @endforeach
            <input type = "submit" class = "btn" value = "Cập nhật" @if ($check) disabled @endif >
                   <a href = "{{URL::action('OrderController@getViewAll')}}" class = "stdbtn">Quay lại</a>
            @else
            <a href = "{{URL::action('OrderController@getViewAll')}}" class = "stdbtn">Quay lại</a>
            @endif
        </p>
    </form>
</div>
@endsection