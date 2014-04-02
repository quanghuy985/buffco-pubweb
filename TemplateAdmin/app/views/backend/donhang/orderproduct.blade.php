@extends("templateadmin2.mainfire")
@section("contentadmin")
<script type="text/javascript">
    function phantrang(page) {
        var request = jQuery.ajax({
            url: "{{URL::action('OrderController@postPagin')}}?page=" + page,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
        });
    }
    function kichhoat(id, stus) {
        var request = jQuery.ajax({
            url: "{{URL::action('OrderController@postOrderActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
        });
        return true;
    }
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
    jQuery(document).ready(function() {
        jQuery("#loctheotieuchi").click(function() {
        var request = jQuery.ajax({
            url: "{{URL::action('OrderController@postFillterOrder')}}",
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
                url: "{{URL::action('OrderController@postSearchOrder')}}?keyword=" + jQuery('#searchblur').val(),
                type: "POST",
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery('#tableproduct').html(msg);
            });
        }
    });
    });</script>
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
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)"  title="Đăng bài"> <img src="{{Asset('adminlib/images/icons/active.png')}}" width="35px"></img></a>
                        @endif
                        @if($item->status!='2')
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