@if(isset($arrayHistory))
@foreach($arrayHistory as $item)
<tr>
    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td>
    <td>
        <?php echo '<a href="javascript:void(0);" onclick="xxx1(this);" data-id="'.$item->id.'" data-email="'.$item->userEmail.'" data-name="'.$item->userAddress.'" data-content="'.$item->historyContent.'">'.str_limit($item->userEmail, 15, '...').'</a>'; ?>
    </td>
    <td><label value="page">{{str_limit($item->userAddress, 15, '...')}} </label></td>
    <td><label value="page">{{str_limit($item->historyContent, 15, '...')}} </label></td>
    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td>
    <td><label value="page">
            @if($item->status != 0)
            {{Lang::get('button.delete')}}
            @endif
        </label>
    </td>
    <td>
        @if($item->status==0)
        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash"
           title="{{Lang::get('button.trash')}}"></a>
        @endif
    </td>
</tr>
@endforeach
<script>jQuery('input:checkbox').uniform();</script>
@if($link!='')
<tr>
    <td colspan="7">{{$link}}</td>
</tr>
@endif

@endif