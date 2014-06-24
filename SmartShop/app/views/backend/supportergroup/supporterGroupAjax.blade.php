<?php $i = ($arrSupporterGroup->getCurrentPage() - 1) * 10 + 1; ?>
@if(count($arrSupporterGroup)>0)
@foreach($arrSupporterGroup as $item)
<tr>
    <td><label value="cateMenuer"><?php echo $i++; ?></label></td>
    <td><label value="cateMenuer">{{str_limit( $item->supporterGroupName, 30, '...')}}</label></td>
    <td><label value="cateMenuer"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td>
    <td>
        <a href="{{URL::action('\BackEnd\SupporterGroupController@getSupporterGroupEdit')}}/{{$item->id}}"  title="{{Lang::get('general.edit')}}">{{Lang::get('general.edit')}}</a>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="javascript: void(0)" onclick="deleteproduct('{{URL::action('\BackEnd\SupporterGroupController@postDeleteSupporterGroup')}}',{{$item->id}})"  title="{{Lang::get('general.delete')}}">{{Lang::get('general.delete')}}</a>
    </td>
</tr>
@endforeach
@if($link!='')
<tr>
    <td colspan="4">{{$link}}</td>
</tr>
@endif
@else
<tr>
    <td colspan="4">{{Lang::get('general.data_empty')}}</td>
</tr>
@endif