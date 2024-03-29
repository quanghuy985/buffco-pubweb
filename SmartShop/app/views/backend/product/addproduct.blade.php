@extends("backend.template")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">Quản lý sản phẩm</h1>
    <span class="pagedesc">Thêm sản phẩm mới</span>
</div>
<script>
    jQuery(document).ready(function() {
    jQuery("#edit-products").validate({
    rules: {
    productName: {required: true, maxlength: 255},
            productCode: {required: true, maxlength: 255},
            productDescription: {required: true},
    }
    });
    });</script>
<div id="contentwrapper" class="contentwrapper nopadding">
    @if(isset($productedit))      
    {{Form::model($productedit, array('action'=>'\BackEnd\ProductController@postProductEdit', 'class'=>'stdform','id'=>'edit-products' ))}}
    @else
    {{Form::open(array('action'=>'\BackEnd\ProductController@postProductAdd', 'class'=>'stdform', 'id'=>'edit-products'))}}
    @endif
    {{Form::hidden('id')}}
    <div class="two_third photosharing_wrapper">
        <div class="contenttitle2">
            <h3> @if(isset($productedit)){{Lang::get('backend/title.product.update')}}@else{{Lang::get('backend/title.product.add')}}    @endif   </h3>
        </div>
        @include('backend.alert')
        <p>
            <label>Tên sản phẩm</label>
            <span class="field">
                {{Form::text('productName', null, array('class'=>'longinput', 'id'=>'productName', 'placeholder'=>Lang::get('placeholder.product_name')))}}
            </span>
        </p>
        <p>
            <label>Mã sản phẩm</label>
            <span class="field">
                {{Form::text('productCode', null, array('class'=>'smallinput', 'id'=>'productCode', 'placeholder'=>Lang::get('placeholder.product_code')))}}
            </span>
        </p>
        <p>
            <script>

                        function addstore_product() {
                        NProgress.start();
                                jQuery("#form-add-store").html('<img src="{{Asset('backend / images / loaders / loader6.gif')}}" alt="" title="" style="margin-left: 47%;margin-top: 25px;"/>');
                                var request = jQuery.ajax({
                                url: "{{URL::action('\BackEnd\ProductController@postDialogGetcolorsize')}}",
                                        type: "POST"
                                });
                                request.done(function(msg) {
                                NProgress.done();
                                        jQuery("#form-add-store").html(msg);
                                });
                                jQuery("#quantity_product").val('');
                                jQuery("#dialog-form-add-store").dialog({
                        resizable: true,
                                width: 400,
                                modal: true,
                                buttons: {
                                "Thêm": function(e) {
                                var quantity = jQuery("#quantity_product").val();
                                        var color = jQuery("#color_list").val();
                                        var color_text = jQuery("#color_list option:selected").text();
                                        var size = jQuery("#size_list").val();
                                        var size_text = jQuery("#size_list option:selected").text();
                                        var rowCount = jQuery('.datastore tr').length + 1;
                                        var colorlist = new Array()
                                        jQuery('input[name="color[]"]').each(function() {
                                var aValue = jQuery(this).val();
                                        colorlist[colorlist.length] = aValue;
                                });
                                        var sizelist = new Array()
                                        jQuery('input[name="size[]"]').each(function() {
                                var aValue = jQuery(this).val();
                                        sizelist[sizelist.length] = aValue;
                                });
                                        var check = false;
                                        for (var i = 0; i < colorlist.length; i++) {
                                if (color == colorlist[i] && size == sizelist[i]) {
                                check = true;
                                }
                                }
                                if (!jQuery.isNumeric(quantity)){
                                jAlert('Nhập số lượng sản phẩm !', 'Thông báo !');
                                } else{
                                if (check == true) {
                                jAlert('Màu sắc và size muốn thêm đã tồn tại !', 'Thông báo !');
                                } else {
                                var html = '<tr><td><input type="text" name="quantity[]" value="' + quantity + '"/></td><td>' + color_text + '<input type="hidden" name="color[]" value="' + color + '"/></td><td class="center">' + size_text + '<input type="hidden" name="size[]" value="' + size + '"/></td><td class="center"><a href="javascript:void(0);" onclick="removeThis(this);">X</a></td></tr>';
                                        jQuery(".datastore").append(html);
                                        jQuery("#dialog-form-add-store").dialog("close");
                                }
                                }
                                }
                                },
                        });
                        }
                function closeDialogStore(check) {
                jQuery("#dialog-form-add-store").dialog("close");
                        if (check == 'color'){
                window.open('{{action('\BackEnd\ProductController@getColorView')}}', '_newtab');
                }
                if (check == 'size'){
                window.open('{{action('\BackEnd\ProductController@getSizeView')}}', '_newtab');
                }
                }
                function removeThis(field) {
                jQuery(field).parent().parent().remove();
                }
                function addmanufact() {
                jQuery("#error_add_manufacturer").css('display', 'none');
                        jQuery("#error_add_manufacturer").html('');
                        jQuery("#manufacturerName").val('');
                        jQuery("#manufacturerPlace").val('');
                        jQuery("#dialog-form-add-manufacturer").dialog({
                resizable: true,
                        width: 400,
                        modal: true,
                        buttons: {
                        "Thêm": function(e) {
                        NProgress.start();
                                var postform = jQuery('#form-add-manufacturer').serialize();
                                var request = jQuery.ajax({
                                url: "{{URL::action('\BackEnd\ProductController@postAddFastManufacturer')}}",
                                        type: "POST",
                                        data: postform
                                });
                                request.done(function(msg) {
                                NProgress.done();
                                        msg = jQuery.parseJSON(msg);
                                        if (msg.id == '' || msg.id == null) {
                                var totalerror = '';
                                        if (msg.manufacturerName != '' && msg.manufacturerName != null) {
                                totalerror += '<p>' + msg.manufacturerName + '</p>';
                                }
                                if (msg.manufacturerPlace != '' && msg.manufacturerPlace != null) {
                                totalerror += '<p>' + msg.manufacturerPlace + '</p>';
                                }
                                jQuery("#error_add_manufacturer").css('display', 'block');
                                        jQuery("#error_add_manufacturer").html(totalerror);
                                } else {
                                var inserthtml = '<option value="' + msg.id + '">' + msg.manufacturerName + '</option>';
                                        jQuery("#manufactureID").append(inserthtml);
                                        jQuery("#dialog-form-add-manufacturer").dialog("close");
                                }



                                }
                                );
                        }
                        },
                });
                }
                function IsJsonString(str) {
                try {
                JSON.parse(str);
                } catch (e) {
                return false;
                }
                return true;
                }
                function addcateproduct() {
                jQuery("#error_add_category_product").css('display', 'none');
                        jQuery("#error_add_category_product").html('');
                        jQuery("#cateName").val('');
                        jQuery("#cateSlug").val('');
                        jQuery("#cateDescription").val('');
                        jQuery("#dialog-form-add-category-product").dialog({
                resizable: true,
                        width: 400,
                        modal: true,
                        buttons: {
                        "Thêm": function(e) {
                        NProgress.start();
                                var postform = jQuery('#form-add-category-product').serialize();
                                var request = jQuery.ajax({
                                url: "{{URL::action('\BackEnd\ProductController@postAddCateProduct')}}",
                                        type: "POST",
                                        data: postform
                                });
                                request.done(function(msg) {
                                NProgress.done();
                                        msg = jQuery.parseJSON(msg);
                                        if (msg.cateName != null || msg.cateSlug != null) {
                                var totalerror = '';
                                        if (msg.cateName != '' && msg.cateName != null) {
                                totalerror += '<p>' + msg.cateName + '</p>';
                                }
                                if (msg.cateSlug != '' && msg.cateSlug != null) {
                                totalerror += '<p>' + msg.cateSlug + '</p>';
                                }
                                jQuery("#error_add_category_product").css('display', 'block');
                                        jQuery("#error_add_category_product").html(totalerror);
                                }
                                else {
                                if (msg.id != '' && msg.content != '' && msg.htmlcontent != '') {
                                var inse = '<option value="' + msg.id + '">' + msg.content + '</option>';
                                        jQuery("#cateaddproduct").html(msg.htmlcontent);
                                        jQuery("#cateParent").append(inse);
                                        jQuery("#dialog-form-add-category-product").dialog("close");
                                }
                                }
                                }
                                );
                        }
                        },
                });
                }
            </script>
            <label>Nhà sẩn xuất</label>
            <span class="field">
                {{Form::select('manufactureID', $arraymanu,null,array('id'=>'manufactureID'))}} &nbsp;<button class="stdbtn btn_world " type="button" value="Thêm mới" onclick="addmanufact()"> Thêm  </button>
            </span>
        </p>
        <p>
            <label>Mô tả sản phẩm</label>
            <span class="field">
                {{Form::textarea('productDescription', null, array('class'=>'ckeditor', 'cols'=>80, 'rows'=>5,'id'=>'productDescription'))}}
            </span>

        </p>
        <p>
        <div id="accordion" class="accordion">
            <h3><a href="#"><strong><i>Chi tiết sản phẩm</i></strong></a></h3>
            <div>
                <div id="tabs-product">
                    <ul>
                        <li><a href="#tabs-1">Giá</a></li>
                        <li><a href="#tabs-2">Thuộc tính sản phẩm</a></li>
                        <li><a href="#tabs-3">Kho hàng</a></li>
                    </ul>
                    <div id="tabs-3">
                        <input type="button" onclick="addstore_product()" class="stdbtn btn_orange" value="Thêm kho hàng">
                        <table cellpadding="0" cellspacing="0" border="0" class="stdtable" style="margin-top: 20px;">
                            <colgroup>
                                <col class="con1" style="width: 20%;" />
                                <col class="con0" style="width: 33%;" />
                                <col class="con1" style="width: 32%;" />
                                <col class="con0" style="width: 15%;" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class="head1">Số lượng</th>
                                    <th class="head0">Màu sắc</th>
                                    <th class="head1">Kích cỡ</th>
                                    <th class="head0">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody class="datastore">
                                <?php
                                if (isset($productmeta)) {
                                    foreach ($productmeta as $item) {
                                        ?>
                                        <tr>
                                            <td><input type="text" name="quantity[]" value="{{$item->quantity}}"/></td>
                                            <td>{{$arraycolor[$item->meta_color]}}<input type="hidden" name="color[]" value="{{$item->meta_color}}"/>
                                            </td><td class="center">{{$arraysize[$item->meta_size]}}<input type="hidden" name="size[]" value="{{$item->meta_size}}"/></td>
                                            <td class="center"><a href="javascript:void(0);" onclick="removeThis(this);">X</a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="tabs-1">
                        <p>
                            <label>Giá nhập</label>
                            <span class="field">
                                {{Form::text('import_prices', null, array('class'=>'smallinput', 'id'=>'import_prices',  'placeholder'=>Lang::get('placeholder.product_code')))}}&nbsp; {{Config::get('configall.pay-tiente')}}
                            </span>.
                        </p>
                        <p>
                            <label>Giá bán</label>
                            <span class="field">
                                {{Form::text('productPrice', null, array('class'=>'smallinput', 'id'=>'productPrice',  'placeholder'=>Lang::get('placeholder.product_code')))}}&nbsp; {{Config::get('configall.pay-tiente')}}
                            </span>.
                        </p>
                        <p>
                            <label>Giá khuyến mại</label>
                            <span class="field">
                                {{Form::text('salesPrice', null, array('class'=>'smallinput', 'id'=>'salesPrice', 'placeholder'=>Lang::get('placeholder.product_code')))}}&nbsp; {{Config::get('configall.pay-tiente')}}
                                &nbsp;&nbsp;&nbsp;+<a href="javascript:void(0);" onclick="showkhuyenmai();">Thời gian khuyến mại</a>
                            </span>.
                        </p>
                        <p id="book" style="display: none;">
                            <label>Thời gian khuyến mại </label>
                            <span class="field">Từ&nbsp;
                                <?php
                                $startdate = null;
                                $enddate = null;
                                ?>
                                @if(isset($productedit))
                                <?php
                                $startdate = date('m/d/Y', $productedit->startSales);
                                $enddate = date('m/d/Y', $productedit->endSales);
                                ?>
                                @endif

                                {{Form::text('startSales', $startdate, array('class'=>'smallinput', 'id'=>'datepickerstart','onchange'=>'checkngaykhuyenmai()'))}}&nbsp;
                                &nbsp;&nbsp;Đến&nbsp;
                                {{Form::text('endSales', $enddate, array('class'=>'smallinput', 'id'=>'datepickerend','onchange'=>'checkngaykhuyenmai()'))}}&nbsp; 
                        </p>
                    </div>
                    <div id="tabs-2">
                        <p>
                            {{Form::textarea('productAttributes', null, array('class'=>'ckeditor', 'cols'=>80, 'rows'=>5,'id'=>'productAttributes'))}}
                        </p>
                    </div>
                </div>

            </div>
        </div> 
        </p>
    </div><!--photosharing_wrapper-->

    <div class="one_third last ps_sidebar">
        <div class="contenttitle3">
            <h3>Đăng</h3>
        </div><!--contenttitle-->
        <button value="Thêm mới" type="submit" class="stdbtn btn_orange"> 
            @if(isset($productedit)){{Lang::get('button.update')}}@else{{Lang::get('button.add')}}    @endif 
        </button>
        <button value="Thêm mới" type="reset" class="stdbtn btn_world "> Làm lại  </button>
        <div class="contenttitle3">
            <h3>Chuyên mục sản phẩm</h3>
        </div>  
        <div id="scroll1" class="mousescroll">
            <ul class="cateaddproduct" id="cateaddproduct">
                @include('backend.product.listcateAjax')
            </ul>
        </div>
        <br clear="all">
        <input value="Thêm chuyên mục" type="button" class="stdbtn btn_orange" onclick="addcateproduct()">
        <div class="contenttitle3">
            <h3>Tags</h3>
        </div>
        {{Form::text('productTag', null, array('class'=>'longinput', 'id'=>'tags', 'placeholder'=>Lang::get('placeholder.tags')))}}
        <div class="contenttitle3">
            <h3>Ảnh sản phẩm</h3>
        </div>
        {{Form::hidden('images',null,array('id'=>"images"))}}
        <ul class="morephotolist" id="morephotolist">

        </ul><!--morephotolist-->
        <ul class="morephotolist-no" id="morephotolist-no" style="display: none;">
        </ul>
        <br clear="all">
        <input value="Thêm ảnh" type="button" class="stdbtn btn_orange" onclick="BrowseServer1();">
    </div>
    {{Form::close()}}
</div><!--contentwrapper-->
<style>
    div.tagsinput{
        width: 100% !important;
    }
    .cateaddproduct {
        list-style: none outside none;
        padding-left: 15px;
    }

    .cateaddproduct ul {
        list-style: none outside none;
        padding-left: 20px;
    }
</style>
<script>
            //lọc dấu tạo slug
<?php
if (isset($productedit)) {
    $itemimage = explode(",", $productedit->images);
    $i = 0;
    foreach ($itemimage as $value) {
        ?>
        <?php $url = Timthumb::link($value, 100, 60, 0); ?>
            var urlImg = '<li id="image-<?php echo $value . $i; ?>"><a href="javascript:void(0);"><img src="<?php echo Asset($url); ?>"/> </a> <a href="javascript:void(0);" onclick="xoaanhthum1(\'image-<?php echo $value . $i; ?>\');" class="delete" title="Delete image"><img alt="Xóa" src="<?php echo Asset(''); ?>backend/templates/images/cross.png"></a></li>';
                    var urlImgNo = '<li id="no-image-<?php echo $value . $i; ?>"><a href="<?php echo $value; ?> "></a></li>';
                    document.getElementById('morephotolist').innerHTML += urlImg;
                    document.getElementById('morephotolist-no').innerHTML += urlImgNo;
                    returnurlimg1();
        <?php
        $i++;
    }
}
?>

    function locdau(id) {
    var str = (document.getElementById(id).value); // lấy chuỗi dữ liệu nhập vào
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
            document.getElementById("cateSlug").value = str; // xuất kết quả xữ lý ra
    }

    function getCheckSlug(id) {
    var str = (document.getElementById(id).value); // lấy chuỗi dữ liệu nhập vào
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
            url: "{{URL::action('\BackEnd\ProductController@postCheckSlug')}}?slug=" + str,
                    type: "POST"
            });
            request.done(function(msg) {
            if (msg != '') {
            if (msg == '0') {
            document.getElementById("cateSlug").value = str;
                    return false;
            } else {
            document.getElementById("cateSlug").value = str + '-' + msg;
                    return false;
            }
            }
            });
    }

    function BrowseServer1()
    {
    var finder = new CKFinder();
            finder.selectActionFunction = SetFileField1;
            //   finder.selectActionData = functionData;
            finder.popup();
    }
    var i = 0;
            function SetFileField1(fileUrl)
            {
            var sFileName = this.getSelectedFile().name + i;
                    var urlImg = '<li id="image-' + sFileName + '"><a href="javascript:void(0);"><img src="<?php echo Asset('pubweb.vn/100/60/0'); ?>/' + fileUrl + '"/> </a> <a href="javascript:void(0);" onclick="xoaanhthum1(\'image-' + sFileName + '\');" class="delete" title="Delete image"><img alt="Xóa" src="http://localhost/SmartShop/backend/templates/images/cross.png"></a></li>';
                    var urlImgNo = '<li id="no-image-' + sFileName + '"><a href="' + fileUrl + '"></a></li>';
                    document.getElementById('morephotolist').innerHTML += urlImg;
                    document.getElementById('morephotolist-no').innerHTML += urlImgNo;
                    i++;
                    returnurlimg1();
            }
    function xoaanhthum1(id) {
    document.getElementById(id).remove();
            document.getElementById('no-' + id).remove();
            returnurlimg1()
    }
    function returnurlimg1() {
    var images = jQuery("#morephotolist-no").find("a").map(function() {
    return this.href;
    }).get();
            jQuery("#images").val(images);
    }
    var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            if (dd < 10) {
    dd = '0' + dd
    }

    if (mm < 10) {
    mm = '0' + mm
    }
    today = mm + '/' + dd + '/' + yyyy;
            jQuery("#datepickerstart").datepicker();
            jQuery("#datepickerstart").datepicker("option", "minDate", today);
            jQuery("#datepickerend").datepicker();
            jQuery("#datepickerend").datepicker("option", "minDate", today);
            function showkhuyenmai() {
            jQuery("#book").slideToggle(1000);
            }
    function checkngaykhuyenmai() {
    jQuery("#datepicker1").datepicker("option", "minDate", jQuery("#datepicker").val());
    }
    jQuery('#accordion').accordion(
    {collapsible: true,
            active: false,
            autoHeight: false,
            clearStyle: true,
    }
    );
            jQuery('#accordion1').accordion(
    {collapsible: true,
            active: false,
            autoHeight: false,
            clearStyle: true,
    }
    );
            jQuery('#tabs-product').tabs();
            jQuery('#scroll1').slimscroll({
    color: '#666',
            size: '10px',
            width: '100%',
            height: '200px',
            border: 'medium none'
    });</script>

