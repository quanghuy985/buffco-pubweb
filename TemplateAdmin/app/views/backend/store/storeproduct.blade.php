@extends("templateadmin2.mainfire")
@section("contentadmin")

<script>

    function phantrang(page) {
        jQuery("#jGrowl").remove();
        jQuery.jGrowl("Đang tải dữ liệu ...");
        var urlpost = "{{URL::action('StoreController@postAjaxpagion')}}?page=" + page;
        if (jQuery('#datepicker').val() != '' && jQuery('#datepicker1').val() != '') {
            urlpost = "{{URL::action('StoreController@postAjaxpagionFillter')}}?timeform=" + jQuery('#datepicker').val() + "&timeto=" + jQuery('#datepicker1').val() + "&oderbyoption=" + jQuery("#oderbyoption1").val() + "&page=" + page;
        }
        if (jQuery('#searchblur').val() != '') {
            urlpost = "{{URL::action('StoreController@postAjaxpagionSearch')}}?keyword=" + jQuery('#searchblur').val() + "&page=" + page;
        }
        var request = jQuery.ajax({
            url: urlpost,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            //jQuery("#jGrowl").remove();
            jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            jQuery('#tableproduct').html(msg);
        });
    }
    function updateStore(id, productID) {
        if (jQuery('#soluongnhap_' + id).val() == '') {
            jAlert('Số lượng nhập không được để trống', 'Thông báo');
        }
        else if (!jQuery.isNumeric(jQuery('#soluongnhap_' + id).val()) || !(jQuery('#soluongnhap_' + id).val() >= 1)) {
            jAlert('Số lượng nhập phải là số lớn hơn 0', 'Thông báo');
            jQuery('#soluongnhap_' + id).val('');
        }
        else if (parseInt(jQuery('#soluongnhap_' + id).val()) < parseInt(jQuery('#soluongban_' + id).val())) {
            jAlert('Số lượng nhập phải lớn hơn số lượng bán', 'Thông báo');
            jQuery('#soluongnhap_' + id).val('');
        }
        else {
            var soluongnhap = jQuery('#soluongnhap_' + id).val();
            var colorID = jQuery('#color_' + id).val();
            var sizeID = jQuery('#size_' + id).val();
            jQuery.jGrowl("Đang kiểm tra kho!");
            var checkStore = jQuery.ajax({
                url: "{{URL::action('StoreController@postCheckExitStore')}}",
                data: {proID: productID, sizeID: sizeID, colorID: colorID},
                type: "POST",
                dataType: "html"
            });
            checkStore.done(function(check) {
                if (check == 'true') {
                    jQuery.jGrowl("Hàng đã có trong kho. Hãy chọn size hoặc màu khác!");
                    return false;
                }
                else {
                    jQuery.jGrowl("Đang cập nhật kho hàng!");
                    var request = jQuery.ajax({
                        url: "{{URL::action('StoreController@postUpdateStoreAjax')}}",
                        data: {id: id, soluongnhap: soluongnhap, colorID: colorID, sizeID: sizeID},
                        type: "POST",
                        dataType: "html"
                    });
                    request.done(function(msg) {
                        if (msg == 'true') {
                            jQuery.jGrowl("Cập nhật kho hàng thành công!");
                        }
                        else {
                            jQuery.jGrowl("Cập nhật kho hàng thất bại!");
                        }
                    });
                }
            });
        }
    }
    function deleteStore(id, productID) {
        jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
            if (r == true) {
                jQuery.jGrowl("Đang xóa hàng");
                var request = jQuery.ajax({
                    url: "{{URL::action('StoreController@postDeleteStoreAjax')}}",
                    data: {id: id, productID: productID},
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {
                    if (msg != 'false') {
                        jQuery.jGrowl("Xóa hàng thành công");
                        jQuery('#tableproduct').empty().html(msg);
                    }
                    else {
                        jQuery.jGrowl("Xóa hàng thất bại");
                    }
                });
            } else {
                return false;
            }
        });
    }
    jQuery(function() {
        jQuery("#wSize").dialog({
            autoOpen: false,
            resizable: false,
            width: 600,
            height: 'auto',
            modal: true
        });
        jQuery("#wColor").dialog({
            autoOpen: false,
            resizable: false,
            width: 600,
            height: 'auto',
            modal: true
        });
        //bật của sổ thêm size
        jQuery("#addSize").button().click(function() {
            jQuery("#wSize").dialog("open");
        });
        //bật của sổ thêm màu
        jQuery("#addColor").button().click(function() {
            jQuery("#wColor").dialog("open");
        });
        //sự kiên thêm size
        jQuery("#submitAddSize").button().click(function() {
            var form = jQuery('#frmSize');
            if (!form.valid())
                return false;
            jQuery.jGrowl("Đang thêm mới size!");
            jQuery('#frmSizeLoader').prop('hidden', false);
            var request = jQuery.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                type: "POST",
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery("#wSize").dialog("close");
                if (msg != 'FALSE') {
                    jQuery("#sizeID").empty().html(msg);
                    jQuery.jGrowl("Thêm mới Size thành công!");
                    jQuery('#frmSizeLoader').prop('hidden', true);
                }
                else {
                    jQuery.jGrowl("Thêm mới Size không thành công!");
                }
            });
        });
        //sự kiên thêm color 
        jQuery("#submitAddColor").button().click(function() {
            var form = jQuery('#frmColor');
            if (!form.valid())
                return false;
            jQuery.jGrowl("Đang thêm mới màu sắc!");
            jQuery('#frmColorLoader').prop('hidden', false);
            var request = jQuery.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                type: "POST",
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery("#wColor").dialog("close");
                if (msg != 'FALSE') {
                    jQuery("#colorID").empty().html(msg);
                    jQuery.jGrowl("Thêm mới Màu Sắc thành công!");
                    jQuery('#frmColorLoader').prop('hidden', true);
<?php
$tblColor = new tblColorModel();
$arrColor = $tblColor->selectAll();
?>
                }
                else {
                    jQuery.jGrowl("Thêm mới Màu Sắc không thành công!");
                }
            });
        });
        jQuery("#btnAddStore").button().click(function() {
            jQuery('#spanLoi').prop('hidden', true);
            var form = jQuery('#frmStore');
            if (!form.valid())
                return false;
            jQuery.jGrowl("Đang kiểm tra kho!");
            jQuery('#frmStoreLoader').prop('hidden', false);
            var checkStore = jQuery.ajax({
                url: "{{URL::action('StoreController@postCheckExitStore')}}",
                data: {proID: jQuery('#productID').val(), sizeID: jQuery('#sizeID').val(), colorID: jQuery('#colorID').val()},
                type: "POST",
                dataType: "html"
            });
            checkStore.done(function(check) {
                if (check == 'true') {
                    jQuery('#frmStoreLoader').prop('hidden', true);
                    jQuery('#spanLoi').prop('hidden', false);

                    jQuery.jGrowl("Hàng đã có trong kho. Hãy chọn size hoặc màu khác!");
                    return false;
                }
                jQuery.jGrowl("Đang thêm hàng!");
                jQuery('#frmStoreLoader').prop('hidden', false);
                var request = jQuery.ajax({
                    url: form.attr('action'),
                    data: form.serialize(),
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {
                    if (msg != 'false') {
                        jQuery.jGrowl("Thêm hàng thành công");
                        jQuery('#tableproduct').empty().html(msg);
                        jQuery('#frmStoreLoader').prop('hidden', true);
                    }
                    else {
                        jQuery.jGrowl("Thêm hàng thất bại");
                    }
                });
            });
        });

    });

