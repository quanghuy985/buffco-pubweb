@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
   
    function xoasanpham(id) {
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('GroupAdminController@postDeleteGroupAdmin')}}?id=" + id,
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
    url: "{{URL::action('GroupAdminController@postGroupAdminActive')}}?id=" + id + '&status=' + stus,
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
    <h1 class="pagetitle">QUẢN LÝ QUYỀN ADMIN</h1>
    <span class="pagedesc">Quản lý quyền</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Bảng nhóm admin</h3>
    </div>
    <div class="contentwrapper">
        <div class="subcontent">
            @if(isset($thongbao))
            <div class="notibar msgalert">
                <a class="close"></a>
                <p>{{$thongbao}}</p>
            </div>
            @endif
            <table  cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
                <colgroup>
                    <col class="con1" style="width: 5%">
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 20%">
                    <col class="con0" style="width: 20%">                  
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 20%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1 nosort">STT</th>
                        <th class="head0">Tên Nhóm</th>
                        <th class="head1">Miêu tả</th>
                        <th class="head1">Khởi tạo</th>
                        <th class="head0">Tình trạng</th>
                        <th class="head1 nosort">Chức năng</th>
                    </tr>  
                </thead>
                <?php $i = 1 ?>
                <tbody id="tableproduct">
                    @foreach($arrGroupAdmin as $item)
                    <tr> 
                        <td><label value="cateMenuer">{{$i++ }}</label></td> 
                        <td><label value="cateMenuer">{{str_limit( $item->groupadminName, 30, '...')}}</label></td>
                        <td><label value="cateMenuer">{{str_limit( $item->groupadminDescription, 30, '...')}}</label></td>
                        <td><label value="cateMenuer"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td> 
                        <td><label value="cateMenuer"><?php
                                if ($item->status == 0) {
                                    echo "ch�? kích hoạt";
                                } else if ($item->status == 1) {
                                    echo "đã kích hoạt";
                                } else if ($item->status == 2) {
                                    echo "đã xóa";
                                }
                                ?>
                            </label>
                        </td> 
                        <td>

                            <a href="{{URL::action('GroupAdminController@getGroupAdminEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                            @if($item->status=='2')
                            <a href="javascript: void(0)" onclick="kichhoat('{{$item->id}}', 0)" class="btn btn4 btn_flag" title="Khởi tạo"></a>
                            @endif
                            @if($item->status=='0')
                            <a href="javascript: void(0)" onclick="kichhoat('{{$item->id}}', 1)" class="btn btn4 btn_world" title="Kích hoạt"></a>
                            @endif
                            @if($item->status!='2')
                            <a href="javascript: void(0)" onclick="xoasanpham('{{$item->id}}')" class="btn btn4 btn_trash" title="Xóa"></a>
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
    <form class="stdform stdform2" method="post" action="@if(isset($objGroupAdmin)) {{URL::action('GroupAdminController@postUpdateGroupAdmin')}} @else {{URL::action('GroupAdminController@postAddGroupAdmin')}}@endif">
        <p>
            <input type="hidden" name="id" id="idnews" value="@if(isset($objGroupAdmin)){{$objGroupAdmin->id}}@endif"/>
            <label>Tên Nhóm</label>
            <span class="field"><input type="text" name="groupAdminName" placeholder="Nhập tên nhóm" value="@if(isset($objGroupAdmin)){{$objGroupAdmin->groupadminName}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Miêu tả</label>
            <span class="field"><input type="text" name="groupAdminDescription" placeholder="Nhập miêu tả cho nhóm" value="@if(isset($objGroupAdmin)){{$objGroupAdmin->groupadminDescription}}@endif" class="longinput"></span>
        </p>

        <p>
            <label>Quyền nhóm</label>
            <span class="field">
                @foreach($arrGroupRoles as $itemGroupRoles)
                <strong>{{$itemGroupRoles->grouprolesName}}</strong>
                <br>
                @foreach($arrRoles as $itemRoles)
                @if($itemRoles->grouprolesID==$itemGroupRoles->id)

                &nbsp &nbsp &nbsp<input type="checkbox" name="roles[]" @if(isset($arrGroupAdminRolesExist)) @foreach($arrGroupAdminRolesExist as $itemRolesExist)
                                        @if($itemRolesExist->rolesCode == $itemRoles->rolesCode)checked @endif
                                        @endforeach @endif id="checkboktest" value="{{$itemRoles->id}}"  \>{{$itemRoles->rolesDescription}} 
                                        @endif
                                        @endforeach
<br>
                                        @endforeach
            </span>
        </p>

        <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status">
                    <option value="0" @if(isset($objGroupAdmin)&& $objGroupAdmin->status==0)selected@endif >Chờ kích hoạt</option>
                    <option value="1" @if(isset($objGroupAdmin)&& $objGroupAdmin->status==1)selected@endif>Kích hoạt</option>
                    <option value="2" @if(isset($objGroupAdmin)&& $objGroupAdmin->status==2)selected@endif>Xóa</option>
                </select>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($objGroupAdmin))Cập nhật @else Thêm mới @endif ">@if(isset($objGroupAdmin))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới">
        </p>
    </form>
</div>
@endsection