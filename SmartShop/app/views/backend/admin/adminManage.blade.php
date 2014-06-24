@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.admin.title')}}
@stop
@section("contentadmin")
<script>
    function phantrang(page) {
        var request = jQuery.ajax({
            url: "{{URL::action('\BackEnd\AdminController@postAjaxpagion')}}?link=" + page,
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
                    url: "{{URL::action('\BackEnd\AdminController@postDeleteAdmin')}}?id=" + id,
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
            url: "{{URL::action('\BackEnd\AdminController@postAdminActive')}}?id=" + id + '&status=' + stus,
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
    <h1 class="pagetitle">{{Lang::get('backend/title.admin.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.admin.description')}}</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>{{Lang::get('backend/title.admin.caption')}}</h3>
    </div>
    @include('backend.alert')
    <div class="contentwrapper">
        <div class="subcontent">
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con1" style="width: 5%">
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 20%">
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1">{{Lang::get('general.stt')}}</th>
                        <th class="head0">{{Lang::get('general.email')}}</th>
                        <th class="head1">{{Lang::get('general.full_name')}}</th>
                        <th class="head0">{{Lang::get('general.group_acl')}}</th>
                        <th class="head1">{{Lang::get('general.time')}}</th>
                        <th class="head0">{{Lang::get('general.status')}}</th>
                        <th class="head1">{{Lang::get('general.action')}}</th>
                    </tr>  
                </thead>
                <?php $i = 1 ?>
                <tbody id="tableproduct" class="tabledataajax">
                    @include('backend.admin.adminAjax')
                </tbody>
            </table>

        </div>
    </div>
    <div class="contenttitle2">
        <h3>
            @if(!isset($AdminData))
            {{Lang::get('backend/title.admin.add')}}
            @else
            {{Lang::get('backend/title.admin.edit')}}
            @endif
        </h3>
    </div>

    @if(isset($AdminData))
<!--    <script>jQuery(document).ready(function(){jQuery('html, body').animate({ scrollTop: jQuery("#adminForm").offset().top}, 1000);})</script>-->
    {{Form::model($AdminData,  array('action'=>'\BackEnd\AdminController@postUpdateAdmin', 'class'=>'stdform stdform2', 'id'=>'adminForm'))}}
    @else
    {{Form::open(array('action'=>'\BackEnd\AdminController@postAddAdmin', 'class'=>'stdform stdform2'))}}
    @endif
    <p>
        {{Form::hidden('id')}}
    </p>
    <p>
        <label>{{Lang::get('general.email')}}</label>
        <span class="field">
            @if(isset($AdminData))
            <input type="text" name="email" @if(isset($AdminData))disabled @endif  value="{{$AdminData->email}}" class="longinput">
                   <input type="hidden" name="email" id="email" value="{{$AdminData->email}}"/>
            @else
            {{Form::text('email', null, array('class'=>'longinput'))}}
            @endif
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.first_name')}}</label>
        <span class="field">
            {{Form::text('firstname', null, array('class'=>'longinput'))}}
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.last_name')}}</label>
        <span class="field">
            {{Form::text('lastname', null, array('class'=>'longinput'))}}
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.date_of_birth')}}</label>
        <span class="field">
            <input id="datepicker" name="dateofbirth" type="text" class="longinput" value="@if(isset($AdminData)&&$AdminData->dateofbirth!=''){{date('d/m/Y',$AdminData->dateofbirth)}}@endif" />
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.address')}}</label>
        <span class="field">
            <textarea cols="80" rows="5" class="longinput" name="address">@if(isset($AdminData)&&$AdminData->address!=''){{$AdminData->address}}@endif</textarea>
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.phone')}}</label>
        <span class="field">
            {{Form::text('phone', null, array('class'=>'longinput'))}}
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.password')}}</label>
        <span class="field">
            <input type="password" name="password" placeholder="@if(isset($AdminData)){{Lang::get('placeholder.empty_no_change')}}@endif" class="longinput">
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.group_acl')}}</label>
        <span class="field">
            <select name="group_admin_id">
                @foreach($arrGroupAdmin as $item2)
                <option value="{{$item2->id}}" @if(isset($AdminData)&& $AdminData->group_admin_id == $item2->id)selected @endif >
                        {{$item2->groupadminName}}
            </option>
            @endforeach
        </select>
        <a href="{{URL::action('\BackEnd\GroupAdminController@getGroupAdminView')}}" > {{Lang::get('button.add')}}</a>
    </span>
</p>
@if(isset($AdminData))
<p>
    <label>{{Lang::get('general.status')}}</label>
    <span class="field">
        <?php
        $user_status = Lang::get('general.user_status');
        echo Form::select('status', $user_status);
        ?>
    </span>
</p>
@endif
<p class="stdformbutton">
    <button class="submit radius2" value="@if(isset($AdminData)){{Lang::get('button.update')}}@else {{Lang::get('button.add')}} @endif ">@if(isset($AdminData)){{Lang::get('button.update')}} @else {{Lang::get('button.add')}} @endif </button>
    <input type="reset" class="reset radius2" value="Làm mới">
</p>
{{Form::close()}}
</div>
@endsection