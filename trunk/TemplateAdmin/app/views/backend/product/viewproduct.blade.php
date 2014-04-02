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
    jQuery.post("{{URL::action('ProductController@postDelmulte')}}", {multiid: addon}).done(function(data) {
    window.location = '{{URL::action('ProductController@getView')}}';
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
    url: "{{URL::action('ProductController@postAjaxsearch')}}?keywordsearch=" + jQuery('#searchblur').val(),
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
    }
    });
            jQuery("#fillterfunction").click(function() {
    alert(jQuery('#oderbyoption').val());
    });
            jQuery("#loctheotieuchi").click(function() {
                jQuery('#imgLoader').prop('hidden',false);
    var request = jQuery.ajax({
    url: "{{URL::action('ProductController@postFillterProduct')}}",
            data: {selectoptionnum: jQuery('#selectoptionnum').val(), oderbyoption: jQuery('#oderbyoption').val(), oderbyoption1: jQuery('#oderbyoption1').val()},
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
             jQuery('#imgLoader').prop('hidden',true);
            });
    });
    });
            function phantrang(page) {
            var request = jQuery.ajax({
            url: "{{URL::action('ProductController@postAjaxpagion')}}?page=" + page,
                    type: "POST",
                    dataType: "html"
            });
                    request.done(function(msg) {
                    jQuery('#tableproduct').html(msg);
                    });
            }
    function xoasanpham(id){
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('ProductController@postDel')}}?id=" + id,
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
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ SẢN PHẨM</h1>
    <span class="pagedesc">Thêm sửa xóa sản phẩm</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Sản phẩm</h3>
        </div>
        <div class="tableoptions">
            <button class="deletepromulti" title="table1">Xóa đã chọn</button> &nbsp;
<!--            <select class="radius3" name="selectoptionnum" id="selectoptionnum">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
            </select> 
            <select class="radius3" name="oderbyoption" id="oderbyoption">
                <option value="id">Mặc định</option>
                <option value="productName">Theo tên</option>
                <option value="productPrice">Theo giá</option>
            </select>-->
            <select class="radius3" name="oderbyoption1" id="oderbyoption1">
                <option value="">Tất cả</option>
                <option value="0">Chờ đăng</option>
                <option value="1">Đã đăng</option>
                <option value="2">Xóa</option>
            </select>&nbsp;
            <button class="radius3" id="loctheotieuchi">Lọc theo tiêu chí</button>
            <img id="imgLoader" hidden="true" src="{{Asset('adminlib2/images/loaders/loader1.gif')}}" alt="" />
            <div class="dataTables_filter" id="searchformfile"><label>Search: <input id="searchblur" name="searchblur" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;" type="text"></label></div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 4%">
                <col class="con1" style="width: 4%">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">

            </colgroup>
            <thead>
                <tr>
                    <th class="head0"><input type="checkbox" class="checkall" name="checkall" ></th>
                    <th class="head1">ID</th>
                    <th class="head0">Nhóm</th>
                    <th class="head1">Tên sản phẩm</th>                    
                    <th class="head1">Giá</th>
                    <th class="head0">Khuyến mại</th>                
                    <th class="head0">Trạng thái</th>
                    <th class="head1">Action</th>
                </tr>
            </thead>

            <tbody id="tableproduct">
                @foreach($dataproduct as $item)
                <tr >
                    <td align="center"><input type="checkbox" name="checkboxidfile" value="{{$item->id}}" ></td>
                    <td>{{$item->id}}</td>
                    <td>{{$item->cateName}}  </td>
                    <td>{{$item->productName}}</td>                  
                    <td class="center">{{$item->productPrice}} </td>
                    <td class="center">{{str_limit( $item->promotionName, 35, '...')}}</td>                    
                    <td class="center">
                        @if($item->status==0)
                        chờ đăng
                        @endif
                        @if($item->status==1)
                        đã đăng
                        @endif 
                        @if($item->status==2)
                        xóa
                        @endif

                    </td>
                    <td class="center"><a href="{{URL::action('ProductController@getEditProduct')}}?idedit={{$item->id}}" >Chỉnh sửa</a> &nbsp; <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})">Xóa</a></td>
                </tr>
                @endforeach
                @if($page!='')
                <tr>
                    <td colspan="10">
                        {{$page}}
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection