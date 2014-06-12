@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.feedback.title')}}
@stop
@section("contentadmin")
<script>
    function phantrang(page) {

        NProgress.start();
        var urlpost = "{{URL::action('\BackEnd\FeedbackController@postAjaxPhanHoi')}}?page=" + page
        if (jQuery('#datepicker').val() != '' && jQuery('#datepicker1').val() != '') {
            urlpost = "{{URL::action('\BackEnd\FeedbackController@postAjaxLocPhanHoi')}}?fromtime=" + jQuery('#datepicker').val() + "&totime=" + jQuery('#datepicker1').val() + "&page=" + page;
        }
        if (jQuery('#searchblur').val() != '') {
            urlpost = "{{URL::action('\BackEnd\FeedbackController@postAjaxSearchPhanHoi')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
        }
        var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {

            NProgress.done();
            jQuery('#tablefeedback').html(msg);
        });
    }
    function locdulieu() {
        jQuery('#searchblur').val("");

        NProgress.start();
        var request = jQuery.ajax({
            url: "{{URL::action('\BackEnd\FeedbackController@postAjaxLocPhanHoi')}}?fromtime=" + jQuery('#datepicker').val() + "&totime=" + jQuery('#datepicker1').val(),
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {

            NProgress.done();
            jQuery('#tablefeedback').html(msg);
        });
    }
    function timkiem() {
        jQuery('#datepicker').val('')
        jQuery('#datepicker1').val('')

        NProgress.start();
        var request = jQuery.ajax({
            url: "{{URL::action('\BackEnd\FeedbackController@postAjaxSearchPhanHoi')}}?keyword=" + jQuery('#searchblur').val(),
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {

            NProgress.done();
            jQuery('#tablefeedback').html(msg);
        });
    }
    function xoasanpham(id) {
        jConfirm("{{Lang::get('messages.delete_confirm')}}", "{{Lang::get('messages.alert')}}", function(r) {
            if (r == true) {

                NProgress.start();
                var request = jQuery.ajax({
                    url: "{{URL::action('\BackEnd\FeedbackController@postXoaPhanHoi')}}?id=" + id,
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {

                    NProgress.done();
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

                NProgress.start();
                var request = jQuery.ajax({
                    url: "{{URL::action('\BackEnd\FeedbackController@postAjaxSearchPhanHoi')}}?keyword=" + jQuery('#searchblur').val(),
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {

                    NProgress.done();
                    jQuery('#tablefeedback').html(msg);
                });
            }
        });
    });</script>
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.feedback.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.feedback.description')}}</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.feedback.caption')}}</h3>
        </div>
        @include('backend.alert')
        <div class="tableoptions">
            <form class="stdform stdform2" action="javascript:void(0)" method="post">
                {{Lang::get('general.date_from')}} : <input id="datepicker" name="timeform" type="text" class="longinput" />&nbsp;
                {{Lang::get('general.date_to')}} : <input id="datepicker1"  name="timeto" type="text" class="datepicker"  />
                &nbsp; &nbsp; <button class="radius3" id="loctheotieuchi" onclick="locdulieu()">{{Lang::get('general.filter')}}</button>

            </form>
            <div class="dataTables_filter1" id="searchformfile" style=" margin-top: -32px !important;">
                <label>{{Lang::get('general.search')}}:
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
                    <th class="head1">{{Lang::get('general.stt')}}</th>
                    <th class="head0">{{Lang::get('general.email')}}</th>
                    <th class="head1">{{Lang::get('general.feedback_user')}}</th>
                    <th class="head0">{{Lang::get('general.feedback_subject')}}</th>
                    <th class="head1">{{Lang::get('general.content')}}</th>
                    <th class="head0">{{Lang::get('general.time_send')}}</th>
                    <th class="head1">{{Lang::get('general.status')}}</th>
                    <th class="head0">{{Lang::get('general.action')}}</th>
                </tr>  
            </thead>
            <tbody id="tablefeedback">
                @include('backend.feedback.AjaxFeedbackManage')
            </tbody>
        </table>
    </div>
</div>
@endsection
