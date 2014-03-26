<?php $i = ($arrayAdmin->getCurrentPage() - 1) * 10 + 1; ?>
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