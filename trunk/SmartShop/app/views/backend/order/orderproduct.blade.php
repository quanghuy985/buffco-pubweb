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
            <form id="filterHistory" action="{{URL::action('\BackEnd\OrderController@postOrderFillterView')}}" method="post">
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
            </form>

            <form id="searchHistory" action="{{URL::action('\BackEnd\OrderController@postOrderSearchView')}}" method="post">
                <div class="dataTables_filter1" id="searchformfile" style=" margin-top: -32px !important;">
                    <label>{{Lang::get('general.search')}}:
                        <input class="longinput" id="searchblur"  name="searchblur" style="-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fcfcfc;color: #666;-moz-box-shadow: inset 0 1px 3px #ddd;-webkit-box-shadow: inset 0 1px 3px #ddd;box-shadow: inset 0 1px 3px #ddd;" type="text"><a href="javascript:void(0)" class="btn btn4 btn_search" onclick="jQuery('#searchHistory').submit();" style=" float: right;    height: 30px;   margin-left: 10px;"></a>
                    </label>
                </div>
            </form>

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
                <col class="con0">
                <col class="con1">
            </colgroup>
            <thead>
                <tr>

                    <th class="head1">STT</th>
                    <th class="head0">Tài khoản</th>
                    <th class="head1">Họ</th>
                    <th class="head0">Đệm và Tên</th>
                    <th class="head1">Mã Đơn Hàng</th>
                    <th class="head0">Thời điểm</th>
                    <th class="head1">Trạng thái</th>
                    <th class="head0">Action</th>
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