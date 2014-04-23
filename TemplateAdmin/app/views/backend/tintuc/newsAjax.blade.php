<?php $i = 1 ?>
@foreach($arrayNews as $item)
<tr> 
    <td><label value="cateNews">{{$i++}}</label></td> 
    <td><label value="cateNews"><a href="{{URL::action('NewsController@getNewsEdit')}}/{{$item->id}}">{{str_limit( $item->newsName, 30, '...')}}</a></label></td> 
    <td><label value="cateNews">{{$item->cateNewsName }}</label></td> 
    <td><label value="cateNews">{{str_limit($item->newsDescription, 30, '...')}} </label></td>
    <td><label value="cateNews">{{str_limit($item->adminName, 30, '...')}} </label></td> 
    <td><label value="cateNews"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td> 
    <td><label value="cateNews"><?php
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
        <a href="{{URL::action('NewsController@getNewsEdit')}}/{{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
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
    <td colspan="8">{{$link}}</td>
</tr>
@endif
@if(count($arrayNews)==0)
<tr>
    <td colspan="8">Không có dữ liệu trả về .</td>
</tr>
@endif