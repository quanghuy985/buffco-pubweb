@extends("templateadmin2.mainfire")
@section("titleAdmin")
{{Lang::get('backend/title.history.titleAdmin')}}
@stop
@section("contentadmin")
<script>
    function xxx(id, email, name, content){
        jQuery('#id').val(id);
        jQuery('#email').val(email);
        jQuery('#name').val(name);
        jQuery('#content').val(content);
        // window.location.href='#frmEdit';
        jQuery('html,body').animate({
            scrollTop: jQuery('#frmEdit').offset().top}, 'slow');
        kichhoat(id, 1);
    }
    function xxx1(e){
        var id, email, name, content;
        id = jQuery(e).data('id');
        email = jQuery(e).data('email');
        name = jQuery(e).data('name');
        content = jQuery(e).data('content');
        jQuery('#email').html(email);
        jQuery('#name').html(name);
        jQuery('#content').html(content);
        // window.location.href='#frmEdit';
        jQuery('html,body').animate({
            scrollTop: jQuery('#frmEdit').offset().top}, 'slow');
        kichhoat(id, 1);
    }
    jQuery(document).ready(function(){
        jQuery('.deletepromulti').click(function(){
            var addon = '';
            av = document.getElementsByName("checkboxidfile");
            for(e = 0; e < av.length; e++){
                if(av[e].checked == true){
                    addon += av[e].value + ',';
                }
            }
            if(addon != ''){
                jConfirm("{{Lang::get('messages.delete_confirm')}}", "{{Lang::get('messages.alert')}}", function(r){
                    if(r == true){
                        jQuery.post("{{URL::action('HistoryAdminController@postDelmulte')}}", {multiid: addon}).done(function(data){
                            window.location = '{{URL::action('HistoryAdminController@getHistoryView')}}';
                        });
                        return false;
                    }else{
                        return false;
                    }
                });
            }else{
                jAlert("{{Lang::get('messages.select_empty')}}", "{{Lang::get('messages.alert')}}");
            }
        });

        jQuery('#searchblur').keypress(function(e){
            // Enter pressed?
            if(e.which == 10 || e.which == 13){
                var request = jQuery.ajax({
                    url     : "{{URL::action('HistoryAdminController@postAjaxsearch')}}?keyword=" + jQuery('#searchblur').val(),
                    type    : "POST",
                    dataType: "html"
                });
                request.done(function(msg){
                    jQuery('#tableproduct').html(msg);
                });
            }
        });

        jQuery("#loctheotieuchi").click(function(){
            var request = jQuery.ajax({
                url     : "{{URL::action('HistoryAdminController@postFillterHistory')}}?status=" + jQuery('#oderbyoption1').val() + "&from=" + jQuery('#datepicker').val() + "&to=" + jQuery('#datepicker1').val(),
                type    : "POST",
                dataType: "html"
            });
            request.done(function(msg){
                jQuery('#tableproduct').html(msg);
            });
        });
    });
    function phantrang(page){
        //jQuery("#jGrowl").remove();
        jQuery.jGrowl("{{Lang::get('messages.data_loading')}}");
        var urlpost = "{{URL::action('HistoryAdminController@postAjaxhistoryadmin')}}?page=" + page
        if(jQuery('#oderbyoption1').val() != '' || jQuery('#datepicker').val() != '' || jQuery('#datepicker1').val() != ''){
            urlpost = "{{URL::action('HistoryAdminController@postFillterHistory')}}?status=" + jQuery('#oderbyoption1').val() + "&page=" + page;
        }
        if(jQuery('#searchblur').val() != ''){
            urlpost = "{{URL::action('HistoryAdminController@postAjaxsearch')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
        }
        var request = jQuery.ajax({
            url     : urlpost,
            type    : "POST",
            dataType: "html"
        });
        request.done(function(msg){
            // jQuery("#jGrowl").remove();
            jQuery.jGrowl("{{Lang::get('messages.data_load_success')}}");
            jQuery('#tableproduct').html(msg);
        });
    }
    function xoasanpham(id){
        jConfirm("{{Lang::get('messages.delete_confirm')}}", "{{Lang::get('messages.alert')}}", function(r){
            if(r == true){
                var request = jQuery.ajax({
                    url     : "{{URL::action('HistoryAdminController@postDeleteHistory')}}?id=" + id,
                    type    : "POST",
                    dataType: "html"
                });
                request.done(function(msg){
                    jQuery('#tableproduct').html(msg);
                });
                return false;
            }else{
                return false;
            }
        })
    }
    function kichhoat(id, stus){
        var request = jQuery.ajax({
            url     : "{{URL::action('HistoryAdminController@postHistoryActive')}}?id=" + id + '&status=' + stus,
            type    : "POST",
            dataType: "html"
        });
        request.done(function(msg){
            jQuery('#tableproduct').html(msg);
        });
        return true;
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle uppercase">{{Lang::get('backend/title.history.headingAdmin')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.history.descriptionAdmin')}}</span>
</div>

<div class="contentwrapper">
    @if(isset($msg))
    <div class="notibar msgalert">
        <a class="close"></a>

        <p>{{$msg}}</p>
    </div>
    @endif
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.history.caption_view')}}</h3>
        </div>

        <div class="tableoptions">

            <button class="deletepromulti" title="table1">{{Lang::get('general.delete_select')}}</button>
            &nbsp;
            <label>{{Lang::get('general.date_from')}}: <input id="datepicker" name="from"
                                                              style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;background: #fff;"
                                                              type="text"/></label>
            <label>{{Lang::get('general.date_to')}}: <input id="datepicker1" name="to"
                                                            style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;background: #fff;"
                                                            type="text"/></label>
            &nbsp;
            <button class="radius3" id="loctheotieuchi">{{Lang::get('general.filter')}}</button>


            <div class="dataTables_filter" id="searchformfile1"><label>{{Lang::get('general.search')}}: <input
                        id="searchblur" name="searchblur"
                        style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;"
                        type="text"></label></div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>

                <col class="con0" style="width: 3%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
            </colgroup>
            <thead>
            <tr>
                <th class="head0"></th>

                <th class="head1">{{Lang::get('general.email')}}</th>
                <th class="head0">{{Lang::get('general.full_name')}}</th>
                <th class="head1">{{Lang::get('general.content')}}</th>
                <th class="head0">{{Lang::get('general.time')}}</th>
                <th class="head1">{{Lang::get('general.status')}}</th>
                <th class="head0">{{Lang::get('general.action')}}</th>
            </tr>
            </thead>
            <tbody id="tableproduct">
            @if(isset($arrHistory))
            @foreach($arrHistory as $item)
            <tr>
                <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td>

                <td>
                    <!--<a href="javascript:void(0);" onclick="xxx('{{$item->id}}','{{$item->adminEmail}}','{{$item->adminName}}','{{$item->historyContent}}');">{{str_limit($item->adminEmail, 15, '...')}}</a>-->
                    <?php echo '<a href="javascript:void(0);" onclick="xxx1(this);" data-id="'.$item->id.'" data-email="'.$item->adminEmail.'" data-name="'.$item->adminName.'" data-content="'.$item->historyContent.'">'.str_limit($item->adminEmail, 15, '...').'</a>'; ?>
                </td>
                <td><label value="page">{{str_limit($item->adminName, 15, '...')}} </label></td>
                <td><label value="page">{{str_limit($item->historyContent, 15, '...')}} </label></td>
                <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td>
                <td><label value="page">
                        @if($item->status != 0)
                        {{Lang::get('button.delete')}}
                        @endif
                    </label>
                </td>
                <td>
                    @if($item->status==0)
                    <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash"
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

            @endif
            </tbody>
        </table>

        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.history.caption_detail')}}</h3>
            <div id="frmEdit"></div>
        </div>
        <div>
            <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb">
                <tbody>
                <tr>
                    <td style="width: 20%;border-top:1px solid #eee"><label>{{Lang::get('general.email')}}</label></td>
                    <td style="border-top:1px solid #eee"><div id="email"></div></td>
                </tr>
                <tr>
                    <td style="width: 20%"><label>{{Lang::get('general.full_name')}}</label></td>
                    <td><div id="name"></div></td>
                </tr>
                <tr>
                    <td style="width: 20%"><label>{{Lang::get('general.content')}}</label></td>
                    <td><div id="content"></div></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

