@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function xxx(id,email,name,content){
      jQuery('#id').val(id);
      jQuery('#email').val(email);
      jQuery('#name').val(name);
      jQuery('#content').val(content);
      //window.location.href='#frmEdit';
      jQuery('html,body').animate({
      scrollTop: jQuery('#frmEdit').offset().top},'slow');
      kichhoat(id,1);
    };
    jQuery(document).ready(function() {

    jQuery('.deletepromulti').click(function() {
    var addon = '';
            av = document.getElementsByName("checkboxidfile");
            for (e = 0; e < av.length; e++) {
    if (av[e].checked == true) {
    addon += av[e].value + ',';
    }
    }
    if (addon != '') {
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    jQuery.post("{{URL::action('HistoryUserController@postDelmulte')}}", {multiid: addon}).done(function(data) {
    window.location = '{{URL::action('HistoryUserController@getHistoryView')}}';
    });
            return false;
    } else {
    return false;
    }
    });
    } else {
    jAlert('Bạn chưa chọn giá trị', 'Thông báo');
    }
    });
    
    jQuery('#searchblur').keypress(function(e) {
    // Enter pressed?
    if (e.which == 10 || e.which == 13) {
    var request = jQuery.ajax({
    url: "{{URL::action('HistoryUserController@postAjaxsearch')}}?keyword=" + jQuery('#searchblur').val(),
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
    }
    });
            jQuery("#loctheotieuchi").click(function() {
        var request = jQuery.ajax({
                url: "{{URL::action('HistoryUserController@postFillterHistory')}}?status=" + jQuery('#oderbyoption1').val()+"&from="+ jQuery('#datepicker').val()+"&to="+ jQuery('#datepicker1').val(),                
                type: "POST",
                dataType: "html"
        });
                request.done(function(msg) {
                jQuery('#tableproduct').html(msg);
                });
        });
            
    });
    
    function phantrang(page) {
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("Đang tải dữ liệu ...");
        var urlpost = "{{URL::action('HistoryUserController@postAjaxhistoryuser')}}?page=" + page
        if (jQuery('#oderbyoption1').val() != '' || jQuery('#datepicker').val() != '' || jQuery('#datepicker1').val() != '') {
            urlpost = "{{URL::action('HistoryUserController@postFillterHistory')}}?status=" + jQuery('#oderbyoption1').val() + "&page=" + page;
        }
        if (jQuery('#searchblur').val() != '') {
            urlpost = "{{URL::action('HistoryUserController@postAjaxsearch')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
        }
        var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery("#jGrowl").remove();
            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            jQuery('#tableproduct').html(msg);
        });
    }
            
    
    
            
    function xoasanpham(id) {
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('HistoryUserController@postDeleteHistory')}}?id=" + id,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
            return false;
    } else {
    return false;
    }
    })
    }
    
    function kichhoat(id, stus) {
    var request = jQuery.ajax({
    url: "{{URL::action('HistoryUserController@postHistoryActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
            return true;
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">Quản lý lịch sử người dùng</h1>
    <span class="pagedesc">Quản lý lịch sử</span>
</div>

<div class="contentwrapper">
    @if(isset($msg))
            <div class="notibar msgalert">
                <a class="close"></a>
                <p>{{$msg}}</p>
            </div>
            @endif
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Bảng quản lý các lịch sử</h3>
        </div>
            
        <div class="tableoptions">
            <button class="deletepromulti" title="table1">Xóa đã chọn</button> &nbsp;
            <label>From: <input id="datepicker" name="from" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;background: #fff;" type="text"/></label>
            <label>To: <input id="datepicker1" name="to" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;background: #fff;" type="text"/></label>
            <select class="radius3" name="oderbyoption1" id="oderbyoption1">
                <option value="3">Tất cả</option>
                <option value="0">Chờ kích hoạt</option>
                <option value="1">Đã kích hoạt</option>
                <option value="2">Xóa</option>
            </select>&nbsp;
            
               
            
            <div class="dataTables_filter" id="searchformfile"><label>Search: <input id="searchblur" name="searchblur" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;" type="text"></label></div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 3%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0"></th> 
                    <th class="head1">Email</th>
                    <th class="head0">Địa chỉ</th>
                    <th class="head1">Nội dung</th>
                    <th class="head0">Khởi tạo</th>
                    <th class="head1">Tình trạng</th>
                    <th class="head0">Chức năng</th>
                </tr>  
            </thead>

            <tbody id="tableproduct"> 
                
                
                @if(isset($arrHistory))
                @foreach($arrHistory as $item)
                <tr> 
                    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td> 
                    <td><a href="javascript:void(0);" onclick="xxx('{{$item->id}}','{{$item->userEmail}}','{{$item->userAddress}}','{{$item->historyContent}}')">{{str_limit( $item->userEmail, 15, '...')}}</a></td> 
                    <td><label value="page">{{str_limit($item->userAddress, 15, '...')}} </label></td> 
                    <td><label value="page">{{str_limit($item->historyContent, 15, '...')}} </label></td> 
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
                    <td>
                        
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_world" title="Chờ kích hoạt"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_flag" title="Kích hoạt"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif
                    </td> 
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="7">{{$link}}</td>
                </tr>
                @endif
                
                @endif
            </tbody>
        </table>
        
        <div class="contenttitle2">
            <h3>Xem chi tiết lịch sử</h3>
             <div id="frmEdit"></div>  
        </div>
        <form class="stdform stdform2" id="history" action="">            
                    
            
            <p>
                <label>Email</label>
                <span class="field">
                    <input type="text" id="email" name="email" disabled="true" value="" width="100px">
                </span>
            </p>
            <p>
                <label>Tên</label>
                <span class="field">
                    <input type="text" id="name" name="name" disabled="true" value="" width="100px">
                </span>
            </p>            
            <p>
                <label>Nội dung</label>
                <span class="field">
                    <textarea style="resize: vertical;" id="content" name="content" disabled="true" width="100px"></textarea>
                    
                </span>
            </p>    
        </form>
        
    </div>
</div>
@endsection
