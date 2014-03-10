@extends("templateadmin2.mainfire")
@section("contentadmin")
<script type="text/javascript">
    jQuery(document).ready(function() {
    jQuery("#loctheotieuchi").click(function() {
    var request = jQuery.ajax({
    url: "{{URL::action('OrderController@postFillterOrderServices')}}",
            data: {oderbyoption1: jQuery('#oderbyoption1').val()},
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
    });
            jQuery('#searchblur').keypress(function(e) {
    // Enter pressed?
    if (e.which == 10 || e.which == 13) {
    var request = jQuery.ajax({
    url: "{{URL::action('OrderController@postSearchOrderServices')}}?keyword=" + jQuery('#searchblur').val(),
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
    }
    });
    });
            function xoasanpham(id){
            jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
            if (r == true) {
            var request = jQuery.ajax({
            url: "{{URL::action('OrderController@postDelServices')}}?id=" + id,
                    type: "POST",
                    dataType: "html"
            });
                    request.done(function(msg) {
                    jQuery('#tableproduct').html(msg);
                    });
                    return false;
            } else {
            return false;
            }
            })
            }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ ĐƠN HÀNG</h1>
    <span class="pagedesc">Quản lý đơn hàng</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Chỉnh sửa thông tin đơn hàng</h3>
        </div>
        <div class="tableoptions"> 
            <select class="radius3" name="oderbyoption1" id="oderbyoption1">
                <option value="">Tất cả</option>
                <option value="0">Chờ</option>
                <option value="1">Thành công</option>
                <option value="2">Xóa</option>
            </select>&nbsp;
            <button class="radius3" id="loctheotieuchi">Lọc theo tiêu chí</button>
            <div class="dataTables_filter" id="searchformfile"><label>Search: <input id="searchblur" name="searchblur" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;" type="text"></label></div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable stdtablecb">
            <colgroup>

                <col class="con1" style="width: 4%">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
            </colgroup>
            <thead>
                <tr>

                    <th class="head1">ID</th>
                    <th class="head0">Tài khoản</th>
                    <th class="head1">Order ID</th>
                    <th class="head0">Tên dịch vụ</th>
                    <th class="head1">Tông tiền</th>
                    <th class="head0">Hình thức thanh toán</th>
                    <th class="head1">Trang thái thanh toán</th>
                    <th class="head0">Thời gian</th>
                    <th class="head1">Trạng thái</th>
                    <th class="head0">Action</th>
                </tr>
            </thead>

            <tbody id="tableproduct">
                @foreach($orderdata as $item)
                <tr >
                    <td class="center">{{$item->id}}</td>
                    <td class="center">{{$item->userEmail}}  </td>
                    <td class="center"><a href="{{URL::action('OrderController@getEdit')}}/{{$item->orderID}}" >{{$item->orderID}}</a></td>
                    <td class="center">{{$item->servicesName}}</td>
                    <td class="center">{{$item->servicesorderAmount}}</td>
                    <td class="center">{{$item->servicesorderTypePay}}</td>
                    <td class="center">{{$item->servicesorderStatusPay}} </td>
                    <td class="center">{{date('d/m/Y',$item->servicesorderTime)}} </td>
                    <td class="center">
                        @if($item->status==0)
                        Chờ
                        @endif
                        @if($item->status==1)
                        Đã xong
                        @endif 
                        @if($item->status==2)
                        Xóa
                        @endif

                    </td>
                    <td class="center"><a href="{{URL::action('OrderController@getOderServicesEdit')}}/{{$item->id}}" >Chỉnh sửa</a> &nbsp; <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})">Xóa</a></td>
                </tr>
                @endforeach
                @if($page!='')
                <tr>
                    <td colspan="11">
                        {{$page}}
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection