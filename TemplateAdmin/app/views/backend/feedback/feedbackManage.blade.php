@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("Đang tải dữ liệu ...");
        var urlpost = "{{URL::action('FeedbackController@postAjaxPhanHoi')}}?page=" + page
        if (jQuery('#datepicker').val() != '' && jQuery('#datepicker1').val() != '') {
            urlpost = "{{URL::action('FeedbackController@postAjaxLocPhanHoi')}}?fromtime=" + jQuery('#datepicker').val() + "&totime=" + jQuery('#datepicker1').val() + "&page=" + page;
        }
        if (jQuery('#searchblur').val() != '') {
            urlpost = "{{URL::action('FeedbackController@postAjaxSearchPhanHoi')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
        }
        var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery("#jGrowl").remove();
            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            jQuery('#tablefeedback').html(msg);
        });
    }
    function locdulieu() {
        jQuery('#searchblur').val("");
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("Đang tải dữ liệu ...");
        var request = jQuery.ajax({
            url: "{{URL::action('FeedbackController@postAjaxLocPhanHoi')}}?fromtime=" + jQuery('#datepicker').val() + "&totime=" + jQuery('#datepicker1').val(),
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery("#jGrowl").remove();
            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            jQuery('#tablefeedback').html(msg);
        });
    }
    function timkiem() {
        jQuery('#datepicker').val('')
        jQuery('#datepicker1').val('')
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("Đang tải dữ liệu ...");
        var request = jQuery.ajax({
            url: "{{URL::action('FeedbackController@postAjaxSearchPhanHoi')}}?keyword=" + jQuery('#searchblur').val(),
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery("#jGrowl").remove();
            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            jQuery('#tablefeedback').html(msg);
        });
    }
    function xoasanpham(id) {
        jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
            if (r == true) {
                jQuery("#jGrowl").remove();
                jQuery.jGrowl("Đang tải dữ liệu ...");
                var request = jQuery.ajax({
                    url: "{{URL::action('FeedbackController@postXoaPhanHoi')}}?id=" + id,
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {
                    jQuery("#jGrowl").remove();
                    jQuery.jGrowl("Đã tải dữ liệu thành công ...");
                    jQuery('#tablefeedback').html(msg);
                });
                return false;
            } else {
                return false;
            }
        })
    }
    jQuery(document).ready(function() {

        jQuery('#searchblur').keypress(function(e) {
            if (e.which == 10 || e.which == 13) {
            jQuery('#datepicker').val('')
                    jQuery('#datepicker1').val('')
                    jQuery("#jGrowl").remove();
                    jQuery.jGrowl("Đang tải dữ liệu ...");
                    var request = jQuery.ajax({
                    url: "{{URL::action('FeedbackController@postAjaxSearchPhanHoi')}}?keyword=" + jQuery('#searchblur').val(),
                            type: "POST",
                            dataType: "html"
                    });
                    request.done(function(msg) {
                    jQuery("#jGrowl").remove();
                    jQuery.jGrowl("Đã tải dữ liệu thành công ...");
                    jQuery('#tablefeedback').html(msg);
                });
        }
    });
    });</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ PHẢN HỒI</h1>
    <span class="pagedesc">Quản lý các phản hồi</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Bảng phản hồi</h3>
        </div>
        <div class="tableoptions">
            <form class="stdform stdform2" action="javascript:void(0)" method="post">
                Từ : <input id="datepicker" name="timeform" type="text" class="longinput" /> 
                &nbsp;   Đến : <input id="datepicker1"  name="timeto" type="text" class="datepicker"  /> 
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
                <col class="con1" style="width: 3%">
                <col class="con0" style="width: 13%">
                <col class="con1" style="width: 13%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 18%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 8%">
                <col class="con0" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head1">STT</th>
                    <th class="head0">Email</th>
                    <th class="head1">Tên</th>
                    <th class="head0">Tiêu đề</th>
                    <th class="head1">Nội dung</th>
                    <th class="head0">Thời gian</th>
                    <th class="head1">Tình trạng</th>
                    <th class="head0">Chức năng</th>
                </tr>  
            </thead>
            <tbody id="tablefeedback">

                <?php $i = 1 ?>
                @foreach($arrayFeedback as $item)
                <tr> 
                    <td><label value="cateNews">{{$i++ }}</label></td> 
                    <td><label value="cateNews">{{str_limit( $item->feedbackUserEmail, 30, '...')}}</label></td> 
                    <td><label value="cateNews">{{str_limit($item->feedbackUserName,30,'...' )}}</label></td> 
                    <td><label value="cateNews">{{str_limit($item->feedbackSubject, 30, '...')}} </label></td>
                    <td><label value="cateNews">{{str_limit($item->feedbackContent, 30, '...')}} </label></td> 
                    <td><label value="cateNews"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td> 
                    <td><label value="cateNews"><?php
                            if ($item->status == 0) {
                                echo "chờ phản hồi";
                            } else if ($item->status == 1) {
                                echo "đã trả lời";
                            } else if ($item->status == 2) {
                                echo "đã xóa";
                            }
                            ?>
                        </label>
                    </td> 
                    <td>
                        <a href="{{URL::action('FeedbackController@getTraLoi')}}?id={{$item->id}}" class="btn btn4 btn_mail" title="Trả lời"></a>
                        @if($item->status!='2')
                        <a href="javascript:void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif

                    </td> 
                </tr> 
                @endforeach
                @if($links!='')
                <tr>
                    <td colspan="8">{{$links}}</td>
                </tr>
                @endif
                @if(count($arrayFeedback)==0)
                <tr>
                    <td colspan="8">Không có dữ liệu trả về .</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
