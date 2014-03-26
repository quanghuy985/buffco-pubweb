@extends("templateadmin2.mainfire")
@section("contentadmin")
<script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.flot.min.js')}}"></script>
<script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.flot.pie.js')}}"></script>
<script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.flot.resize.min.js')}}"></script>
<!--<script type="text/javascript" src="{{Asset('adminlib2/js/custom/dashboard.js')}}"></script>-->
<script  type="text/javascript">
        jQuery(document).ready(function(){
jQuery('#dp_start').datepicker({ language: "vi", format: "dd/mm/yyyy" }).on('changeDate', function (ev) {
var dateText = jQuery(this).data('date');
        var endDateTextBox = jQuery('#dp_end input');
        if (endDateTextBox.val() != '') {
var testStartDate = new Date(dateText);
        var testEndDate = new Date(endDateTextBox.val());
        if (testStartDate > testEndDate) {
            endDateTextBox.val(dateText);
                    }
            }
            else {
            endDateTextBox.val(dateText);
                    };
                    jQuery('#dp_end').datepicker('setStartDate', dateText);
                    jQuery('#dp_start').datepicker('hide');
                    });
                    jQuery('#dp_end').datepicker({ language: "vi", format: "dd/mm/yyyy" }).on('changeDate', function (ev) {
            var dateText = jQuery(this).data('date');
                    var startDateTextBox = jQuery('#dp_start input');
                    if (startDateTextBox.val() != '') {
            var testStartDate = new Date(startDateTextBox.val());
                    var testEndDate = new Date(dateText);
                    if (testStartDate > testEndDate) {
            startDateTextBox.val(dateText);
            }
            }
            else {
            startDateTextBox.val(dateText);
            };
                    jQuery('#dp_start').datepicker('setEndDate', dateText);
                    jQuery('#dp_end').datepicker('hide');
            });
                    /**PIE CHART IN MAIN PAGE WHERE LABELS ARE INSIDE THE PIE CHART**/
                    var data = [];
                    var series = 5;
//		for( var i = 0; i<series; i++) {
//			data[i] = { label: "Series"+(i+1), data: 300 }
//		}
                    data[0] = { label: "Tổng số sản phẩm: " + {{$productActive + $productNoActive}}, data: 0 }
            data[1] = { label: "Chưa kích hoạt: " + {{$productNoActive}}, data: {{$productNoActive}} }
            data[2] = { label: "Đã kích hoạt: " + {{$productActive}}, data: {{$productActive}} }
            jQuery.plot(jQuery("#piechart"), data, {
            colors: ['#ccc', '#b9d6fd', '#fdb5b5'],
                    series: {
                    pie: { show: true }
                    }
            });
                    });

</script>
<div class="contentwrapper">

    <div id="charts" class="subcontent">


        <div class="one_half ">
            <div class="contenttitle2">
                <h3>Thống kê số lượng sản phẩm</h3>
            </div><!--contenttitle-->
            <br />
            <div id="piechart" style="height: 300px;"></div>
        </div><!--one_half last-->

        <br clear="all" />

    </div><!--#charts-->

    <br clear="all" />

    <div class="contenttitle2 nomargintop">
        <h3>Top 10 sản phẩm được nhiều người dùng nhất</h3>
    </div><!--contenttitle-->

    <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb overviewtable2">                         
                            <thead>
                                <tr>                                   
                                     <th class="head1">STT</th>
                                    <th class="head1">Tên sản phẩm</th>
                                    <th class="head0">Giá</th>
                                    <th class="head1">Phiên bản</th>                                   
                                </tr>
                            </thead>                            
                            <tbody>
                                <?php $i=1; ?>
                                  @foreach($toptenProduct as $item)
                                <tr>        
                                    <td>{{$i}}</td>                                    
                                    <td>{{$item->productName}}</td>
                                    <td>{{$item->productPrice}}</td>
                                    <td class="center">{{$item->productPromotion}}</td>      
                                    <?php $i++; ?>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
<!--    <div class="overviewhead">                        	
        From: &nbsp;<input type="text" id="dp_start" /> &nbsp; &nbsp; To: &nbsp;<input type="text" id="dp_end" />
    </div>overviewhead-->



</div><!--contentwrapper-->

@endsection