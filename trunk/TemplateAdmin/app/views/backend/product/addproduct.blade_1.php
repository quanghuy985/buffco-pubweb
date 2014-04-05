@extends("templateadmin2.mainfire")
@section("contentadmin")
<style type="text/css">
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
        border: 1px solid #d3d3d3;
        background: #e6e6e6 url(images/ui-bg_glass_75_e6e6e6_1x400.png) 50% 50% repeat-x;
        font-weight: normal;
        color: #555555;
    }
    .stdform small.desc {
        margin: 5px 0 0 2px !important;
    }
    #frmStore #addColor,#addSize {
        margin-left: 5px;
        position: absolute;
    }

    #frmStore div.selector {
        height: 53px !important;
    }
</style>
<script>
    jQuery(document).ready(function() {
        //validate form thêm sản phẩm
        jQuery("#frmProduct").validate({
            rules: {
                productName: {
                    required: true
                },
                cateProductSelect: {
                    required: true,
                    min: 1
                },
                productDescription: {
                    required: true
                },
                productPrice: {
                    required: true
                },
                productTag: {
                    required: true
                },
                productSlug: {
                    required: true
                },
                manufactureSelect: {
                    required: true,
                    min: 1
                },
            },
            messages: {
                productName: "Tên sản phẩm không được để trống",
                cateProductSelect: "Danh mục sản phẩm không được để trống",
                productDescription: "Mô tả sản phẩm không được để trống",
                productPrice: "Giá sản phẩm không được để trống",
                productTag: "Tag không được để trống",
                productSlug: "Đường dẫn không được để trống",
                manufactureSelect: "Nhà sản xuất không được để trống"
            }
        });
        //validate form thêm khuyến mại
        jQuery("#frmPromotion").validate({
            rules: {
                promotionContent: {
                    required: true
                },
                promotionName: {
                    required: true
                },
                promotionAmount: {
                    required: true
                },
            },
            messages: {
                promotionContent: "Nội dung khuyến mại không được để trống",
                promotionName: "Tên khuyến mại không được để trống",
                promotionAmount: "Giá trị khuyến mại không được để trống"
            }
        });
        //validate form thêm tag
        jQuery("#frmTag").validate({
            rules: {
                tagKey: {
                    required: true
                },
                tagValue: {
                    required: true
                },
            },
            messages: {
                tagKey: "Key không được để trống",
                tagValue: "Value không được để trống"
            }
        });
        //validate form thêm nhà sản xuất
        jQuery("#frmManu").validate({
            rules: {
                manufacturerName: {
                    required: true
                },
                manufacturerDescription: {
                    required: true
                },
                manufacturerPlace: {
                    required: true
                },
            },
            messages: {
                manufacturerName: "Tên nhà sản xuất không được để trống",
                manufacturerDescription: "Mô tả không được để trống",
                manufacturerPlace: "Xuất xứ không được để trống"
            }
        });
        //validate form nhập hàng
        jQuery("#frmStore").validate({
            rules: {
                sizeID: {
                    required: true
                },
                colorID: {
                    required: true
                },
                soluongnhap: {
                    required: true
                },
            },
            messages: {
                sizeID: "Size không được để trống",
                colorID: "Màu không được để trống",
                soluongnhap: "Số lượngkhông được để trống"
            }
        });
    });

    //lấy tag theo danh mục sản phẩm
    function getCateTag() {
        jQuery.jGrowl("Đang tải dữ liệu!");
        var cateID = jQuery('#cateProductSelect').val();
        if (cateID == '') {
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
    //update ckeditor để nhận giá trị vào form
    function CKupdate() {
        for (instance in CKEDITOR.instances)
            CKEDITOR.instances[instance].updateElement();
    }
    //xử lí các sự kiện của dialog
    jQuery(function() {
        jQuery("#wPromotion").dialog({
            autoOpen: false,
            resizable: false,
            width: 800,
            height: 'auto',
            modal: true,
        });
        jQuery("#wTag").dialog({
            autoOpen: false,
            resizable: false,
            width: 600,
            height: 'auto',
            modal: true,
        });
<?php if (isset($openStore)) { ?>
            jQuery("#wStore").dialog({
                autoOpen: true,
                resizable: false,
                width: 600,
                height: 'auto',
                modal: true,
            });
<?php } else { ?>
            jQuery("#wStore").dialog({
                autoOpen: false,
                resizable: false,
                width: 600,
                height: 'auto',
                modal: true,
            });
<?php } ?>
        jQuery("#wManu").dialog({
            autoOpen: false,
            resizable: false,
            width: 600,
            height: 'auto',
            modal: true,
        });
        //bật của sổ thêm nhà sản xuất
        jQuery("#addManu").button().click(function() {
            jQuery("#wManu").dialog("open");
        });
        //bật của sổ thêm khuyến mại
        jQuery("#addPromotion").button().click(function() {
            jQuery("#wPromotion").dialog("open");
        });
        //Bật của sổ nhập hàng
        jQuery("#btnAddProductToStore").button().click(function() {
            jQuery("#wStore").dialog("open");
        });
        //bật của sổ thêm tag cho danh mục sản phẩm
        jQuery("#addTag").button().click(function() {
            var cateID = jQuery('#cateProductSelect').val();
            if (cateID == '') {
                return;
            }
            else {
                jQuery('#cateTagID').val(jQuery('#cateProductSelect').val());
                jQuery("#ui-dialog-title-wTag").html('Thêm tag cho danh mục: ' + jQuery('#cateProductSelect option:selected').text());
                jQuery("#wTag").dialog("open");
            }

        });
        //bắt sự kiện submit form thêm mới khuyến mại
        jQuery("#submitAddPromotion").button().click(function() {
            CKupdate();
            var form = jQuery('#frmPromotion');
            if (!form.valid())
                return false;
            jQuery('#frmPromoLoader').prop('hidden', false);
            jQuery.jGrowl("Đang thêm mới khuyến mại!");
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
                    jQuery('#frmPromoLoader').prop('hidden', true);
                }

            });
        });
        //sự kiện submit form thêm tag   
        jQuery("#submitAddTag").button().click(function() {
            jQuery.jGrowl("Đang thêm mới tag!");
            var form = jQuery('#frmTag');
            if (!form.valid())
                return false;
            jQuery('#frmTagLoader').prop('hidden', false);
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
                    jQuery('#frmTagLoader').prop('hidden', true);
                }
                //jQuery.jGrowl("Thêm mới khuyến mại thành công!");
            });
        });

        //sự kiện submit form thêm mới nhà sản xuất       
        jQuery("#submitAddManu").button().click(function() {
            var form = jQuery('#frmManu');
            if (!form.valid())
                return false;
            jQuery.jGrowl("Đang thêm mới nhà sản xuất!");
            jQuery('#frmManuLoader').prop('hidden', false);
            var request = jQuery.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                type: "POST",
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery("#wManu").dialog("close");
                if (msg != 'FALSE') {
                    jQuery("#manufactureSelect").empty().html(msg);
                    jQuery.jGrowl("Thêm mới nhà sản xuất thành công!");
                    jQuery('#frmManuLoader').prop('hidden', true);
                }
            });
        });
        //sự kiện thêm mới sản phẩm
        jQuery("#btnAddProduct").button().click(function() {
            var form = jQuery('#frmProduct');
            if (!form.valid())
                return false;
            jQuery.jGrowl("Đang thêm mới sản phẩm!");
            jQuery('#frmProductLoader').prop('hidden', false);
        });
        //Thêm mới size và màu
        jQuery("#btnAddStore").button().click(function() {
            jQuery('#divThongBaoOK').prop('hidden', true);
            jQuery('#divThongBaoLoi').prop('hidden', true);
            jQuery('#divThongBaoLoi1').prop('hidden', true);
            var form = jQuery('#frmStore');
            if (!form.valid())
                return false;
            jQuery.jGrowl("Đang kiểm tra kho!");
            jQuery('#frmStoreLoader').prop('hidden', false);
            var request = jQuery.ajax({
                url: "{{URL::action('StoreController@postCheckExitStore')}}",
                data: {proID: jQuery('#proID').val(), sizeID: jQuery('#sizeID').val(), colorID: jQuery('#colorID').val()},
                type: "POST",
                dataType: "html"
            });
            request.done(function(msg) {
                if (msg == "1") {
                    jQuery('#frmStoreLoader').prop('hidden', true);
                    jQuery('#divThongBaoLoi').prop('hidden', false);
                    return false;
                }
                else {
                    var request = jQuery.ajax({
                        url: form.attr('action'),
                        data: form.serialize(),
                        type: "POST",
                        dataType: "html"
                    });
                    request.done(function(msg1) {
                        jQuery('#frmStoreLoader').prop('hidden', true);
                        if (msg1 == "true") {
                            jQuery('#divThongBaoOK').prop('hidden', false);
                            // làm cái đéo j thì làm
                            jQuery.jGrowl("Nhập hàng vào kho thành công!");
                        }
                        else {
                            jQuery('#divThongBaoLoi1').prop('hidden', false);
                            jQuery.jGrowl("Nhập hàng vào kho không thành công!");
                        }
                    });
                }
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
        @if(isset($thongbao) && $thongbao!='')
        <div class="notibar msgsuccess">
            <a class="close"></a>
            <p>{{$thongbao}}</p>
        </div>
        @endif
        <div class="contenttitle2">
            <h3>Thêm mới</h3>
        </div>

        <form id="frmProduct" class="stdform stdform2" method="post" action="@if(isset($dataedit)){{URL::action('ProductController@postEditProduct')}} @else {{URL::action('ProductController@postAddProduct')}} @endif" accept-charset="UTF-8" enctype="multipart/form-data">

            <p>
                <label>Tên sản phẩm</label>
                <span class="field">
                    <input type="hidden" name="idpro" id="idpro" value="@if(isset($dataedit)){{$dataedit->id}}@endif"/>
                    <input type="text" id="productName"  name="productName" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($dataedit)){{$dataedit->productName}}@endif">
                </span>
            </p>
            <p>
                <label>Nhóm sản phẩm</label>
                <span class="field">
                    <select name="cateID" id="cateProductSelect" onchange="getCateTag()">
                        <option value="" >---Chọn danh mục---</option>
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
            </p>
            <p>
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
                    <textarea class="ckeditor" id="productDescription" rows="5" name="productDescription" placeholder="Nhập chi tiết sản phẩm">@if(isset($dataedit)){{$dataedit->productDescription}}@endif</textarea>

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
                        <option value="0">---Chọn khuyến mại---</option>
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
                    <input type="text" name="productSlug" id="productSlug" placeholder="Nhập slug sản phẩm" class="smallinput" value="@if(isset($dataedit)){{$dataedit->productSlug}}@endif"> 
                </span>
            </p>   
            <p>
                <label>Chọn nhà sản xuất </label>
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
                @if(isset($dataedit))
                <button id="btnEditProduct"  class="submit radius2">Cập nhật</button>
                <button id="btnAddProductToStore" type="button"  class="submit radius2">Nhập hàng</button>
                @else
                <button id="btnAddProduct" class="submit radius2"> Thêm mới</button>
                @endif
                <input type="reset" class="reset radius2" value="Làm lại">
                <button type="button" onclick="window.location.href ='{{URL::action('ProductController@getView')}}';" class="submit radius2">Quay lại danh sách sản phẩm</button>
                <img id="frmProductLoader" hidden="true" src="{{Asset('adminlib/images/loaders/loader1.gif')}}" alt="" />
            </p>           
        </form>
        <div id="wPromotion" title="Thêm khuyến mại">
            <form class="stdform stdform2" method="post" id="frmPromotion" action="{{URL::action('PromotionController@postAddPromotionAjax')}}">
                <p>                  
                    <label>Tên khuyến mại</label>
                    <span class="field">
                        <input type="hidden" name="promoID" value="@if(isset($dataedit)){{$dataedit->promotionID}}@endif"/>
                        <input type="text" id="promotionName" name="promotionName" placeholder="Nhập tên nhóm hỗ trợ viên" value="" class="smallinput"></span>
                </p>
                <p>           
                    <label>Nội dung</label>
                    <span class="field">                    
                        <textarea class="ckeditor" rows="5" name="promotionContent" id="promotionContent" placeholder="Nhập nội dung khuyến mại"></textarea>
                    </span>
                </p>
                <p>         
                    <label>Giá trị</label>
                    <span class="field"><input type="text" id="promotionAmount" name="promotionAmount" placeholder="Nhập giá trị khuyến mại" value="" class="smallinput"></span>
                </p>               
                <p class="stdformbutton">
                    <button class="submit radius2" type="button" id="submitAddPromotion" value="Thêm mới">Thêm mới </button>
                    <input type="reset" class="reset radius2" value="Làm mới">
                    <img id="frmPromoLoader" hidden="true" src="{{Asset('adminlib/images/loaders/loader1.gif')}}" alt="" />
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
                        <input type="text" name="tagKey" id="tagKey" placeholder="Tên Tag" value="" class="longinput"></span>
                </p>
                <p>           
                    <label>Value</label>
                    <span class="field">                    
                        <input type="text" name="tagValue" id="tagValue" placeholder="Giá trị của Tag" value="" class="longinput">
                    </span>                 
                </p>                        
                <p class="stdformbutton">
                    <button class="submit radius2" type="button" id="submitAddTag" value="Thêm mới">Thêm mới </button>
                    <input type="reset" class="reset radius2" value="Làm mới">
                    <img id="frmTagLoader" hidden="true" src="{{Asset('adminlib/images/loaders/loader1.gif')}}" alt="" />
                </p>
            </form>
        </div>
        <div id="wManu" title="Thêm nhà sản xuất">
            <form class="stdform stdform2" method="post" id="frmManu" action="{{URL::action('ManufacturerController@postAddManufaturerAjax')}}">
                <p>                  
                    <label>Tên nhà sản xuất</label>
                    <span class="field">          
                        <input type="hidden" name="manuID" value="@if(isset($dataedit)){{$dataedit->manufactureID}}@endif"/>
                        <input type="text" name="manufacturerName" id="manufacturerName" placeholder="Tên nhà sản xuất" value="" class="longinput"></span>
                </p>
                <p>           
                    <label>Mô tả</label>
                    <span class="field">                    
                        <textarea class="longinput" rows="5" name="manufacturerDescription" id="manufacturerDescription" placeholder="Mô tả nhà sản xuất"></textarea>
                    </span>                 
                </p>      
                <p>           
                    <label>Xuất xứ</label>
                    <span class="field">        
                        <select name="manufacturerPlace" id="manufacturerPlace">
                            <option value="">Country...</option>
                            <option value="Afganistan">Afghanistan</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bonaire">Bonaire</option>
                            <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                            <option value="Brunei">Brunei</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Canary Islands">Canary Islands</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Channel Islands">Channel Islands</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos Island">Cocos Island</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote DIvoire">Cote D'Ivoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Curaco">Curacao</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="East Timor">East Timor</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands">Falkland Islands</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Ter">French Southern Ter</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Great Britain">Great Britain</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Hawaii">Hawaii</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Iran">Iran</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Isle of Man">Isle of Man</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea North">Korea North</option>
                            <option value="Korea Sout">Korea South</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Laos">Laos</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libya">Libya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macau">Macau</option>
                            <option value="Macedonia">Macedonia</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Midway Islands">Midway Islands</option>
                            <option value="Moldova">Moldova</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Nambia">Nambia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherland Antilles">Netherland Antilles</option>
                            <option value="Netherlands">Netherlands (Holland, Europe)</option>
                            <option value="Nevis">Nevis</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau Island">Palau Island</option>
                            <option value="Palestine">Palestine</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Phillipines">Philippines</option>
                            <option value="Pitcairn Island">Pitcairn Island</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Republic of Montenegro">Republic of Montenegro</option>
                            <option value="Republic of Serbia">Republic of Serbia</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russia">Russia</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="St Barthelemy">St Barthelemy</option>
                            <option value="St Eustatius">St Eustatius</option>
                            <option value="St Helena">St Helena</option>
                            <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                            <option value="St Lucia">St Lucia</option>
                            <option value="St Maarten">St Maarten</option>
                            <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                            <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                            <option value="Saipan">Saipan</option>
                            <option value="Samoa">Samoa</option>
                            <option value="Samoa American">Samoa American</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Serbia">Serbia</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syria">Syria</option>
                            <option value="Tahiti">Tahiti</option>
                            <option value="Taiwan">Taiwan</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania">Tanzania</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Erimates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States of America">United States of America</option>
                            <option value="Uraguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Vatican City State">Vatican City State</option>
                            <option value="Venezuela">Venezuela</option>
                            <option selected value="Vietnam">Việt Nam</option>
                            <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                            <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                            <option value="Wake Island">Wake Island</option>
                            <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zaire">Zaire</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>                                   
                        </select>
                    </span>                 
                </p>   
                <p class="stdformbutton">
                    <button class="submit radius2" type="button" id="submitAddManu" value="Thêm mới">Thêm mới </button>
                    <input type="reset" class="reset radius2" value="Làm mới">
                    <img id="frmManuLoader" hidden="true" src="{{Asset('adminlib/images/loaders/loader1.gif')}}" alt="" />
                </p>
            </form>
        </div>
        <div id="wStore" title="Nhập hàng">
            <div class="notibar msgerror" id="divThongBaoLoi" hidden="true">
                <a class="close"></a>
                <p>Hàng đã có trong kho. Vui lòng chọn size và màu khác để nhập!</p>
            </div><!-- notification msginfo -->
            <div class="notibar msgerror" id="divThongBaoLoi1" hidden="true">
                <a class="close"></a>
                <p>Thêm hàng vào kho bị lỗi! Vui lòng nhập lại!</p>
            </div><!-- notification msginfo -->
            <div class="notibar msgsuccess" id="divThongBaoOK" hidden="true">
                <a class="close"></a>
                <p>Hàng đã được nhập vào kho. Bạn có thể tiếp tục nhập thêm hàng!</p>
            </div>
            <form class="stdform stdform2" method="post" id="frmStore" action="{{URL::action('StoreController@postAddStoreAjax')}}">
                <p>                  
                    <label>Size</label>
                    <span class="field">                               
                        <input type="hidden" name="proID" id="proID" value="@if(isset($dataedit)){{$dataedit->id}}@endif"/>
                        <select name="sizeID" id="sizeID" required>
                            <option value="">---Chọn size---</option>
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
                            <option value="">---Chọn màu---</option>
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
                        <input type="text"  onkeypress="return event.charCode > 47 && event.charCode < 58;" pattern="[0-9]" name="soluongnhap" id="soluongnhap" placeholder="Số lượng" value="" class="longinput">
                    </span>                 
                </p>  
                <p class="stdformbutton">
                    <button class="submit radius2" type="button" id="btnAddStore" value="Thêm mới">Nhập </button>
                    <input type="reset" class="reset radius2" value="Làm mới">
                    <img id="frmStoreLoader" hidden="true" src="{{Asset('adminlib/images/loaders/loader1.gif')}}" alt="" />
                </p>
            </form>
        </div>
    </div>
</div>      
@endsection