</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ HÀNG TRONG KHO</h1>
    <span class="pagedesc">Thêm sửa xóa kho hàng</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Sản phẩm : <strong style="color: red; font-size: 14pt;">{{$arrStore[0]->productName}}</strong></h3>
        </div>        
        <table cellpadding="0" cellspacing="0" border="0"  class="stdtable stdtablecb">
            <colgroup>
                <col class="con1" style="width: 5%"> 
                <col class="con0" style="width: 25%">
                <col class="con1" style="width: 25%">
                <col class="con0" style="width: 13%">              
                <col class="con0" style="width: 12%">
                <col class="con0" style="width: 20%">              
            </colgroup>
            <thead>
                <tr>
                    <th class="head1">STT</th> 
                    <th class="head0">Màu sắc</th>
                    <th class="head1">Size</th>    
                    <th class="head0">Số lượng</th>
                    <th class="head1">Đã bán</th>                          
                    <th class="head0">Action</th>
                </tr>
            </thead>

            <tbody id="tableproduct">
                <?php
                $i = 1;
                if (Input::get('page') > 1) {
                    $i = 10 * Input::get('page') - 9;
                }
                ?>
                @foreach($arrStore as $item)
                <tr id="{{$item->id}}" >  
                    <td class="center"><?php
                        echo $i;
                        $i++;
                        ?> </td>
                    <td>
                        @if(isset($arrColor))
                        <select   id="color_{{$item->id}}" style="width: 100px;">
                            @foreach($arrColor as $mau)
                            <option value="{{$mau->id}}" @if($item->colorID == $mau->id) selected @endif >{{$mau->colorName}}</option>
                            @endforeach
                        </select>
                        @endif
                    </td>  
                    <td> 
                        @if(isset($arrSize))
                        <select id="size_{{$item->id}}" style="width: 100px;">
                            @foreach($arrSize as $size)
                            <option value="{{$size->id}}" @if($item->sizeID == $size->id) selected @endif >{{$size->sizeName}}</option>
                            @endforeach
                        </select>
                        @endif
                    </td>                                      
                    <td class="center">
                        <input type="text" value="{{$item->soluongnhap}}" onkeypress="return event.charCode > 47 && event.charCode < 58;" pattern="[0-9]" id="soluongnhap_{{$item->id}}" /> 
                        <input type="hidden" value="{{$item->soluongban}}" id="soluongban_{{$item->id}}" /> 
                    </td>
                    <td class="center">{{$item->soluongban}} </td> 

                    <td ><a class="btn btn_orange btn_search radius50" href="javascript:updateStore('{{$item->id}}','{{$item->productID}}');" ><span>Cập nhật</span></a> &nbsp; &nbsp; <a href="javascript:deleteStore('{{$item->id}}','{{$item->productID}}')" class="btn btn_trash" ><span>Xóa</span></a></td>
                </tr>
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="6">
                        {{$link}}
                    </td>
                </tr>
                @endif
                @if(count($arrStore)==0)
                <tr>
                    <td colspan="6" style="text-align: center;"><span class="center">Không có dữ liệu trả về .</span></td>
                </tr>
                @endif
            </tbody>
        </table>
        <div class="contenttitle2">
            <h3>Thêm hàng vào kho</h3>
        </div>  
        <form class="stdform stdform2" method="post" id="frmStore" action="{{URL::action('StoreController@postAddStoreAjax')}}">
            <p>                  
                <label>Size</label>
                <span class="field">                               
                    <input type="hidden" name="productID" id="productID" value="@if(isset($arrStore)){{$arrStore[0]->productID}}@endif"/>
                    <select name="sizeID" id="sizeID" required>                            
                        @if(isset($arrSize))
                        @foreach($arrSize as $item)
                        <option value="{{$item->id}}" >{{$item->sizeName}}</option>
                        @endforeach
                        @endif
                    </select> 
                    <button type="button"  class="submit radius2" id="addSize">Thêm size</button>
                </span>
            </p>        
            <p>           
                <label>Màu sắc</label>
                <span class="field">                                               
                    <select name="colorID" id="colorID" required>                            
                        @if(isset($arrColor))
                        @foreach($arrColor as $item)
                        <option value="{{$item->id}}" >{{$item->colorName}}</option>
                        @endforeach
                        @endif
                    </select>  
                    <button type="button"  class="submit radius2" id="addColor">Thêm màu</button>
                </span>                 
            </p>  
            <p>           
                <label>Số lượng</label>
                <span class="field">                                               
                    <input type="text" required title="Trường này không được để trống"  onkeypress="return event.charCode > 47 && event.charCode < 58;" pattern="[0-9]" name="soluongnhap" id="soluongnhap" placeholder="Số lượng" value="" class="longinput">
                </span>                 
            </p>               
            <p class="stdformbutton">
                <button class="submit radius2" type="button" id="btnAddStore" value="Thêm mới">Thêm hàng </button>
                <input type="reset" class="reset radius2" value="Làm mới">
                <img id="frmStoreLoader" hidden="true" src="{{Asset('adminlib/images/loaders/loader1.gif')}}" alt="" />
                <span hidden="true" id="spanLoi" style="color: red;">Hàng đã có trong kho. Vui lòng chọn size hoặc màu khác </span>
            </p>
        </form>
    </div>
    <div id="wSize" title="Thêm size">
        <form class="stdform stdform2" method="post" id="frmSize" action="{{URL::action('SizeController@postAddSizeAjax')}}">
            <p>                  
                <label>Tên</label>
                <span class="field">                                              
                    <input type="text" name="sizeName" required title="Trường này không được để trống" id="sizeName" placeholder="Tên size" value="" class="longinput"></span>
            </p>
            <p>           
                <label>Size</label>
                <span class="field">                    
                    <input type="text" name="sizeValue" required title="Trường này không được để trống" id="sizeValue" placeholder="Size" value="" class="longinput">
                </span>                 
            </p>                        
            <p class="stdformbutton">
                <button class="submit radius2" type="button" id="submitAddSize" value="Thêm mới">Thêm mới </button>
                <input type="reset" class="reset radius2" value="Làm mới">
                <img id="frmSizeLoader" hidden="true" src="{{Asset('adminlib/images/loaders/loader1.gif')}}" alt="" />
            </p>
        </form>
    </div>
    <div id="wColor" title="Thêm màu sắc">
        <form class="stdform stdform2" method="post" id="frmColor" action="{{URL::action('ColorController@postAddColorAjax')}}">
            <p>                  
                <label>Màu sắc: </label>
                <span class="field">                                              
                    <input type="text" name="colorName" required title="Trường này không được để trống" id="colorName" placeholder="Tên màu" value="" class="longinput"></span>
            </p>
            <p>           
                <label>Mã màu: </label>
                <span class="field">                    
                    <input type="text" name="colorCode" required title="Trường này không được để trống" id="colorpicker" placeholder="Mã màu" value="" class="width100">
                    <span id="colorSelector" class="colorselector">                       
                    </span>
                </span>                 
            </p>                        
            <p class="stdformbutton">
                <button class="submit radius2" type="button" id="submitAddColor" value="Thêm mới">Thêm mới </button>
                <input type="reset" class="reset radius2" value="Làm mới">
                <img id="frmColorLoader" hidden="true" src="{{Asset('adminlib/images/loaders/loader1.gif')}}" alt="" />
            </p>
        </form>
    </div>    
</div>

@endsection