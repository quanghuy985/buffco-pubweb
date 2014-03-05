@foreach($datasevices as $item)
<tr > 
    <td class="center">{{$item->id}}</td>
    <td class="center">{{$item->servicesName}}  </td>
    <td class="center">{{$item->servicesContent}}</td>
    <td class="center">{{$item->servicesPrices}}</td>
    <td class="center">{{$item->servicesPromotion}} </td>
    <td class="center">{{$item->servicesSlug}} </td>
    <td class="center">{{date('d/m/Y h:i:s',$item->servicesTime)}} </td>
    <td class="center">
        @if($item->status==0)
        chờ đăng
        @endif
        @if($item->status==1)
        đã đăng
        @endif 
        @if($item->status==2)
        xóa
        @endif

    </td>
    <td class="center"><a href="{{URL::action('ServicesController@getEditServices')}}?idedit={{$item->id}}" >Chỉnh sửa</a> &nbsp; <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})">Xóa</a></td>
</tr>
@endforeach
@if($page!='')
<tr>
    <td colspan="9">
        {{$page}}
    </td>
</tr>
@endif