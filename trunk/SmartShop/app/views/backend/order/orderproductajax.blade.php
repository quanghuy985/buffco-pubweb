<?php
$i = 1;
if (Input::get('page') > 1) {
    $i = (Input::get('page') - 1) * 10 + 1;
}
$user_status = Lang::get('general.order_status');
$payment_type = Lang::get('general.payment_type');
?>
@if(count($arrOrder)>0)
@foreach($arrOrder as $item)
<tr>
    <td class="center">{{$i++}}</td>
    <td class="center">{{$item->email}}</td>
    <td class="center">{{$item->firstname}}</td>
    <td class="center">{{$item->lastname}}  </td> 
    <td class="center"><a href="{{URL::action('\BackEnd\OrderController@getEdit')}}/{{$item->orderCode}}">{{$item->orderCode}}</a></td>
    <td class="center"><?php
        if (array_key_exists($item->payment_type, $payment_type)) {
            if ($item->payment_type == 1) {
                echo "<span style='color:#FB9337'>" . $payment_type[$item->payment_type] . "</span>";
            } else {
                echo $payment_type[$item->payment_type];
            }
        }
        ?></td>
    <td class="center">{{date('d/m/Y',$item->time)}} </td>
    <td class="center">
        <?php
        if (array_key_exists($item->status, $user_status)) {
            echo $user_status[$item->status];
        }
        ?>

    </td>
    <td class="center">
        <a class="btn btn4 btn_orderdetail" title="{{Lang::get('general.order.detail')}}" href="<?php echo action('\BackEnd\OrderController@getEdit') ?>/{{$item->orderCode}}"> </a>
    </td>
</tr>
@endforeach
@if($page!='')
<tr>
    <td colspan="9">
        {{$page}}
    </td>
</tr>
@endif
@else
<tr>
    <td colspan="9">{{Lang::get('general.data_empty')}}</td>
</tr>
@endif