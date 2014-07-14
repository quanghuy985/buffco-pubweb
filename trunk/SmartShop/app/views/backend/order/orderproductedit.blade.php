@extends("backend.template")
@section("titleAdmin")
{{Lang::get('backend/title.order.title')}}
@stop
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.order.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.order.detail')}}</span>
</div>
<div class="contentwrapper">
    @include('backend.alert')
    <div class="contenttitle2">
        <h3>{{Lang::get('backend/title.order.detail')}}</h3>
    </div>
    @if(isset($objOrder))
<!--    <script>jQuery(document).ready(function(){jQuery('html, body').animate({ scrollTop: jQuery("#adminForm").offset().top}, 1000);})</script>-->
    {{Form::model($objOrder[0],  array( 'class'=>'stdform', 'id'=>'orderViewForm'))}}
    <p>
        {{Form::hidden('orderCode')}}
    </p>
    <p>
        <label>{{Lang::get('general.order.user')}}:</label>
        <span class="field">         
            {{Form::text('email', null, array('id'=>'email','class'=>'longinput','disabled'=>'disabled' ))}}
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.order.code')}}</label>
        <span class="field">
            {{Form::text('orderCode', null, array('id'=>'orderCode','class'=>'longinput','disabled'=>'disabled'))}}
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.order.buyername')}}</label>
        <span class="field">         
            <input type="text" name="orderCode" placeholder="Nhập tên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->lastname.' '.$objOrder[0]->firstname}}@endif" disabled>
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.order.buyerphone')}}</label>
        <span class="field">
            {{Form::text('phone', null, array('id'=>'phone','class'=>'longinput','disabled'=>'disabled'  ))}}
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.order.name')}}</label>
        <span class="field">
            {{Form::text('receiverName', null, array('id'=>'receiverName','class'=>'longinput','disabled'=>'disabled'  ))}}
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.order.phone')}}</label>
        <span class="field">
            {{Form::text('receiverPhone', null, array('id'=>'receiverPhone','class'=>'longinput','disabled'=>'disabled'  ))}}
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.order.address')}}</label>
        <span class="field">
            {{Form::text('orderAddress', null, array('id'=>'orderAddress','class'=>'longinput','disabled'=>'disabled' ))}}
        </span>
    </p>
    {{Form::close()}}
    <div class="contenttitle2">
        <h3>Thông tin sản phẩm</h3>
    </div>
    <table cellpadding="0" cellspacing="0" border="0"  class="stdtable">
        <colgroup>
            <col class="con0" style="width: 1%">
            <col class="con1" style="width: 10%">
            <col class="con0" style="width: 23%">
            <col class="con1" style="width: 10%">
            <col class="con0" style="width: 10%">
            <col class="con1" style="width: 10%">
            <col class="con0" style="width: 10%">
            <col class="con1" style="width: 10%">
            <col class="con0" style="width: 15%">
        </colgroup>
        <thead>
            <tr>

                <th class="head0">{{Lang::get('general.order.stt')}}</th>
                <th class="head1">{{Lang::get('general.product.code')}}</th>
                <th class="head0">{{Lang::get('general.product.name')}}</th>
                <th class="head0">{{Lang::get('general.product.size')}}</th>
                <th class="head0">{{Lang::get('general.product.color')}}</th>
                <th class="head1">{{Lang::get('general.product.price')}}</th>
                <th class="head0">{{Lang::get('general.quantity')}}</th>
                <th class="head1">{{Lang::get('general.store')}}</th>
                <th class="head0">{{Lang::get('general.order.total_price')}}</th>
            </tr>
        </thead>
        <tbody id="tableproduct">
            <?php $i = 1; ?>
            @include('backend.order.orderproducteditAjax')

        </tbody>
    </table>
    {{Form::model($objOrder,  array('action'=>'\BackEnd\OrderController@postUpdateOrder', 'id'=>'orderUpdateForm'))}}
    <p>

        <span class="field">    
            @if(isset($objOrder))      
            <input type="hidden" name="idOrderCode" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($objOrder)){{$objOrder[0]->orderCode}}@endif">

            @endif
        </span>
    </p>

    <p>

    </p>
    <p>
        <input type="button" id="btPrint" class="stdbtn btn_orange" value="In đơn hàng"  />
        @if(isset($objOrder)&& $objOrder[0]->orderStatus!=1)
        <?php $check = FALSE ?>
        @foreach($objOrder as $item)
        <?php
        if ($item->quantity <= $item->quantity_sold) {
            $check == True;
        }
        ?> 
        @endforeach
        @if($check==True) 
        <a href="#" class = "stdbtn btn_red">Hết hàng</a>
        @else
        <input type = "submit" name="btSubmit" class = "btn" value = "{{\Lang::get('button.order.btAccept')}}"  >
        <input type = "submit" name="btSubmit" class = "btn" value = "{{\Lang::get('button.order.btDelete')}}"  >
        <input type = "submit" name="btSubmit" class = "btn" value = "{{\Lang::get('button.order.btDonothing')}}"  >
        @endif
        <a href = "{{URL::action('\BackEnd\OrderController@getViewAll')}}" class = "stdbtn">Quay lại</a>
        @else
        <a href = "{{URL::action('\BackEnd\OrderController@getViewAll')}}" class = "stdbtn">Quay lại</a>
        @endif
    </p>
    {{Form::close()}}


    <div style="display: none" id="dialog-form" title="Thông tin đơn hàng">
        <div class="contenttitle2">
            <h3>Thông tin đơn hàng</h3>
        </div>
        {{Form::model($objOrder[0],  array( 'class'=>'stdform','accept-charset'=>'UTF-8', 'id'=>'orderViewForm'))}}

        <p>
            <label>{{Lang::get('general.order.user')}} :</label>
            <span class="field">         
                <strong>&nbsp;@if(isset($objOrder)){{$objOrder[0]->email}}@endif</strong>
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.order.code')}} :</label>
            <span class="field">
                <strong> &nbsp;@if(isset($objOrder)){{$objOrder[0]->orderCode}}@endif</strong>
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.order.buyername')}} :</label>
            <span class="field">         
                <strong>&nbsp;@if(isset($objOrder)){{$objOrder[0]->lastname.' '.$objOrder[0]->firstname}}@endif</strong>
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.order.buyerphone')}} :</label>
            <span class="field">
                <strong>&nbsp;@if(isset($objOrder)){{$objOrder[0]->phone}}@endif</strong>
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.order.name')}} :</label>
            <span class="field">
                <strong>&nbsp;@if(isset($objOrder)){{$objOrder[0]->receiverName}}@endif</strong>
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.order.phone')}} :</label>
            <span class="field">
                <strong>&nbsp;@if(isset($objOrder)){{$objOrder[0]->receiverPhone}}@endif</strong>
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.order.address')}} :</label>
            <span class="field">
                <strong>&nbsp;@if(isset($objOrder)){{$objOrder[0]->orderAddress}}@endif</strong>
            </span>
        </p>
        {{Form::close()}}
        <div class="contenttitle2">
            <h3>{{Lang::get('general.order.productDetail')}}</h3>
        </div>
        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable">
            <colgroup>
                <col class="con0" style="width: 5%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 25%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 20%">
                <col class="con1" style="width: 20%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0">{{Lang::get('general.order.stt')}}</th>
                    <th class="head1">{{Lang::get('general.product.code')}}</th>
                    <th class="head0">{{Lang::get('general.product.name')}}</th>
                    <th class="head1">{{Lang::get('general.product.price')}}</th>
                    <th class="head0">{{Lang::get('general.quantity')}}</th>
                    <th class="head1">{{Lang::get('general.order.total_price')}}</th>
                </tr>
            </thead>
            <tbody id="tableproduct">
                <?php $i = 1; ?>
                <?php $tongcong = 0; ?>
                @foreach($objOrder as $item)

                <tr>   
                    <td><label value="cateNews"> {{$i++}} </label></td> 
                    <td><label value="cateNews">{{str_limit( $item->productCode, 30, '...')}}</label></td> 
                    <td><label value="cateNews">{{str_limit( $item->productName, 30, '...')}}</label></td>
                    <td><label value="cateNews">{{number_format($item->productPrice,0,'.', ',')}}</label></td> 
                    <td><label value="cateNews">{{number_format($item->amount,0,'.', ',')}} </label></td>
                    <td><label value="cateNews">{{number_format($item->total,0,'.', ',')}} </label></td>
                </tr> 
                <?php $tongcong = $tongcong + $item->total ?>
                @endforeach

                <tr>
                    <td colspan="5" style="text-align: right;"><strong><label>{{Lang::get('general.order.total_grand')}}</label></strong></td>
                    <td><label value="cateNews">{{number_format($tongcong,0,'.', ',')}} </label></td>
                </tr>
            </tbody>
        </table>
        <strong><label style="float: left;margin-left: 40px;margin-top: 20px;"> Người nhận </label></strong>
        <strong><label style="float: right;margin-right: 40px;margin-top: 20px;"> Người giao hàng </label></strong>
    </div>
</div>
@endif
<script src="{{Asset('backend')}}/printjscss/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>
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
            jQuery('#dialog-form').printArea();
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