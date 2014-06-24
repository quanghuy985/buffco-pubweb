@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.feedback.title')}}
@stop
@section("contentadmin")
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
            {{Form::open(array('action'=>'\BackEnd\FeedbackController@postFillterFeedBack', 'class'=>'stdform stdform2','id'=>'fillterfrom'))}}
            {{Lang::get('general.date_from')}} : <input id="datepicker" name="timeform" type="text" class="longinput" />&nbsp;
            {{Lang::get('general.date_to')}} : <input id="datepicker1"  name="timeto" type="text" class="datepicker"  />
            &nbsp;
            {{Form::select('fillter_status', Lang::get('general.feedback_fillter_status'), null, array('id' => 'fillter_status'))}}
            &nbsp;
            <input type="submit" class="radius3" value="{{Lang::get('general.filter')}}"/>
            {{Form::close()}}
            {{Form::open(array('action'=>'\BackEnd\FeedbackController@postSearchFeedBack','id'=>'searchaction'))}}
            <div class="dataTables_filter1" id="searchformfile" style=" margin-top: -32px !important;">
                <label>
                    <input class="longinput" id="searchblur"  name="searchblur" style="-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fcfcfc;color: #666;-moz-box-shadow: inset 0 1px 3px #ddd;-webkit-box-shadow: inset 0 1px 3px #ddd;box-shadow: inset 0 1px 3px #ddd;" type="text">
                    &nbsp; <input type="submit" value="{{Lang::get('general.search')}}" class="radius3"/>
                </label>
            </div>
            {{Form::close()}}
        </div> 
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con1" style="width: 1%">
                <col class="con0" style="width: 30%">
                <col class="con1" style="width: 25%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 13%">
                <col class="con0" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head1">{{Lang::get('general.stt')}}</th>
                    <th class="head0">{{Lang::get('general.email')}}</th>
                    <th class="head1">{{Lang::get('general.feedback_user')}}</th>
                    <th class="head0">{{Lang::get('general.time_send')}}</th>
                    <th class="head1">{{Lang::get('general.status')}}</th>
                    <th class="head0">{{Lang::get('general.action')}}</th>
                </tr>  
            </thead>
            <tbody id="tablefeedback" class="tabledataajax">
                @include('backend.feedback.AjaxFeedbackManage')
            </tbody>
        </table>
    </div>
</div>
@endsection
