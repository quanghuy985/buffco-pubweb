@foreach($orderdata as $item)
<tr >
    <td class="center">{{$item->id}}</td>
    <td class="center">{{$item->userEmail}}  </td>
    <td class="center"><a href="{{URL::action('OrderController@getEdit')}}/{{$item->orderID}}" >{{$item->orderID}}</a></td>
    <td class="center">{{$item->servicesName}}</td>
    <td class="center">{{$item->servicesorderAmount}}</td>
    <td class="center">{{$item->servicesorderTypePay}}</td>
    <td class="center">{{$item->servicesorderStatusPay}} </td>
    <td class="center">{{date('d/m/Y',$item->servicesorderTime)}} </td>
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
    <td class="center"><a href="{{URL::action('OrderController@getOderServicesEdit')}}/{{$item->id}}" >Chỉnh sửa</a> &nbsp; <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})">Xóa</a></td>
</tr>
@endforeach
@if($page!='')
<tr>
    <td colspan="11">
        {{$page}}
    </td>
</tr>
@endif