@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
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
    jQuery.post("{{URL::action('PageController@postDelmulte')}}", {multiid: addon}).done(function(data) {
    window.location = '{{URL::action('PageController@getPageView')}}';
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
    url: "{{URL::action('PageController@postAjaxsearch')}}?keyword=" + jQuery('#searchblur').val(),
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
                url: "{{URL::action('PageController@postFillterPage')}}?status=" + jQuery('#oderbyoption1').val(),                
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
        var urlpost = "{{URL::action('PageController@postAjaxpage')}}?page=" + page
        if (jQuery('#oderbyoption1').val() != '') {
            urlpost = "{{URL::action('PageController@postFillterPage')}}?status=" + jQuery('#oderbyoption1').val() + "&page=" + page;
        }
        if (jQuery('#searchblur').val() != '') {
            urlpost = "{{URL::action('PageController@postAjaxsearch')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
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
    url: "{{URL::action('PageController@postDeletePage')}}?id=" + id,
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
    url: "{{URL::action('PageController@postPageActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
            return true;
    }
</script>

<script>
    jQuery(document).ready(function(){
    jQuery("#addPage").validate({
    rules: {
            pageName: {
                required: true
                
            },
            pageKeyword: {
                required: true
                
            },
            pageTag: {
                required: true
            },
            pageSlug: {
                required: true
            }

            },
    messages: {
            pageName: {
                required: 'Tên là trường bắt buộc'
                
            },
            pageKeyword: {
                required: 'Từ khóa là trường bắt buộc'
               
            },
            pageTag: {
                required: 'Vui lòng nhập tag'
            },
            pageSlug: {
                required: 'Vui lòng nhập slug '
            }
        }
        });
    });
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">Quản lý trang</h1>
    <span class="pagedesc">Quản lý các trang</span>
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
            <h3>Bảng quản lý các trang</h3>
        </div>
            
        <div class="tableoptions">
            <button class="deletepromulti" title="table1">Xóa đã chọn</button> &nbsp;
            <select class="radius3" name="oderbyoption1" id="oderbyoption1">
                <option value="">Tất cả</option>
                <option value="0">Chờ đăng</option>
                <option value="1">Đã đăng</option>
                <option value="2">Xóa</option>
            </select>&nbsp;
            <button class="radius3" id="loctheotieuchi">Lọc theo tiêu chí</button>
            <div class="dataTables_filter" id="searchformfile"><label>Search: <input id="searchblur" name="searchblur" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;" type="text"></label></div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 3%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 10%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 10%">
                <col class="con1" style="width: 20%">
                <col class="con1" style="width: 15%">
                <col class="con1" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0"></th> 
                    <th class="head1">Tên trang</th>
                    <th class="head0">Từ khóa</th>
                    <th class="head1">Tag</th>
                    <th class="head0">Slug</th>
                    <th class="head1">Khởi tạo</th>
                    <th class="head0">Tình trạng</th>
                    <th class="head1">Chức năng</th>
                </tr>  
            </thead>

            <tbody id="tableproduct"> 
                
                
                @if(isset($arrPage))
                @foreach($arrPage as $item)
                <tr> 
                    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td> 
                    <td><label value="page">{{str_limit( $item->pageName, 30, '...')}}</label></td> 
                    <td><label value="page">{{str_limit($item->pageKeywords, 30, '...')}} </label></td> 
                    <td><label value="page">{{str_limit($item->pageTag, 30, '...')}} </label></td> 
                    <td><label value="page">{{str_limit($item->pageSlug, 30, '...')}} </label></td> 
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
                        <a href="{{URL::action('PageController@getPageEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
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
                    <td colspan="8">{{$link}}</td>
                </tr>
                @endif
                
                @endif
            </tbody>
        </table>
        
        
    </div>
</div>
@endsection

