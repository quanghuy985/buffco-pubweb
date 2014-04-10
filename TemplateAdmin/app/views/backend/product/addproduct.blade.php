@extends("templateadmin2.mainfire")
@section("contentadmin")
<script src="http://appendgrid.apphb.com/Scripts/jquery.appendGrid-1.3.4.js"></script>
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
    #tblStore > tfoot > tr > td > button{
        display: none !important;
    }
</style>
<script>

    jQuery(document).ready(function() {
        jQuery('#wizard').smartWizard({onFinish: onFinishCallback});
        function onFinishCallback() {
            alert('Finish Clicked');
        }

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

        //validate form thêm mới size
        jQuery("#frmSize").validate({
            rules: {
                sizeName: {
                    required: true
                },
                sizeValue: {
                    required: true
                },
            },
            messages: {
                sizeName: "Tên size không được để trống",
                sizeValue: "size không được để trống"
            }
        });
    });
    //lấy tag theo danh mục sản phẩm
    function getCateTag() {
        //jQuery.jGrowl("Đang tải dữ liệu!");
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
    //thêm key vào text box
    function keyChange() {
        jQuery('#tagKey').val(jQuery('#keyed').val());
    }
//lọc dấu tạo slug
    function locdau() {
        var str = (document.getElementById("productName").value); // lấy chuỗi dữ liệu nhập vào
        str = str.toLowerCase(); // chuyển chuỗi sang chữ thường để xử lý
        /* tìm kiếm và thay thế tất cả các nguyên âm có dấu sang không dấu*/
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, "-");
        /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
        str = str.replace(/-+-/g, "-"); //thay thế 2- thành 1-
        str = str.replace(/^\-+|\-+$/g, ""); //cắt bỏ ký tự - ở đầu và cuối chuỗi
        document.getElementById("productSlug").value = str; // xuất kết quả xữ lý ra
    }


    function getCheckSlug() {
        var str = (document.getElementById("productName").value); // lấy chuỗi dữ liệu nhập vào
        str = str.toLowerCase(); // chuyển chuỗi sang chữ thường để xử lý
        /* tìm kiếm và thay thế tất cả các nguyên âm có dấu sang không dấu*/
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, "-");
        /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
        str = str.replace(/-+-/g, "-"); //thay thế 2- thành 1-
        str = str.replace(/^\-+|\-+$/g, ""); //cắt bỏ ký tự - ở đầu và cuối chuỗi
        var request = jQuery.ajax({
            url: "{{URL::action('ProductController@postCheckSlug')}}?slug=" + str,
            type: "POST"
        });
        request.done(function(msg) {
            if (msg != '') {
                if (msg == '0') {
                    document.getElementById("productSlug").value = str;
                    return false;
                } else {
                    document.getElementById("productSlug").value = str + '-' + msg;
                    return false;
                }
            }
        });
    }
    //update ckeditor để nhận giá trị vào form
    function CKupdate() {
        for (instance in CKEDITOR.instances)
            CKEDITOR.instances[instance].updateElement();
    }
    //hàm submit form thêm mới
    function submitForm() {
        var form = jQuery('#frmProduct');
        if (!form.valid()) {
            return false;
        }
        else {
             var data = jQuery('#tblStore').appendGrid('getAllValue', true);
            var count = data['_RowCount'];
            jQuery('#countTable').val(count);
            jQuery.jGrowl("Đang lưu sản phẩm!");
            jQuery('#frmProductLoader').prop('hidden', false);
            form.submit();

        }
    }
    //xử lí các sự kiện của dialog
    jQuery(function() {
        // Initialize appendGrid
        jQuery('#tblStore').appendGrid('init', {
            initRows: 1,
            columns: [
                {name: 'ban', display: 'ban', type: 'hidden'},
                {name: 'sizeID', display: 'ban', type: 'hidden'},
                {name: 'colorID', display: 'ban', type: 'hidden'},
                {name: 'SizeName', display: 'Size', type: 'text', ctrlCss: {width: '100px'}, ctrlProp: {disabled: 'disabled'}},
                {name: 'ColorName', display: 'Màu', type: 'text', ctrlCss: {width: '100px'}, ctrlProp: {disabled: 'disabled'}},
                {name: 'SoLuongBan', display: 'Đã bán', type: 'text', ctrlCss: {width: '100px'}, ctrlProp: {disabled: 'disabled'}},
                {name: 'SoLuongNhap', display: 'Số lượng (Có thể sửa)', type: 'number', onChange: function(evt, rowIndex) {
                        checkSoLuong(rowIndex);
                    }, ctrlCss: {width: '100px'}},
                {name: 'status', display: 'Trạng thái (Có thể sửa)', type: 'select', ctrlOptions: {0: 'Chờ kích hoạt', 1: 'Đã kích hoạt', 2: 'Đã xóa'}}
            ],
            initData: [
<?php
if (isset($arrStore)) {
    foreach ($arrStore as $sItem) {
        ?>
                        {'ban': '<?php echo $sItem->soluongban; ?>', 'sizeID': '<?php echo $sItem->sizeID; ?>', 'colorID': '<?php echo $sItem->colorID; ?>', 'SizeName': '<?php echo $sItem->sizeName; ?>', 'ColorName': '<?php echo $sItem->colorName; ?>', 'SoLuongNhap': '<?php echo $sItem->soluongnhap; ?>', 'SoLuongBan': '<?php echo $sItem->soluongban; ?>', 'status': '<?php echo $sItem->status; ?>'},
        <?php
    }
}
?>
            ],
            hideRowNumColumn: true,
            rowButtonsInFront: true,
            hideButtons: {
                remove: true,
                removeLast: true,
                insert: true,
                moveUp: true,
                moveDown: true,
                appendRow: true
            }
        });
        function checkSoLuong(x) {
            var tmp = x + 1;
            if (jQuery('#tblStore_SoLuongNhap_' + tmp).val() < jQuery('#tblStore_ban_' + tmp).val())
            {
                alert('Số lượng nhập không được nhỏ hơn số lượng đã bán!');
                jQuery('#tblStore_SoLuongNhap_' + tmp).val(jQuery('#tblStore_SoLuongBan_' + tmp).val());
                return false;
            }
        }
        ;

        //range datetimepicker
        var dates = jQuery("#startSales, #endSales").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onSelect: function(selectedDate) {
                var option = this.id == "startSales" ? "minDate" : "maxDate",
                        instance = jQuery(this).data("datepicker"),
                        date = jQuery.datepicker.parseDate(
                                instance.settings.dateFormat ||
                                jQuery.datepicker._defaults.dateFormat,
                                selectedDate, instance.settings);
                dates.not(this).datepicker("option", option, date);
            }
        });
        jQuery("#wTag").dialog({
            autoOpen: false,
            resizable: false,
            width: 600,
            height: 'auto',
            modal: true
        });
        jQuery("#wManu").dialog({
            autoOpen: false,
            resizable: false,
            width: 600,
            height: 'auto',
            modal: true
        });
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
        //bật của sổ thêm nhà sản xuất
        jQuery("#addManu").button().click(function() {
            jQuery("#wManu").dialog("open");
        });
        //bật của sổ thêm size
        jQuery("#addSize").button().click(function() {
            jQuery("#wSize").dialog("open");
        });
        //bật của sổ thêm màu
        jQuery("#addColor").button().click(function() {
            jQuery("#wColor").dialog("open");
        });
        //bật của sổ thêm tag cho danh mục sản phẩm
        jQuery("#addTag").button().click(function() {
            var cateID = jQuery('#cateProductSelect').val();
            if (cateID == '') {
                return;
            }
            else {
                jQuery('#cateTagID').val(jQuery('#cateProductSelect').val());
                jQuery("#ui-dialog-title-wTag").html('Thêm thông số kỹ thuật cho danh mục: ' + jQuery('#cateProductSelect option:selected').text());
                jQuery("#wTag").dialog("open");
            }

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
                }
                else {
                    jQuery.jGrowl("Thêm mới Màu Sắc không thành công!");
                }
            });
        });
        //Thêm mới size và màu
        jQuery("#btnAddStore").button().click(function() {
            if (jQuery('#sizeID').val() == '' || jQuery('#colorID').val()=='' || jQuery('#soluongnhap').val() == '') {
                jQuery.jGrowl("Bạn phải nhập đầy đủ thông tin!");
            }
            else {
                jQuery('#tblStore').appendGrid('insertRow', [
                    {ban: '0', sizeID: jQuery('#sizeID').val(), colorID: jQuery('#colorID').val(), SizeName: jQuery('#sizeID option:selected').text(), ColorName: jQuery('#colorID option:selected').text(), SoLuongNhap: jQuery('#soluongnhap').val(), SoLuongBan: '0', status: '0'}
                ], 0);
            }
        });
    });</script>
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
            <h3>@if(isset($dataedit))Chỉnh sửa sản phẩm @else Thêm mới sản phẩm @endif</h3>
        </div>
        <input type="hidden" id="divAvtive" value="" />
        <form id="frmProduct" class="stdform stdform2" method="post" action="@if(isset($dataedit)){{URL::action('ProductController@postEditProduct')}} @else {{URL::action('ProductController@postAddProduct')}} @endif" accept-charset="UTF-8" enctype="multipart/form-data">
            <div id="wizard" class="wizard">
                <br />
                <ul class="hormenu">
                    <li>
                        <a href="#wiz1step1">
                            <span class="h2">Bước 1</span>
                            <span class="dot"><span></span></span>
                            <span class="label">Nhập thông tin cơ bản</span>
                        </a>
                    </li>
                    <li>
                        <a href="#wiz1step2">
                            <span class="h2">Bước 2</span>
                            <span class="dot"><span></span></span>
                            <span class="label">Nhập thông tin chi tiết</span>
                        </a>
                    </li>
                    <li>
                        <a href="#wiz1step3">
                            <span class="h2">Bước 3</span>
                            <span class="dot"><span></span></span>
                            <span class="label">Nhập số lượng hàng</span>
                        </a>
                    </li>
                </ul>

                <br clear="all" /><br /><br />

                <div id="wiz1step1" class="formwiz">
                    <h4>Bước 1: Nhập thông tin cơ bản</h4>
                    <p>
                        <label>Tên sản phẩm (<span style="color: red;">*</span>)</label>
                        <span class="field">
                            <input type="hidden" name="idpro" id="idpro" value="@if(isset($dataedit)){{$dataedit->id}}@endif"/>
                            <input type="text" onkeyup="locdau()" onchange="getCheckSlug()" id="productName"  name="productName" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($dataedit)){{$dataedit->productName}}@endif">
                        </span>
                    </p>
                    <p>
                        <label>Danh mục sản phẩm (<span style="color: red;">*</span>)</label>
                        <span class="field">
                            <select name="cateID" id="cateProductSelect" onchange="getCateTag();" >
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

                        </span>
                    </p>
                    <p>
                        <label>Mô tả (<span style="color: red;">*</span>)</label>
                        <span class="field">
                            <textarea class="ckeditor" id="productDescription" rows="5" name="productDescription" placeholder="Nhập chi tiết sản phẩm">@if(isset($dataedit)){{$dataedit->productDescription}}@endif</textarea>
                        </span>
                    </p>
                    <p>
                        <label>Giá sản phẩm (<span style="color: red;">*</span>)</label>
                        <span class="field">
                            <input type="text" name="productPrice"   onkeypress="return event.charCode > 47 && event.charCode < 58;" pattern="[0-9]"  placeholder="Nhập giá sản phẩm" class="smallinput" value="@if(isset($dataedit)){{$dataedit->productPrice}}@endif">
                        </span>
                    </p>      
                    <p>
                        <label>Khuyến mại</label>
                        <span class="field" id="sPromotion"> 
                            <input type="text" name="salesPrice" value="@if(isset($dataedit)){{$dataedit->salesPrice}}@endif" placeholder="Nhập khuyến mại" onkeypress="return event.charCode > 47 && event.charCode < 58;" pattern="[0-9]" style="width:100px;" id="salesPrice">&nbsp;&nbsp;   Từ ngày:  <input type="text" id="startSales" class="width100" value="@if(isset($dataedit)&& $dataedit->startSales!=''){{date('m/d/Y',$dataedit->startSales)}}@endif" name="startSales"/> &nbsp; &nbsp;Tới ngày: <input type="text" value="@if(isset($dataedit)&& $dataedit->endSales!=''){{date('m/d/Y',$dataedit->endSales)}}@endif" id="endSales" class="width100" name="endSales"/>
                        </span>
                    </p>
                    <p>
                        <label>Đường dẫn ngắn gọn</label>
                        <span class="field">
                            <input type="text" name="productSlug" id="productSlug" placeholder="Nhập đường dẫn ngắn gọn" class="smallinput" @if(isset($dataedit))disabled @endif value="@if(isset($dataedit)){{$dataedit->productSlug}}@endif"> 
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
                </div><!--#wiz1step1-->

                <div id="wiz1step2" class="formwiz">
                    <h4>Bước 2: Nhập thông tin chi tiết</h4>  
                    <p>
                        <label>Thông số kỹ thuật</label>
                        <input type="hidden" name="productID" id="productID" value="@if(isset($dataedit)){{$dataedit->id}}@endif"/>
                        <span class="field" id="spanTag" style="overflow: auto;width: 548px; height: 200px;border: 1;BORDER-RIGHT: blue 1px solid;BORDER-TOP: blue 1px solid; BORDER-LEFT: blue 1px solid;BORDER-BOTTOM: blue 1px solid;BACKGROUND-COLOR: White;">
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
                        <label>Thêm thông số kỹ thuật</label>
                        <span class="field">
                            <button type="button"   class="submit radius2" id="addTag">Thêm thông số kỹ thuật</button>
                        </span>
                    </p>
                    <p> 
                        <label>Từ khóa seo (<span style="color: red;">*</span>)</label>
                        <span class="field">
                            <input type="text" name="productTag" placeholder="Nhập từ khóa seo " id="tags" class="smallinput" value="@if(isset($dataedit)){{$dataedit->productTag}}@endif">
                            <small class="desc">Ấn phím enter hoắc dấu "," sau mỗi lần nhập từ khóa</small>
                        </span>

                    </p>

                    <p>
                        <label>Chọn nhà sản xuất (<span style="color: red;">*</span>)</label>
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
                </div><!--#wiz1step2-->
                <div id="wiz1step3" class="formwiz">
                    <h4>Bước 3: Nhập hàng vào kho</h4>  
                    <div class="contenttitle2">
                        <h3>Hàng  trong kho</h3>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="tblStore">
                    </table>
                    <input type="hidden" name="countTable" id="countTable" value="" />
                    <div class="contenttitle2">
                        <h3>Nhập thêm hàng</h3>
                    </div>
                    <p>                  
                        <label>Size</label>
                        <span class="field">                               
                            <input type="hidden" name="proID" id="proID" value="@if(isset($dataedit)){{$dataedit->id}}@endif"/>
                            <select name="sizeID" id="sizeID" >
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
                            <select name="colorID" id="colorID" >
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
                            <input type="text"  onkeypress="return event.charCode > 47 && event.charCode < 58;" pattern="[0-9]" name="soluongnhap" id="soluongnhap" placeholder="Số lượng" value="" class="width100">
                        </span>                 
                    </p>  


                    <p class="stdformbutton">
                        <button class="submit radius2" type="button" id="btnAddStore" value="Thêm mới">Nhập </button>                       
                        <img id="frmStoreLoader" hidden="true" src="{{Asset('adminlib/images/loaders/loader1.gif')}}" alt="" />
                    </p>
                </div>
            </div><!--#wizard-->
        </form>

        <div id="wTag" title="Thêm thông số kỹ thuật">
            <form class="stdform stdform2" method="post" id="frmTag" action="{{URL::action('TagController@postAddTagAjax')}}">
                <p>                  
                    <label>Chọn Key</label>
                    <span class="field">
                        <input type="hidden" name="cateTagID" id="cateTagID" value=""/>
                        <input type="hidden" name="productID"  id="productID" value="@if(isset($dataedit)){{$dataedit->id}}@endif"/>
                        <select id="keyed" name="keyed" onchange="keyChange();">
                            <option value="">--Chọn key--</option>
                            @foreach($arrTagKey as $item)
                            <option value="{{$item->tagKey}}">{{$item->tagKey}}</option>
                            @endforeach
                        </select>
                </p>
                <p>                  
                    <label>Custom key</label>
                    <span class="field">                        
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
        <div id="wSize" title="Thêm size">
            <form class="stdform stdform2" method="post" id="frmSize" action="{{URL::action('SizeController@postAddSizeAjax')}}">
                <p>                  
                    <label>Tên</label>
                    <span class="field">                                              
                        <input type="text" name="sizeName" id="sizeName" placeholder="Tên size" value="" class="longinput"></span>
                </p>
                <p>           
                    <label>Size</label>
                    <span class="field">                    
                        <input type="text" name="sizeValue" id="sizeValue" placeholder="Size" value="" class="longinput">
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
                        <input type="text" name="colorName" id="colorName" placeholder="Tên màu" value="" class="longinput"></span>
                </p>
                <p>           
                    <label>Mã màu: </label>
                    <span class="field">                    
                        <input type="text" name="colorCode" id="colorpicker" placeholder="Mã màu" value="" class="width100">
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

    </div>
</div>      
@endsection