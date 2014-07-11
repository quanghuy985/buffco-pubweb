@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">Tín Dụng</h1>
    <span class="pagedesc">Quản lý tín dụng</span>
</div>
<div class="contentwrapper">
    @if(isset($msg))
    <div class="notibar msgalert">
        <a class="close"></a>
        <p>{{$msg}}</p>
    </div>
    @endif 
    <div class="subcontent">

        <div class="contenttitle2">
            <h3>Chi tiết người vay :  @if(isset($arrTinDung)){{str_limit( $arrTinDung[0]->userLastName.' '.$arrTinDung[0]->userFirstName, 30, '...')}}@endif</h3>
        </div>
    </div>


    @if(isset($arrTinDungDaVay))
    <blockquote class="bq2 currentstatus marginbottom0">
        Tổng số tín dụng đang vay : {{$arrTinDungDaVay->tongtindung}} khoản &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Tổng số tiền đã vay :{{number_format($arrTinDungDaVay->tonggiatri,0,'.', ',')}} VNĐ
    </blockquote>

    @endif

    @if(isset($arrTinDungChuaTra))
    <blockquote class="bq2 currentstatus marginbottom0">
        Tổng số tín dụng chưa hết : {{$arrTinDungChuaTra->tongtindung}} khoản &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Tổng số tiền chưa thanh toán :{{number_format($arrTinDungChuaTra->tonggiatri,0,'.', ',')}} VNĐ
    </blockquote>
    @endif

    @if(isset($arrTinDungNoXau))
    <blockquote class="bq2 currentstatus marginbottom0">
        Tổng số khoản nợ xấu :<a href="#" style="color: red"> {{$arrTinDungNoXau->tongtindung}} khoản </a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Tổng số tiền nợ xấu : <a href="#" style="color: red">{{number_format($arrTinDungNoXau->tonggiatri,0,'.', ',')}} VNĐ</a>
    </blockquote>
    @endif
    <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
        <colgroup>
            <col class="con1" style="width: 3%">
            <col class="con0" style="width: 12%">
            <col class="con1" style="width: 10%">
            <col class="con0" style="width: 10%">
            <col class="con1" style="width: 10%">
            <col class="con0" style="width: 7%">
            <col class="con1" style="width: 7%">
            <col class="con0" style="width: 8%">
            <col class="con1" style="width: 8%">
            <col class="con0" style="width: 10%">
            <col class="con1" style="width: 15%">

        </colgroup>
        <thead>
            <tr>
                <th class="head1"></th> 
                <th class="head0">Họ tên</th>
                <th class="head1">Miêu tả</th>
                <th class="head0">Khoản vay</th>
                <th class="head1">Thu về</th>
                <th class="head0">Chu kỳ</th>
                <th class="head1">Lãi xuất</th>
                <th class="head0">Từ ngày</th>
                <th class="head1">Đến ngày</th>
                <th class="head0">Tình trạng</th>
                <th class="head1">Chức năng</th>
            </tr>  
        </thead>

        <tbody id="tableKhoanVay"> 

            <?php $i = 1 ?>
            @if(isset($arrTinDung))
            @foreach($arrTinDung as $itemKhoanVay)
            <tr> 
                <td>{{$i}}</td> 
                <td><label value="manuf">{{str_limit( $itemKhoanVay->userLastName.' '.$itemKhoanVay->userFirstName, 30, '...')}}</label></td> 
                <td><label value="manuf">{{str_limit( $itemKhoanVay->vaytienDescription, 30, '...')}}</label></td> 
                <td><label value="manuf"><a style="color: blue" href="{{URL::action('vaytienController@getKhoanVayEdit')}}?id={{$itemKhoanVay->id}}">{{number_format($itemKhoanVay->giatri,0,'.', ',')}} VNĐ</a> </label></td> 
                <td><label value="manuf">{{number_format($itemKhoanVay->thuve,0,'.', ',')}} VNĐ </label></td> 
                <td><label value="manuf">{{str_limit($itemKhoanVay->chuky, 30, '...')}} ngày </label></td> 
                <td><label value="manuf">{{number_format($itemKhoanVay->laixuat,0,'.', ',')}}/ 1 triệu </label></td> 
                <td><label value="manuf"></label><?php echo date('d/m/Y', $itemKhoanVay->from); ?></td> 
                <td><label value="manuf"></label><?php echo date('d/m/Y', $itemKhoanVay->to); ?></td>
                <td><label value="manuf">
                        <?php
                        if ($itemKhoanVay->status == 0) {
                            echo "Chưa thanh toán";
                        } else if ($itemKhoanVay->status == 1) {
                            echo "Đã thanh toán";
                        } else if ($itemKhoanVay->status == 2) {
                            echo "Xóa";
                        } else if ($itemKhoanVay->status == 3) {
                            echo "Nợ xấu";
                        }
                        ?>
                    </label>
                </td> 
                <td>
                    <input type="button" onclick="abc('{{$itemKhoanVay->id}}')" id="btPrint" class="stdbtn btn_orange ui-button ui-widget ui-state-default ui-corner-all" value="Xem chi tiết" role="button" aria-disabled="false">
                </td> 
            </tr> 
            <?php $i++ ?>
            @endforeach
            @if($link!='')
            <tr>
                <td colspan="10">{{$link}}</td>
            </tr>
            @endif

            @endif
        </tbody>
    </table>
    <div style="display: none" id="dialog-form-detail" title="Thông tin chi tiết">

    </div>
    <script src="{{Asset('adminlib/printjscss/jquery.PrintArea.js')}}" type="text/JavaScript" language="javascript"></script>
    <script>
                                jQuery("#dialog-form-detail").dialog({
                        resizable: true,
                                autoOpen: false,
                                width: 500,
                                modal: true,
                                buttons: {
                                "In đơn hàng": function(e) {
                                jQuery('#dialog-form-detail').html(jQuery(this)[0].innerHTML).printArea();
                                },
                                        Hủy: function() {
                                        jQuery(this).dialog("close");
                                        }
                                },
                                Đóng: function() {
                                allFields.val("").removeClass("ui-state-error");
                                }
                        });
                                function abc(id) {

                                var request = jQuery.ajax({
                                url: "{{URL::action('vaytienController@postChiTietTinDung')}}?id=" + id,
                                        type: "POST",
                                        dataType: "html"
                                });
                                        request.done(function(msg) {
                                        jQuery('#dialog-form-detail').html(msg);
                                                jQuery("#dialog-form-detail").dialog("open");
                                        });
                                }

    </script>
</div>
@endsection

