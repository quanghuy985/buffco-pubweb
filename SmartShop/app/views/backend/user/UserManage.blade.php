@extends("backend.template")
@section("contentadmin")

<script>

    jQuery(document).ready(function() {
    jQuery("#addUserForm").validate({
    rules: {
    email: {required: true, email: true},
            confirm: {equalTo: "#userPassword"},
            userFirstName: {required: true},
            userLastName: {required: true},
            userAddress: {required: true},
            userPhone: {required: true, number: true, minlength: 10, maxlength: 11}
    }
    });
            jQuery('.deletepromulti').click(function() {
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
    NProgress.start();
            jQuery.post("{{URL::action('\BackEnd\UserController@postDelmulte')}}", {multiid: addon}).done(function(data) {
    jQuery('#tableproduct').html(data);
            NProgress.done();
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
            jQuery('#searchblur').keypress(function(e) {
    NProgress.start();
            // Enter pressed?
            if (e.which == 10 || e.which == 13) {
                    jQuery("#oderbyoption1").val('');
    var urlr = "{{URL::action('\BackEnd\UserController@postAjaxsearch')}}?keywordsearch=" + jQuery('#searchblur').val();
            var request = jQuery.ajax({
            url: urlr,
                    type: "POST",
                    dataType: "html"
            });
            request.done(function(msg) {
            window.history.pushState({path: "{{URL::action('\BackEnd\UserController@postAjaxsearch')}}"}, '', "{{URL::action('\BackEnd\UserController@postAjaxsearch')}}");
                    reLoad();
                    jQuery('#tableproduct').html(msg);
                    NProgress.done();
            });
    }
    });
            jQuery("#loctheotieuchi").click(function() {
    jQuery("#searchblur").val('');
            NProgress.start();
            var request = jQuery.ajax({
            url: "{{URL::action('\BackEnd\UserController@postFillterUser')}}",
                    data: {selectoptionnum: jQuery('#selectoptionnum').val(), oderbyoption: jQuery('#oderbyoption').val(), oderbyoption1: jQuery('#oderbyoption1').val()},
                    type: "POST",
                    dataType: "html"
            });
            request.done(function(msg) {
            window.history.pushState({
            path: "{{URL::action('\BackEnd\UserController@postFillterUser')}}"
            }, '', "{{URL::action('\BackEnd\UserController@postFillterUser')}}");
                    reLoad();
                    jQuery('#tableproduct').html(msg);
                    NProgress.done();
            });
    });
    });
            function phantrang(page) {
            var request = jQuery.ajax({
            url: "{{URL::action('\BackEnd\UserController@postAjaxpagion')}}?page=" + page,
                    type: "POST",
                    dataType: "html"
            });
                    request.done(function(msg) {
                    reLoad();
                            jQuery('#tableproduct').html(msg);
                    });
            }
    function reLoad() {
    jQuery('html, body').animate({scrollTop: jQuery(".contenttitle2").offset().top}, 1000);
    }
    function xoasanpham(id) {
    jConfirm("{{Lang::get('messages.delete_confirm')}}", "{{Lang::get('messages.alert')}}", function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('\BackEnd\UserController@postDeleteUser')}}?id=" + id,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            reLoad();
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
    url: "{{URL::action('\BackEnd\UserController@postUserActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    }
    );
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
                    reLoad();
            });
            return true;
    }
</script>

