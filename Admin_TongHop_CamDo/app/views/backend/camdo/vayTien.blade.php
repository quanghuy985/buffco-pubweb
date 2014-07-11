@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    var fromLoc = 0;
            var toLoc = 0;
            var status = '';
            var keyword = '';
            jQuery(document).ready(function() {
    jQuery('#searchblur').keypress(function(e) {
    if (e.which == 10 || e.which == 13) {
    locdulieu();
    }
    });
            jQuery("#datepicker").change(function() {

    var giatri = jQuery("#giatri").val();
            giatri = giatri.replace(/\,/g, '');
            giatri = giatri.replace(' VND', '');
            var laiky = jQuery("#laiky").val();
            laiky = laiky.replace(/\,/g, '');
            laiky = laiky.replace(' VND/1 kỳ', '');
            var chuky = jQuery("#chuky").val();
            var count = giatri / laiky * chuky - 1;
            var result = count * 24 * 60 * 60;
            var times = jQuery("#datepicker").val();
            var timestamps = new Date(times).getTime() / 1000;
            var newtimes = timestamps + result;
            var date = new Date(newtimes * 1000);
            jQuery("#datepicker1").datepicker("setDate", date);
    });
    });
            function phantrang(page) {
            jQuery.jGrowl("Đang tải dữ liệu ...");
                    fromLoc = jQuery('#datepicker2').val();
                    toLoc = jQuery('#datepicker4').val();
                    var urlpost = "{{URL::action('vaytienController@postAjaxpagion')}}?page=" + page + "&fromLoc=" + fromLoc + "&toLoc=" + toLoc + "&keyword=" + keyword + "&status=" + status;
                    var request = jQuery.ajax({
                    url: urlpost,
                            type: "POST",
                            dataType: "html"
                    });
                    request.done(function(msg) {
                    //  
                    jQuery.jGrowl("Đã tải dữ liệu thành công ...");
                            jQuery('#tableKhoanVay').html(msg);
                    });
            }
    function locdulieu() {
    fromLoc = jQuery('#datepicker2').val();
            toLoc = jQuery('#datepicker4').val();
            status = jQuery("#oderbyoption1").val();
            keyword = jQuery('#searchblur').val();
            jQuery.jGrowl("Đang tải dữ liệu ...");
            var request = jQuery.ajax({
            url: "{{URL::action('vaytienController@postAjaxpagion')}}?fromLoc=" + fromLoc + "&toLoc=" + toLoc + "&status=" + status + "&keyword=" + keyword,
                    type: "POST",
                    dataType: "html"
            }
            );
            request.done(function(msg) {
            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
                    jQuery('#tableKhoanVay').html(msg);
            });
    }
    function xoasanpham(id) {
    jConfirm("{{Lang::get('messages.delete_confirm')}}", "{{Lang::get('messages.alert')}}", function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('vaytienController@postDeleteVayTien')}}?id=" + id,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {

            jQuery('#tableKhoanVay').html(msg);
            });
            return false;
    } else {
    return false;
    }
    });
    }

    function kichhoat(id, stus) {
    if (stus == 0) {

    var request = jQuery.ajax({
    url: "{{URL::action('vaytienController@postKhoanVayActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableKhoanVay').html(msg);
            });
            return true;
    } else {
    jConfirm("{{Lang::get('messages.thanhtoan_confirm')}}", "{{Lang::get('messages.alert')}}", function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('vaytienController@postKhoanVayActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableKhoanVay').html(msg);
            });
            return true;
    } else {
    return false;
    }
    });
    }

    }

</script>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="{{Asset('adminlib/js/plugins/autoNumeric-1.9.22.js')}}" type=text/javascript></script>
<script>
            jq162 = jQuery.noConflict(true);</script>

