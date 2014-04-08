<?php $i = ($arrSupporter->getCurrentPage() - 1) * 10 + 1; ?>
@foreach($arrSupporter as $item)
<tr > 
    <td><label value="cateSupporter">{{$i++ }}</label></td> 
    <td><label value="cateSupporter">{{str_limit( $item->supporterName, 30, '...')}}</label></td> 
    <td><label value="cateSupporter">{{str_limit($item->supporterGroupName , 30, '...')}}</label></td>
    <td><label value="cateSupporter">{{str_limit($item->supporterNickYH , 30, '...')}}</label></td> 
    <td><label value="cateSupporter">{{str_limit($item->supporterNickSkype, 30, '...')}} </label></td>
    <td><label value="cateSupporter">{{str_limit($item->time, 30, '...')}} </label></td>
    <td><label value="cateSupporter"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td> 
    <td><label value="cateSupporter"><?php
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

        <a href="{{URL::action('SupporterController@getSupporterEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
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
    <td colspan="9">
        {{$link}}
    </td>
</tr>
@endif