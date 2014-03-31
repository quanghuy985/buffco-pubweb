@foreach($arrSupporterGroup as $item)
<tr> 

    <td><label value="cateMenuer">{{$item->id }}</label></td> 
    <td><label value="cateMenuer">{{str_limit( $item->supporterGroupName, 30, '...')}}</label></td>
    <td><label value="cateMenuer"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td> 
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

        <a href="{{URL::action('SupporterGroupController@getSupporterGroupEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
        @if($item->status=='2')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="Khởi tạo"></a>
        @endif
        @if($item->status=='0')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="Kích hoạt"></a>
        @endif
        @if($item->status!='2')
        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
        @endif

    </td> 
</tr> 
@endforeach
@if($link!='')
<tr>
    <td colspan="4">{{$link}}</td>
</tr>
@endif