<?php
$i = 1;
if (Input::get('page') > 1) {
    $i = (Input::get('page') - 1) * 10 + 1;
}
$order_status = Lang::get('general.order_status');
?>
@if(count($arrorder)>0)
@foreach($arrorder as $item)
<tr>
    <td><label value="cateMenuer">{{$i++ }}</label></td>
    <td><label value="cateMenuer"><a href="{{URL::action('\BackEnd\OrderController@getEdit')}}/{{$item->orderCode}}">{{$item->orderCode}}</a></label></td>
    <td><label value="cateMenuer">{{date('d/m/Y',$item->time)}} </label>
    </td>
    <td><label value="cateMenuer">
            <?php
            if (array_key_exists($item->status, $order_status)) {
                echo $order_status[$item->status];
            }
            ?>
        </label>
    </td>
    <td>
        <a class="btn btn4 btn_orderdetail" title="{{Lang::get('general.order.detail')}}" href="<?php echo action('\BackEnd\OrderController@getEdit') ?>/{{$item->orderCode}}"></a>
        @if($item->status!='2')
        <a  class="btn btn4 btn_trash" title="{{Lang::get('general.delete')}}" href="javascript:void(0);" onclick="deleteproduct('{{URL::action('\BackEnd\OrderController@postDeleteOrderFromHistoryUser')}}','{{$item->id}}',{{$arrorder->getCurrentPage()}});"> </a>
        @endif

    </td>
</tr>
@endforeach
@if($orderlink!='')
<tr>
    <td colspan="5">{{$orderlink}}</td>
</tr>
@endif
@else
<tr>
    <td colspan="5">{{Lang::get('general.data_empty')}}</td>
</tr>
@endif