<div class="pageheader notab">
    <h1 class="pagetitle">Quản lý thành viên</h1>
    <span class="pagedesc">Quản lý thành viên</span>
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
            <h3>Bảng quản lý thành viên</h3>
        </div>
        <div>
            @include('backend.alert')
        </div>
        <div class="tableoptions">
            <button class="deletepromulti" title="table1">Xóa đã chọn</button>
            &nbsp;
            <select class="radius3" name="oderbyoption1" id="oderbyoption1">
                <option value="">Tất cả</option>
                <option value="0">Chờ kích hoạt</option>
                <option value="1">Đã kích hoạt</option>
                <option value="2">Xóa</option>
            </select>&nbsp;
            <button class="radius3" id="loctheotieuchi">Lọc theo tiêu chí</button>
            <div class="dataTables_filter1" id="searchformfile"><label>Search: <input value="{{Input::get('keywordsearch')}}" id="searchblur" name="searchblur" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;" type="text"></label></div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 3%">
                <col class="con1" style="width: 10%">
                <col class="con1" style="width: 10%">
                <col class="con1" style="width: 10%">
                <col class="con1" style="width: 15%">
                <col class="con1" style="width: 10%">
                <col class="con1" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0"></th>
                    <th class="head1">Email</th>
                    <th class="head0">Địa chỉ</th>
                    <th class="head1">Số điện thoại</th>
                    <th class="head1">Khởi tạo</th>
                    <th class="head0">Tình trạng</th>
                    <th class="head1">Chức năng</th>
                </tr>
            </thead>

            <tbody id="tableproduct" class="tabledataajax">
                @foreach($arrUser as $item)
                <tr>
                    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td>
                    <td><a href="{{URL::action('\BackEnd\UserController@getUserDetail')}}?email={{$item->email}}">{{str_limit(
                        $item->email, 10, '...')}}</a></td>
                    <td><label value="user">{{str_limit( $item->address, 10, '...')}}</label></td>
                    <td><label value="user">{{str_limit($item->phone, 10, '...')}} </label></td>
                    <td><label value="user"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td>
                    <td><label value="user">
                            <?php
                            if ($item->status == 0) {
                                echo "chờ kích hoạt";
                            } else if ($item->status == 1) {
                                echo "đã kích hoạt";
                            } else if ($item->status == 2) {
                                echo "đã xóa";
                            }
                            ?>
                        </label>
                    </td>
                    <td>
                        <a href="{{URL::action('\BackEnd\UserController@getUserEdit')}}?id={{$item->email}}" class="btn btn4 btn_book"
                           title="Sửa" onclick="focus()"></a>
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item -> id}}, 0)" class="btn btn4 btn_flag"
                           title="Chờ kích hoạt"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item -> id}}, 1)" class="btn btn4 btn_world"
                           title="Kích hoạt"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item -> id}})" class="btn btn4 btn_trash"
                           title="Xóa"></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="7">{{$link}}</td>
                </tr>
                @endif


            </tbody>
        </table>

        <div class="contenttitle2" id="editUser">
            <h3>
                Thêm/Sửa thành viên
                @if(isset($arrayUsers))
                <script>jQuery(document).ready(function() {
                    jQuery('html, body').animate({scrollTop: jQuery("#addUserForm").offset().top}, 1000);
                    })</script>
                @else

                @endif
            </h3>
            <a name="focus"></a>
        </div>
        @if(isset($arrayUsers))
        {{Form::model($arrayUsers,  array('action'=>'\BackEnd\UserController@postUpdateUser', 'class'=>'stdform stdform2', 'id'=>'adminForm'))}}
        @else
        {{Form::open(array('action'=>'\BackEnd\UserController@postAddUser', 'class'=>'stdform stdform2'))}}
        @endif
        <p>
            {{Form::hidden('id')}}
        </p>
        <p>
            <label>{{Lang::get('general.email')}}</label>
            <span class="field">
                @if(isset($arrayUsers))
                <input type="text" name="email" @if(isset($arrayUsers))disabled @endif  value="{{$arrayUsers->email}}" class="longinput">
                       <input type="hidden" name="email" id="email" value="{{$arrayUsers->email}}"/>
                @else
                {{Form::text('email', null, array('class'=>'longinput'))}}
                @endif
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.first_name')}}</label>
            <span class="field">
                {{Form::text('firstname', null, array('class'=>'longinput'))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.last_name')}}</label>
            <span class="field">
                {{Form::text('lastname', null, array('class'=>'longinput'))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.date_of_birth')}}</label>
            <span class="field">
                <input id="datepicker" name="dateofbirth" type="text" class="longinput" value="@if(isset($arrayUsers)&&$arrayUsers->dateofbirth!=''){{date('d/m/Y',$arrayUsers->dateofbirth)}}@endif" />
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.address')}}</label>
            <span class="field">
                <textarea cols="80" rows="5" class="longinput" name="address">@if(isset($arrayUsers)&&$arrayUsers->address!=''){{$arrayUsers->address}}@endif</textarea>
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.phone')}}</label>
            <span class="field">
                {{Form::text('phone', null, array('class'=>'longinput'))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.password')}}</label>
            <span class="field">
                <input type="password" name="password" placeholder="@if(isset($arrayUsers)){{Lang::get('placeholder.empty_no_change')}}@endif" class="longinput">
            </span>
        </p>
        @if(isset($arrayUsers))
        <p>
            <label>{{Lang::get('general.status')}}</label>
            <span class="field">
                <?php
                $user_status = Lang::get('general.user_status');
                echo Form::select('status', $user_status);
                ?>
            </span>
        </p>
        @endif
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($arrayUsers)){{Lang::get('button.update')}}@else {{Lang::get('button.add')}} @endif ">@if(isset($arrayUsers)){{Lang::get('button.update')}} @else {{Lang::get('button.add')}} @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới">
        </p>
        {{Form::close()}}
    </div>
</div>
@endsection

