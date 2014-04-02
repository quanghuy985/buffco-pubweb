@extends("templateadmin2.mainfire")
@section("contentadmin")
<style type="text/css">
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
        border: 1px solid #d3d3d3;
        background: #e6e6e6 url(images/ui-bg_glass_75_e6e6e6_1x400.png) 50% 50% repeat-x;
        font-weight: normal;
        color: #555555;
    }
</style>
<script>
    jQuery(document).ready(function() {
        jQuery('#tags').tagsInput();
    });
    function getCateTag() {
        jQuery.jGrowl("Đang tải dữ liệu!");
        var cateID = jQuery('#cateProductSelect').val();
        if (cateID == 0) {
            jQuery('#addTag').prop("disabled", true);
            jQuery("#spanTag").empty();
        } else {
            jQuery('#addTag').prop("disabled", false)
            var productID = jQuery('#idpro').val();
            var request = jQuery.ajax({
                url: "{{URL::action('ProductController@postTagByCateID')}}",
                data: {cateID: cateID, productID: productID},
                type: "POST",
                dataType: "html"
            });
            request.done(function(msg) {
                if (msg != 'FALSE') {
                    jQuery("#spanTag").empty().html(msg);
                }
            });
        }
    }
    function CKupdate() {
        for (instance in CKEDITOR.instances)
            CKEDITOR.instances[instance].updateElement();
    }
    jQuery(function() {
        jQuery("#wPromotion").dialog({
            autoOpen: false,
            resizable: false,
            width: 800,
            height: 'auto',
            modal: true,
//            buttons: {
//                "Set": function() {
//                    jQuery(this).dialog("close");
//                },
//                "Đóng": function() {
//                    jQuery(this).dialog("close");
//                }
//            }
        });
        jQuery("#wTag").dialog({
            autoOpen: false,
            resizable: false,
            width: 600,
            height: 'auto',
            modal: true,
//            buttons: {
//                "Set": function() {
//                    jQuery(this).dialog("close");
//                },
//                "Đóng": function() {
//                    jQuery(this).dialog("close");
//                }
//            }
        });
        //bật của sổ thêm khuyến mại
        jQuery("#addPromotion").button().click(function() {
            jQuery("#wPromotion").dialog("open");
        });
        //bật của sổ thêm tag cho danh mục sản phẩm
        jQuery("#addTag").button().click(function() {
            var cateID = jQuery('#cateProductSelect').val();
            if (cateID == 0) {
                return;
            }
            else {
                
                jQuery('#cateTagID').val(jQuery('#cateProductSelect').val());
            jQuery("#ui-dialog-title-wTag").html('Thêm tag cho danh mục: '+jQuery('#cateProductSelect option:selected').text() ) ;   
            jQuery("#wTag").dialog("open");
            }

        });
        jQuery("#submitAddPromotion").button().click(function() {
            CKupdate();
            jQuery.jGrowl("Đang thêm mới khuyến mại!");
            var form = jQuery('#frmPromotion');
            var request = jQuery.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                type: "POST",
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery("#wPromotion").dialog("close");
                if (msg != 'FALSE') {
                    jQuery("#promotionSelect").empty().html(msg);
                    jQuery.jGrowl("Thêm mới khuyến mại thành công!");
                }

            });
        });
        jQuery("#submitAddTag").button().click(function() {
            jQuery.jGrowl("Đang thêm mới tag!");
            var form = jQuery('#frmTag');
            var request = jQuery.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                type: "POST",
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery("#wTag").dialog("close");
                if (msg != 'FALSE') {
                    jQuery("#spanTag").empty().html(msg);
                    jQuery.jGrowl("Thêm mới tag thành công!");
                }
                //jQuery.jGrowl("Thêm mới khuyến mại thành công!");
            });
        });
    });

