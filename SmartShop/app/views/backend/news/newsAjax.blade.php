<?php
$i = ($arrayNews->getCurrentPage() - 1) * 10 + 1;
$data_status = Lang::get('general.data_status2');
unset($data_status['']);
?>
@foreach($arrayNews as $item)
<tr>
    <td class="text-center" class="head0"><label value="cateNews">{{$i++}}</label></td>
    <td class="head1"><label value="cateNews"><a href="{{URL::action('\BackEnd\NewsController@getNewsEdit')}}/{{$item->id}}">{{str_limit( $item->newsName, 30, '...')}}</a></label></td>
    <td class="head0"><label value="cateNews">{{str_limit($item->newsDescription, 30, '...')}} </label></td>
    <td class="head1"><label value="cateNews"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td>
    <td class="head0"> <label value="cateNews">
            <?php
            if (array_key_exists($item->status, $data_status)) {
                echo $data_status[$item->status];
            }
            ?>
        </label>
    </td>
    <td class="head1">
        <a href="{{URL::action('\BackEnd\NewsController@getNewsEdit')}}/{{$item->id}}"  title="{{Lang::get('general.edit')}}">{{Lang::get('general.edit')}}</a>
        @if($item->status=='2')
        &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: void(0)" onclick="active_element('{{URL::action('\BackEnd\NewsController@postActiveNews')}}',{{$item->id}})" class="" title="{{Lang::get('button.btn.flag')}}">{{Lang::get('button.btn.flag')}}</a>
        @endif
        @if($item->status=='0')
        &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: void(0)" onclick="active_element('{{URL::action('\BackEnd\NewsController@postPublicNews')}}',{{$item->id}})" class="" title="{{Lang::get('button.btn.world')}}">{{Lang::get('button.btn.world')}}</a>
        @endif
        @if($item->status!='2')
        &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: void(0)" onclick="deleteproduct('{{URL::action('\BackEnd\NewsController@postDeleteNews')}}',{{$item->id}})" title="{{Lang::get('general.delete')}}">{{Lang::get('general.delete')}}</a>
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
    <td colspan="8">{{Lang::get('general.data_empty')}}</td>
</tr>
@endif