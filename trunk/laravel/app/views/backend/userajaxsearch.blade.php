@foreach($arrayUsers as $item)
<tr> 

    <td><label value="cateUser">{{$item->userEmail }}</label></td> 
    <td><label value="cateUser">{{$item->userFirstName }}</label></td> 
    <td><label value="cateUser">{{str_limit($item->userLastName, 10, '...')}}</label></td> 
    <td><label value="cateUser">{{str_limit($item->userAddress, 10, '...')}} </label></td> 
    <td><label value="cateUser">{{str_limit($item->userPhone, 10, '...')}}</label></td> 
    <td><label value="cateUser">{{str_limit($item->userIdentify, 10, '...')}}</label></td> 
    <td><label value="cateUser">{{str_limit($item->userPoint, 10, '...')}} </label></td> 
    <td><label value="cateUser">{{str_limit($item->verify, 10, '...')}}</label></td> 
    <td><label value="cateUser"><?php echo date('d/m/Y', $item->userTime); ?></label></td> 
    <td><label value="cateUser"><?php
            if ($item->status == 0) {
                echo "chờ kích hoạt";
            } else if ($item->status == 1) {
                echo "kích hoạt";
            } else if ($item->status == 2) {
                echo "khóa";
            }
            ?>
        </label>
    </td> 
    <td>

        <a href="{{URL::action('UserController@getUserEdit')}}?id={{$item->userEmail}}" class="btn btn4 btn_book" title="Sửa"></a>
        @if($item->status=='2')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->userEmail}}, 0)" class="btn btn4 btn_flag" title="Chờ kích hoạt"></a>
        @endif
        @if($item->status=='0')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->userEmail}}, 1)" class="btn btn4 btn_world" title="Kích hoạt"></a>
        @endif
        @if($item->status!='2')
        <a href="javascript: void(0)" onclick="xoasanpham({{$item->userEmail}})" class="btn btn4 btn_trash" title="Xóa"></a>
        @endif
    </td> 
</tr> 
@endforeach
@if($link!='')
<tr>
    <td colspan="11">{{$link}}</td>
</tr>
@endif