<div class="pageheader notab">
    <h1 class="pagetitle">Tín dụng</h1>
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
        <div class="contenttitle2" id="editManuf">
            <h3>{{Lang::get('general.vaytien_titleForm')}}</h3>
        </div>
        @include('templateadmin2.alert')
        @if(isset($objTinDung))
        {{Form::model($objTinDung, array('action'=>array('vaytienController@postUpdateKhoanVay', $objTinDung->id), 'id'=>'updateKhoanVayForm', 'class'=>'stdform stdform2'))}}
        <?php
        $objTinDung->from = date('m/d/Y', $objTinDung->from);
        $objTinDung->to = date('m/d/Y', $objTinDung->to);
        ?>
        @else
        {{Form::open(array('action'=>'vaytienController@postAddKhoanVay', 'id'=>'addKhoanVayForm', 'class'=>'stdform stdform2'))}}
        @endif

        {{Form::hidden('id', null, array('id'=>'id'))}}
        {{Form::hidden('status', null, array('id'=>'status'))}}
        <p></p>
        <p>
            <label>{{Lang::get('general.vaytien_userName')}}</label>
            @if(isset($arrUser))
            <span class="field">
                <select name="userID" id="userID">
                    @foreach($arrUser as $itemUser)
                    <option value="{{$itemUser->id}}" @if(isset($objTinDung)&& $itemUser->id == $objTinDung->userID )selected @endif>{{$itemUser->userFirstName.' '.$itemUser->userLastName}}</option>
                    @endforeach
                </select>
                <button type="button" class="stdbtn" onclick="loadUser()">Làm mới</button>
                <a style="color: #00F;text-decoration: underline;" href="javascript:void{0}" onclick="window.open('{{URL::action('UserController@getUserView')}}', '_newtab');" class="submit radius2" >Thêm khách hàng?</a>
            </span>
            @endif
        </p>

        <script>
                            function loadUser() {
                            var request = jQuery.ajax({
                            url: "{{URL::action('vaytienController@postUserAjax')}}",
                                    type: "POST"
                            });
                                    request.done(function(msg) {
                                    jQuery('#userID').empty().html(msg);
                                            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
                                    }
                                    );
                            }
        </script>
        <p>
            <label>{{Lang::get('general.description')}}</label>
            <span class="field">
                {{Form::text('vaytienDescription', null, array('id'=>'description',  'class'=>'longinput','placeholder'=>'Nhập 1 đoạn miêu tả ngắn gọn'))}}
            </span>
        </p>

        <script>
                    jQuery(function($) {
                    jq162('#giatri').autoNumeric('init', {aSign: ' VND', pSign: 's', dGroup: '4'});
                            jq162('#thuve').autoNumeric('init', {aSign: ' VND', pSign: 's', dGroup: '4'});
                            jq162('#laixuat').autoNumeric('init', {aSign: ' VND/1 Triệu', pSign: 's', dGroup: '4'});
                    });</script>
        <p>
            <label>{{Lang::get('general.vaytien_giatri')}}</label>
            <span class="field">
                {{Form::text('giatri', null, array('id'=>'giatri','placeholder'=>'Nhập giá trị'))}}
            </span>
        </p> 
        @if(isset($objTinDung))
        <p>
            <label>{{Lang::get('general.vaytien_thuve')}}</label>
            <span class="field">
                {{Form::text('thuve', null, array('id'=>'thuve','placeholder'=>'Nhập khoản thu về'))}}
            </span>
        </p> 
        @endif
        <p>
            <label>{{Lang::get('general.vaytien_chuky')}}</label>
            <span class="field">
                {{Form::text('chuky', null, array('id'=>'chuky','placeholder'=>'Nhập 10 nếu chu kỳ thu lãi là 10 ngày'))}}
            </span>
        </p> 
        <p>
            <label>{{Lang::get('general.vaytien_laiky')}}</label>
            <span class="field">
                {{Form::text('laixuat', null, array('id'=>'laixuat','placeholder'=>'Nhập 1000 nếu lãi là 1000 VNĐ/1 triệu'))}}
            </span>
        </p> 
        <p>
            <label>{{Lang::get('general.date_begin')}}</label>
            <span class="field">
                {{Form::text('from', null, array('id'=>'datepicker', 'width'=>'100px'))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.date_end')}}</label>
            <span class="field">
                {{Form::text('to', null, array('id'=>'datepicker1', 'width'=>'100px'))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.vaytien_status')}}</label>
            <span class="field">
                <?php
                $selectData = Lang::get('general.vaytien_data_status');
                unset($selectData['']);
                echo Form::select('status', $selectData);
                ?>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2">@if(isset($objTinDung)){{Lang::get('button.update')}} @else{{Lang::get('button.add')}} @endif</button>
            <input type="reset" class="reset radius2" value="{{Lang::get('button.reset')}}">
            <input type="button" id="btPrint" class="stdbtn btn_orange ui-button ui-widget ui-state-default ui-corner-all" value="In phiếu" role="button" aria-disabled="false">
        </p>

        <div style="display: none" id="dialog-form" title="Thông tin phiếu">
            <div class="contenttitle2">
                <h3>Thông tin tín dụng</h3>
            </div>
            @if(isset($objTinDung))
            <form class="stdform" accept-charset="UTF-8" action="#" method="post">
                <p>
                    <label>{{Lang::get('general.batho_userName')}}</label>
                    <strong style="
                            margin-left: 69px;
                            ">{{$objTinDung->userFirstName.' '.$objTinDung->userLastName}}</strong>

                </p>
                <p>
                    <label>{{Lang::get('general.description')}}</label>
                    <strong style="
                            margin-left: 156px;
                            ">{{$objTinDung->vaytienDescription}}</strong>
                </p>
                <p>
                    <label>{{Lang::get('general.vaytien_giatri')}}</label>
                    <strong style="
                            margin-left: 119px;
                            ">{{number_format($objTinDung->giatri,0,'.', ',')}} VND</strong>
                </p>
                <p>
                    <label>{{Lang::get('general.vaytien_thuve')}}</label>
                    <strong style="
                            margin-left: 119px;
                            ">{{number_format($objTinDung->thuve,0,'.', ',')}} VND</strong>
                </p>
                <p>
                    <label>{{Lang::get('general.vaytien_chuky')}}</label>
                    <strong style="
                            margin-left: 112px;
                            ">{{$objTinDung->chuky}} Ngày</strong>
                </p>
                <p>
                    <label>{{Lang::get('general.vaytien_laiky')}}</label>
                    <strong style="
                            margin-left: 122px;
                            ">{{number_format($objTinDung->laixuat,0,'.', ',')}}/1 Triệu </strong>
                </p>
                <p>
                    <label>{{Lang::get('general.date_begin')}}</label>
                    <strong style="
                            margin-left: 117px;
                            "><?php echo $objTinDung->from; ?></strong>
                </p>
                <p>
                    <label>{{Lang::get('general.date_end')}}</label>
                    <strong style="
                            margin-left: 114px;
                            "><?php echo $objTinDung->to; ?></strong>
                </p>
                <p>
                    <label>{{Lang::get('general.vaytien_status')}}</label>
                    <strong style="
                            margin-left: 132px;
                            ">
                        @if($objTinDung->status==0)
                        {{'Chưa thanh toán'}}
                        @endif
                        @if($objTinDung->status==1)
                        {{'Đã thanh toán'}}
                        @endif
                        @if($objTinDung->status==2)
                        {{'Xóa'}}
                        @endif
                    </strong>
                </p>
                <p>
                    <label> Người lập phiếu </label>
                    <strong style="
                            margin-left: 98px;
                            "><?php
                                $objAdmin = Session::get('adminSession');
                                echo $objAdmin[0]->adminEmail;
                                ?></strong>
                </p>
            </form>
            @endif
        </div>
        <div style="display: none" id="dialogformtiendo" title="Thông tin chi tiết">

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
                            width: 500,
                            modal: true,
                            buttons: {
                            "In": function(e) {
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
                            function abcd(id) {

                            var request = jQuery.ajax({
                            url: "{{URL::action('vaytienController@postCapNhatTienDo')}}?id=" + id,
                                    type: "POST",
                                    dataType: "html"
                            });
                                    request.done(function(msg) {
                                    jQuery('#dialogformtiendo').html(msg);
                                            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
                                            jQuery("#dialogformtiendo").dialog({
                                    resizable: true,
                                            width: 1000,
                                            height: 600,
                                            modal: true,
                                            buttons: {
                                            "In": function(e) {
                                            jQuery('#dialogformtiendo').html(jQuery(this)[0].innerHTML).printArea();
                                            },
                                                    Hủy: function() {
                                                    jQuery(this).dialog("close");
                                                    }
                                            },
                                            Đóng: function() {
                                            allFields.val("").removeClass("ui-state-error");
                                            }
                                    });
                                    });
                            }

        </script>
        {{Form::close()}}
    </div>
</div>

@endsection

