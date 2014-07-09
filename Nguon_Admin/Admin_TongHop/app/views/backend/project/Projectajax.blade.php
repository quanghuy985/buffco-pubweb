@if(count($arrayProject)>0)
<?php
$i = ($arrayProject->getCurrentPage() - 1) * 10 + 1;
?>
@foreach($arrayProject as $item)
<tr>
    <td>{{$i++}}</td>
    <td><?php echo date('d/m/Y', $item->from); ?></td>
    <td><?php echo date('d/m/Y', $item->to); ?></td>
    <td>{{$item->projectName}}</td>
    <td><?php echo date('d/m/Y h:i:s', $item->time); ?></td>
    <td>
        <?php
        $page_status = Lang::get('general.data_status');
        if (array_key_exists($item->status, $page_status)) {
            echo $page_status[$item->status];
        }
        ?>
    </td>
    <td>
        <a href="{{URL::action('\BackEnd\ProjectController@getProjectEdit',$item->id)}}" title="{{Lang::get('general.edit')}}">{{Lang::get('general.edit')}}</a>
        @if($item->status=='2')
        &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0)" onclick="active_element('{{URL::action('\BackEnd\ProjectController@postActiveProject')}}',{{$item->id}})" title="{{Lang::get('button.btn.flag')}}">{{Lang::get('button.btn.flag')}}</a>
        @endif
        @if($item->status=='0')
        &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:void(0)" onclick="active_element('{{URL::action('\BackEnd\ProjectController@postPublicProject')}}',{{$item->id}})"  title="{{Lang::get('button.btn.world')}}">{{Lang::get('button.btn.world')}}</a>
        @endif
        @if($item->status!='2')
        &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript: void(0)" onclick="deleteproduct('{{URL::action('\BackEnd\ProjectController@postDeleteProject')}}',{{$item->id}})" title="{{Lang::get('general.delete')}}">{{Lang::get('general.delete')}}</a>
        @endif
    </td>
</tr>
@endforeach
@if($link!='')
<tr>
    <td colspan="7">{{$link}}</td>
</tr>
@endif

@else
<tr>
    <td colspan="7">
        {{Lang::get('general.data_empty')}}
    </td>
</tr>
@endif