</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ SẢN PHẨM</h1>
    <span class="pagedesc">Thêm sửa xóa sản phẩm</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        @if(isset($thongbao))
        <div class="notibar msgsuccess">
            <a class="close"></a>
            <p>{{$thongbao}}</p>
        </div>
        @endif
        <div class="contenttitle2">
            <h3>Thêm mới</h3>
        </div>

        <form class="stdform stdform2" method="post" action="@if(isset($dataedit)){{URL::action('ProductController@postEditProduct')}} @else {{URL::action('ProductController@postAddProduct')}} @endif" accept-charset="UTF-8" enctype="multipart/form-data">

            <p>
                <label>Tên sản phẩm</label>
                <span class="field">
                    <input type="hidden" name="idpro" id="idpro" value="@if(isset($dataedit)){{$dataedit->id}}@endif"/>
                    <input type="text" name="productName" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($dataedit)){{$dataedit->productName}}@endif">
                </span>
            </p>
            <p>
                <label>Nhóm sản phẩm</label>
                <span class="field">
                    <select name="cateID" id="cateProductSelect" onchange="getCateTag()">
                        <option value="0" >---Chọn danh mục---</option>
                        <?php
                        foreach ($catproduct as $item) {
                            if ($item->cateParent == 0) {
                                $selec = '';
                                if (isset($dataedit) && $item->id == $dataedit->cateID) {
                                    $selec = 'selected';
                                }
                                echo '<option value="' . $item->id . '" ' . $selec . '> ' . $item->cateName . '</option>';
                                foreach ($catproduct as $item1) {
                                    if ($item1->cateParent == $item->id) {
                                        $selec1 = '';
                                        if (isset($dataedit) && $item1->id == $dataedit->cateID) {
                                            $selec1 = 'selected';
                                        }
                                        echo '<option value="' . $item1->id . '" ' . $selec1 . '>-- ' . $item1->cateName . '</option>';
                                    }
                                }
                            }
                        }
                        ?>

                    </select>      
                    <button type="button"   class="submit radius2" id="addTag">Thêm tag cho danh mục sản phẩm</button>
                </span>  
                <label>Tag</label>
                <span class="formwrapper" id="spanTag" style="overflow: auto;width: 548px; height: 200px;border: 1;BORDER-RIGHT: blue 1px solid;BORDER-TOP: blue 1px solid; BORDER-LEFT: blue 1px solid;BORDER-BOTTOM: blue 1px solid;BACKGROUND-COLOR: White;">

                    <?php
                    if (isset($arrTag)) {
                        foreach ($arrTag as $itemTag) {
                            if (isset($arrTaged)) {
                                $checked = '';
                                foreach ($arrTaged as $itemTaged) {
                                    if ($itemTaged->tagID == $itemTag->id) {
                                        $checked = 'checked';
                                        break;
                                    } else {
                                        $checked = '';
                                    }
                                }
                                echo '<input ' . $checked . ' type="checkbox" value="' . $itemTag->id . '" name="tag[]" />' . $itemTag->tagKey . ':  ' . $itemTag->tagValue . ' <br />';
                            } else {
                                echo '<input type="checkbox" value="' . $itemTag->id . '" name="tag[]" />' . $itemTag->tagKey . ':  ' . $itemTag->tagValue . ' <br />';
                            }
                        }
                    }
                    ?>                        
                </span>  
            </p>        
            <p>
                <label>Chi tiết sản phẩm</label>
                <span class="field">
                    <textarea class="ckeditor" id="xxx" rows="5" name="productDescription" placeholder="Nhập chi tiết sản phẩm">@if(isset($dataedit)){{$dataedit->productDescription}}@endif</textarea>

                </span>
            </p>

            <p>
                <label>Giá sản phẩm </label>
                <span class="field">
                    <input type="text" name="productPrice"  placeholder="Nhập giá sản phẩm" class="smallinput" value="@if(isset($dataedit)){{$dataedit->productPrice}}@endif">
                </span>
            </p>
            <p>
                <label>Chọn khuyến mại </label>
                <span class="field" id="sPromotion"> 
                    <select name="promotionID" id="promotionSelect">
                        <option value="">---Chọn khuyến mại---</option>
                        @foreach($arrPromotion as $item)
                        <option value="{{$item->id}}" @if(isset($dataedit) && $dataedit->promotionID == $item->id) selected @endif >{{$item->promotionName}}</option>
                        @endforeach
                    </select>
                    <button type="button"  class="submit radius2" id="addPromotion">Thêm khuyến mại</button>
                </span>
            </p>
            <p>
                <label>Từ khóa seo</label>
                <span class="field">
                    <input type="text" name="productTag" placeholder="Nhập từ khóa seo " id="tags" class="smallinput" value="@if(isset($dataedit)){{$dataedit->productTag}}@endif">
                    <small class="desc">Ấn phím enter hoắc dấu "," sau mỗi lần nhập từ khóa</small>
                </span>

            </p>
            <p>
                <label>Slug</label>
                <span class="field">
                    <input type="text" name="productSlug" placeholder="Nhập slug sản phẩm" class="smallinput" value="@if(isset($dataedit)){{$dataedit->productSlug}}@endif"> 
                </span>
            </p>   
            <p>
                <label>Chọn khuyến mại </label>
                <span class="field" id="sPromotion"> 
                    <select name="manufactureID" id="manufactureSelect">
                        <option value="">---Chọn nhà sản xuất---</option>
                        @foreach($arrManu as $item)
                        <option value="{{$item->id}}" @if(isset($dataedit) && $dataedit->manufactureID == $item->id) selected @endif >{{$item->manufacturerName}}</option>
                        @endforeach
                    </select>
                    <button type="button"  class="submit radius2" id="addManu">Thêm nhà sản xuất</button>
                </span>
            </p>
            <p>
                <label>Trạng thái</label>
                <span class="field">
                    <select name="status" id="selection2">
                        <option value="0" @if(isset($dataedit)&& $dataedit->status==0)selected @endif >Chờ đăng</option>
                        <option value="1" @if(isset($dataedit)&&$dataedit->status==1)selected @endif >Đã đăng</option>
                        <option value="2" @if(isset($dataedit)&&$dataedit->status==2)selected @endif >Xóa</option>
                    </select>
                </span>
            </p>

            <p class="stdformbutton">
                <button class="submit radius2">@if(isset($dataedit))Cập nhật @else Thêm mới @endif</button>
                <input type="reset" class="reset radius2" value="Làm lại">
                <button type="button" onclick="window.location.href='{{URL::action('ProductController@getView')}}';" class="submit radius2">Quay lại danh sách sản phẩm</button>
            </p>           
        </form>
        <div id="wPromotion" title="Thêm khuyến mại">
            <form class="stdform stdform2" method="post" id="frmPromotion" action="{{URL::action('PromotionController@postAddPromotionAjax')}}">
                <p>                  
                    <label>Tên khuyến mại</label>
                    <span class="field">
                        <input type="hidden" name="promotionID" value="@if(isset($dataedit)){{$dataedit->promotionID}}@endif"/>
                        <input type="text" name="promotionName" placeholder="Nhập tên nhóm hỗ trợ viên" value="" class="smallinput"></span>
                </p>
                <p>           
                    <label>Nội dung</label>
                    <span class="field">                    
                        <textarea class="ckeditor" rows="5" name="promotionContent" placeholder="Nhập nội dung khuyến mại"></textarea>
                    </span>
                </p>
                <p>         
                    <label>Giá trị</label>
                    <span class="field"><input type="text" name="promotionAmount" placeholder="Nhập giá trị khuyến mại" value="" class="smallinput"></span>
                </p>               
                <p class="stdformbutton">
                    <button class="submit radius2" type="button" id="submitAddPromotion" value="Thêm mới">Thêm mới </button>
                    <input type="reset" class="reset radius2" value="Làm mới">
                </p>
            </form>
        </div>
        <div id="wTag" title="Thêm tag">
            <form class="stdform stdform2" method="post" id="frmTag" action="{{URL::action('TagController@postAddTagAjax')}}">
                <p>                  
                    <label>Key</label>
                    <span class="field">
                        <input type="hidden" name="cateTagID" id="cateTagID" value=""/>
                        <input type="hidden" name="productID" id="productID" value="@if(isset($dataedit)){{$dataedit->id}}@endif"/>
                        <input type="text" name="tagKey" placeholder="Tên Tag" value="" class="longinput"></span>
                </p>
                <p>           
                    <label>Value</label>
                    <span class="field">                    
                        <input type="text" name="tagValue" placeholder="Giá trị của Tag" value="" class="longinput">
                    </span>                 
                </p>                        
                <p class="stdformbutton">
                    <button class="submit radius2" type="button" id="submitAddTag" value="Thêm mới">Thêm mới </button>
                    <input type="reset" class="reset radius2" value="Làm mới">
                </p>
            </form>
        </div>
    </div>
</div>
@endsection