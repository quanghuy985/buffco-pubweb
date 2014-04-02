@foreach($orderdata as $item)
<tr >
    <td class="center">{{$item->id}}</td>
    <td class="center">{{$item->userEmail}}  </td>
    <td class="center">{{$item->productName}}</td>
    <td class="center">{{$item->orderAmount}}</td>
    <td class="center">{{$item->orderTypePay}}</td>
    <td class="center">{{date('d/m/Y',$item->orderTime)}} </td>
    <td class="center">{{$item->domain}} </td>
    <td class="center">{{round($item->diskStore/1024/1024,2).'MB'}} </td>
    <td class="center">{{date('d/m/Y',$item->orderExp)}} </td>
    <td class="center">
        @if($item->status==0)
        Chờ
        @endif
        @if($item->status==1)
        Đã xong
        @endif 
        @if($item->status==2)
        Xóa
        @endif

    </td>
    <td class="center"><a href="{{URL::action('OrderController@getEdit')}}/{{$item->id}}" >Chỉnh sửa</a> &nbsp; <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})">Xóa</a></td>
</tr>
@endforeach
@if($page!='')
<tr>
    <td colspan="11">
        {{$page}}
    </td>
</tr>
@endif