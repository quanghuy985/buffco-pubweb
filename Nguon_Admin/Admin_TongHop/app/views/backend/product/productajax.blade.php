<?php if (!isset($arrProduct) || count($arrProduct) == 0) { ?>
    <tr>
        <td colspan="9" style="text-align: center;">
            <?php echo Lang::get('general.data_empty'); ?>
        </td>
    </tr>
    <?php
} else {

    $i = ($arrProduct->getCurrentPage() - 1) * 10 + 1;
    foreach ($arrProduct as $item) {
        ?>
        <tr>
            <td class="text-center"><label value="cateNews">{{$i++}}</label></td>
            <td class="head0">
                <?php
                $pieces = explode(",", $item->images);
                ?>
                <?php $url = Timthumb::link($pieces[0], 40, 15, 0); ?>
                <a title="{{Lang::get('general.edit')}}" href="<?php echo action('\BackEnd\ProductController@postProductEdit') ?>/{{$item->id}}"> <img src="{{Asset($url)}}" /></a>
            </td>        
            <td class="head1"> <a title="{{Lang::get('general.edit')}}" href="<?php echo action('\BackEnd\ProductController@postProductEdit') ?>/{{$item->id}}"> <?php echo $item->productName ?></a></td>
            <td class="head0"><?php echo $item->productCode ?></td>        
            <td class="head1"><?php echo $item->quantity ?></td>
            <td class="head0"><?php echo number_format($item->productPrice); ?> <?php echo Config::get('configall.pay-tiente'); ?></td>        
            <td class="head1">
                <?php
//                if ($item->CatNameProduct != '') {
//                    $listidcat = explode(',', $item->IdCatNameProduct);
//                    $listnamecat = explode(',', $item->CatNameProduct);
//                    for ($i = 0; $i < count($listidcat); $i++) {
//                        if ($i == 0) {
//                            echo '<a href="' . action('\BackEnd\ProductController@getProductView') . '/' . $listidcat[$i] . '">' . $listnamecat[$i] . '</a>';
//                        } else {
//                            echo ', <a href="' . action('\BackEnd\ProductController@getProductView') . '/' . $listidcat[$i] . '">' . $listnamecat[$i] . '</a>';
//                        }
//                    }
//                }
                ?> 
                <?php echo number_format($item->salesPrice); ?> <?php echo Config::get('configall.pay-tiente'); ?>
                <?php
                if ($item->endSales > time()) {
                    ?>
                    <br/> ( <?php echo date('d/m/Y', $item->startSales); ?> - <?php echo date('d/m/Y', $item->endSales); ?>)
                    <?php
                }
                ?>
            </td>
            <td class="head0">
                <?php echo date('d/m/Y', $item->time); ?>
            </td>
            <td class="head1" style="text-align: center;">
                <a title="{{Lang::get('general.edit')}}" href="<?php echo action('\BackEnd\ProductController@postProductEdit') ?>/{{$item->id}}"> {{Lang::get('general.edit')}}</a>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a title="{{Lang::get('general.delete')}}" href="javascript:void(0);" onclick="deleteproduct('{{URL::action('\BackEnd\ProductController@postDeleteProduct')}}',{{$item->id}});"> {{Lang::get('general.delete')}}</a>
            </td>
        </tr>

        <?php
    }
}
?>
<?php if ($link != '' && isset($link)) { ?>
    <tr>
        <td colspan="9">
            <?php echo $link; ?>
        </td>
    </tr>
<?php } ?>