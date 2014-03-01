@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">THÀNH VIÊN</h1>
    <span class="pagedesc">Thêm mới thành viên</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Trang đăng ký</h3>
        </div>
        @if(isset($message)) <h4 class="alert_warning">{{$message}}</h4>@endif
        <form class="stdform stdform2" method="post" action="@if(isset($userdata)) {{URL::action('UserController@postUserEdit')}} @else {{URL::action('UserController@postAddUser')}}@endif">
            <p>
                <input type="hidden" name="emailupdate" id="status" value="@if(isset($userdata)){{$userdata->userEmail}}@endif"/>
                <label>Email :</label>
                <span class="field"><input type="text" name="userEmail" placeholder=" eg: John@email.com" @if(isset($userdata))disabled @endif  value="@if(isset($userdata)){{$userdata->userEmail}}@endif" class="longinput"></span>
            </p>
            <p>
                <label>Mật Khẩu :</label>
                <span class="field"><input type="password" name="userPassword" placeholder="@if(isset($userdata))Để trống nếu không thay đổi @else Nhập mật khẩu @endif" class="longinput"></span>
            </p>

            <p>
                <label>Tên</label>
                <span class="field"><input type="text" name="userFirstName" placeholder="Vui lòng nhập tên" value="@if(isset($userdata)){{$userdata->userFirstName}}@endif" class="longinput"></span>
            </p>

            <p>
                <label>Họ và đệm</label>
                <span class="field"><input type="text" name="userLastName" placeholder="Vui lòng nhập họ và đệm" value="@if(isset($userdata)){{$userdata->userLastName}}@endif" class="longinput"></span>
            </p>

            <p>
                <label>Địa chỉ</label>
                <span class="field"><input type="text" name="userAddress" placeholder="Vui lòng nhập địa chỉ " value="@if(isset($userdata)){{$userdata->userAddress}}@endif" class="longinput"></span>
            </p>

            <p>
                <label>Điện thoại</label>
                <span class="field"><input type="text" name="userPhone" placeholder="Vui lòng nhập số điện thoại " value="@if(isset($userdata)){{$userdata->userPhone}}@endif" class="longinput"></span>
            </p>
            <p>
                <label>Số CMND</label>
                <span class="field"><input type="text" name="userIdentify" placeholder="Vui lòng nhập số CMND " value="@if(isset($userdata)){{$userdata->userIdentify}}@endif" class="longinput"></span>
            </p>
            @if(isset($userdata))
            <p>
                <label>Điểm tích lũy</label>
                <span class="field"><input type="text" name="userPoint" placeholder="Điểm tích lũy " value="@if(isset($userdata)){{$userdata->userPoint}}@endif" class="longinput"></span>
            </p>
            @endif
            <p>
                <label>Trạng thái</label>
                <span class="field">
                    <select name="status">
                        <option value="0" @if(isset($userdata)&& $userdata->status==0)selected@endif >Chờ kích hoạt</option>
                        <option value="1" @if(isset($userdata)&& $userdata->status==1)selected@endif>Kích hoạt</option>
                        <option value="2" @if(isset($userdata)&& $userdata->status==2)selected@endif>Xóa</option>
                    </select>
                </span>
            </p>
            <p class="stdformbutton">
                <button class="submit radius2" value="@if(isset($userdata))Cập nhật @else Thêm mới @endif ">@if(isset($userdata))Cập nhật @else Thêm mới @endif </button>
                <input type="reset" class="reset radius2" value="Làm mới">
            </p>
        </form>
    </div>
</div>

@endsection