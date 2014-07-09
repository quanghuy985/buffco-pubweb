@extends("backend.template")
@section("titleAdmin")
{{Lang::get('backend/title.history.titleUser')}}
@stop
@section("contentadmin")
<script>
    function xxx(id, email, name, content) {
        jQuery('#id').val(id);
        jQuery('#email').val(email);
        jQuery('#name').val(name);
        jQuery('#content').val(content);
        var user_id = jQuery('#user_id').val();
        //window.location.href='#frmEdit';
        jQuery('html,body').animate({
            scrollTop: jQuery('#frmEdit').offset().top}, 'slow');
        kichhoat(id, 1, user_id);
    }

    function xxx1(e) {
        var id, email, name, content;
        id = jQuery(e).data('id');
        email = jQuery(e).data('email');
        name = jQuery(e).data('name');
        content = jQuery(e).data('content');
        jQuery('#id').html(id);
        var user_id = jQuery('#user_id').val();
        jQuery('#email').html(email);
        jQuery('#name').html(name);
        jQuery('#content').html(content);
        // window.location.href='#frmEdit';
        jQuery('html,body').animate({
            scrollTop: jQuery('#frmEdit').offset().top}, 'slow');
        kichhoat(id, 1, user_id);
    }
    jQuery(document).ready(function() {

        jQuery('#deletepromulti').click(function() {
            var user_id = jQuery('#user_id').val();
            var addon = '';
            av = document.getElementsByName("checkboxidfile");
            for (e = 0; e < av.length; e++) {
                if (av[e].checked == true) {
                    addon += av[e].value + ',';
                }
            }
            if (addon != '') {
                jConfirm("{{Lang::get('messages.delete_confirm')}}", "{{Lang::get('messages.alert')}}", function(r) {
                    if (r == true) {
                        jQuery.post("{{URL::action('\BackEnd\HomeController@postDelmulte')}}", {multiid: addon, user: user_id}).done(function(data) {
                            jQuery('#tableproduct').html(data);
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
    });


    function kichhoat(id, stus, user_id) {

        var request = jQuery.ajax({
            url: "{{URL::action('\BackEnd\HomeController@postHistoryActive')}}?id=" + id + '&status=' + stus + '&user=' + user_id,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
        });
        return true;
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.history.headingUser')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.history.headingUser')}}</span>
</div>

<div class="contentwrapper">
    @include('backend.alert')
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.history.descriptionUser')}}</h3>
        </div>
        <h4>{{$objUser->firstname.' '.$objUser->lastname}}</h4>

        <br class='clearall'>
        <div class="tableoptions">
            {{Form::open(array('action'=>'\BackEnd\HomeController@postHistoryUserFillterView','id'=>'filterHistory'))}}

            <input  type="button" class="anchorbutton" id="deletepromulti" title="table1" value="{{Lang::get('general.delete_select')}}"/>
            <label>{{Lang::get('general.date_from')}}: <input id="datepicker" name="from"
                                                              style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;background: #fff;"
                                                              type="text"/></label>
            <label>{{Lang::get('general.date_to')}}: <input id="datepicker1" name="to"
                                                            style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;background: #fff;"
                                                            type="text"/></label>
            <input type="hidden" id="user_id" value="{{$objUser->id}}" name="user_id"/>
            <?php
            $data_status = Lang::get('general.data_status1');
            echo Form::select('fillter_status', $data_status, 3, array('id' => 'fillter_status'));
            ?>
            &nbsp; &nbsp; <button class="anchorbutton" id="loctheotieuchi" type="submit" >{{Lang::get('general.filter')}}</button>
            {{Form::close()}}

        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 3%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head1"></th>
                    <th class="head0">{{Lang::get('general.time')}}</th>
                    <th class="head1">{{Lang::get('general.content')}}</th>
                    <th class="head0">{{Lang::get('general.status')}}</th>
                    <th class="head1">{{Lang::get('general.action')}}</th>
                </tr>
            </thead>

            <tbody id="tableproduct" class="tabledataajax">
                <?php $i = 1 ?>
                @include('backend.admin.adminHistoryAjax')
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

