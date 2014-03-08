@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    jQuery(document).ready(function() {
        jQuery('#searchblur').keypress(function(e) {
            // Enter pressed?
            if (e.which == 10 || e.which == 13) {
                var request = jQuery.ajax({
                    url: "{{URL::action('UserController@postAjaxsearch')}}?keywordsearch=" + jQuery('#searchblur').val(),
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {
                    jQuery('#tableproduct').html(msg);
                });
            }
        });
        jQuery("#fillterfunction").click(function() {
            alert(jQuery('#oderbyoption').val());
        });
        jQuery("#loctheotieuchi").click(function() {
            var request = jQuery.ajax({
                url: "{{URL::action('UserController@postFillterUser')}}",
                data: {oderbyoption1: jQuery('#oderbyoption1').val()},
                type: "POST",
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery('#tableproduct').html(msg);
            });
        });
    });
    function phantrang(page) {
    var request = jQuery.ajax({
    url: "{{URL::action('UserController@postAjaxpagion')}}?page=" + page,
            type: "POST",
            dataType: "html"
    }
    );
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
    }
    function xoasanpham(id) {
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('UserController@postDeleteUser')}}?id=" + id,
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
    function kichhoat(id, stus) {
    var request = jQuery.ajax({
    url: "{{URL::action('UserController@postUserActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
            return true;
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">THÀNH VIÊN</h1>
    <span class="pagedesc">Quản lý thành viên</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Bảng thành viên</h3>
        </div>
        <div class="tableoptions">
            <select class="radius3" name="oderbyoption1" id="oderbyoption1">
                <option value="">Tất cả</option>
                <option value="0">Chờ kích hoạt</option>
                <option value="1">Đã kích hoạt</option>
                <option value="2">Khóa</option>
            </select>&nbsp;
            <button class="radius3" id="loctheotieuchi">Lọc theo tiêu chí</button>
            <div class="dataTables_filter" id="searchformfile"><label>Search: <input id="searchblur" name="searchblur" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;" type="text"></label></div>
        </div>
        @if(!isset($Errors))
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 5%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 4%">
                <col class="con0" style="width: 5%">
                <col class="con1" style="width: 5%">
                <col class="con0" style="width: 5%">
                <col class="con1" style="width: 7%">
                <col class="con0" style="width: 12%">
                <col class="con1" style="width: 20%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head1">Email</th>
                    <th class="head0">Tên</th>
                    <th class="head1">Họ và Đệm</th>
                    <th class="head0">Địa chỉ</th>
                    <th class="head1">Điện Thoại</th>
                    <th class="head0">CMND</th>
                    <th class="head1">Điểm</th>
                    <th class="head0">Mã kích hoạt</th>
                    <th class="head1">Ngày khởi tạo</th>
                    <th class="head0">Tình trạng</th>
                    <th class="head1">Chức năng</th>
                </tr>  
            </thead>
            <tbody id="tableproduct">
                @foreach($arrayUsers as $item)
                <tr> 

                    <td><label value="cateUser">{{$item->userEmail }}</label></td> 
                    <td><label value="cateUser">{{$item->userFirstName }}</label></td> 
                    <td><label value="cateUser">{{str_limit($item->userLastName, 10, '...')}}</label></td> 
                    <td><label value="cateUser">{{str_limit($item->userAddress, 10, '...')}} </label></td> 
                    <td><label value="cateUser">{{str_limit($item->userPhone, 10, '...')}}</label></td> 
                    <td><label value="cateUser">{{str_limit($item->userIdentify, 10, '...')}}</label></td> 
                    <td><label value="cateUser">{{str_limit($item->userPoint, 10, '...')}} </label></td> 
                    <td><label value="cateUser">{{str_limit($item->verify, 10, '...')}}</label></td> 
                    <td><label value="cateUser"><?php echo date('d/m/Y', $item->userTime); ?></label></td> 
                    <td><label value="cateUser"><?php
                            if ($item->status == 0) {
                                echo "chờ kích hoạt";
                            } else if ($item->status == 1) {
                                echo "kích hoạt";
                            } else if ($item->status == 2) {
                                echo "khóa";
                            }
                            ?>
                        </label>
                    </td> 
                    <td>

                        <a href="{{URL::action('UserController@getUserEdit')}}?id={{$item->userEmail}}" class="btn btn4 btn_book" title="Sửa"></a>
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->userEmail}}, 0)" class="btn btn4 btn_flag" title="Chờ kích hoạt"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->userEmail}}, 1)" class="btn btn4 btn_world" title="Kích hoạt"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item->userEmail}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif
                    </td> 
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="11">{{$link}}</td>
                </tr>
                @endif

            </tbody>
        </table>
        @else
        <h3>{{$Errors}}</h3>
        @endif
    </div>
</div>
@endsection

