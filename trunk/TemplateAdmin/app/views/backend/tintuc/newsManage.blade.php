@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("Đang tải dữ liệu ...");
        var urlpost = "{{URL::action('NewsController@postAjaxNews')}}?page=" + page
        if (jQuery('#datepicker').val() != '' && jQuery('#datepicker1').val() != '') {
            urlpost = "{{URL::action('NewsController@postAjaxNewsFilter')}}?fromtime=" + jQuery('#datepicker').val() + "&totime=" + jQuery('#datepicker1').val() + "&status=" + jQuery('#status').val() + "&page=" + page;
        }
        if (jQuery('#searchblur').val() != '') {
            urlpost = "{{URL::action('NewsController@postAjaxSearchNews')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
        }
         if (jQuery('#status').val() != '') {
            urlpost = "{{URL::action('NewsController@postAjaxNewsFilter')}}?status=" + jQuery('#status').val() + "&page=" + page;
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
            url: "{{URL::action('NewsController@postAjaxNewsFilter')}}?fromtime=" + jQuery('#datepicker').val() + "&totime=" + jQuery('#datepicker1').val() + "&status=" + jQuery('#status').val(),
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
            url: "{{URL::action('NewsController@postAjaxSearchNews')}}?keyword=" + jQuery('#searchblur').val(),
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
                    url: "{{URL::action('NewsController@postAjaxSearchNews')}}?keyword=" + jQuery('#searchblur').val(),
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
    url: "{{URL::action('NewsController@postDeleteNews')}}?id=" + id,
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
    url: "{{URL::action('NewsController@postNewsActive')}}?id=" + id + '&status=' + stus,
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
    <h1 class="pagetitle">TIN TỨC</h1>
    <span class="pagedesc">Quản lý tin tức</span>
</div>

<div class="contentwrapper">
    @if($thongbao!='')
    <div class="notibar msgalert">
        <a class="close"></a>
        <p>{{$thongbao}} </p>
    </div>
    @endif
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Bảng tin tức</h3>
        </div>

        <div class="tableoptions">
            <form class="stdform stdform2" action="javascript:void(0)" method="post">
                Từ : <input id="datepicker" name="timeform" type="text" class="longinput" /> 
                &nbsp;   Đến : <input id="datepicker1"  name="timeto" type="text" class="datepicker"  /> 
                &nbsp; <select name="status" id="status">
                    <option value="3">Tất cả</option>
                    <option value="0">Chờ đăng</option>
                    <option value="1">Đã đăng</option>
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
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 2%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 15%">
                <col class="con0" style="width: 13%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0">STT</th>
                    <th class="head1">Tiêu đề</th>
                    <th class="head0">Nhóm tin tức</th>
                    <th class="head1">Miêu tả</th>
                    <th class="head0">Khởi tạo</th>
                    <th class="head1">Tác giả</th>
                    <th class="head0">Tình trạng</th>
                    <th class="head1">Chức năng</th>
                </tr>  
            </thead>

            <tbody id="tableproduct">
                <?php $i = 1 ?>
                @foreach($arrayNews as $item)
                <tr> 
                    <td><label value="cateNews">{{$i++}}</label></td> 
                    <td><label value="cateNews"><a href="{{URL::action('NewsController@getNewsEdit')}}/{{$item->id}}">{{str_limit( $item->newsName, 30, '...')}}</a></label></td> 
                    <td><label value="cateNews">{{$item->cateNewsName }}</label></td> 
                    <td><label value="cateNews">{{str_limit($item->newsDescription, 30, '...')}} </label></td>
                    <td><label value="cateNews">{{str_limit($item->adminName, 30, '...')}} </label></td> 
                    <td><label value="cateNews"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td> 
                    <td><label value="cateNews"><?php
                            if ($item->status == 0) {
                                echo "chờ đăng";
                            } else if ($item->status == 1) {
                                echo "đã đăng";
                            } else if ($item->status == 2) {
                                echo "đã xóa";
                            }
                            ?>
                        </label>
                    </td> 
                    <td>
                        <a href="{{URL::action('NewsController@getNewsEdit')}}/{{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="Kích hoạt"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="Đăng bài"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif
                    </td> 
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="8">{{$link}}</td>
                </tr>
                @endif
                @if(count($arrayNews)==0)
                <tr>
                    <td colspan="8">Không có dữ liệu trả về .</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
