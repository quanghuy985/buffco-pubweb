@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.project.title')}}
@stop
@section("contentadmin")
<script>
    jQuery(document).ready(function () {

    jQuery('.deletepromulti').click(function () {
    var addon = '';
            av = document.getElementsByName("checkboxidfile");
            for (e = 0; e < av.length; e++) {
    if (av[e].checked == true) {
    addon += av[e].value + ',';
    }
    }
    if (addon != '') {
    jConfirm("{{Lang::get('messages.delete_confirm')}}", "{{Lang::get('messages.alert')}}", function (r) {
    if (r == true) {
    jQuery.post("{{URL::action('\BackEnd\ProjectController@postDelmulte')}}", {multiid: addon}).done(function (data) {
    window.location = '{{URL::action('\BackEnd\ProjectController@getProjectView')}}';
    });
            return false;
    } else {
    return false;
    }
    });
    } else {
    jAlert("{{Lang::get('messages.select_empty')}}", "{{Lang::get('messages.alert')}}");
    }
    });
            jQuery('#searchblur').keypress(function (e) {
    // Enter pressed?
    if (e.which == 10 || e.which == 13) {
    var request = jQuery.ajax({
    url: "{{URL::action('\BackEnd\ProjectController@postAjaxsearch')}}?keyword=" + jQuery('#searchblur').val(),
            type: "POST",
            dataType: "html"
    });
            request.done(function (msg) {
            jQuery('#tableproduct').html(msg);
            });
    }
    });
            jQuery("#loctheotieuchi").click(function () {
    var request = jQuery.ajax({
    url: "{{URL::action('\BackEnd\ProjectController@postFillterProject')}}?status=" + jQuery('#oderbyoption1').val(),
            type: "POST",
            dataType: "html"
    });
            request.done(function (msg) {
            jQuery('#tableproduct').html(msg);
            });
    });
    });
            function phantrang(page) {
            jQuery("#jGrowl").remove();
                    jQuery.jGrowl("{{Lang::get('messages.data_loading')}}");
                    var urlpost = "{{URL::action('\BackEnd\ProjectController@postAjaxproject')}}?page=" + page
                    if (jQuery('#oderbyoption1').val() != '') {
            urlpost = "{{URL::action('\BackEnd\ProjectController@postFillterProject')}}?status=" + jQuery('#oderbyoption1').val() + "&page=" + page;
            }
            if (jQuery('#searchblur').val() != '') {
            urlpost = "{{URL::action('\BackEnd\ProjectController@postAjaxsearch')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
            }
            var request = jQuery.ajax({
            url: urlpost,
                    type: "POST",
                    dataType: "html"
            });
                    request.done(function (msg) {
                    jQuery("#jGrowl").remove();
                            jQuery.jGrowl("{{Lang::get('messages.data_load_success')}}");
                            jQuery('#tableproduct').html(msg);
                    });
            }


    function xoasanpham(id) {
    jConfirm("{{Lang::get('messages.delete_confirm')}}", "{{Lang::get('messages.alert')}}", function (r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('\BackEnd\ProjectController@postDeleteProject')}}?id=" + id,
            type: "POST",
            dataType: "html"
    });
            request.done(function (msg) {
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
    url: "{{URL::action('\BackEnd\ProjectController@postProjectActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function (msg) {
            jQuery('#tableproduct').html(msg);
            });
            return true;
    }
</script>
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
            <button class="deletepromulti" title="table1">{{Lang::get('general.delete_select')}}</button>&nbsp;
            <?php
            $selectData = Lang::get('general.data_status');
            echo Form::select('oderbyoption1', $selectData, '', array('id' => 'oderbyoption1'));
            ?>&nbsp;
            <button class="radius3" id="loctheotieuchi">{{Lang::get('general.filter')}}</button>
            <div class="dataTables_filter1" id="searchformfile">
                <label>{{Lang::get('general.search')}}:
                    <input id="searchblur" name="searchblur"
                           style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;"
                           type="text">
                </label>
            </div>
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
                            if (array_key_exists($item->status, $selectData)) {
                                echo $selectData[$item->status];
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

