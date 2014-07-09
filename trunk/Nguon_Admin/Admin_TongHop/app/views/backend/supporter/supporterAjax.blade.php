<?php
$i = ($arrSupporter->getCurrentPage() - 1) * 10 + 1;
?>
@foreach($arrSupporter as $item)
<tr>

    <td><label value="cateSupporter">{{$i++ }}</label></td>
    <td><label value="cateSupporter">{{$item->supporterName}}</label></td>
    <td><label value="cateSupporter">{{$item->supporterGroupName}}</label></td>
    <td><label value="cateSupporter">{{date('d/m/Y',$item->time)}} </label></td>
    <td>
        <a href="{{URL::action('\BackEnd\SupporterController@getSupporterEdit')}}/{{$item->id}}"  title="{{Lang::get('general.edit')}}">{{Lang::get('general.edit')}}</a>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="javascript: void(0)" onclick="deleteproduct('{{URL::action('\BackEnd\SupporterController@postDeleteSupporter')}}',{{$item->id}})"  title="{{Lang::get('general.delete')}}">{{Lang::get('general.delete')}}</a>
    </td>

</tr>
@endforeach
@if(count($arrSupporter)==0)
<tr>
    <td colspan="5">{{Lang::get('general.data_empty')}}</td>
</tr>
@endif
@if($link!='')
<tr>
    <td colspan="5">{{$link}}</td>
</tr>
@endif