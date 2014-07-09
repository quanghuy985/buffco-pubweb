@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.supporter.title')}}
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

</script>
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.supporter.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.supporter.description')}}</span>
</div>
<div class="contentwrapper">
    <div class="two_fifth">
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
        {{Form::model($supportData, array('action'=>'\BackEnd\SupporterController@postUpdateSupport', 'id'=>'frmSuport', 'class'=>'stdform'))}}
        @else
        {{Form::open(array('action'=>'\BackEnd\SupporterController@postAddSupport', 'id'=>'frmSuport', 'class'=>'stdform'))}}
        @endif
        <p>{{Form::hidden('id')}}</p>
        <p>
            <label>{{Lang::get('general.group_support')}}</label>
            <span class="field">

                <select name="cbSupportGroup">
                    <?php
                    foreach ($arrSupporterGroup as $item) {
                        $selc = '';
                        if (isset($supportData)) {
                            if ($item->id == $supportData->supporterGroupID) {
                                $selc = 'selected';
                            } else {
                                $selc = '';
                            }
                        }
                        echo '<option  value="' . $item->id . '" ' . $selc . '>' . $item->supporterGroupName . '</option>';
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
        <p class="stdformbutton">
            <button class="submit radius2" type="submit">
                @if(isset($supportData)){{Lang::get('button.update')}}@else{{Lang::get('button.add')}}@endif
            </button>
            <input type="reset" class="reset radius2" value="{{Lang::get('button.reset')}}">
        </p>
        {{Form::close()}}
    </div>
    <div class="three_fifth">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.supporter.caption')}}</h3>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con1" style="width: 1%">
                <col class="con0" style="width: 30%">
                <col class="con1" style="width: 30%">
                <col class="con0" style="width: 20%">
                <col class="con1" style="width: 18%">

            </colgroup>
            <thead>
                <tr>
                    <th class="head1">{{Lang::get('general.stt')}}</th>
                    <th class="head0">{{Lang::get('general.supporterName')}}</th>
                    <th class="head1">{{Lang::get('general.group_support')}}</th>
                    <th class="head0">{{Lang::get('general.time')}}</th>
                    <th class="head1">{{Lang::get('general.action')}}</th>
                </tr>
            </thead>

            <tbody id="tableproduct" class="tabledataajax">
                @include('backend.supporter.supporterAjax')
            </tbody>
        </table>
    </div>
</div>
@endsection