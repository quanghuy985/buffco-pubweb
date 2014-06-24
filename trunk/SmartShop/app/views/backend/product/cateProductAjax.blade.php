@foreach($arrCateProduct as $item)
<tr> 
    <td><label value="cateMenuer">@if($item->cateParent!=0) — @endif @if($item->cateParent==0) <strong> @endif{{ $item->cateName}} @if($item->cateParent==0) </strong> @endif</label></td> 
    <td><label value="cateMenuer">{{str_limit($item->cateDescription , 30, '...')}}</label></td>
    <td><label value="cateMenuer">{{$item->cateSlug}}</label></td> 
    <td>
        <a href="{{URL::action('\BackEnd\CategoryProductController@getCateProductEdit')}}/{{$item->id}}"  title="Sửa"> Sửa</a>
        &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})"title="Xóa">Xóa</a>
    </td> 
</tr> 
@endforeach
@if($link!='')
<tr>
    <td colspan="7">{{$link}}</td>
</tr>
@endif