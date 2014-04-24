@extends("templateadmin2.mainfire")
@section("contentadmin")

<script>

    function phantrang(page) {
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("Đang tải dữ liệu ...");
        var urlpost = "{{URL::action('StoreController@postAjaxpagion')}}?page=" + page;
        if (jQuery('#datepicker').val() != '' && jQuery('#datepicker1').val() != '') {
            urlpost = "{{URL::action('StoreController@postAjaxpagionFillter')}}?timeform=" + jQuery('#datepicker').val() + "&timeto=" + jQuery('#datepicker1').val() + "&oderbyoption=" + jQuery("#oderbyoption1").val() + "&page=" + page;
        }
        if (jQuery('#searchblur').val() != '') {
            urlpost = "{{URL::action('StoreController@postAjaxpagionSearch')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
        }
        var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            //jQuery("#jGrowl").remove();
            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            jQuery('#tableproduct').html(msg);
        });
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">CHI TIẾT HÀNG TRONG KHO</h1>
    <span class="pagedesc">Xem chi tiết kho hàng</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Sản phẩm : <strong style="color: red; font-size: 14pt;">{{$arrStore[0]->productName}}</strong></h3>
        </div>        
        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable stdtablecb">
            <colgroup>
                <col class="con1" style="width: 5%"> 
                <col class="con0" style="width: 30%">
                <col class="con1" style="width: 30%">
                <col class="con0" style="width: 15%">              
                <col class="con0" style="width: 15%">

            </colgroup>
            <thead>
                <tr>
                    <th class="head1">STT</th> 
                    <th class="head0">Màu sắc</th>
                    <th class="head1">Size</th>    
                    <th class="head0">Số lượng</th>
                    <th class="head1">Đã bán</th>                         

                </tr>
            </thead>

            <tbody id="tableproduct">
                <?php
                $i = 1;
                $daban = 0;
                $nhap = 0;
                if (Input::get('page') > 1) {
                    $i = 10 * Input::get('page') - 9;
                }
                ?>
                @foreach($arrStore as $item)
                <tr id="{{$item->id}}" >  
                    <td class="center"><?php
                        echo $i;
                        $i++;
                        ?> </td>
                    <td>
                        {{$item->sizeName}}
                    </td>  
                    <td>     
                        {{$item->colorName}}
                    </td>                                      
                    <td class="center">{{$item->soluongnhap}}</td>
                    <td class="center">{{$item->soluongban}} </td> 
                    <?php
                    $daban+= (int) $item->soluongban;
                    $nhap+= (int) $item->soluongnhap;
                    ?>
                </tr>
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="6">
                        {{$link}}
                    </td>
                </tr>
                @endif
                @if(count($arrStore)==0)
                <tr>
                    <td colspan="6" style="text-align: center;"><span class="center">Không có dữ liệu trả về .</span></td>
                </tr>
                @else
            <td colspan="3" style="text-align: center;"></td>            
             <td  style="text-align: center;">Tổng số lượng bán: {{$nhap}}</td>
             <td  style="text-align: center;">Tổng số lượng nhập: {{$daban}}</td>
            @endif

            </tbody>
        </table>      
    </div>     
</div>
@endsection