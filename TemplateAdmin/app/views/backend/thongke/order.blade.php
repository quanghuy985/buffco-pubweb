@extends("templateadmin2.mainfire")
@section("contentadmin")
<script type="text/javascript">
    jQuery(document).ready(function(){
       jQuery('#datepicker').change(function(){
           jQuery('.from').text(jQuery('#datepicker').val());
       }) ;
       
       jQuery('#datepicker1').change(function(){
           jQuery('.to').text(jQuery('#datepicker1').val());
       }) ;
       
       
    });
    
    function phantrang(page) {
            var request = jQuery.ajax({
            url: "{{URL::action('OrderController@postSearchDateOrder')}}?from=" + jQuery('#datepicker').val() + "&to=" + jQuery('#datepicker1').val()+"&page=" + page,
                    type: "POST",
                    dataType: "html"
            });
                    request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
            }
    
    function locdulieu() {        
        var request = jQuery.ajax({
            url: "{{URL::action('OrderController@postThongKeOrderAjax')}}?from=" + jQuery('#datepicker').val() + "&to=" + jQuery('#datepicker1').val(),
            type: "POST",
            dataType: "text"
        });
        request.done(function(msg) {            
            jQuery('#total_order').text(msg);
        });
           var request1 = jQuery.ajax({
            url: "{{URL::action('OrderController@postThongKePriceAjax')}}?from=" + jQuery('#datepicker').val() + "&to=" + jQuery('#datepicker1').val(),
            type: "POST",
            dataType: "text"
        });
        request1.done(function(msg) {            
            jQuery('#total_price').text(msg);
        });
        
        var request2 = jQuery.ajax({
            url: "{{URL::action('OrderController@postSearchDateOrder')}}?from=" + jQuery('#datepicker').val() + "&to=" + jQuery('#datepicker1').val(),
            type: "POST",
            dataType: "text"
        });
        request2.done(function(msg) {            
            jQuery('#tableproduct').html(msg);
        });
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">Th?ng k� ��n h�ng</h1>
    
</div>

<div class="contentwrapper">
    
    <div class="subcontent">
       
        <div class="tableoptions"> 
            <form class="stdform stdform2" action="javascript:void(0)" method="post">
                T? : <input id="datepicker" name="timeform" type="text" class="longinput" /> 
                &nbsp;   t?i: <input id="datepicker1"  name="timeto" type="text" class="datepicker"  /> 
                
                &nbsp; &nbsp; <button class="radius3" id="loctheotieuchi" onclick="locdulieu()">L?c d? li?u</button>

            </form>
            
        </div>
        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable stdtablecb">
            <colgroup>

                <col class="con1">
            </colgroup>
            <thead>
                <tr>

                    <th class="head1">
                    T?ng s? ��n h�ng trong ng�y h�m nay ({{date('d/m/Y',time())}}): @if(isset($count)) {{$count}} @endif ��n h�ng<br/>
                    T?ng gi� tr? ��n h�ng trong ng�y h�m nay ({{date('d/m/Y',time())}}):  @if(isset($total) && $total!=null) {{$total[0]->total}} @elseif(isset($total) && $total==null) 0 @endif VND<br/>
                    T?ng s? ��n h�ng t? <label class='from'>...</label> t?i <label class='to'>...</label> : <label id='total_order'>...</label> ��n h�ng<br/>
                    T?ng gi� tr? ��n h�ng t? <label class='from'>...</label> t?i <label class='to'>...</label> : <label id='total_price'>...</label> VND<br/>    
                    </th>
                    
                </tr>
            </thead>

            
        </table>
        
        <div class="contenttitle2" id="editUser">
            <h3>Quản lý đơn hàng</h3>            
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                
                <col class="con1" style="width: 13%">
                <col class="con1" style="width: 12%">                
                <col class="con1" style="width: 12%">
                <col class="con1" style="width: 12%">
                <col class="con1" style="width: 10%">                
            </colgroup>
            <thead>
                <tr>
                    
                    <th class="head0">Tài khoản</th>                    
                    <th class="head1">Mã Đơn Hàng</th>                    
                    <th class="head0">Giá trị</th>
                    <th class="head1">Thời điểm</th>
                    <th class="head0">Trạng thái</th>
                                       
                </tr>  
            </thead>

            <tbody id="tableproduct"> 
                @if(isset($order))
                @foreach($order as $item)
                <tr> 
                    <td><label value="page">{{str_limit( $item->receiverName, 15, '...')}}</label></td> 
                    <td><label value="page">{{str_limit( $item->orderCode, 15, '...')}}</label></td> 
                    <td><label value="page">{{number_format($item->total,0,',', ' ')}} VND </label></td>
                    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    <td><label value="page">
                            <?php
                            if ($item->status == 0) {
                                echo "chờ kích hoạt";
                            } else if ($item->status == 1) {
                                echo "đã kích hoạt";
                            } else if ($item->status == 2) {
                                echo "đã xóa";
                            }
                            ?>
                        </label>
                    </td> 
                    
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="5">{{$link}}</td>
                </tr>
                @endif
                @endif
                
            </tbody>
        </table>
    </div>
</div>
@endsection