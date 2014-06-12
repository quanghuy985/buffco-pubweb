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
                <input type="text" name="orderCode" placeholder="Nhập tên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->userLastName.' '.$objOrder[0]->userFirstName}}@endif" disabled>
            </span>
        </p>
        <p>
            <label>Điện thoại liên hệ :</label>
            <span class="field">         
                <input type="text" name="orderCode" placeholder="Nhập tên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->userPhone}}@endif" disabled>
            </span>
        </p>
        <p>
            <label>Người nhận :</label>
            <span class="field">         
                <input type="text" name="orderCode" placeholder="Nhập tên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->receiverName}}@endif" disabled>
            </span>
        </p>
        <p>
        <p>
            <label>Điện thoại người nhận :</label>
            <span class="field">         
                <input type="text" name="orderCode" placeholder="Nhập tên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->receiverPhone}}@endif" disabled>
            </span>
        </p>
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
            <col class="con1" style="width: 10%">
            <col class="con0" style="width: 10%">
        </colgroup>
        <thead>
            <tr>

                <th class="head0">STT</th>
                <th class="head1">Mã sản phẩm</th>
                <th class="head0">Tên sản phẩm</th>
                <th class="head1">Size</th>
                <th class="head0">Màu</th>
                <th class="head1">Giá</th>
                <th class="head0">Số lượng</th>
                <th class="head1">Kho</th>
                <th class="head0">Tổng tiền</th>
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
                <td><label value="cateNews">{{number_format($item->amount,0,'.', ',')}} </label></td>
                <td><label value="cateNews">@foreach($arrayStore as $itemStore)@if ($itemStore->productID == $item->productID && $itemStore->sizeID == $item->sizeID && $itemStore->colorID == $item->colorID)  {{number_format(($itemStore->soluongnhap - $itemStore->soluongban),0,'.', ',')}} @endif @endforeach </label></td>
                <td><label value="cateNews">{{number_format($item->productPrice * $item->amount,0,'.', ',')}} VND</label></td>
            </tr> 

            @endforeach
          
            <tr>
                <td colspan="8" style="text-align: right;"><strong><label>Tổng giá trị đơn hàng :</label></strong></td>
                <td><label value="cateNews">{{number_format($objOrder[0]->total,0,'.', ',')}} VND</label></td>
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
            <span class="field">  
                <input type="button" id="btPrint" class="stdbtn btn_orange" value="In đơn hàng"  />
            </span>
        </p>
        <p>
            @if(isset($objOrder)&& $objOrder[0]->orderStatus!=1)
            <?php $check = FALSE ?>
            @foreach($objOrder as $item)
            @foreach($arrayStore as $itemStore)
            @if ($itemStore->productID == $item->productID && $itemStore->sizeID == $item->sizeID && $itemStore->colorID == $item->colorID)
            @if (($itemStore->soluongnhap - $itemStore->soluongban) < $item->amount) <?php $check = TRUE; ?> 
            @endif 
            @endif 
            @endforeach
            @endforeach
            @if($check==True) 
            <a href = "#" class = "stdbtn btn_red">Hết hàng</a>
            @else
            <input type = "submit" class = "btn" value = "Cập nhật"  >
            @endif
            <a href = "{{URL::action('OrderController@getViewAll')}}" class = "stdbtn">Quay lại</a>
            @else
            <a href = "{{URL::action('OrderController@getViewAll')}}" class = "stdbtn">Quay lại</a>
            @endif
        </p>
    </form>

    <div style="display: none" id="dialog-form" title="Thông tin đơn hàng">
        <div class="contenttitle2">
            <h3>Thông tin đơn hàng</h3>
        </div>
           <form class="stdform" accept-charset="UTF-8" action="#" method="post">
        <p>
            <label>Tài khoản :</label>
            <span class="field">         
                <input type="hidden" name="idOrderCode" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->orderCode}}@endif">
                <strong>@if(isset($objOrder)){{$objOrder[0]->userEmail}}@endif</strong>
            </span>
        </p>
        <p>
            <label>Mã Đơn Hàng :</label>
            <span class="field">         
                <strong>@if(isset($objOrder)){{$objOrder[0]->orderCode}}@endif</strong>
            </span>
        </p>
        <p>
            <label>Người mua :</label>
            <span class="field">         
                <strong>@if(isset($objOrder)){{$objOrder[0]->userLastName.' '.$objOrder[0]->userFirstName}}@endif</strong>
            </span>
        </p>
        <p>
            <label>Điện thoại liên hệ :</label>
            <span class="field">         
                <strong>@if(isset($objOrder)){{$objOrder[0]->userPhone}}@endif</strong>
            </span>
        </p>
        <p>
            <label>Người nhận :</label>
            <span class="field">         
                <strong>@if(isset($objOrder)){{$objOrder[0]->receiverName}}@endif</strong>
            </span>
        </p>

        <p>
            <label>Điện thoại người nhận :</label>
            <span class="field">         
                <strong>@if(isset($objOrder)){{$objOrder[0]->receiverPhone}}@endif</strong>
            </span>
        </p>
        <p>
            <label>Địa chỉ nhận hàng :</label>
            <span class="field">         
                <strong>@if(isset($objOrder)){{$objOrder[0]->orderAddress}}@endif</strong>
            </span>
        </p>
           </form>
        <div class="contenttitle2">
            <h3>Thông tin sản phẩm</h3>
        </div>
        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable">
            <colgroup>
                <col class="con0" style="width: 5%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 10%">
                <col class="con1" style="width: 15%">
            </colgroup>
            <thead>
                <tr>

                    <th class="head0">STT</th>
                    <th class="head1">Mã sản phẩm</th>
                    <th class="head0">Tên sản phẩm</th>
                    <th class="head1">Size</th>
                    <th class="head0">Màu</th>
                    <th class="head1">Giá</th>
                    <th class="head0">Số lượng</th>
                    <th class="head0">Tổng tiền</th>
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
                    <td><label value="cateNews">{{number_format($item->amount,0,'.', ',')}} </label></td>
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
                    <td colspan="7" style="text-align: right;"><strong><label>Tổng giá trị đơn hàng :</label></strong></td>
                    <td><label value="cateNews">{{$total}}</label></td>
                </tr>
            </tbody>
        </table>
        <strong><label style="float: left;margin-left: 40px;margin-top: 20px;"> Người nhận </label></strong>
        <strong><label style="float: right;margin-right: 40px;margin-top: 20px;"> Người giao hàng </label></strong>
    </div>
</div>
<script src="{{Asset('adminlib/printjscss/jquery.PrintArea.js')}}" type="text/JavaScript" language="javascript"></script>
<script>
jQuery("#btPrint")
        .button()
        .click(function() {
            jQuery("#dialog-form").dialog("open");
        });
jQuery("#dialog-form").dialog({
      resizable: true,
    autoOpen: false,
    width: 992,
    modal: true,
    buttons: {
        "In đơn hàng": function(e) {
            jQuery('#dialog-form').html(jQuery(this)[0].innerHTML).printArea();
        },
        Hủy: function() {
            jQuery(this).dialog("close");
        }
    },
    Đóng: function() {
        allFields.val("").removeClass("ui-state-error");
    }
});

</script>

@endsection