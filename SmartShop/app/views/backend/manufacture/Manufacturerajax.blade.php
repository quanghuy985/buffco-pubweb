@if(isset($arrayManuf))
@foreach($arrayManuf as $item)

<tr> 
    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td> 
    <td><label value="manuf">{{str_limit( $item->manufacturerName, 30, '...')}}</label></td> 
    <td><label value="manuf">{{str_limit( $item->manufacturerDescription, 30, '...')}}</label></td> 
    <td><label value="manuf">{{str_limit($item->manufacturerPlace, 30, '...')}} </label></td> 
    <td><label value="manuf"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
    <td><label value="manuf">
            <?php
            if ($item->status == 0) {
                echo "chờ đăng";
            } else if ($item->status == 1) {
                echo "đã đăng";
            } else if ($item->status == 2) {
                echo "đã xóa";
            }
            ?>
        </label>
    </td> 
    <td>
        <a href="{{URL::action('\BackEnd\ManufacturerController@getManufacturerEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
        @if($item->status=='2')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="Kích hoạt"></a>
        @endif
        @if($item->status=='0')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="Đăng bài"></a>
        @endif
        @if($item->status!='2')
        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
        @endif
    </td> 
</tr> 

@endforeach
@if($link!='')
<tr>
    <td colspan="7">{{$link}}</td>
</tr>
@endif
@endif

