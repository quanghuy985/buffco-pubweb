@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.project.title')}}
@stop
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.project.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.project.description')}}</span>
</div>

<div class="contentwrapper">
    @include('backend.alert')
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.project.caption')}}</h3>
        </div>

        <div class="tableoptions">
            {{Form::open(array('action'=>'\BackEnd\ProjectController@postFillterProjectView', 'class'=>'stdform stdform2','id'=>'fillterfrom'))}}
            <?php
            $page_status = Lang::get('general.data_status');
            echo Form::select('fillter_status', $page_status, null, array('id' => 'fillter_status'));
            ?>
            &nbsp;
            <input type="submit" value="{{Lang::get('general.filter')}}" class="radius3"/>
            {{Form::close()}}
            {{Form::open(array('action'=>'\BackEnd\ProjectController@postSeaechProjectView','id'=>'searchaction'))}}
            <div class="dataTables_filter1"  style=" margin-top: -32px !important;">
                <label>
                    <input class="longinput" id="key_word"  name="key_word" style="-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fcfcfc;color: #666;-moz-box-shadow: inset 0 1px 3px #ddd;-webkit-box-shadow: inset 0 1px 3px #ddd;box-shadow: inset 0 1px 3px #ddd;" type="text">&nbsp;&nbsp; <input type="submit" value="{{Lang::get('general.search')}}" class="radius3"/>
                </label>
            </div>
            {{Form::close()}}
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 1%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 10%">
                <col class="con1" style="width: 30%">
                <col class="con0" style="width: 20%">
                <col class="con1" style="width: 13%">
                <col class="con0" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0">{{Lang::get('general.stt')}}</th>
                    <th class="head1">{{Lang::get('general.date_begin')}}</th>
                    <th class="head0">{{Lang::get('general.date_end')}}</th>
                    <th class="head1">{{Lang::get('general.project_name')}}</th>
                    <th class="head0">{{Lang::get('general.time')}}</th>
                    <th class="head1">{{Lang::get('general.status')}}</th>
                    <th class="head0">{{Lang::get('general.action')}}</th>
                </tr>
            </thead>

            <tbody id="tableproduct" class="tabledataajax">
                @include('backend.project.Projectajax')
            </tbody>
        </table>
    </div>
</div>
@endsection

