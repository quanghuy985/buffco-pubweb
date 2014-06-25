@extends("backend.template")

@section("contentadmin")

<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.user.detail')}}</h1>
    <span class="pagedesc"> {{Lang::get('backend/title.user.heading')}}</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">

        <div class="one_half">
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
            <p>
                <a href="{{URL::action('\BackEnd\HistoryUserController@getUserHistory')}}/{{$data->id}}" class="btn btn_orange btn_link"><span>{{Lang::get('button.btHistory')}}</span></a>
            </p>
        </div>

        @if(isset($arrorder))

        <div class="one_half last">
            <div class="contenttitle2">
                <h3>{{Lang::get('backend/title.user.order')}}</h3>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                    <colgroup>
                        <col class="con0" style="width: 3%">
                        <col class="con1" style="width: 25%">
                        <col class="con0" style="width: 21%">
                        <col class="con1" style="width: 21%">
                        <col class="con0" style="width: 30%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="head0">{{Lang::get('general.stt')}}</th>
                            <th class="head1">{{Lang::get('general.order.code')}}</th>
                            <th class="head0">{{Lang::get('general.order.time')}}</th>
                            <th class="head1">{{Lang::get('general.order.status')}}</th>
                            <th class="head0">{{Lang::get('general.action')}}</th>
                        </tr>  
                    </thead>
                    <tbody id="tableproduct" class="tabledataajax">
                        <?php $i = 1 ?>
                        @include('backend.order.historyorder')
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection