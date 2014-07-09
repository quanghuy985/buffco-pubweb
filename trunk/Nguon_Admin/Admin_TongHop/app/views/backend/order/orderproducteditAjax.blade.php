<?php
$i = 1;
if (Input::get('page') > 1) {
    $i = (Input::get('page') - 1) * 10 + 1;
}
?>
<?php $tongcong = 0; ?>
@foreach($objOrder as $item)
<?php
$hangtrongkho = $item->quantity - $item->quantity_sold;
?>
<tr>   
    <td><label value="cateNews"> {{$i++}} </label></td> 
    <td><label value="cateNews">{{str_limit( $item->productCode, 30, '...')}}</label></td> 
    <td><label value="cateNews">{{str_limit( $item->productName, 30, '...')}}</label></td>
    <td><label value="cateNews">{{number_format($item->productPrice,0,'.', ',')}}</label></td> 
    <td><label value="cateNews">{{number_format($item->amount,0,'.', ',')}} </label></td>
    <td><label value="cateNews">{{number_format($hangtrongkho,0,'.', ',')}} </label></td>
    <td><label value="cateNews">{{number_format($item->total,0,'.', ',')}} </label></td>
</tr> 
<?php $tongcong = $tongcong + $item->total ?>
@endforeach

<tr>
    <td colspan="6" style="text-align: right;"><strong><label>{{Lang::get('general.order.total_grand')}}</label></strong></td>
    <td><label value="cateNews">{{number_format($tongcong,0,'.', ',')}} </label></td>
</tr>
