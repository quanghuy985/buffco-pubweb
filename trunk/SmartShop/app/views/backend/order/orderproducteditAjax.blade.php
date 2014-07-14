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
    <td><label value="cateNews">{{$arraysize[$item->product_size]}}</label></td>
    <td><label value="cateNews">{{$arraycolor[$item->product_color]}}</label></td>
    <td><label value="cateNews">{{number_format($item->productPrice,0,'.', ',')}}</label></td> 
    <td><label value="cateNews">{{number_format($item->amount,0,'.', ',')}} </label></td>
    <td><label value="cateNews">{{number_format($hangtrongkho,0,'.', ',')}} </label></td>
    <td><label value="cateNews">{{number_format($item->total,0,'.', ',')}} </label></td>
</tr> 
<?php $tongcong = $tongcong + $item->total ?>
@endforeach
{{Config::get('configall.pay-tiente')}}
<tr>
    <td colspan="8" style="text-align: right;"><strong><label>{{Lang::get('general.order.total_grand')}} ({{Config::get('configall.pay-tiente')}})</label></strong></td>
    <td><label value="cateNews">{{number_format($tongcong,0,'.', ',')}} </label></td>
</tr>
