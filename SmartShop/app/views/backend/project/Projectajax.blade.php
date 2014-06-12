@if(count($dataProject)>0)
<?php $selectData = Lang::get('general.data_status'); ?>
@foreach($dataProject as $item)
<tr>
    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td>
    <td><label value="project"></label><?php echo date('d/m/Y', $item->from); ?></td>
    <td><label value="project"></label><?php echo date('d/m/Y', $item->to); ?></td>
    <td><label value="project">{{str_limit( $item->projectName, 30, '...')}}</label></td>
    <td><label value="project">{{str_limit($item->projectContent, 30, '...')}} </label></td>
    <td><label value="project"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td>
    <td><label value="project">
            <?php
            if (array_key_exists($item->status, $selectData)) {
                echo $selectData[$item->status];
            }
            ?>
        </label>
    </td>
    <td>
        <a href="{{URL::action('\BackEnd\ProjectController@getProjectEdit')}}/{{$item->id}}"
           class="btn btn4 btn_book" title="{{Lang::get('button.edit')}}"></a>
        @if($item->status=='2')
        <a href="javascript:void(0)" onclick="kichhoat({{$item-> id}}, 0)" class="btn btn4 btn_flag"
           title="{{Lang::get('button.active')}}"></a>
        @endif
        @if($item->status=='0')
        <a href="javascript:void(0)" onclick="kichhoat({{$item-> id}}, 1)" class="btn btn4 btn_world"
           title="{{Lang::get('button.public')}}"></a>
        @endif
        @if($item->status!='2')
        <a href="javascript: void(0)" onclick="xoasanpham({{$item-> id}})" class="btn btn4 btn_trash"
           title="{{Lang::get('button.delete')}}"></a>
        @endif
    </td>
</tr>
@endforeach
<script>jQuery('input:checkbox').uniform();</script>
@if($link!='')
<tr>
    <td colspan="8">{{$link}}</td>
</tr>
@endif

@else
<tr>
    <td colspan="8">
        {{Lang::get('general.data_empty')}}
    </td>
</tr>
@endif