@extends("templateadmin2.mainfire")
@section("contentadmin")

<script>

    var from =0;
            var to =0;
            var status = '';
            var keyword = '';
            function phantrang(page) {
              
                    jQuery.jGrowl("Đang tải dữ liệu ...");
                    var urlpost = "{{URL::action('ProductController@postAjaxpagion')}}?page=" + page + "&from=" + from + "&to=" + to + "&keyword=" + keyword + "&status=" + status;
                    var request = jQuery.ajax({
                    url: urlpost,
                            type: "POST",
                            dataType: "html"
                    });
                    request.done(function(msg) {
                    //  
                    jQuery.jGrowl("Đã tải dữ liệu thành công ...");
                            jQuery('#tableproduct').html(msg);
                    });
            }
    function locdulieu() {
    from = jQuery('#datepicker').val();
            to = jQuery('#datepicker1').val();
            status = jQuery("#oderbyoption1").val();
            keyword = jQuery('#searchblur').val();            
            jQuery.jGrowl("Đang tải dữ liệu ...");
            var request = jQuery.ajax({
            url: "{{URL::action('ProductController@postFillterProduct')}}?from=" + from + "&to=" + to + "&status=" + status + "&keyword=" + keyword,
                    type: "POST",
                    dataType: "html"
            }
            );
            request.done(function(msg) {
              
                    jQuery.jGrowl("Đã tải dữ liệu thành công ...");
                    jQuery('#tableproduct').html(msg);
            });
    }
    jQuery(document).ready(function() {
    jQuery('#searchblur').keypress(function(e) {
    if (e.which == 10 || e.which == 13) {
    locdulieu();
    }
    });
    });
            function xoasanpham(id) {
            jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
            if (r == true) {
            var request = jQuery.ajax({
            url: "{{URL::action('ProductController@postDel')}}?id=" + id,
                    type: "POST",
                    dataType: "html"
            });
                    request.done(function(msg) {
                    locdulieu();
                    });
                    return false;
            } else
            {
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
            <form class="stdform stdform2" action="javascript:void(0)" method="post">
                Từ : <input id="datepicker" name="timeform" type="text" class="longinput" /> 
                &nbsp;   Đến : <input id="datepicker1"  name="timeto" type="text" class="datepicker"  /> 
                &nbsp; &nbsp; <select class="radius3" name="oderbyoption1" id="oderbyoption1">
                    <option value="">Tất cả</option>
                    <option value="0">Chờ đăng</option>
                    <option value="1">Đã đăng</option>
                    <option value="2">Xóa</option>
                </select>&nbsp; &nbsp;<button class="radius3" id="loctheotieuchi" onclick="locdulieu()">Lọc dữ liệu</button>

            </form>
            <div class="dataTables_filter1" id="searchformfile"><label>Search: <input id="searchblur" name="searchblur" style="-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fcfcfc;color: #666;-moz-box-shadow: inset 0 1px 3px #ddd;-webkit-box-shadow: inset 0 1px 3px #ddd;box-shadow: inset 0 1px 3px #ddd;" type="text"></label>&nbsp; &nbsp;<a href="javascript:void(0)" onclick="locdulieu()" class="btn btn_search radius50"><span>Tìm kiếm</span></a></div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable stdtablecb">
            <colgroup>

                <col class="con0" style="width: 20%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 12%">
                <col class="con1" style="width: 7%">
                <col class="con0" style="width: 7%">
                <col class="con1" style="width: 7%">
                <col class="con0" style="width: 20%">
                <col class="con1" style="width: 8%">
                <col class="con0" style="width: 15%">

            </colgroup>
            <thead>
                <tr>
                    <th class="head0">Tên sản phẩm</th>
                    <th class="head1">Mã sản phẩm</th>
                    <th class="head0">Nhóm</th>                    
                    <th class="head1">Giá</th>
                    <th class="head0">Số lượng</th>
                    <th class="head1">Đã bán</th>
                    <th class="head0">Khuyến mại</th>                
                    <th class="head1">Trạng thái</th>
                    <th class="head0">Action</th>
                </tr>
            </thead>

            <tbody id="tableproduct">
                @foreach($dataproduct as $item)
                <tr >  
                    <td><a href="{{URL::action('ProductController@getEditProduct')}}/{{$item->id}}" >{{$item->productName}}</a>  </td>
                    <td><a href="{{URL::action('ProductController@getEditProduct')}}/{{$item->id}}" >{{$item->productCode}}</a></td>             
                    <td class="center">{{$item->cateName}} </td>
                    <td class="center">{{number_format($item->productPrice,0,'.', ',')}}</td>  
                    <td class="center">@if($item->soluong!=null){{$item->soluong}} @else 0 @endif </td>
                    <td class="center">@if($item->daban!=null) {{$item->daban}}  @else 0 @endif </td>
                    <td class="center">{{number_format($item->salesPrice,0,'.', ',')}}<br/>                    
                        @if($item->startSales!=0 ||$item->endSales!=0)  {{ '(' }}  @endif
                        @if($item->startSales!=0)Từ {{date('d/m/Y',$item->startSales)}} @else  @endif  @if($item->endSales!=0)đến {{date('d/m/Y',$item->endSales)}} @else   @endif
                        @if($item->startSales!=0 ||$item->endSales!=0)  {{ ')' }}  @endif
                    </td> 
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
                    <td class="center"><a href="{{URL::action('ProductController@getEditProduct')}}/{{$item->id}}" >Sửa</a> &nbsp; || &nbsp; <a href="javascript: void(0)" onclick="xoasanpham('{{$item->id}}')">Xóa</a></td>
                </tr>
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="9">
                        {{$link}}
                    </td>
                </tr>
                @endif
                @if(count($dataproduct)==0)
                <tr>
                    <td colspan="9" style="text-align: center;"><span class="center">Không có dữ liệu trả về .</span></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection