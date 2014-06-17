@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.admin.title')}}
@stop
@section("contentadmin")
<script>

    function reLoad() {
        jQuery('html, body').animate({scrollTop: jQuery(".contenttitle2").offset().top}, 1000);
    }
    jQuery(document).ready(function() {
        jQuery("#adminAddForm").validate({
            rules: {
                email: {required: true, maxlength: 255},
                firstname: {required: true, maxlength: 255},
                lastname: {required: true, maxlength: 255},
                datepicker: {required: true},
                address: {required: true},
                phone: {required: true},
                password: {required: true}
            }
        });
    });
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.admin.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.admin.description')}}</span>
</div>
<div class="contentwrapper" id="adminFormAjax">
    @if(isset($AdminData))
<!--    <script>jQuery(document).ready(function(){jQuery('html, body').animate({ scrollTop: jQuery("#adminForm").offset().top}, 1000);})</script>-->
    {{Form::model($AdminData,  array('action'=>'\BackEnd\AdminController@postUpdateAdmin', 'class'=>'stdform', 'id'=>'adminUpdateForm'))}}
    @else
    {{Form::open(array('action'=>'\BackEnd\AdminController@postAddAdmin', 'class'=>'stdform','id'=>'adminAddForm'))}}
    @endif
    <p>
        {{Form::hidden('id')}}
    </p>
    <div class="two_third photosharing_wrapper">
        @include('backend.alert')
        <div class="contenttitle2">
            <h3> @if(isset($AdminData)){{Lang::get('backend/title.admin.edit')}}@else{{Lang::get('backend/title.admin.add')}}    @endif</h3>
        </div>
        <p></p>
        <p>
            <label>{{Lang::get('general.email')}}</label>
            <span class="field">
                {{Form::text('email', null, array('id'=>'email','class'=>'longinput', 'placeholder'=>Lang::get('placeholder.email')))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.first_name')}}</label>
            <span class="field">
                {{Form::text('firstname', null, array('id'=>'firstname','class'=>'longinput', 'placeholder'=>Lang::get('placeholder.firstname')))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.last_name')}}</label>
            <span class="field">
                {{Form::text('lastname', null, array('id'=>'lastname','class'=>'longinput', 'placeholder'=>Lang::get('placeholder.lastname')))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.date_of_birth')}}</label>
            <span class="field">
                <input id="datepicker" name="dateofbirth" type="text" class="longinput" value="@if(isset($AdminData)&&$AdminData->dateofbirth!=''){{date('d/m/Y',$AdminData->dateofbirth)}}@endif" />
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.address')}}</label>
            <span class="field">
                <textarea cols="80" rows="5" class="longinput" id="address" name="address" >@if(isset($AdminData)&&$AdminData->address!=''){{$AdminData->address}}@endif</textarea>
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.phone')}}</label>
            <span class="field">
                {{Form::text('phone', null, array('id'=>'phone','class'=>'longinput', 'placeholder'=>Lang::get('placeholder.phone')))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.password')}}</label>
            <span class="field">
                <input type="password" id="password" name="password" placeholder="@if(isset($AdminData)){{Lang::get('placeholder.empty_no_change')}}@endif" class="longinput">
            </span>
        </p>
    </div>
    <div class="one_third last ps_sidebar">
        <div class="contenttitle3">
            <h3>{{Lang::get('general.admin_roles')}}</h3>
        </div>
        <div id="scroll1" class="mousescroll">
            <ul class="cateaddproduct" id="cateaddproduct">
                @foreach($arrRoles as $itemRoles)
                &nbsp &nbsp &nbsp<input style="float: left;width: 100px;" type="checkbox" name="roles[]" @if(isset($listRolesSelect))  @foreach($listRolesSelect as $itemRolesExist)
                                        @if($itemRolesExist->rolesID == $itemRoles->id)checked @endif
                                        @endforeach @endif id="checkboktest" value="{{$itemRoles->id}}"  \>{{$itemRoles->rolesDescription}}
                                        <br/> 
                @endforeach
                <br>
            </ul>
        </div>
        <br clear="all">
        <div class="contenttitle3">
            <h3>Chức năng</h3>
        </div>
        @if(isset($AdminData))

        <?php
        $user_status = Lang::get('general.user_status');
        echo Form::select('status', $user_status);
        ?>
        @endif
        <br clear="all">
        <br>
        <button class="submit radius2">@if(isset($AdminData)){{Lang::get('button.update')}} @else{{Lang::get('button.add')}}@endif </button>
        <br clear="all">
    </div>


    {{Form::close()}}
    <style>

        .cateaddproduct {
            list-style: none outside none;
            padding-left: 15px;
        }

        .cateaddproduct ul {
            list-style: none outside none;
            padding-left: 20px;
        }
    </style>
    <script>
        jQuery('#scroll1').slimscroll({
            color: '#666',
            size: '10px',
            width: '100%',
            height: '300px',
            border: 'medium none'
        });
    </script>
</div>
@endsection

