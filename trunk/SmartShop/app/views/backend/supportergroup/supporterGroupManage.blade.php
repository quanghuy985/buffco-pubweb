@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.groupSupporter.title')}}
@stop
@section("contentadmin")
<script>
    function phantrang(page) {
        var request = jQuery.ajax({
            url: "{{URL::action('\BackEnd\SupporterGroupController@postAjaxpagion')}}?page=" + page,
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
                    url: "{{URL::action('\BackEnd\SupporterGroupController@postDeleteSupporterGroup')}}?id=" + id,
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {
                    jQuery('#tableproduct').html(msg);
                });
                return true;
            } else {
                return false;
            }
        })
    }
    function kichhoat(id, stus) {
        var request = jQuery.ajax({
            url: "{{URL::action('\BackEnd\SupporterGroupController@postSupporterGroupActive')}}?id=" + id + "&status=" + stus,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            jQuery('#messages1').empty().html(" <div class='notibar msgsuccess'><a class='close'></a><p>{{Lang::get('messages.update.success')}}</p> </div>");
        });
        return true;
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.groupSupporter.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.groupSupporter.description')}}</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>{{Lang::get('backend/title.groupSupporter.caption')}}</h3>
    </div>
    &nbsp;&nbsp;&nbsp;<a href="{{URL::action('\BackEnd\SupporterGroupController@getSupporterGroupView')}}#formSubmit" class="btn btn_orange btn_link"><span>{{Lang::get('button.add')}}</span></a>
    <div class="contentwrapper">
        <div class="subcontent">
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con1" style="width: 5%">
                    <col class="con0" style="width: 25%">
                    <col class="con1" style="width: 25%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 25%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1">{{Lang::get('general.stt')}}</th>
                        <th class="head0">{{Lang::get('general.group_support')}}</th>
                        <th class="head1">{{Lang::get('general.time')}}</th>
                        <th class="head0">{{Lang::get('general.status')}}</th>
                        <th class="head1">{{Lang::get('general.action')}}</th>
                    </tr>  
                </thead>
                <?php $i = 1; ?>
                <tbody id="tableproduct" class="tabledataajax">
                    @include('backend.supportergroup.supporterGroupAjax')
                </tbody>
            </table>

        </div>
    </div>
    <div class="contenttitle2">
        <h3>
            @if(isset($SupporterGroupData))
            {{Lang::get('backend/title.groupSupporter.edit')}}
            @else
            {{Lang::get('backend/title.groupSupporter.add')}}
            @endif
        </h3>
    </div>
    @include('backend.alert')
    @if(isset($SupporterGroupData))
    <script>jQuery(document).ready(function() {
            jQuery('html, body').animate({scrollTop: jQuery("#formSubmit").offset().top}, 2000);
        })</script>
    {{Form::model($SupporterGroupData, array('action'=>'\BackEnd\SupporterGroupController@postUpdateSupporterGroup', 'class'=>'stdform stdform2', 'id'=>'formSubmit'))}}
    @else
    {{Form::open(array('action'=>'\BackEnd\SupporterGroupController@postAddSupporterGroup', 'class'=>'stdform stdform2', 'id'=>'formSubmit'))}}
    @endif
    <p></p>
    <p>
        <input type="hidden" name="id" id="idnews" value="@if(isset($SupporterGroupData)){{$SupporterGroupData->id}}@endif"/>
        <label>{{Lang::get('general.group_support')}}</label>
        <span class="field">
            {{Form::text('supporterGroupName',null,array('class'=>'longinput'))}}
        </span>
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
        <button class="submit radius2" type="submit" value="@if(isset($SupporterGroupData)){{Lang::get('button.update')}} @else{{Lang::get('button.add')}} @endif ">@if(isset($SupporterGroupData))Cập nhật @else Thêm mới @endif </button>
        <input type="reset" class="reset radius2" value="{{Lang::get('button.reset')}}">
    </p>
</form>
</div>

@endsection

