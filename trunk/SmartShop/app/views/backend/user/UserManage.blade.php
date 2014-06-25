@extends("backend.template")
@section("contentadmin")
<style>
    .stdform label {
        float: left;
        padding: 5px 20px 0 0;
        text-align: right;
        width: 35%;
    }
    .stdform span.field, .stdform div.field {
        display: block;
        margin-left: 35%;
        position: relative;
    }
    .three_fifth {
        width: 55.9%;
    }
    .tableoptions{
        margin-top: 20px;
    }
</style>
<script>

    jQuery(document).ready(function() {
        jQuery("#addUserForm").validate({
            rules: {
                email: {required: true, email: true},
                firstname: {required: true},
                lastname: {required: true},
                address: {required: true},
                dateofbirth: {required: true},
                phone: {required: true, number: true},
                password: {required: true},
            }
        });
    });

</script>

<div class="pageheader notab">
    <h1 class="pagetitle">Quản lý thành viên</h1>
    <span class="pagedesc">Quản lý thành viên</span>
</div>
<div class="contentwrapper">
    <div class="two_fifth">
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
        </div>
        @include('backend.alert')
        @if(isset($arrayUsers))
        {{Form::model($arrayUsers,  array('action'=>'\BackEnd\UserController@postUpdateUser', 'class'=>'stdform', 'id'=>'adminForm'))}}
        @else
        {{Form::open(array('action'=>'\BackEnd\UserController@postAddUser', 'class'=>'stdform','id'=>'addUserForm'))}}
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
            <label>{{Lang::get('general.password')}}</label>
            <span class="field">
                <input type="password" name="password" placeholder="@if(isset($arrayUsers)){{Lang::get('placeholder.empty_no_change')}}@endif" class="longinput">
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
    <div class="three_fifth">
        <div class="contenttitle2">
            <h3>Bảng quản lý thành viên</h3>
        </div>
        <div class="tableoptions">
            {{Form::open(array('action'=>'\BackEnd\UserController@postFillterUsers', 'class'=>'stdform stdform2','id'=>'fillterfrom'))}}
            <select class="radius3" name="fillter_status" id="fillter_status">
                <option value="">Tất cả</option>
                <option value="0">Chờ kích hoạt</option>
                <option value="1">Đã kích hoạt</option>
                <option value="2">Xóa</option>
            </select>&nbsp;
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
                <col class="con1" style="width: 37%">
                <col class="con1" style="width: 20%">
                <col class="con1" style="width: 20%">
                <col class="con1" style="width: 20%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0">STT</th>
                    <th class="head1">Email</th>
                    <th class="head1">Số điện thoại</th>
                    <th class="head0">Tình trạng</th>
                    <th class="head1">Chức năng</th>
                </tr>
            </thead>

            <tbody id="tableproduct" class="tabledataajax">
                @include('backend.user.Userajax')
            </tbody>
        </table>

    </div>
</div>
@endsection

