
<?php $i = 1 ?>
@if(isset($arrTinDung))
@foreach($arrTinDung as $itemKhoanVay)
<tr> 
    <td>{{$i}}</td> 
    <td><label value="manuf"><a style="color: blue" href="{{URL::action('vaytienController@getKhoanVayChiTietByUserID')}}?userid={{$itemKhoanVay->userID}}">{{str_limit( $itemKhoanVay->userLastName.' '.$itemKhoanVay->userFirstName, 30, '...')}}</a></label></td> 
    <td><label value="manuf">{{str_limit( $itemKhoanVay->vaytienDescription, 30, '...')}}</label></td> 
    <td><label value="manuf"><a style="color: blue" onclick="abcd('{{$itemKhoanVay->id}}')" href="javascript:void(0);">{{number_format($itemKhoanVay->giatri,0,'.', ',')}} VNĐ</a> </label></td> 
    <td><label value="manuf">{{number_format($itemKhoanVay->thuve,0,'.', ',')}} VNĐ</label></td>
    <td><label value="manuf">{{str_limit($itemKhoanVay->chuky, 30, '...')}} ngày </label></td> 
    <td><label value="manuf">{{number_format($itemKhoanVay->laixuat,0,'.', ',')}}/ 1 triệu </label></td> 
    <td><label value="manuf"></label><?php echo date('d/m/Y', $itemKhoanVay->from); ?></td> 
    <td><label value="manuf"></label><?php echo date('d/m/Y', $itemKhoanVay->to); ?></td>
    <td><label value="manuf">
            <?php
            if ($itemKhoanVay->status == 0) {
                echo "Chưa thanh toán";
            } else if ($itemKhoanVay->status == 1) {
                echo "Đã thanh toán";
            } else if ($itemKhoanVay->status == 2) {
                echo "Xóa";
            } else if ($itemKhoanVay->status == 3) {
                echo "Nợ xấu";
            }
            ?>
        </label>
    </td> 
    <td>
        <a href="{{URL::action('vaytienController@getKhoanVayEdit')}}?id={{$itemKhoanVay->id}}" class="btn btn4 btn_book" title="Sửa"></a>
        @if($itemKhoanVay->status=='2')
        <a href="javascript: void(0)" onclick="kichhoat({{$itemKhoanVay->id}}, 0)" class="btn btn4 btn_flag" title="Bỏ xóa"></a>
        @endif
        @if($itemKhoanVay->status=='0')
        <a href="javascript: void(0)" onclick="kichhoat({{$itemKhoanVay->id}}, 1)" class="btn btn4 btn_world" title="Thanh toán"></a>
        @endif
        @if($itemKhoanVay->status!='2')
        <a href="javascript: void(0)" onclick="xoasanpham({{$itemKhoanVay->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
        @endif
    </td> 
</tr> 
<?php $i++ ?>
@endforeach
@if($link!='')
<tr>
    <td colspan="11">{{$link}}</td>
</tr>
@endif

@endif