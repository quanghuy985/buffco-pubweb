@extends("templateadmin2.mainfire")

@section("contentadmin")

<div class="pageheader notab">
    <h1 class="pagetitle">Nhà sản xuất</h1>
    <span class="pagedesc"> Thêm sửa nhà sản xuất</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Xem chi tiết user</h3>
            
        </div>
        @if(isset($data))
        <form class="stdform stdform2" id="user" method="get" action="{{URL::action('UserController@getUserView')}}"> 
            
            <p>
                <label>Email</label>
                <span class="field"><input disabled="true" type="text" name="dEmail" id="dEmail" value="{{$data->userEmail}}" class="longinput"></span>
            </p>           

            <p>
                <label>Firstname</label>
                <span class="field"><input disabled="true" type="text" name="dFirstName" id="dFirstName" value="{{$data->userFirstName}}" class="longinput"></span>
            </p> 
            <p>
                <label>Lastname</label>
                <span class="field"><input disabled="true" type="text" name="dLastName" id="dLastName" value="{{$data->userLastName}}" class="longinput"></span>
            </p> 
            <p>
                <label>Ngày sinh</label>
                <span class="field"><input disabled="true" type="text" name="dDOB" id="dDOB" value="{{$data->userDOB}}" width="100px"></span>
            </p> 
            <p>
                <label>Địa chỉ</label>
                <span class="field"><input disabled="true" type="text" name="dAddress" id="dAddress" value="{{$data->userAddress}}" class="longinput"></span>
            </p> 
            <p>
                <label>Sdt</label>
                <span class="field"><input disabled="true" type="text" name="dPhone" id="dPhone" value="{{$data->userPhone}}" class="longinput"></span>
            </p> 
            <p class="stdformbutton">
                <button class="submit radius2">Quay về trang quản lý</button>
            </p>
            @endif
        </form>
    </div>
</div>
@endsection