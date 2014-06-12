@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.supporter.title')}}
@stop
@section("contentadmin")
<script>
    function phantrang(page) {
        var request = jQuery.ajax({
            url: "{{URL::action('\BackEnd\SupporterController@postAjaxpagion')}}?page=" + page,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
        });
    }
    function xoasanpham(id) {
        jConfirm("{{Lang::get('messages.delete_confirm')}}", "{{Lang::get('messages.alert')}}", function(r) {
            if (r == true) {
                var request = jQuery.ajax({
                    url: "{{URL::action('\BackEnd\SupporterController@postDeleteSupporter')}}?id=" + id,
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {
                    jQuery('#tableproduct').html(msg);
                    jQuery('#messages1').empty().html(" <div class='notibar msgsuccess'><a class='close'></a><p>{{Lang::get('messages.delete.success')}}</p> </div>");
                });
                return false;
            } else {
                return false;
            }
        })
    }
    function kichhoat(id, stus) {
        var request = jQuery.ajax({
            url: "{{URL::action('\BackEnd\SupporterController@postSupporterActive')}}?id=" + id + "&status=" + stus,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            jQuery('#messages1').empty().html("<div class='notibar msgsuccess'><a class='close'></a><p>{{Lang::get('messages.update.success')}}</p> </div>")
                    ;
        });
        return true;
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.supporter.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.supporter.description')}}</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>{{Lang::get('backend/title.supporter.caption')}}</h3>
    </div>
    &nbsp;&nbsp;&nbsp;<a href="{{URL::action('\BackEnd\SupporterController@getSupporterView')}}#frmSuport" class="btn btn_orange btn_link"><span>{{Lang::get('button.add')}}</span></a>
    <div class="contentwrapper">
        <div class="subcontent">
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con1" style="width: 3%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 10%">
                    <col class="con0" style="width: 12%">
                    <col class="con1" style="width: 10%">
                    <col class="con0" style="width: 10%">
                    <col class="con0" style="width: 10%">
                    <col class="con1" style="width: 10%">
                    <col class="con1" style="width: 15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1">{{Lang::get('general.stt')}}</th>
                        <th class="head0">{{Lang::get('general.supporterName')}}</th>
                        <th class="head1">{{Lang::get('general.group_support')}}</th>
                        <th class="head0">Yahoo</th>
                        <th class="head1">Skype</th>
                        <th class="head0">{{Lang::get('general.phone')}}</th>
                        <th class="head1">{{Lang::get('general.time')}}</th>
                        <th class="head0">{{Lang::get('general.status')}}</th>
                        <th class="head1">{{Lang::get('general.action')}}</th>
                    </tr>
                </thead>

                <tbody id="tableproduct" class="tabledataajax">
                    @include('backend.supporter.supporterAjax')
                </tbody>
            </table>
        </div>
    </div>
    <div class="contenttitle2">
        <h3>
            @if(!isset($supportData))
            {{Lang::get('backend/title.supporter.add')}}
            @else
            {{Lang::get('backend/title.supporter.edit')}}
            @endif
        </h3>
    </div>
    @include('backend.alert')
    @if(isset($supportData))
    <script>jQuery(document).ready(function() {
            jQuery('html, body').animate({scrollTop: jQuery("#frmSuport").offset().top}, 1000);
        })</script>
    {{Form::model($supportData, array('action'=>'\BackEnd\SupporterController@postUpdateSupport', 'id'=>'frmSuport', 'class'=>'stdform stdform2'))}}
    @else
    {{Form::open(array('action'=>'\BackEnd\SupporterController@postAddSupport', 'id'=>'frmSuport', 'class'=>'stdform stdform2'))}}
    @endif
    <p>{{Form::hidden('id')}}</p>
    <p>
        <label>{{Lang::get('general.group_support')}}</label>
        <span class="field">

            <select name="cbSupportGroup">
                <?php
                foreach ($arrSupporterGroup as $item) {
                    echo '<option  value="' . $item->id . '">' . $item->supporterGroupName . '</option>';
                }
                ?>
            </select>
        </span>
    </p>

    <p>
        <label>{{Lang::get('general.supporterName')}}</label>
        <span class="field">
            {{Form::text('supporterName', null, array('class'=>'longinput'))}}
        </span>
    </p>

    <p>
        <label>Yahoo</label>
        <span class="field">
            {{Form::text('supporterNickYH', null, array('class'=>'longinput'))}}
        </span>
    </p>

    <p>
        <label>Skype</label>
        <span class="field">
            {{Form::text('supporterNickSkype', null, array('class'=>'longinput'))}}
        </span>
    </p>

    <p>
        <label>{{Lang::get('general.phone')}}</label>
        <span class="field">
            {{Form::text('supporterPhone', null, array('class'=>'longinput'))}}
    </p>

    <p>
        <label>{{Lang::get('general.status')}}</label>
        <span class="field">
            <?php
            $supporter_status = Lang::get('general.supporter_status');
            echo Form::select('status', $supporter_status);
            ?>
        </span>
    </p>
    <p class="stdformbutton">
        <button class="submit radius2" type="submit">
            @if(isset($supportData)){{Lang::get('button.update')}}@else{{Lang::get('button.add')}}@endif
        </button>
        <input type="reset" class="reset radius2" value="{{Lang::get('button.reset')}}">
    </p>
    {{Form::close()}}
</div>
@endsection