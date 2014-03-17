@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
    var request = jQuery.ajax({
    url: "{{URL::action('AdminController@postAjaxpagion')}}?link=" + page,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
    }
     function xoasanpham(id) {
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('AdminController@postDeleteAdmin')}}?id=" + id,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
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
    url: "{{URL::action('AdminController@postAdminActive')}}?id=" + id + '&status=' + stus,
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
    <h1 class="pagetitle">QUẢN LÝ ADMIN</h1>
    <span class="pagedesc">Quản lý admin</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Bảng Admin</h3>
    </div>
    <div class="contentwrapper">
        <div class="subcontent">
            @if(isset($thongbao))
            <div class="notibar msgalert">
                <a class="close"></a>
                <p>{{$thongbao}}</p>
            </div>
            @endif
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con1" style="width: 5%">
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 20%">
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1">STT</th>
                        <th class="head0">Admin Email</th>
                        <th class="head1">Họ tên</th>
                        <th class="head0">Admin Roles</th>
                        <th class="head1">Khởi tạo</th>
                        <th class="head0">Tình trạng</th>
                        <th class="head1">Chức năng</th>
                    </tr>  
                </thead>
                <?php $i = 1 ?>
                <tbody id="tableproduct">
                    @foreach($arrayAdmin as $item)
                    <tr> 
                        <td><label value="cateMenuer">{{$i++ }}</label></td> 
                        <td><label value="cateMenuer">{{str_limit( $item->adminEmail, 30, '...')}}</label></td>
                        <td><label value="cateMenuer">{{str_limit( $item->adminName, 30, '...')}}</label></td>
                        <td><label value="cateMenuer"> <?php
                                if ($item->adminRoles == 0) {
                                    echo "Supper Admin";
                                } else if ($item->adminRoles == 1) {
                                    echo "Admin";
                                } else if ($item->adminRoles == 2) {
                                    echo "Nhân viên kinh doanh";
                                } else if ($item->adminRoles == 3) {
                                    echo "Kỹ thuật viên";
                                }
                                ?>
                            </label>
                        </td>
                        <td><label value="cateMenuer"><?php echo date('d/m/Y h:i:s', $item->adminTime); ?></label></td> 
                        <td><label value="cateMenuer"><?php
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

                            <a href="{{URL::action('AdminController@getAdminEdit')}}?id={{$item->adminEmail}}" class="btn btn4 btn_book" title="Sửa"></a>
                            @if($item->status=='2')
                            <a href="javascript: void(0)" onclick="kichhoat('{{$item->adminEmail}}', 0)" class="btn btn4 btn_flag" title="Khởi tạo"></a>
                            @endif
                            @if($item->status=='0')
                            <a href="javascript: void(0)" onclick="kichhoat('{{$item->adminEmail}}', 1)" class="btn btn4 btn_world" title="Kích hoạt"></a>
                            @endif
                            @if($item->status!='2')
                            <a href="javascript: void(0)" onclick="xoasanpham('{{$item->adminEmail}}')" class="btn btn4 btn_trash" title="Xóa"></a>
                            @endif

                        </td> 
                    </tr> 
                    @endforeach
                    @if($link!='')
                    <tr>
                        <td colspan="4">{{$link}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    <div class="contenttitle2">
        <h3>Bảng thêm và chỉnh sửa</h3>
    </div>
    <form class="stdform stdform2" method="post" action="@if(isset($AdminData)) {{URL::action('AdminController@postUpdateAdmin')}} @else {{URL::action('AdminController@postAddAdmin')}}@endif">
        <p>
            <input type="hidden" name="adminEmail" id="status" value="@if(isset($AdminData)){{$AdminData->adminEmail}}@endif"/>
            <input type="hidden" name="id" id="idnews" value="@if(isset($AdminData)){{$AdminData->id}}@endif"/>
            <label>Email :</label>
            <span class="field"><input type="text" name="adminEmail" placeholder=" eg: John@email.com" @if(isset($AdminData))disabled @endif  value="@if(isset($AdminData)){{$AdminData->adminEmail}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Họ tên Admin</label>
            <span class="field"><input type="text" name="adminName" placeholder="Nhập họ tên Admin" value="@if(isset($AdminData)){{$AdminData->adminName}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Mật Khẩu :</label>
            <span class="field"><input type="password" name="adminPassword" placeholder="@if(isset($AdminData))Để trống nếu không thay đổi @else Nhập mật khẩu @endif" class="longinput"></span>
        </p>
        <p>
            <label>Chức năng Admin</label>
            <span class="field">
                <select name="adminRoles">
                    <option value="1" @if(isset($AdminData)&& $AdminData->adminRoles==1)selected@endif >Admin</option>
                    <option value="2" @if(isset($AdminData)&& $AdminData->adminRoles==2)selected@endif>Nhân viên kinh doanh</option>
                    <option value="3" @if(isset($AdminData)&& $AdminData->adminRoles==3)selected@endif>Kỹ thuật viên</option>
                </select>
            </span>
        </p>
        <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status">
                    <option value="0" @if(isset($AdminData)&& $AdminData->status==0)selected@endif >Chờ kích hoạt</option>
                    <option value="1" @if(isset($AdminData)&& $AdminData->status==1)selected@endif>Kích hoạt</option>
                    <option value="2" @if(isset($AdminData)&& $AdminData->status==2)selected@endif>Xóa</option>
                </select>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($AdminData))Cập nhật @else Thêm mới @endif ">@if(isset($AdminData))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới">
        </p>
    </form>
</div>
@endsection