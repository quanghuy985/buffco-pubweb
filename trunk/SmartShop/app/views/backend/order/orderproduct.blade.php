@extends("backend.template")
@section("titleAdmin")
{{Lang::get('backend/title.order.title')}}
@endsection
@section("contentadmin")
<script type="text/javascript">

</script>
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.order.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.order.description')}}</span>
</div>

<div class="contentwrapper">
    @include('backend.alert')
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.order.caption')}}</h3>
        </div>
        <div class="tableoptions"> 
            {{Form::open(array('action'=>'\BackEnd\OrderController@postOrderFillterView','id'=>'filterHistory'))}}
            <label>{{Lang::get('general.date_from')}}: <input id="datepicker" name="from"
                                                              style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;background: #fff;"
                                                              type="text"/></label>
            <label>{{Lang::get('general.date_to')}}: <input id="datepicker1" name="to"
                                                            style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;background: #fff;"
                                                            type="text"/></label>
                <?php
                $data_status = Lang::get('general.order_status');
                echo Form::select('fillter_status', $data_status, '', array('id' => 'fillter_status'));
                ?>
            &nbsp; &nbsp; <button class="anchorbutton" id="loctheotieuchi" type="submit" >{{Lang::get('general.filter')}}</button>
            {{Form::close()}}
            {{Form::open(array('action'=>'\BackEnd\OrderController@postOrderSearchView','id'=>'searchHistory'))}}
            <div class="dataTables_filter1" id="searchformfile" style=" margin-top: -32px !important;">
                <label>{{Lang::get('general.search')}}:
                    <input class="longinput" id="searchblur"  name="searchblur" style="-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fcfcfc;color: #666;-moz-box-shadow: inset 0 1px 3px #ddd;-webkit-box-shadow: inset 0 1px 3px #ddd;box-shadow: inset 0 1px 3px #ddd;" type="text"><a href="javascript:void(0)" class="btn btn4 btn_search" onclick="jQuery('#searchHistory').submit();" style=" float: right;    height: 30px;   margin-left: 10px;"></a>
                </label>
            </div>
            {{Form::close()}}
        </div>
        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable stdtablecb">
            <colgroup>

                <col class="con1" style="width: 4%">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
            </colgroup>
            <thead>
                <tr>

                    <th class="head1">{{Lang::get('general.order.stt')}}</th>
                    <th class="head0">{{Lang::get('general.email')}}</th>
                    <th class="head1">{{Lang::get('general.first_name')}}</th>
                    <th class="head0">{{Lang::get('general.last_name')}}</th>
                    <th class="head1">{{Lang::get('general.order.code')}}</th>
                    <th class="head0">{{Lang::get('general.order.payment')}}</th>
                    <th class="head1">{{Lang::get('general.order.time')}}</th>
                    <th class="head0">{{Lang::get('general.order.status')}}</th>
                    <th class="head1">{{Lang::get('general.order.action')}}</th>
                </tr>
            </thead>

            <tbody id="tableproduct">
                <?php $i = 1 ?>
                @include('backend.order.orderproductajax')
            </tbody>
        </table>
    </div>
</div>
@endsection