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
    <form class="stdform" accept-charset="UTF-8" action="#" method="post">
        <p>
            <label>Người mua :</label>
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
            <label>Họ và tên :</label>
            <span class="field">         
                <input type="text" name="orderCode" placeholder="Nhập tên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->userFirstName.' '.$objOrder[0]->userLastName}}@endif" disabled>
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
            <col class="con1" style="width: 15%">
            <col class="con0" style="width: 10%">
            <col class="con1" style="width: 10%">
            <col class="con0" style="width: 15%">
            <col class="con1" style="width: 15%">
        </colgroup>
        <thead>
            <tr>

                <th class="head0">STT</th>
                <th class="head1">Mã sản phẩm</th>
                <th class="head0">Tên sản phẩm</th>
                <th class="head1">Giá</th>
                <th class="head0">Khuyến mại</th>
                <th class="head1">Số lượng</th>
                <th class="head0">Tổng tiền</th>
                <th class="head1">Tên sản phẩm</th>
            </tr>
        </thead>
        <tbody id="tableproduct">
            <?php $i = 1; ?>
            @foreach($objOrder as $item)
            <tr>   
                <td><label value="cateNews"> {{$i++}} </label></td> 
                <td><label value="cateNews">{{str_limit( $item->productCode, 30, '...')}}</label></td> 
                <td><label value="cateNews">{{str_limit( $item->productName, 30, '...')}}</label></td> 
                <td><label value="cateNews">{{$item->productPrice }}</label></td> 
                <td><label value="cateNews">{{str_limit($item->promotionAmount, 30, '...')}} </label></td>
                <td><label value="cateNews">{{str_limit($item->amount, 30, '...')}} </label></td> 
                <td><label value="cateNews">{{str_limit($item->total, 30, '...')}} </label></td>
                <td><label value="cateNews">{{str_limit( $item->productName, 30, '...')}}</label></td> 
            </tr> 
            @endforeach
            <?php
            $total = 0;
            foreach ($objOrder as $item) {
                $total = $item->total + $total;
            };
            ?>
            <tr>
                <td colspan="7" style="text-align: right;"><strong><label>Tổng giá trị đơn hàng :</label></strong></td>
                <td><label value="cateNews">{{$total}}</label></td>
            </tr>
        </tbody>
    </table>
    <form  id="fdgfdkjghdkf" method="post" action="{{URL::action('OrderController@postUpdateOrder')}}">
        <p>
            <label>Trạng thái :</label>
            <span class="field">         
                <input type="hidden" name="idOrderCode" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->orderCode}}@endif">
                <span class="field">
                    <select name="status">
                        <option value="0" @if(isset($objOrder)&& $objOrder[0]->status==0)selected @endif >Chờ kích hoạt</option>
                        <option value="1" @if(isset($objOrder)&& $objOrder[0]->status==1)selected @endif>Kích hoạt</option>
                        <option value="2" @if(isset($objOrder)&& $objOrder[0]->status==2)selected @endif>Xóa</option>
                    </select>
                </span>
            </span>
        </p>
        <p>
            <input type="submit" class="btn" value="Cập nhật">
            <input type="reset" class="reset radius2" value="Làm lại">
        </p>
    </form>
</div>
@endsection