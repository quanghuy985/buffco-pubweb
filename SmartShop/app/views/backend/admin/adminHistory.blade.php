@extends("templateadmin2.mainfire")
@section('titleAdmin')
{{Lang::get('backend/title.history.global')}}
@stop
@section("contentadmin")
<script>
    jQuery(document).ready(function(){   
    
    jQuery('#searchblur').keypress(function(e) {
    // Enter pressed?
    if (e.which == 10 || e.which == 13) {
        jQuery.jGrowl("{{Lang::get('messages.data_loading')}}");
    var request = jQuery.ajax({
    url: "{{URL::action('AdminController@postAjaxsearch')}}?keyword=" + jQuery('#searchblur').val(),
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
                jQuery('#tableproduct').html(msg);
                jQuery.jGrowl("{{Lang::get('messages.data_load_success')}}");
            });
    }
    });      
    });
    
    function phantrang(page) {
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("{{Lang::get('messages.data_loading')}}");
        var urlpost = "{{URL::action('AdminController@postAjaxhistory')}}?page=" + page
        
        if (jQuery('#searchblur').val() != '') {
            urlpost = "{{URL::action('AdminController@postAjaxsearch')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
        }
        var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery("#jGrowl").remove();
            jQuery.jGrowl("{{Lang::get('messages.data_load_success')}}");
            jQuery('#tableproduct').html(msg);
        });
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.history.global')}}</h1>
</div>

<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.history.global_caption')}}</h3>
        </div>            
        <div class="dataTables_filter" id="searchformfile"><label>{{Lang::get('general.search')}} <input id="searchblur" name="searchblur" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;" type="text"></label></div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 10%">
                
            </colgroup>
            <thead>
                <tr>
                    <th class="head1">{{Lang::get('general.email')}}</th>
                    <th class="head0">{{Lang::get('general.full_name')}}</th>
                    <th class="head1">{{Lang::get('general.content')}}</th>
                    <th class="head0">{{Lang::get('general.time')}}</th>
                </tr>  
            </thead>
            <tbody id="tableproduct">
            @include('backend.admin.adminHistoryAjax')
            </tbody>
        </table>
        
        
    </div>
</div>
@endsection

