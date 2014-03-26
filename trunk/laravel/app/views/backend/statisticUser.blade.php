@extends("templateadmin2.mainfire")
@section("contentadmin")
<script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.flot.min.js')}}"></script>
<script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.flot.pie.js')}}"></script>
<script type="text/javascript" src="{{Asset('adminlib2/js/plugins/jquery.flot.resize.min.js')}}"></script>

 <script  type="text/javascript">
 jQuery(document).ready(function(){		
		
		/**PIE CHART IN MAIN PAGE WHERE LABELS ARE INSIDE THE PIE CHART**/
		var data = [];
		var series = 5;
//		for( var i = 0; i<series; i++) {
//			data[i] = { label: "Series"+(i+1), data: 300 }
//		}
                 data[0] = { label: "Tổng số thành viên: "+{{$userAvtived+$userNoActive}}, data: 0 }
                data[1] = { label: "Chưa kích hoạt: "+{{$userNoActive}}, data: {{$userNoActive}} }
                 data[2] = { label: "Đã kích hoạt: "+{{ $userAvtived }}, data: {{ $userAvtived }} }                 
		jQuery.plot(jQuery("#piechart"), data, {
				colors: ['#ccc','#b9d6fd','#fdb5b5'],		   
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
                    <h3>Thống kê số lượng thành viên</h3>
                </div><!--contenttitle-->
                <br />
                <div id="piechart" style="height: 300px;"></div>
            </div><!--one_half last-->
        
        <br clear="all" />
        
        </div><!--#charts-->
        
        <div id="statistics" class="subcontent">
        	&nbsp;
        </div><!--#statistics-->
        
    </div><!--contentwrapper-->
    
@endsection