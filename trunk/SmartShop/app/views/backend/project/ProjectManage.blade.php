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
            {{Form::open(array('action'=>'\BackEnd\UserController@postFillterUsers', 'class'=>'stdform stdform2','id'=>'fillterfrom'))}}
            <?php
            $page_status = Lang::get('general.data_status');
            echo Form::select('fillter_status', $page_status, null, array('id' => 'fillter_status'));
            ?>
            &nbsp;
            <input type="submit" value="{{Lang::get('general.filter')}}" class="radius3"/>
            {{Form::close()}}
            {{Form::open(array('action'=>'\BackEnd\UserController@postSearchUsers','id'=>'searchaction'))}}
            <div class="dataTables_filter1"  style=" margin-top: -32px !important;">
                <label>
                    <input class="longinput" id="key_word"  name="key_word" style="-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fcfcfc;color: #666;-moz-box-shadow: inset 0 1px 3px #ddd;-webkit-box-shadow: inset 0 1px 3px #ddd;box-shadow: inset 0 1px 3px #ddd;" type="text">&nbsp;&nbsp; <input type="submit" value="{{Lang::get('general.search')}}" class="radius3"/>
                </label>
            </div>
            {{Form::close()}}
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 3%">
                <col class="con1" style="width: 10%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 14%">
                <col class="con1" style="width: 20%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 10%">

            </colgroup>
            <thead>
                <tr>
                    <th class="head0"></th>
                    <th class="head1">{{Lang::get('general.date_begin')}}</th>
                    <th class="head1">{{Lang::get('general.date_end')}}</th>
                    <th class="head0">{{Lang::get('general.project_name')}}</th>
                    <th class="head1">{{Lang::get('general.content')}}</th>
                    <th class="head0">{{Lang::get('general.time')}}</th>
                    <th class="head1">{{Lang::get('general.status')}}</th>
                    <th class="head1">{{Lang::get('general.action')}}</th>
                </tr>
            </thead>

            <tbody id="tableproduct" class="tabledataajax">
                @if(count($arrayProject)>0)
                @foreach($arrayProject as $item)
                <tr>
                    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td>
                    <td><label value="project"></label><?php echo date('d/m/Y', $item->from); ?></td>
                    <td><label value="project"></label><?php echo date('d/m/Y', $item->to); ?></td>
                    <td><label value="project">{{str_limit( $item->projectName, 30, '...')}}</label></td>
                    <td><label value="project">{{str_limit($item->projectContent, 30, '...')}} </label></td>
                    <td><label value="project"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td>
                    <td><label value="project">
                            <?php
                            if (array_key_exists($item->status, $page_status)) {
                                echo $page_status[$item->status];
                            }
                            ?>
                        </label>
                    </td>
                    <td>
                        <a href="{{URL::action('\BackEnd\ProjectController@getProjectEdit',$item->id)}}"
                           class="btn btn4 btn_book" title="{{Lang::get('button.btn.book')}}"></a>
                        @if($item->status=='2')
                        <a href="javascript:void(0)" onclick="kichhoat({{$item-> id}}, 0)" class="btn btn4 btn_flag"
                           title="{{Lang::get('button.btn.flag')}}"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript:void(0)" onclick="kichhoat({{$item-> id}}, 1)" class="btn btn4 btn_world"
                           title="{{Lang::get('button.btn.world')}}"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item-> id}})" class="btn btn4 btn_trash"
                           title="{{Lang::get('button.btn.trash')}}"></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="8">{{$link}}</td>
                </tr>
                @endif

                @else
                <tr>
                    <td colspan="8">
                        {{Lang::get('general.data_empty')}}
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>
@endsection

