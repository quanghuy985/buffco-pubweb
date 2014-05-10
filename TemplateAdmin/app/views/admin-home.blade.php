@extends("templateadmin2.mainfire")
@section("contentadmin")
<script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/jquery.flot.pie.js"></script>
<script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="{{Asset('adminlib')}}/js/plugins/jquery.slimscroll.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#accordion').accordion({autoHeight: false});
            
        var flash = [<?php for($i=0;$i<count($dateprev);$i++){ ?>[{{strtotime($dateprev[$i])}}000, {{$dataOrder[$i]}}],<?php }?>];
        var html5 = [<?php for($i=0;$i<count($dateprev);$i++){ ?>[{{strtotime($dateprev[$i])}}000, {{$dataUser1[$i]}}],<?php }?>];
        
        function showTooltip(x, y, contents) {
            jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css({
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 5
            }).appendTo("body").fadeIn(200);
        }


        var plot = jQuery.plot(jQuery("#chartplace"),
                [{data: flash, label: "Đơn hàng", color: "#069"}, {data: html5, label: "Người dùng", color: "#FF6600"}], {
            series: {
                lines: {show: true, fill: true, fillColor: {colors: [{opacity: 0.05}, {opacity: 0.15}]}},
                points: {show: true}
            },
            legend: {position: 'nw'},
            grid: {hoverable: true, clickable: true, borderColor: '#ccc', borderWidth: 1, labelMargin: 10},
            xaxis: {mode: "time", timeformat: "%d/%m/%y"},
            yaxis: {min: 0}
        });

        var previousPoint = null;
        jQuery("#chartplace").bind("plothover", function(event, pos, item) {
            jQuery("#x").text(pos.x.toFixed(2));
            jQuery("#y").text(pos.y.toFixed(2));

            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    jQuery("#tooltip").remove();
                    var x = 'Tháng ' + item.datapoint[0].toFixed(0),
                            y = item.datapoint[1].toFixed(0);

                    showTooltip(item.pageX, item.pageY,
                            item.series.label + " : " + y);
                }

            } else {
                jQuery("#tooltip").remove();
                previousPoint = null;
            }

        });

        jQuery("#chartplace").bind("plotclick", function(event, pos, item) {
            if (item) {
                jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
                plot.highlight(item.series, item.datapoint);
            }
        });
    });
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">Elements</h1>
    <span class="pagedesc">This is a sample description of a page</span>
</div>
<div id="contentwrapper" class="contentwrapper">
    <div class="subcontent">
        <div class="notibar announcement">
            <a class="close"></a>
            <h3>Thông báo</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div class="two_third dashboard_left">

            <ul class="shortcuts">
                <li><a href="#" class="settings"><span>Settings</span></a></li>
                <li><a href="#" class="users"><span>Users</span></a></li>
                <li><a href="#" class="gallery"><span>Gallery</span></a></li>
                <li><a href="#" class="events"><span>Events</span></a></li>
                <li><a href="#" class="analytics"><span>Analytics</span></a></li>
            </ul>

            <br clear="all" />
            <div class="contenttitle2 nomargintop">
                <h3>Đơn hàng mới nhất</h3>
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb overviewtable2">
                <colgroup>
                    
                    <col class="con1" />
                    <col class="con0" />
                    <col class="con1" />
                    <col class="con0" />
                </colgroup>
                <thead>
                    <tr>
                        
                        <th class="head1">Email</th>
                        <th class="head0">Tên</th>                        
                        <th class="head0">Địa chỉ</th>
                        <th class="head1">Thời gian</th>
                    </tr>
                </thead>
                @if(isset($getorder))
                @foreach($getorder as $item)
                <tbody>
                    <tr>                        
                        <td>{{$item->userEmail}}</td>
                        <td>{{$item->userFirstName}}</td>
                        
                        <td>{{str_limit($item->userAddress, 50, '...')}}</td>
                        <td>{{date('d/m/Y',$item->time)}}</td>
                    </tr>                    
                </tbody>
                @endforeach
                @endif
            </table>

            <br clear="all" />
            <div class="contenttitle2 nomargintop">
                <h3>Biểu đồ tăng trưởng</h3>
            </div>
            <div id="chartplace" style="height:300px;"></div>

            <br clear="all" />
        </div>
        <div class="one_third last dashboard_right">

            <div class="widgetbox">
                <div class="title"><h3>Tài khoản mới nhất</h3></div>
                <div class="widgetoptions">
                    <div class="right"><a href="#">Xem tất cả</a></div>
                    <a href="#">Thêm mới</a>
                </div>
                <div class="widgetcontent userlistwidget nopadding">
                    <ul>
                        @if(isset($dataUser))
                        @foreach($dataUser as $item)
                        <li>
                            <div class="avatar"><img alt="" src="http://www.gravatar.com/avatar/{{md5($item->userEmail)}}?s=50&d=identicon&r=PG" /></div>
                            <div class="info">
                                <a href="#">{{$item->userFirstName}}</a> <br />
                                {{$item->userFirstName}} <br /><?php echo date('d/m/Y', $item->time) ?>
                            </div><!--info-->
                        </li>                        
                        @endforeach
                        @endif
                    </ul>
                    <a class="more" href="#">Xem thêm</a>
                </div><!--widgetcontent-->
            </div>
            <div class="widgetbox">
                <div class="title"><h3>Tin tức mới nhất</h3></div>
                <div class="widgetcontent">
                    <div class="widgetcontent userlistwidget nopadding">
                        <ul>
                            @if(isset($datacatetintuc))
                            @foreach($datacatetintuc as $item)
                            <li>
                                <div class="avatar"><img alt="" src="http://www.gravatar.com/avatar/{{md5($item->newsSlug)}}?s=50&d=identicon&r=PG" /></div>
                                <div class="info">
                                    <a href="#">{{str_limit($item->newsName, 50, '...')}}</a> <br />
                                    {{str_limit($item->newsContent, 300, '...')}} <br />
                                </div><!--info-->
                            </li>                        
                            @endforeach
                            @endif
                        </ul>
                        <a class="more" href="#">Xem thêm </a>
                    </div>
                        
                </div> <!--widgetcontent-->
            </div><!--
</div>
</div>
</div>
@endsection