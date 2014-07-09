@extends("backend.template")
@section("contentadmin")
<script type="text/javascript" src="{{Asset('backend')}}/js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="{{Asset('backend')}}/js/plugins/jquery.flot.pie.js"></script>
<script type="text/javascript" src="{{Asset('backend')}}/js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="{{Asset('backend')}}/js/plugins/jquery.slimscroll.js"></script>
<style>
    .widgetbox .title h3 {
        font-family: Arial,Helvetica,sans-serif;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .toplist li a {
        display: block;
        font-weight: bold;
        overflow: hidden;
    }
</style>
<script>
        jQuery(document).ready(function() {


/*****SIMPLE CHART*****/
var flash = [<?php
foreach ($arrreturn1 as $key => $value) {
    echo '[' . $key . '000,' . $value . '],';
}
?>];
        var html5 = [<?php
foreach ($arrreturn as $key => $value) {
    echo '[' . $key . '000,' . $value . '],';
}
?>];
        function showTooltip(x, y, contents) {
        jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css({
        position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 5
        }).appendTo("body").fadeIn(200);
        }


var plot = jQuery.plot(jQuery("#chartplace"),
        [{data: flash, label: "{{Lang::get('backend/home.order')}} ({{Lang::get('backend/home.number')}})", color: "#069"}, {data: html5, label: "{{Lang::get('backend/home.order_anly_users')}} ({{Lang::get('backend/home.order_anly_users_count')}})", color: "#FF6600"}], {
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
        var x = '{{Lang::get('backend / home.months')}}' + item.datapoint[0].toFixed(0),
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
        });</script>

<?php
$rolelist = unserialize(Auth::user()->roles);
$check = false;
if (is_array($rolelist)) {
    foreach ($rolelist as $item) {
        if (strpos($item, 'StatisticView') >= 0 && strpos($item, 'StatisticView') !== false) {
            $check = true;
            break;
        } else {
            $check = false;
        }
    }
}
if ($check == true) {
    ?>
    <script>
                jQuery(document).ready(function() {


        /*****SIMPLE CHART*****/
        var flash = [<?php
    foreach ($arrreturn3 as $key => $value) {
        echo '[' . $key . '000,' . $value . '],';
    }
    ?>];
                var html5 = [<?php
    foreach ($arrreturn2 as $key => $value) {
        echo '[' . $key . '000,' . $value . '],';
    }
    ?>];
                function showTooltip(x, y, contents) {
                jQuery('<div id="tooltip1" class="tooltipflot1">' + contents + '</div>').css({
                position: 'absolute',
                        display: 'none',
                        top: y + 5,
                        left: x + 5
                }).appendTo("body").fadeIn(200);
                }


        var plot = jQuery.plot(jQuery("#chartplace1"),
                [{data: flash, label: "{{Lang::get('backend/home.order_anly_tongtien')}} ({{Lang::get('backend/home.money_format')}})", color: "#069"}, {data: html5, label: "{{Lang::get('backend/home.order_anly_lai')}} ({{Lang::get('backend/home.money_format')}})", color: "#FF6600"}], {
        series: {
        lines: {show: true, fill: true, fillColor: {colors: [{opacity: 0.05}, {opacity: 0.15}]}},
                points: {show: true}
        },
                legend: {position: 'nw'},
                grid: {hoverable: true, clickable: true, borderColor: '#ccc', borderWidth: 1, labelMargin: 10},
                xaxis: {mode: "time", timeformat: "%d/%m/%y"}
        });
                var previousPoint = null;
                jQuery("#chartplace1").bind("plothover", function(event, pos, item) {
        jQuery("#x").text(pos.x.toFixed(2));
                jQuery("#y").text(pos.y.toFixed(2));
                if (item) {
        if (previousPoint != item.dataIndex) {
        previousPoint = item.dataIndex;
                jQuery("#tooltip1").remove();
                var x = '{{Lang::get('backend / home.months')}}' + item.datapoint[0].toFixed(0),
                y = item.datapoint[1].toFixed(0);
                showTooltip(item.pageX, item.pageY,
                        item.series.label + " : " + y);
        }

        } else {
        jQuery("#tooltip1").remove();
                previousPoint = null;
        }

        });
                jQuery("#chartplace1").bind("plotclick", function(event, pos, item) {
        if (item) {
        jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
                plot.highlight(item.series, item.datapoint);
        }
        });
        });
    </script>
    <?php
}
?>
<div id="contentwrapper" class="contentwrapper">
    <div class="subcontent">
        <div class="notibar announcement">
            <a class="close"></a>
            <h3>{{Lang::get('general.alert')}}</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div class="two_third dashboard_left">
            <ul class="shortcuts">
                <li><a href="#"><h3>{{$countall['CountNews']}}</h3><span>{{Lang::get('backend/home.count_news')}}</span></a></li>
                <li><a href="#"><h3>{{$countall['CountProduct']}}</h3><span>{{Lang::get('backend/home.count_product')}}</span></a></li>
                <li><a href="#"><h3>{{$countall['CountOrder']}}</h3><span>{{Lang::get('backend/home.count_order')}}</span></a></li>
                <li><a href="#"><h3>{{$countall['CountCustomer']}}</h3><span>{{Lang::get('backend/home.count_customer')}}</span></a></li>
                <li><a href="#"><h3>{{$countall['CountSupporter']}}</h3><span>{{Lang::get('backend/home.count_support')}}</span></a></li>
                <li><a href="#"><h3>{{$countall['CountFeedBack']}}</h3><span>{{Lang::get('backend/home.count_feedback')}}</span></a></li>
                <li><a href="#"><h3>{{$countall['CountProject']}}</h3><span>{{Lang::get('backend/home.count_project')}}</span></a></li>
                <li><a href="#"><h3>{{$countall['CountPage']}}</h3><span>{{Lang::get('backend/home.count_pages')}}</span></a></li>
                <li><a href="#"><h3>{{$countall['CountAdmin']}}</h3><span>{{Lang::get('backend/home.count_admins')}}</span></a></li>
                <li><a href="#"><h3>{{$countall['CountMenu']}}</h3><span>{{Lang::get('backend/home.count_menus')}}</span></a></li>
            </ul>
            <br clear="all" />
            <div class="contenttitle2 nomargintop">
                <h3>{{Lang::get('backend/home.new_order')}}</h3>
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

                        <th class="head1">{{Lang::get('backend/home.order_code')}}</th>
                        <th class="head0">{{Lang::get('backend/home.order_email')}}</th>
                        <th class="head0">{{Lang::get('backend/home.order_total')}}</th>
                        <th class="head1">{{Lang::get('backend/home.order_times')}}</th>
                    </tr>
                </thead>
                @if(isset($arrOrdernew))
                @foreach($arrOrdernew as $item)
                <tbody>
                    <tr>                        
                        <td>{{$item->orderCode}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{number_format($item->total)}}&nbsp; {{Config::get('configall.pay-tiente')}}</td>
                        <td>{{date('d/m/Y h:m:i',$item->time)}}</td>
                    </tr>                    
                </tbody>
                @endforeach
                @endif
            </table>

            <br clear="all" />
            <div class="contenttitle2 nomargintop">
                <h3>{{Lang::get('backend/home.chart')}}</h3>
            </div>
            {{Form::open(array('action'=>'\BackEnd\HomeController@postHome', 'class'=>'stdform stdform2','id'=>'fillterfrom'))}}
            &nbsp;&nbsp; {{Lang::get('general.date_from')}} <input id="datepicker" name="timeform" type="text" class="longinput" />&nbsp;
            &nbsp;{{Lang::get('general.date_to')}}&nbsp;&nbsp;<input id="datepicker1"  name="timeto" type="text" class="datepicker"  />
            &nbsp;
            <input type="submit" class="radius3" value="{{Lang::get('general.views-aly')}}"/>
            {{Form::close()}}
            <br clear="all" />
            <blockquote>
                <span>  {{Lang::get('backend/home.order_anly_from')}}  : <strong> {{date('d/m/Y',$arrstatic['timeformanaly'])}}</strong> {{Lang::get('backend/home.order_anly_to')}} : <strong> {{date('d/m/Y',$arrstatic['timetoanaly'])}}</strong></span>
                <br><span>  {{Lang::get('backend/home.order_anly_total')}} : <strong> {{$arrstatic['totalorder']}}</strong> ( Đơn hàng )</span>
                <br><span>  {{Lang::get('backend/home.order_anly_users')}} : <strong> {{number_format($arrstatic['totauser'])}}</strong> ( {{Lang::get('backend/home.order_anly_users_count')}} )</span>
            </blockquote>
            <br clear="all" />
            <div id="chartplace" style="height:300px;"></div>
            <?php
            if ($check == true) {
                ?>
                <br clear="all" />
                <blockquote>
                    <span>  {{Lang::get('backend/home.order_anly_from')}}  : <strong> {{date('d/m/Y',$arrstatic['timeformanaly'])}}</strong> {{Lang::get('backend/home.order_anly_to')}} : <strong> {{date('d/m/Y',$arrstatic['timetoanaly'])}}</strong></span>
                    <br><span>  {{Lang::get('backend/home.order_anly_lai')}} : <strong> {{number_format($arrstatic['totalai'])}}</strong> (  {{Config::get('configall.pay-tiente')}} )</span>
                    <br><span>  {{Lang::get('backend/home.order_anly_tongtien')}} : <strong> {{number_format($arrstatic['tongtien'])}}</strong> (  {{Config::get('configall.pay-tiente')}} )</span>
                </blockquote>
                <div id="chartplace1" style="height:300px;"></div>
                <?php
            }
            ?>
            <br clear="all" />
        </div>
        <div class="one_third last dashboard_right">
            <div class="contenttitle2 nomargintop">
                <h3>{{Lang::get('backend/home.order')}}</h3>
            </div>
            <ul class="toplist">
                <li>
                    <div>
                        <span class="three_fifth">
                            <span class="left">
                                <span class="title"><a href="{{URL::action('\BackEnd\OrderController@getOrderFillterView', array('null', 'null', 1))}}">{{Lang::get('backend/home.order_ok')}}</a></span>
                                <span class="desc">{{Lang::get('backend/home.order_ok_detail')}}</span>
                            </span><!--left-->
                        </span><!--three_fourth-->
                        <span class="two_fifth last">
                            <span class="right">
                                <span class="h3"><a style="color: #59bf04" href="{{URL::action('\BackEnd\OrderController@getOrderFillterView', array('null', 'null', 1))}}">{{$CountUsers}}</a></span>
                            </span><!--right-->
                        </span><!--one_fourth-->
                        <br clear="all">
                    </div>
                </li>
                <li>
                    <div>
                        <span class="three_fifth">
                            <span class="left">
                                <span class="title"><a href="{{URL::action('\BackEnd\OrderController@getOrderFillterView', array('null', 'null', '0'))}}">{{Lang::get('backend/home.order_pending')}}</a></span>
                                <span class="desc">{{Lang::get('backend/home.order_pending_detail')}}</span>
                            </span><!--left-->
                        </span><!--three_fourth-->
                        <span class="two_fifth last">
                            <span class="right">
                                <span class="h3"><a  style="color:red" href="{{URL::action('\BackEnd\OrderController@getOrderFillterView', array('null', 'null', '0'))}}">{{$CountOrderOk}}</a></span>
                            </span><!--right-->
                        </span><!--one_fourth-->
                        <br clear="all">
                    </div>
                </li>
                <li>
                    <div>
                        <span class="three_fifth">
                            <span class="left">
                                <span class="title"><a href="{{URL::action('\BackEnd\OrderController@getOrderFillterView', array('null', 'null', 2))}}">{{Lang::get('backend/home.order_cancel')}}</a></span>
                                <span class="desc">{{Lang::get('backend/home.order_cancel_detail')}}</span>
                            </span><!--left-->
                        </span><!--three_fourth-->
                        <span class="two_fifth last">
                            <span class="right">
                                <span class="h3"><a style="color:#fbe187" href="{{URL::action('\BackEnd\OrderController@getOrderFillterView', array('null', 'null', 2))}}">{{$CountOrderPen}}</a></span>
                            </span><!--right-->
                        </span><!--one_fourth-->
                        <br clear="all">
                    </div>
                </li>
            </ul>
            <div class="widgetbox">
                <div class="title"><h3>{{Lang::get('backend/home.latest_account')}}</h3></div>
                <div class="widgetcontent userlistwidget nopadding">
                    <ul>
                        @if(isset($arrNewUsers))
                        @foreach($arrNewUsers as $item)
                        <li style="height: 60px;">
                            <div class="avatar"><img alt="" src="http://www.gravatar.com/avatar/{{md5($item->email)}}?s=50&d=identicon&r=PG" /></div>
                            <div class="info">
                                <a href="#">{{$item->firstname}} {{$item->lastname}}</a> <br />
                                {{$item->email}} <br /><?php echo date('d/m/Y h:m:i', $item->time) ?>
                            </div><!--info-->
                        </li>                        
                        @endforeach
                        @endif
                    </ul>
                    <a class="more" href="{{URL::action('\BackEnd\UserController@getUserView')}}">{{Lang::get('backend/home.more')}}</a>
                </div><!--widgetcontent-->
            </div>
            <div class="widgetbox">
                <div class="title"><h3>{{Lang::get('backend/home.latest_news')}}</h3></div>
                <div class="widgetcontent">
                    <div class="widgetcontent userlistwidget nopadding">
                        <ul>
                            @if(isset($arrLastNew))
                            @foreach($arrLastNew as $item)
                            <li style="height: 60px;">
                                <?php
                                $pieces = explode(",", $item->newsImg);
                                ?>
                                <?php $url = Timthumb::link($pieces[0], 50, 50, 0); ?>
                                <div class="avatar"><img alt="" src="{{Asset($url)}}" /></div>
                                <div class="info">
                                    <a href="#">{{$item->newsName}}</a> <br />
                                    <?php echo date('d/m/Y h:m:i', $item->time) ?>
                                </div><!--info-->
                            </li>                        
                            @endforeach
                            @endif
                        </ul>
                        <a class="more" href="{{action('\BackEnd\NewsController@getNewsView')}}">{{Lang::get('backend/home.more')}} </a>
                    </div>

                </div> <!--widgetcontent-->
            </div>
        </div>
    </div>
</div>
@endsection