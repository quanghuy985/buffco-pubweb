@foreach($arrayCateNews as $item)    
<tr> 

    <td><label value="cateMenuer">{{$item->id }}</label></td> 
    <td><label value="cateMenuer">@if($item->catenewsParent !=0) ---- @endif {{str_limit( $item->catenewsName, 30, '...')}}</label></td>
    <td><label value="cateMenuer">{{str_limit( $item->catenewsDescription, 30, '...')}}</label></td>
    <td><label value="cateMenuer">{{str_limit($item->catenewsParent , 30, '...')}}</label></td>
    <td><label value="cateMenuer">{{str_limit($item->catenewsSlug , 30, '...')}}</label></td> 
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

        <a href="{{URL::action('cateNewsController@getCateNewsEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
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
    <td colspan="8">{{$link}}</td>
</tr>
@endif