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
            {{Form::open(array('action'=>'\BackEnd\NewsController@postNewsFillterView', 'class'=>'stdform stdform2','id'=>'fillterfrom'))}}
            <select name="fillter_category" id="fillter_category" style="opacity: 0;">
                <option value="">{{Lang::get('general.all')}}</option>
                <?php
                if (isset($arrayCate)) {
                    if (isset($cateselectfillter)) {
                        $status_cate = $cateselectfillter;
                    } else {
                        $status_cate = '';
                    }

                    foreach ($arrayCate as $item) {
                        if ($item->catenewsParent == 0) {
                            ?>
                            <option style="font-size: 13px;font-weight: bold;text-decoration: inherit;"  value="{{$item->id}}"  <?php
                            if ($status_cate == $item->id) {
                                echo 'selected="selected"';
                            }
                            ?> > {{$item->catenewsName}}</option>
                                    <?php
                                    foreach ($arrayCate as $item1) {
                                        if ($item1->catenewsParent == $item->id) {
                                            ?>
                                    <option  value="{{$item1->id}}" <?php
                                    if ($status_cate == $item1->id) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>— {{$item1->catenewsName}}</option>
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
            if (isset($statusselectfillter)) {
                $status_select = $statusselectfillter;
            } else {
                $status_select = '';
            }
            echo Form::select('fillter_status', $data_status, $status_select, array('id' => 'fillter_status'));
            ?>
            &nbsp; <input type="submit" class="radius3" value="{{Lang::get('general.filter')}}">
            {{Form::close()}}
            {{Form::open(array('action'=>'\BackEnd\NewsController@postNewsSearchView','id'=>'searchaction'))}}
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
                <col class="con1" style="width: 30%">
                <col class="con0" style="width: 30%">
                <col class="con1" style="width: 14%">
                <col class="con0" style="width: 10%">
                <col class="con1" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0">{{Lang::get('general.stt')}}</th>
                    <th class="head1">{{Lang::get('general.title')}}</th>
                    <th class="head0">{{Lang::get('general.description')}}</th>
                    <th class="head1">{{Lang::get('general.time')}}</th>
                    <th class="head0">{{Lang::get('general.status')}}</th>
                    <th class="head1">{{Lang::get('general.action')}}</th>
                </tr>  
            </thead>

            <tbody id="tableproduct" class="tabledataajax">
                @include('backend.news.newsAjax')
            </tbody>
        </table>
    </div>
</div>
@endsection
