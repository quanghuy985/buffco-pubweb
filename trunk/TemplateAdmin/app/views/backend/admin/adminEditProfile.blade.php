@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">Quản Lý thông tin cá nhân</h1>
    <span class="pagedesc">Quản lý Profile</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Chỉnh sửa Profile</h3>
    </div>
    <form class="stdform stdform2"  method="post" action="@if(isset($dataProfile)) {{URL::action('AdminController@postProfileAdmin')}} @endif">
        <p>
            <input type="hidden" name="adminEmail" id="status" value="@if(isset($dataProfile)){{$dataProfile->adminEmail}}@endif"/>
            <input type="hidden" name="id" id="idnews" value="@if(isset($AdminData)){{$AdminData->id}}@endif"/>
            <label>Email :</label>
            <span class="field"><input type="text" name="adminEmail" placeholder=" eg: John@email.com" @if(isset($dataProfile))disabled @endif  value="@if(isset($dataProfile)){{$dataProfile->adminEmail}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Họ tên Admin</label>
            <span class="field"><input type="text" name="adminName" placeholder="Nhập họ tên Admin" value="@if(isset($dataProfile)){{$dataProfile->adminName}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Mật Khẩu :</label>
            <span class="field"><input type="password" name="adminPassword" placeholder="@if(isset($dataProfile))Để trống nếu không thay đổi @else Nhập mật khẩu cần thay đổi@endif" class="longinput"></span>
        </p>        
    
    <p class="stdformbutton">
        <button class="submit radius2" value="@if(isset($dataProfile))Cập nhật @else Thêm mới @endif ">@if(isset($dataProfile))Cập nhật @else Thêm mới @endif </button>
        <input type="reset" class="reset radius2" value="Làm mới">
    </p>
</form>
</div>
@endsection