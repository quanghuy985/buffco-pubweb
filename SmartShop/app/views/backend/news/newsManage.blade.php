@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.news.title')}}
@stop
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.news.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.news.description')}}</span>
</div>

<div class="contentwrapper">
    @include('backend.alert')
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.news.caption')}}</h3>
        </div>
        &nbsp;&nbsp;&nbsp;<a href="{{URL::action('\BackEnd\NewsController@getAddNews')}}" class="btn btn_orange btn_link"><span>{{Lang::get('button.add')}}</span></a>
        <div class="tableoptions">
            <form class="stdform stdform2" action="{{URL::action('\BackEnd\NewsController@postNewsFillterView')}}" method="post">
                <select name="fillter_category" id="fillter_category" style="opacity: 0;">
                    <option selected="selected" value="">{{Lang::get('general.all')}}</option>
                    <?php
                    if (isset($arrayCate)) {
                        foreach ($arrayCate as $item) {
                            if ($item->catenewsParent == 0) {
                                ?>
                                <option style="font-size: 13px;font-weight: bold;text-decoration: inherit;"  value="{{$item->id}}"> {{$item->catenewsName}}</option>
                                <?php
                                foreach ($arrayCate as $item1) {
                                    if ($item1->catenewsParent == $item->id) {
                                        ?>
                                        <option  value="{{$item1->id}}">— {{$item1->catenewsName}}</option>
                                        <?php
                                    }
                                }
                                ?>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
                <?php
                $data_status = Lang::get('general.data_status2');
                echo Form::select('fillter_status', $data_status, 3, array('id' => 'fillter_status'));
                ?>
                &nbsp; &nbsp; <button class="radius3" id="loctheotieuchi" type="submit" >{{Lang::get('general.filter')}}</button>
            </form>
            <div class="dataTables_filter1" id="searchformfile" style=" margin-top: -32px !important;">
                <label>{{Lang::get('general.search')}}:
                    <input class="longinput" id="searchblur"  name="searchblur" style="-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fcfcfc;color: #666;-moz-box-shadow: inset 0 1px 3px #ddd;-webkit-box-shadow: inset 0 1px 3px #ddd;box-shadow: inset 0 1px 3px #ddd;" type="text"><a href="javascript:void(0)" class="btn btn4 btn_search" onclick="timkiem()" style=" float: right;    height: 30px;   margin-left: 10px;"></a>
                </label>
            </div>
        </div> 
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 1%">
                <col class="con1" style="width: 30%">
                <col class="con1" style="width: 30%">
                <col class="con0" style="width: 14%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0">{{Lang::get('general.stt')}}</th>
                    <th class="head1">{{Lang::get('general.title')}}</th>
                    <th class="head1">{{Lang::get('general.description')}}</th>
                    <th class="head1">{{Lang::get('general.time')}}</th>
                    <th class="head0">{{Lang::get('general.status')}}</th>
                    <th class="head1">{{Lang::get('general.action')}}</th>
                </tr>  
            </thead>

            <tbody id="tableproduct" class="tabledataajax">
                <?php $i = 1 ?>
                @include('backend.news.newsAjax')
            </tbody>
        </table>
    </div>
</div>
@endsection
