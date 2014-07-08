@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.groupSupporter.title')}}
@stop
@section("contentadmin")
<style>
    .stdform label {
        float: left;
        padding: 5px 20px 0 0;
        text-align: right;
        width: 35%;
    }
    .stdform span.field, .stdform div.field {
        display: block;
        margin-left: 35%;
        position: relative;
    }
    .three_fifth {
        width: 55.9%;
    }
    .tableoptions{
        margin-top: 20px;
    }
</style>
<script>
    jQuery(document).ready(function() {
        jQuery("#formSubmit").validate({
            rules: {
                supporterGroupName: {required: true}
            }
        });
    });

</script>
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.groupSupporter.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.groupSupporter.description')}}</span>
</div>

<div class="contentwrapper">
    <div class="two_fifth">
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
        {{Form::model($SupporterGroupData, array('action'=>'\BackEnd\SupporterController@postUpdateSupporterGroup', 'class'=>'stdform ', 'id'=>'formSubmit'))}}
        @else
        {{Form::open(array('action'=>'\BackEnd\SupporterController@postAddSupporterGroup', 'class'=>'stdform', 'id'=>'formSubmit'))}}
        @endif
        <p></p>
        <p>
            <input type="hidden" name="id" id="idnews" value="@if(isset($SupporterGroupData)){{$SupporterGroupData->id}}@endif"/>
            <label>{{Lang::get('general.group_support')}}</label>
            <span class="field">
                {{Form::text('supporterGroupName',null,array('class'=>'longinput'))}}
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" type="submit" value="@if(isset($SupporterGroupData)){{Lang::get('button.update')}} @else{{Lang::get('button.add')}} @endif ">@if(isset($SupporterGroupData))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="{{Lang::get('button.reset')}}">
        </p>
        </form>
    </div>
    <div class="three_fifth">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.groupSupporter.caption')}}</h3>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb" style="margin-top: 20px;">
            <colgroup>
                <col class="con1" style="width: 5%">
                <col class="con0" style="width: 55%">
                <col class="con1" style="width: 25%">
                <col class="con1" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head1">{{Lang::get('general.stt')}}</th>
                    <th class="head0">{{Lang::get('general.group_support')}}</th>
                    <th class="head1">{{Lang::get('general.time')}}</th>
                    <th class="head1">{{Lang::get('general.action')}}</th>
                </tr>  
            </thead>
            <?php $i = 1; ?>
            <tbody id="tableproduct" class="tabledataajax">
                @include('backend.supporter.supporterGroupAjax')
            </tbody>
        </table>
    </div>
</div>
@endsection

