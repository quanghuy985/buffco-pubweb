@extends("backend.template")
@section("titleAdmin")
{{Lang::get('backend/title.profile.title')}}
@stop
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.profile.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.profile.description')}}</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>{{Lang::get('backend/title.profile.caption')}}</h3>
    </div>
    @include('backend.alert')
    {{Form::model($dataProfile, array('action'=>'\BackEnd\AdminController@postProfileAdmin', 'class'=>'stdform'))}}
    <p></p>
    <p>
        <label>{{Lang::get('general.email')}}</label>
        <span class="field">
            <input type="text" disabled value="{{$dataProfile->email}}" class="longinput">
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
            <input id="datepicker" name="dateofbirth" type="text" class="longinput" value="@if(isset($dataProfile)&&$dataProfile->dateofbirth!=''){{date('d/m/Y',$dataProfile->dateofbirth)}}@endif" />
        </span>
    </p>
    <p>
        <label>{{Lang::get('general.address')}}</label>
        <span class="field">
            <textarea cols="80" rows="5" class="longinput" name="address">@if(isset($dataProfile)&& $dataProfile->address!=''){{$dataProfile->address}}@endif</textarea>
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
            <input type="password" name="password" placeholder="@if(isset($dataProfile)){{Lang::get('placeholder.empty_no_change')}}@endif" class="longinput">
        </span>
    </p>      

    <p class="stdformbutton">
        <button class="submit radius2" style="margin-left: 30px;">@if(isset($dataProfile)){{Lang::get('button.update')}}@else {{Lang::get('button.add')}} @endif </button>
        <input type="reset" class="reset radius2" value="{{Lang::get('button.reset')}}">
    </p>
    {{Form::close()}}
</div>
@endsection