<div id="dialog-form-add-manufacturer" title="Thêm nhà sản xuât" style="display: none">
    <form id="form-add-manufacturer" class="stdform ">
        <div class="notibar announcement" id="error_add_manufacturer" style="display: none">

        </div>
        <p>
            <label>Tên nhà sản xuât</label>
            <span class="field">
                {{Form::text('manufacturerName', null, array('class'=>'longinput', 'id'=>'manufacturerName', 'placeholder'=>Lang::get('placeholder.product_name')))}}
            </span>
        </p>
        <p>
            <label>Nơi sản xuât</label>
            <span class="field">
                {{Form::text('manufacturerPlace', null, array('class'=>'longinput', 'id'=>'manufacturerPlace', 'placeholder'=>Lang::get('placeholder.product_name')))}}
            </span>
        </p>
    </form>
</div>
<div id="dialog-form-add-store" title="Thêm kho hàng" style="display: none">
    <form id="form-add-store" class="stdform">
        <img src="{{Asset('backend/images/loaders/loader6.gif')}}" alt="" title="" style="margin-left: 47%;margin-top: 25px;"/>
    </form>
</div>
<div id="dialog-form-add-category-product" title="Thêm danh mục sản phẩm" style="display: none">
    <form id="form-add-category-product" class="stdform ">
        <div class="notibar announcement" id="error_add_category_product" style="display: none">

        </div>
        <p>
            {{Form::hidden('id')}}
            <label>Tên danh mục sản phẩm</label>
            <span class="field">
                {{Form::text('cateName', null, array('class'=>'longinput', 'id'=>'cateName', 'placeholder'=>Lang::get('placeholder.product_cateName'),"onkeyup"=>"locdau('cateName')", "onchange"=>"getCheckSlug('cateName')"))}}
            </span>
        </p>
        <p>
            <label>Danh mục Cha</label>
            <span class="field">
                {{Form::select('cateParent',$listcate,null,array('id'=>'cateParent'))}}
            </span>
        </p>
        <p>
            <label>Đường dẫn</label>
            <span class="field">
                {{Form::text('cateSlug', null, array('class'=>'longinput', 'id'=>'cateSlug', 'placeholder'=>Lang::get('placeholder.product_cateSlug'), "onchange"=>"getCheckSlug('cateSlug')"))}}     
            </span>
        </p>       
        <p>
            <label>Mô tả</label>
            <span class="field">
                {{Form::textarea('cateDescription', null, array('id'=>'cateDescription','rows'=>'5'))}}
            </span>
        </p>
    </form>
</div>

<script src="{{Asset('backend/js/plugins/autoNumeric.js')}}" type=text/javascript></script>
<script>
            jQuery(function(cash) {
            jQuery('#import_prices').autoNumeric('init', {pSign: 's', dGroup: '2'});
                    jQuery('#productPrice').autoNumeric('init', {pSign: 's', dGroup: '2'});
                    jQuery('#salesPrice').autoNumeric('init', {pSign: 's', dGroup: '2'});
            });
</script>
@endsection