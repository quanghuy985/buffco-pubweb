<?php
$i = 1;
if (Input::get('page') > 1) {
    $i = (Input::get('page') - 1) * 10 + 1;
}
$user_status = Lang::get('general.data_status1');
?>
@if(count($arrHistory)>0)
@if(isset($objUser))
<input type="hidden" id="user_id" value="{{$objUser->id}}" name="user_id"/>
@endif
@foreach($arrHistory as $item)
<tr>
    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td>

    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td>
    <td>
        <?php echo '<a href="javascript:void(0);" onclick="xxx1(this);" data-id="' . $item->id . '" data-email="' . $item->email . '" data-name="' . $item->firstname . ' ' . $item->lastname . '" data-content="' . $item->historyContent . '">' . str_limit($item->historyContent, 15, '...') . '</a>'; ?>
    </td>
    <td><label value="page">
            <?php
            if (array_key_exists($item->status, $user_status)) {
                echo $user_status[$item->status];
            }
            ?>
        </label>
    </td>
    <td>
        @if($item->status !=2)
        <a href="javascript: void(0)" onclick="kichhoat('{{$item->id}}', 2, jQuery('#user_id').val())" class="btn btn4 btn_trash"
           title="{{Lang::get('button.trash')}}"></a>
        @endif
    </td>
</tr>
@endforeach
<script>
            jQuery('input:checkbox').uniform();</script>
@if($link!='')
<tr>
    <td colspan="7">{{$link}}</td>
</tr>
@endif
@else
<tr>
    <td colspan="7">{{Lang::get('general.data_empty')}}</td>
</tr>
@endif