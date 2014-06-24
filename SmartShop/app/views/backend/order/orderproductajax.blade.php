<?php $i = 1 ?>
@foreach($arrOrder as $item)
<tr>
    <td class="center">{{$i++}}</td>
    <td class="center">{{$item->userEmail}}</td>
    <td class="center">{{$item->userFirstName}}</td>
    <td class="center">{{$item->userLastName}}  </td> 
    <td class="center"><a href="{{URL::action('OrderController@getEdit')}}/{{$item->orderCode}}">{{$item->orderCode}}</a></td>
    <td class="center">{{date('d/m/Y',$item->time)}} </td>
    <td class="center">
        @if($item->status==0)
        Chờ xử lý
        @endif
        @if($item->status==1)
        Đã xử lý
        @endif 
        @if($item->status==2)
        Xóa
        @endif

    </td>
    <td class="center">
        <a href="{{URL::action('OrderController@getEdit')}}/{{$item->orderCode}}" class="btn btn4 btn_orderdetail" title="Chi tiết đơn hàng"></a>
        &nbsp; 
        @if($item->status=='0')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)"  title="Đăng bài"> <img src="{{Asset('adminlib/images/icons/active.png')}}" width="35px"></img></a>
        @endif
       @if($item->status !='2' && $item->status != '1' )
        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
        @endif
    </td>
</tr>
@endforeach
@if($page!='')
<tr>
    <td colspan="11">
        {{$page}}
    </td>
</tr>
@endif