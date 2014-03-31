@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
    var request = jQuery.ajax({
    url: "{{URL::action('PromotionController@postAjaxpagion')}}?page=" + page,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
    }
    function xoasanpham(id) {
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('PromotionController@postDeletePromotion')}}?id=" + id,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
            return true;
    } else {
    return false;
    }
    })
    }
    function kichhoat(id, stus) {
    var request = jQuery.ajax({
    url: "{{URL::action('PromotionController@postPromotionActive')}}?id=" + id + "&status=" + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);     
             jQuery('#messages1').empty().html(" <div class='notibar msgsuccess'><a class='close'></a><p>Cập nhật thành công.</p> </div>"); 
        });
            return true;
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ  KHUYẾN MẠI</h1>
    <span class="pagedesc">Quản lý khuyến mại</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Khuyến mại</h3>
    </div>
    <div class="contentwrapper">
        <div class="subcontent">
             <div id="messages1">
            @if(isset($thongbao))
            <div class="notibar msgalert">
                <a class="close"></a>
                <p>{{$thongbao}}</p>
            </div>
            @endif
             </div>
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con1" style="width: 5%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 30%">
                    <col class="con0" style="width: 10%">
                     <col class="con1" style="width: 10%">
                     <col class="con0" style="width: 10%">
                    <col class="con1" style="width: 15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1">ID</th>
                        <th class="head0">Tên khuyến mại</th>
                        <th class="head1">Nội dung</th>
                        <th class="head0">Giá trị</th>
                        <th class="head0">Ngày khởi tạo</th>                        
                        <th class="head1">Tình trạng</th>
                        <th class="head0">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct">
                    @foreach($arrPromotion as $item)
                    <tr> 

                        <td><label value="cateMenuer">{{$item->id }}</label></td> 
                        <td><label value="cateMenuer">{{$item->promotionName}}</label></td>
                         <td><label value="cateMenuer">{{str_limit( $item->promotionContent, 50, '...')}}</label></td>
                          <td><label value="cateMenuer">{{$item->promotionAmount}}</label></td>
                        <td><label value="cateMenuer"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td> 
                        <td><label value="cateMenuer"><?php
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

                            <a href="{{URL::action('PromotionController@getPromotionEdit')}}?id={{$item->id}}&#frmEdit" class="btn btn4 btn_book" title="Sửa"></a>
                            @if($item->status=='2')
                            <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="Khởi tạo"></a>
                            @endif
                            @if($item->status=='0')
                            <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="Kích hoạt"></a>
                            @endif
                            @if($item->status!='2')
                            <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                            @endif

                        </td> 
                    </tr> 
                    @endforeach
                    @if($link!='')
                    <tr>
                        <td colspan="4">{{$link}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    <div class="contenttitle2">
        <h3>Bảng thêm và chỉnh sửa</h3>
    </div>
    <a name="frmEdit"></a>
    <form class="stdform stdform2" method="post" action="@if(isset($promotionData)) {{URL::action('PromotionController@postUpdatePromotion')}} @else {{URL::action('PromotionController@postAddPromotion')}}@endif">

        <p>
            <input type="hidden" name="id" id="idnews" value="@if(isset($promotionData)){{$promotionData->id}}@endif"/>
            <label>Tên khuyến mại</label>
            <span class="field"><input type="text" name="promotionName" placeholder="Nhập tên nhóm hỗ trợ viên" value="@if(isset($promotionData)){{$promotionData->promotionName}}@endif" class="longinput"></span>
        </p>
         <p>           
            <label>Nội dung</label>
            <span class="field">
               <textarea class="ckeditor" id="xxx" rows="5" name="promotionContent" placeholder="Nhập nội dung khuyến mại">@if(isset($promotionData)){{$promotionData->promotionContent}}@endif</textarea>
            </span>
        </p>
            <p>         
            <label>Giá trị</label>
            <span class="field"><input type="text" name="promotionAmount" placeholder="Nhập giá trị khuyến mại" value="@if(isset($promotionData)){{$promotionData->promotionAmount}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status">
                    <option value="0" @if(isset($promotionData)&& $promotionData->status==0)selected@endif >Chờ kích hoạt</option>
                    <option value="1" @if(isset($promotionData)&& $promotionData->status==1)selected@endif>Kích hoạt</option>
                    <option value="2" @if(isset($promotionData)&& $promotionData->status==2)selected@endif>Xóa</option>
                </select>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($promotionData))Cập nhật @else Thêm mới @endif ">@if(isset($promotionData))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới">
        </p>
    </form>
</div>

@endsection

