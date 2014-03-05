@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
    var request = jQuery.ajax({
    url: "{{URL::action('ServicesController@postAjaxpagion')}}?page=" + page,
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
    url: "{{URL::action('ServicesController@postDeleteServices')}}?iddel=" + id,
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
    <h1 class="pagetitle">QUẢN LÝ DỊCH VỤ</h1>
    <span class="pagedesc">Thêm sửa xóa dịch vụ</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        @if(isset($thongbao))
        <div class="notibar msgalert">
            <a class="close"></a>
            <p>{{$thongbao}}</p>
        </div>
        @endif
        <div class="contenttitle2">
            <h3>Quản lý</h3>
        </div>


        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable stdtablecb">
            <colgroup>
                <col class="con1" style="width: 4%">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">

            </colgroup>
            <thead>
                <tr>
                    <th class="head1">ID</th>
                    <th class="head0">Tên</th>
                    <th class="head1">Mô tả</th>
                    <th class="head0">Giá</th>
                    <th class="head1">Giá khuyến mại</th>
                    <th class="head0">Slug</th>
                    <th class="head0">Thời gian</th>
                    <th class="head0">Trạng thái</th>
                    <th class="head1">Action</th>
                </tr>
            </thead>

            <tbody id="tableproduct">
                @foreach($datasevices as $item)
                <tr > 
                    <td class="center">{{$item->id}}</td>
                    <td class="center">{{$item->servicesName}}  </td>
                    <td class="center">{{$item->servicesContent}}</td>
                    <td class="center">{{$item->servicesPrices}}</td>
                    <td class="center">{{$item->servicesPromotion}} </td>
                    <td class="center">{{$item->servicesSlug}} </td>
                    <td class="center">{{date('d/m/Y h:i:s',$item->servicesTime)}} </td>
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
                    <td class="center"><a href="{{URL::action('ServicesController@getEditServices')}}?idedit={{$item->id}}" >Chỉnh sửa</a> &nbsp; <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})">Xóa</a></td>
                </tr>
                @endforeach
                @if($page!='')
                <tr>
                    <td colspan="9">
                        {{$page}}
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        <br/>
        <div class="contenttitle2" id="chinhsuaservices">
            <h3>Chỉnh sửa thêm mới</h3>
        </div>
        <form class="stdform stdform2" method="post" action="@if(isset($datasevicesedit)){{URL::action('ServicesController@postUpdateServices')}} @else {{URL::action('ServicesController@postAddServices')}} @endif" accept-charset="UTF-8" enctype="multipart/form-data">
            <p>
                <label>Tên dịch vụ</label>
                <span class="field">   
                    <input type="hidden" name="idservices"  class="longinput"  value="@if(isset($datasevicesedit)){{$datasevicesedit->id}}@endif">
                    <input type="text" name="servicesname" placeholder="Tên dịch vụ" class="longinput" value="@if(isset($datasevicesedit)){{$datasevicesedit->servicesName}}@endif" >
                </span>
            </p>
            <p>
                <label>Mô tả</label>
                <span class="field">
                    <input type="text" name="servicesconent" placeholder="Mô tả ngắn gọn dịch vụ" class="longinput" value="@if(isset($datasevicesedit)){{$datasevicesedit->servicesContent}}@endif" >
                </span>
            </p>
            <p>
                <label>Giá</label>
                <span class="field">
                    <input type="text" name="servicesprice" placeholder="Giá dịch vụ / tháng" class="longinput" value="@if(isset($datasevicesedit)){{$datasevicesedit->servicesPrices}}@endif" >
                </span>
            </p>
            <p>
                <label>Giá khuyến mại</label>
                <span class="field">
                    <input type="text" name="servicesprom" placeholder="Giá khuyến mại" class="longinput" value="@if(isset($datasevicesedit)){{$datasevicesedit->servicesPromotion}}@endif" >
                </span>
            </p>
            <p>
                <label>Slug</label>
                <span class="field">
                    <input type="text" name="servicesslug" placeholder="Nhập đường dẫn rút gọn" class="longinput" value="@if(isset($datasevicesedit)){{$datasevicesedit->servicesSlug}}@endif" >
                </span>
            </p>
            @if(isset($datasevicesedit))
            <p>
                <label>Trạng thái</label>
                <span class="field">
                    <select name="status" id="selection2">
                        <option value="0" @if($datasevicesedit->status==0)selected @endif >Chờ đăng</option>
                        <option value="1" @if($datasevicesedit->status==1)selected @endif >Đã đăng</option>
                        <option value="2" @if($datasevicesedit->status==2)selected @endif >Xóa</option>
                    </select>
                </span>
            </p>
            @endif
            <p class="stdformbutton">
                <button class="submit radius2">@if(isset($datasevicesedit))Cập nhật @else Thêm mới @endif</button>
                <input type="reset" class="reset radius2" value="Làm lại">
            </p>
        </form>
    </div>
</div>
@endsection