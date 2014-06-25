@extends("backend.template")

@section("contentadmin")

<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.user.detail')}}</h1>
    <span class="pagedesc"> {{Lang::get('backend/title.user.heading')}}</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.user.detail')}}</h3>

        </div>
        @if(isset($data))
        <form class="stdform stdform2" id="user" method="get" action=""> 

            <p>
                <label>{{Lang::get('general.email')}}</label>
                <span class="field">{{$data->email}}</span>
            </p>           

            <p>
                <label>{{Lang::get('general.first_name')}}</label>
                <span class="field">&nbsp{{$data->firstname}}</span>
            </p> 
            <p>
                <label>{{Lang::get('general.last_name')}}</label>
                <span class="field">&nbsp{{$data->lastname}}</span>
            </p> 
            <p>
                <label>{{Lang::get('general.date_of_birth')}}</label>
                <span class="field">&nbsp{{date('d/m/Y',$data->dateofbirth)}}</span>
            </p> 
            <p>
                <label>{{Lang::get('general.address')}}</label>
                <span class="field">&nbsp{{$data->address}}</span>
            </p> 
            <p>
                <label>{{Lang::get('general.phone')}}</label>
                <span class="field">&nbsp{{$data->phone}}</span>
            </p> 
        </form>
        @endif
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.user.order')}}</h3>
        </div>
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.user.history')}}</h3>
        </div>
        <p>
            <a href="{{URL::action('\BackEnd\UserController@getUserView')}}" class="btn btn_orange btn_link"><span>{{Lang::get('button.back')}}</span></a>
        </p>
    </div>
</div>
@endsection