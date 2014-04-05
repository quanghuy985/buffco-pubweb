@extends("templateadmin2.mainfire")
@section("contentadmin")
<script type="text/javascript">
    function phantrang(page) {
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("Đang tải dữ liệu ...");
        var urlpost = "{{URL::action('OrderController@postAjaxOrder')}}?page=" + page
        if (jQuery('#datepicker').val() != '' && jQuery('#datepicker1').val() != '') {
            urlpost = "{{URL::action('OrderController@postAjaxOrderFilter')}}?fromtime=" + jQuery('#datepicker').val() + "&totime=" + jQuery('#datepicker1').val() + "&status=" + jQuery('#status').val() + "&page=" + page;
        }
        if (jQuery('#searchblur').val() != '') {
            urlpost = "{{URL::action('OrderController@postAjaxSearchOrder')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
        }
        var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery("#jGrowl").remove();
            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            jQuery('#tableproduct').html(msg);
        });
    }
    function locdulieu() {
        jQuery('#searchblur').val("");
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("Đang tải dữ liệu ...");
        var request = jQuery.ajax({
            url: "{{URL::action('OrderController@postAjaxOrderFilter')}}?fromtime=" + jQuery('#datepicker').val() + "&totime=" + jQuery('#datepicker1').val() + "&status=" + jQuery('#status').val(),
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery("#jGrowl").remove();
            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            jQuery('#tableproduct').html(msg);
        });
    }
    function timkiem() {
        jQuery('#datepicker').val('')
        jQuery('#datepicker1').val('')
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("Đang tải dữ liệu ...");
        var request = jQuery.ajax({
            url: "{{URL::action('OrderController@postAjaxSearchOrder')}}?keyword=" + jQuery('#searchblur').val(),
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery("#jGrowl").remove();
            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            jQuery('#tableproduct').html(msg);
        });
    }
    jQuery(document).ready(function() {

        jQuery('#searchblur').keypress(function(e) {
            if (e.which == 10 || e.which == 13) {
                jQuery('#datepicker').val('')
                jQuery('#datepicker1').val('')
                jQuery("#jGrowl").remove();
                jQuery.jGrowl("Đang tải dữ liệu ...");
                var request = jQuery.ajax({
                    url: "{{URL::action('OrderController@postAjaxSearchOrder')}}?keyword=" + jQuery('#searchblur').val(),
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {
                    jQuery("#jGrowl").remove();
                    jQuery.jGrowl("Đã tải dữ liệu thành công ...");
                    jQuery('#tableproduct').html(msg);
                });
            }
        });
    });
    function xoasanpham(id) {
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('OrderController@postDel')}}?id=" + id,
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
    @if(isset($thongbao))
    <div class="notibar msgalert">
        <a class="close"></a>
        <p>{{$thongbao}}</p>
    </div>
    @endif
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Quản lý đơn đặt hàng</h3>
        </div>
        <div class="tableoptions"> 
            <form class="stdform stdform2" action="javascript:void(0)" method="post">
                Từ : <input id="datepicker" name="timeform" type="text" class="longinput" /> 
                &nbsp;   Đến : <input id="datepicker1"  name="timeto" type="text" class="datepicker"  /> 
                &nbsp; <select name="status" id="status">
                    <option value="3">Tất cả</option>
                    <option value="0" selected>Chờ xử lý</option>
                    <option value="1">Đã xử lý</option>
                    <option value="2">Đã xóa</option>
                </select>
                &nbsp; &nbsp; <button class="radius3" id="loctheotieuchi" onclick="locdulieu()">Lọc dữ liệu</button>

            </form>
            <div class="dataTables_filter1" id="searchformfile">
                <label>Search: 
                    <input class="longinput" id="searchblur"  name="searchblur" style="-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fcfcfc;color: #666;-moz-box-shadow: inset 0 1px 3px #ddd;-webkit-box-shadow: inset 0 1px 3px #ddd;box-shadow: inset 0 1px 3px #ddd;" type="text"><a href="javascript:void(0)" class="btn btn4 btn_search" onclick="timkiem()" style=" float: right;    height: 30px;   margin-left: 10px;"></a>
                </label>
            </div>
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

                    <th class="head1">STT</th>
                    <th class="head0">Tài khoản</th>
                    <th class="head1">Họ</th>
                    <th class="head0">Đệm và Tên</th>
                    <th class="head1">Mã Đơn Hàng</th>
                    <th class="head0">Thời điểm</th>
                    <th class="head1">Trạng thái</th>
                    <th class="head0">Action</th>
                </tr>
            </thead>

            <tbody id="tableproduct">
                <?php $i = 1 ?>
                @foreach($arrOrder as $item)
                <tr>
                    <td class="center">{{$i++}}</td>
                    <td class="center">{{$item->userEmail}}</td>
                    <td class="center">{{$item->userFirstName}}</td>
                    <td class="center">{{$item->userLastName}}  </td> 
                    <td class="center"><a href="{{URL::action('OrderController@getEdit')}}/{{$item->orderCode}}">{{$item->orderCode}}</a></td>
                    <td class="center">{{date('d/m/Y',$item->time)}} </td>
                    <td class="center">
                        @if($item->status==0)
                        Chờ xử lý
                        @endif
                        @if($item->status==1)
                        Đã xử lý
                        @endif 
                        @if($item->status==2)
                        Xóa
                        @endif

                    </td>
                    <td class="center">
                        <a href="{{URL::action('OrderController@getEdit')}}/{{$item->orderCode}}" class="btn btn4 btn_orderdetail" title="Chi tiết đơn hàng"></a>
                        &nbsp; 
                        @if($item->status =='0')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif
                    </td>
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