@if(count($arrPage)==0)
<tr>
    <td colspan="8">{{Lang::get('general.data_empty')}}</td>
</tr>
@endif

<?php
$i = ($arrPage->getCurrentPage() - 1) * 10 + 1;
$selectData = Lang::get('general.data_status');
?>
@foreach($arrPage as $item)
<tr> 
    <td>{{$i++}}</td> 
    <td><label value="page">{{str_limit($item->pageName, 30, '...')}}</label></td> 
    <td><label value="page">{{str_limit($item->pageSlug, 30, '...')}} </label></td> 
    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
    <td><label value="page">
            <?php
            if (array_key_exists($item->status, $selectData)) {
                echo $selectData[$item->status];
            }
            ?>
        </label>
    </td> 
    <td>
        <a href="{{URL::action('\BackEnd\PageController@getPageEdit',$item->id)}}"  title="{{Lang::get('general.edit')}}">{{Lang::get('general.edit')}}</a>
        @if($item->status=='2')
        &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: void(0)" onclick="active_element('{{URL::action('\BackEnd\PageController@postActivePages')}}',{{$item->id}})"  title="{{Lang::get('button.btn.flag')}}">{{Lang::get('button.btn.flag')}}</a>
        @endif
        @if($item->status=='0')
        &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: void(0)" onclick="active_element('{{URL::action('\BackEnd\PageController@postPublicPages')}}',{{$item->id}})" title="{{Lang::get('button.btn.world')}}">{{Lang::get('button.btn.world')}}</a>
        @endif
        @if($item->status!='2')
        &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: void(0)" onclick="deleteproduct('{{URL::action('\BackEnd\PageController@postDeletePages')}}',{{$item->id}})" title="{{Lang::get('general.delete')}}">{{Lang::get('general.delete')}}</a>
        @endif
    </td> 
</tr> 
@endforeach
<script>
                            jQuery('input:checkbox').uniform();</script>
@if($link!='')
<tr>
    <td colspan="8">{{$link}}</td>
</tr>
@endif
