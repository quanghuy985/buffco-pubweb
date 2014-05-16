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
            url: "{{URL::action('UserController@postSearchDateUser')}}?from=" + jQuery('#datepicker').val() + "&to=" + jQuery('#datepicker1').val()+"&page=" + page,
                    type: "POST",
                    dataType: "html"
            });
                    request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
            }
    
    function locdulieu() {        
        var request = jQuery.ajax({
            url: "{{URL::action('UserController@postThongKeUserAjax')}}?from=" + jQuery('#datepicker').val() + "&to=" + jQuery('#datepicker1').val(),
            type: "POST",
            dataType: "text"
        });
        request.done(function(msg) {            
            jQuery('#total_user').text(msg);
        });
        
        var request1 = jQuery.ajax({
            url: "{{URL::action('UserController@postSearchDateUser')}}?from=" + jQuery('#datepicker').val() + "&to=" + jQuery('#datepicker1').val(),
            type: "POST",
            dataType: "text"
        });
        request1.done(function(msg) {            
            jQuery('#tableproduct').html(msg);
        });
           
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">Th?ng k� ng�?i d�ng ��ng k?</h1>
    
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
                    T?ng s? ng�?i d�ng ��ng k? trong ng�y h�m nay ({{date('d/m/Y',time())}}): @if(isset($count)) {{$count}} @endif .<br/>
                    
                    T?ng s? ng�?i d�ng ��ng k? t? <label class='from'>...</label> t?i <label class='to'>...</label> : <label id='total_user'>...</label> .<br/>
                    
                    </th>
                    
                </tr>
            </thead>
        </table>
        
        <div class="contenttitle2" id="editUser">
            <h3>Quản lý người dùng</h3>            
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                
                <col class="con1" style="width: 13%">
                <col class="con1" style="width: 12%">                
                <col class="con1" style="width: 12%">
                <col class="con1" style="width: 10%">                
            </colgroup>
            <thead>
                <tr>
                    
                    <th class="head1">Email</th>
                    <th class="head0">Số điện thoại</th>                    
                    <th class="head1">Khởi tạo</th>
                    <th class="head0">Tình trạng</th>                    
                </tr>  
            </thead>

            <tbody id="tableproduct"> 
                @if(isset($user))
                @foreach($user as $item)
                <tr> 
                     
                    <td><label value="page">{{str_limit( $item->userEmail, 15, '...')}}</label></td> 
                    <td><label value="page">{{str_limit($item->userPhone, 15, '...')}} </label></td>
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
                    <td colspan="4">{{$link}}</td>
                </tr>
                @endif
                @endif
                
            </tbody>
        </table>
    </div>
</div>
@endsection