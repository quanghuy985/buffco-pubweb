@extends("templateadmin2.mainfire")
@section("contentadmin")
<script type="text/javascript">

    function checkValid(){
    if (jQuery("#frmProduct").valid())
            jQuery("#frmProduct").submit();
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
            function showkhuyenmai() {
            jQuery("#datepicker").val('');
                    jQuery("#datepicker1").val('');
                    jQuery("#datepicker").datepicker("option", "minDate", today);
                    jQuery("#datepicker1").datepicker("option", "minDate", today);
                    jQuery("#book").toggle();
            }
    function checkngaykhuyenmai() {
    jQuery("#datepicker1").datepicker("option", "minDate", jQuery("#datepicker").val());
    }
    jQuery(function() {
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
            jQuery("#sizeproduct").empty().html(msg);
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
            jQuery("#mausacproduct").empty().html(msg);
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
    });</script>
<div class="contentwrapper">
    <div class="subcontent">
        @if(isset($thongbao) && $thongbao!='')
        <div class="notibar msgsuccess">
            <a class="close"></a>
            <p>{{$thongbao}}</p>
        </div>
        @endif
        @if(isset($thongbaoloi) && $thongbaoloi!='')
        <div class="notibar msgalert">
            <a class="close"></a>
            <p>{{$thongbaoloi}}</p>
        </div>
        @endif
        <div class="contenttitle2">
            <h3>@if(isset($dataedit))CẬP NHẬT SẢN PHẨM @else  THÊM MỚI SẢN PHẨM @endif</h3>
        </div>
    </div>
    <form class="stdform" id="frmProduct" action="@if(isset($dataedit)){{URL::action('ProductController@postEditProduct')}} @else {{URL::action("ProductController@postAddProduct")}} @endif" method="post">
        <p>
            <label>Tên sản phẩm</label>
            <input type="hidden" name="pid" id="pid" value="@if(isset($dataedit)){{$dataedit->id}}@endif"/>
            <span class="field"><input type="text" required title="Trường này không được để trống" onkeyup="locdau()" onchange="getCheckSlug()" value="@if(isset($dataedit)){{$dataedit->productName}}@endif" id="productName"  name="nameProduct" class="longinput" /></span>
            <script>
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
                        //kiểm trra product code
                        function checkProductCode(){
                        var id = jQuery('#pid').val();
                                var code = jQuery('#productCode').val();
                                var request = jQuery.ajax({
                                url: "{{URL::action('ProductController@postCheckProductCode')}}?id=" + id + "&code=" + code,
                                        type: "POST"
                                });
                                request.done(function(msg) {
                                if (msg == 'false'){
                                jAlert('Mã sản phẩm "' + code + '" đã tồn tại.Vui lòng nhập mã khác', 'Thông báo');
                                        if (jQuery('#codeHidden').val() != ''){
                                jQuery('#productCode').val(jQuery('#codeHidden').val());
                                }
                                else{
                                jQuery('#productCode').val('');
                                }
                                jQuery('#productCode').focus();
                                }
                                });
                        }
            </script>
        </p>
        <p>
            <label>Mã sản phẩm</label>
            <input type="hidden" id="codeHidden" value="@if(isset($dataedit)){{$dataedit->productCode}}@endif" />
            <span class="field"><input type="text" required title="Trường này không được để trống" onchange="checkProductCode()" id="productCode"  name="productCode"  value="@if(isset($dataedit)){{$dataedit->productCode}}@endif" class="smallinput" /></span>
            <small class="desc">Ví dụ : JEAN-1029, AO-1292 .</small>
        </p>
        <p>
            <label>Nhóm sản phẩm</label>
            <span class="field">
                <select name="productGroup" id="productGroup">
                    @if(isset($arrCatProduct))
                    @foreach($arrCatProduct as $item)
                    <?php
                    if ($item->cateParent == 0) {
                        ?>
                        <option @if(isset($dataedit) && $dataedit->cateID== $item->id)selected @endif value="{{$item->id}}">{{$item->cateName}}</option>
                        <?php
                        foreach ($arrCatProduct as $item1) {
                            if ($item1->cateParent == $item->id) {
                                $selected = '';
                                if (isset($dataedit) && $dataedit->cateID == $item1->id) {
                                    $selected = 'selected';
                                }
                                echo '<option ' . $selected . ' value="' . $item1->id . '" >-- ' . $item1->cateName . '</option>';
                            }
                        }
                    }
                    ?>
                    @endforeach
                    @endif
                </select>

                <button type="button" onclick="loadNhom()"  class="stdbtn" >Làm mới</button>
                <button type="button" onclick="window.open('{{URL::action('CategoryProductController@getCateProductView')}}?#frmEdit','_newtab');" class="submit radius2" >Thêm nhóm</button>
            </span>
        </p>
        <script>
                                    function loadNhom(){
                                    var request = jQuery.ajax({
                                    url: "{{URL::action('ProductController@postCateAjax')}}",
                                            type: "POST"
                                    });
                                            request.done(function(msg) {
                                            jQuery('#productGroup').empty().html(msg);
                                            }
                                            );
                                    }
        </script>
        <p>
            <label>Mô tả sản phẩm</label>
            <span class="field"><textarea cols="80" rows="5" required title="Trường này không được để trống"  id="productDescription" class="ckeditor" name="productDescription" placeholder="Mô tả sản phẩm">@if(isset($dataedit)){{$dataedit->productDescription}}@endif</textarea></span>

        </p>
        <p>
            <label>Chi tiết sản phẩm</label>
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Thuộc tính sản phẩm</a></li>
                <li><a href="#tabs-2">Số lượng</a></li>   
                <li><a href="#tabs-3">Ảnh sản phẩm</a></li>   
                <li><a href="#tabs-4">Phân loại</a></li>   
            </ul>
            <div id="tabs-1">
                <p>
                    <textarea cols="80" rows="3"  id="location3" class="ckeditor" name="productAttributes" placeholder="Thuộc tính sản phẩm">@if(isset($dataedit)){{$dataedit->Attributes}}@endif</textarea>
                </p>
            </div>
            <div id="tabs-2">
                <script type="text/javascript">
                                    var a = 0;
                                            function  onfor(id) {
                                            a = jQuery('#mausanpham-' + id).val();
                                            }
                                    function  onchangeselec(id) {

                                    var rowCount = jQuery('#myTable tr').length;
                                            var check = true;
                                            for (i = 1; i <= rowCount - 1; i++) {
                                    if (i != id) {
                                    if (jQuery('#mausanpham-' + i).val() == jQuery('#mausanpham-' + id).val() && jQuery('#sizesanpham-' + i).val() == jQuery('#sizesanpham-' + id).val()) {
                                    check = false;
                                    }
                                    }
                                    }
                                    if (check == true) {
                                    return  true;
                                    } else {
                                    jQuery('#mausanpham-' + id).val(a)
                                            jAlert('Phần tử đã thêm đã tồn tại', 'Thông báo');
                                    }
                                    }

                                    var b = 0;
                                            function  onfor1(id) {
                                            b = jQuery('#sizesanpham-' + id).val();
                                            }
                                    function  onchangeselec1(id) {

                                    var rowCount = jQuery('#myTable tr').length;
                                            var check = true;
                                            for (i = 1; i <= rowCount - 1; i++) {
                                    if (i != id) {
                                    if (jQuery('#mausanpham-' + i).val() == jQuery('#mausanpham-' + id).val() && jQuery('#sizesanpham-' + i).val() == jQuery('#sizesanpham-' + id).val()) {
                                    check = false;
                                    }
                                    }
                                    }
                                    if (check == true) {
                                    return  true;
                                    } else {
                                    jQuery('#sizesanpham-' + id).val(b)
                                            jAlert('Phần tử đã thêm đã tồn tại', 'Thông báo');
                                    }
                                    }
                                    function themsoluong(mausac, size, soluong) {

                                    var rowCount = jQuery('#myTable tr').length;
                                            var check = true;
                                            for (i = 1; i <= rowCount - 1; i++) {
                                    if (jQuery('#mausanpham-' + i).val() == mausac && jQuery('#sizesanpham-' + i).val() == size) {
                                    check = false;
                                    }
                                    }

                                    if (check == false)
                                    {
                                    jAlert('Phần tử đã thêm đã tồn tại', 'Thông báo');
                                    } else {
                                    if (soluong == '') {
                                    jAlert('Bạn vui lòng thêm số lượng sản phẩm', 'Thông báo');
                                    } else {
                                    var html = '<tr id="row-' + rowCount + '"> '+
                                            ' <td><span id="stt-' + rowCount + '">' + rowCount + '</span></td>'+
                                            '<td><select  name="mausacsanpham[]" id="mausanpham-' + rowCount + '"  onfocus="onfor(' + rowCount + ')" onchange="onchangeselec(' + rowCount + ')"> @if(isset($arrColor))@foreach($arrColor as $item)<option @if($item->id == '+mausac+') selected @endif value="{{$item->id}}" style="background: {{$item->colorCode}}">{{$item->colorName}}</option>@endforeach@endif</select></td>'+
                                            '<td><select name="sizesanphamr[]" id="sizesanpham-' + rowCount + '" onfocus="onfor1(' + rowCount + ')" onchange="onchangeselec1(' + rowCount + ')">  @if(isset($arrSize))@foreach($arrSize as $item)<option  @if($item->id == '+size+') selected @endif value="{{$item->id}}" >{{$item->sizeName}}</option>@endforeach@endif</select></td>'+
                                            '<td class="center"><input type="text" id="soluongsanpham-' + rowCount + '" name="soluongsanpham[]" style="smallinput"/></td>'+
                                            '<td class="center"><a href="javascript:void(0);" onclick="xoasanpham(\'row-' + rowCount + '\')" class="btn btn4 btn_trash"></a></td>'+
                                            '</tr>';
                                            jQuery('#themsoluong').append(html);
                                            setTimeout(jQuery('#mausanpham-' + rowCount).val(mausac), 100);
                                            setTimeout(jQuery('#sizesanpham-' + rowCount).val(size), 100);
                                            setTimeout(jQuery('#soluongsanpham-' + rowCount).val(soluong), 100);
                                    }
                                    }
                                    }
                                    function xoasanpham(id) {
                                    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
                                    if (r == true) {
                                    jQuery('#' + id).remove();
                                    } else {
                                    return false;
                                    }
                                    });
                                    }
                </script>
                <table  cellpadding="0" cellspacing="0" border="0" class="stdtable" id="myTable">
                    <colgroup>
                        <col class="con0" style="width: 10%;" />
                        <col class="con1" style="width: 30%;" />
                        <col class="con0"  style="width: 30%;"/>
                        <col class="con1" style="width: 20%;" />
                        <col class="con0" style="width: 10%;" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="head0">STT</th>
                            <th class="head1">Màu sắc</th>
                            <th class="head0">Size</th>
                            <th class="head1">Số lượng</th>    
                            <th class="head1">Xóa</th>  
                        </tr>
                    </thead>
                    <tbody id="themsoluong">

                    </tbody>
                </table>
                <p>
                    <label>Màu sắc</label>
                    <span class="field">
                        <select  name="mausacproduct" id="mausacproduct">
                            @if(isset($arrColor))
                            @foreach($arrColor as $item)
                            <option value="{{$item->id}}" style="background: {{$item->colorCode}}">{{$item->colorName}}</option>
                            @endforeach
                            @endif
                        </select>
                        <button type="button"  class="submit radius2" id="addColor">Thêm màu</button>
                    </span>
                </p>
                <p>
                    <label>Size</label>
                    <span class="field">
                        <select name="sizeproduct" id="sizeproduct">
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
                    <label>Số lượng</label>
                    <span class="field"><input type="text" onkeypress="return event.charCode > 47 && event.charCode < 58;" pattern="[0-9]" name="soluongproduct" id="soluongproduct" class="longinput" /></span>
                </p>
                <input type="button" class="stdbtn btn_orange" value="Thêm loại" onclick="themsoluong(jQuery('#mausacproduct').val(), jQuery('#sizeproduct').val(), jQuery('#soluongproduct').val());"/>
            </div>
            <div id="tabs-3">
                <script type="text/javascript">

                                            function BrowseServer(startupPath, functionData)
                                            {
                                            // You can use the "CKFinder" class to render CKFinder in a page:
                                            var finder = new CKFinder();
                                                    // The path for the installation of CKFinder (default = "/ckfinder/").
                                                    // finder.basePath = '../';

                                                    //Startup path in a form: "Type:/path/to/directory/"
                                                    finder.startupPath = startupPath;
                                                    // Name of a function which is called when a file is selected in CKFinder.
                                                    finder.selectActionFunction = SetFileField;
                                                    // Additional data to be passed to the selectActionFunction in a second argument.
                                                    // We'll use this feature to pass the Id of a field that will be updated.
                                                    finder.selectActionData = functionData;
                                                    // Launch CKFinder
                                                    finder.popup();
                                            }

// This is a sample function which is called when a file is selected in CKFinder.
                                    function SetFileField(fileUrl, data)
                                    {
                                    var sFileName = this.getSelectedFile().name;
                                            var urlImg = '<div id="image-' + sFileName + '"><img src="{{Asset('timthumb.php')}}?src=http://' + window.location.hostname + fileUrl + '&w=100&h=100&zc=0&q=100" width="100" height="100"/><a href="javascript:void(0);" onclick="xoaanhthum(\'image-' + sFileName + '\');" class="delete" title="Delete image">x</a></div>';
                                            document.getElementById('thumbnails').innerHTML += urlImg;
                                            returnurlimg();
                                            //   document.getElementById(data["selectActionData"]).value = fileUrl;
                                    }
                                    function xoaanhthum(id) {
                                    document.getElementById(id).remove();
                                            returnurlimg();
                                    }
                                    function returnurlimg() {
                                    var images = jQuery("#thumbnails").find("img").map(function() {
                                    return this.src;
                                    }).get();
                                            jQuery("#xImagePath").val(images);
                                    }

                                    //load ảnh
                                    jQuery(document).ready(function() {
<?php
if (isset($dataimg)) {
    foreach ($dataimg as $item) {
        ?>
                                            var urlImg = '<div id="image-' + <?php echo $item->id; ?> + '"><img src="<?php echo $item->attachmentURL; ?>" width="100" height="100"/><a href="javascript:void(o);" onclick="xoaanhthum(\'image-' + <?php echo $item->id; ?> + '\');" class="delete" title="Delete image">x</a></div>';
                                                    document.getElementById('thumbnails').innerHTML += urlImg;
    <?php }
    ?>
                                        returnurlimg();
<?php }
?>
<?php
if (isset($dataStore)) {
    foreach ($dataStore as $sItem) {
        ?>
                                            themsoluong('<?php echo $sItem->colorID; ?>', '<?php echo $sItem->sizeID; ?>', '<?php echo $sItem->soluongnhap; ?>');
        <?php
    }
}
?>
                                    });</script>

                <div id="thumbnails">

                </div>
                <input id="xImagePath" name="ImagePath" type="hidden" />
                <div class="clear"></div>
                <input type="button" value="Thêm ảnh" class="stdbtn btn_orange" onclick="BrowseServer('Images:/', 'xImagePath');" />
            </div>
            <div id="tabs-4">
                <p>
                    <label>Chọn loại</label>
                    <span class="field">
                        <select name="loaisanpham[]" multiple="multiple" size="10">
                            @if(isset($arrmuti))
                            @foreach($arrmuti as $item)
                            <?php $select = ''; ?>
                            @if(isset($arrPmeta)) 
                            @foreach($arrPmeta as $item1)
                            @if($item1->tagID == $item->id)
                            <?php $select = 'selected'; ?>
                            @endif
                            @endforeach
                            @endif
                            <option <?php echo $select; ?> value="{{$item->id}}" >{{$item->tagName}}</option>
                            @endforeach
                            @endif
                        </select>
                    </span>
                    <small class="desc">Bạn có thể chọn nhiều loại bằng cách giữ CTRL rồi chọn</small>
                </p>
            </div>
        </div>
        </p>
        <p>
            <label>Giá sản phẩm </label>
            <span class="field"><input type="text" required title="Trường này không được để trống" value="@if(isset($dataedit)){{$dataedit->productPrice}}@endif" id="productPrice" onchange="checkPrice(0)"  onkeypress="return event.charCode > 47 && event.charCode < 58;"  name="productPrice" class="smallinput" /></span>
        </p>
        <p>
            <label>Giá khuyến mại </label>
            <span class="field"><input type="text" id="salesPrice" value="@if(isset($dataedit)){{$dataedit->salesPrice}}@endif"  onchange="checkPrice(1)"  onkeypress="return event.charCode > 47 && event.charCode < 58;"   name="salesPrice" class="smallinput" />  &nbsp;<a href="javascript:void(0);" onclick="showkhuyenmai();">Thời gian khuyến mại</a></span>
            <small class="desc">Không khuyến mại để mặc định là trống .</small>
        </p>
        <script>
                                    //kiểm tra giá và khuyến mại
                                            function checkPrice(obj) {

                                            var price = jQuery('#productPrice').val();
                                                    var sales = jQuery('#salesPrice').val();
                                                    if (price != '' && sales != '')
                                            {
                                            if (parseInt(price) < parseInt(sales))
                                            {
                                            jAlert('Giá khuyến mại không được lớn hơn giá sản phẩm!', 'Thông báo');
                                                    if (obj == 0)
                                            {
                                            jQuery('#productPrice').val('').focus();
                                            }
                                            else
                                            {
                                            jQuery('#salesPrice').val('').focus();
                                            }
                                            }
                                            }
                                            }
        </script>
        <p id="book" style="display: none;">
            <label>Thời gian khuyến mại </label>
            <span class="field">Từ&nbsp;<input type="text" name="datetosales" value="@if(isset($dataedit)){{$dataedit->startSales}}@endif" id="datepicker" class="smallinput" onchange="checkngaykhuyenmai()" />&nbsp;&nbsp;Đến&nbsp;<input id="datepicker1" type="text" name="datefromsales" value="@if(isset($dataedit)){{$dataedit->endSales}}@endif" class="smallinput" /> </span>
        </p>
        <p>
            <label>Đường dẫn tĩnh </label>
            <span class="field"><input required title="Trường này không được để trống" @if(isset($dataedit))  disabled @else id="productSlug" @endif value="@if(isset($dataedit)){{$dataedit->productSlug}}@endif" type="text"  name="productSlug" class="smallinput" /></span>
        </p>
        <p>
            <label>Tags</label>
            <span class="field">
                <input name="producttags" value="@if(isset($dataedit)){{$dataedit->productTag}}@endif"  id="tags" class="longinput" />
                <small class="desc">Tag cách nhau bằng dấu phẩy.</small>
            </span>
        </p>
        <p>
            <label>Nhà sản xuất</label>
            <span class="field">
                <select name="manufacture" id="manufacture">
                    @if(isset($arrManu))
                    @foreach($arrManu as $item)                   
                    <option  @if(isset($dataedit) && $dataedit->manufactureID== $item->id) selected @endif value="{{$item->id}}">{{$item->manufacturerName}}</option>
                    @endforeach
                    @endif
                </select>
                <button type="button" class="stdbtn" onclick="loadNhaSanXuat()">Làm mới</button>
                <button type="button" onclick="window.open('{{URL::action('ManufacturerController@getAddManufaturer')}}', '_newtab');" class="submit radius2" >Thêm nhà sản xuất</button>
            </span>
        </p>
        <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status" id="status">
                    <option value="0" @if(isset($dataedit)&& $dataedit->status==0)selected @endif >Chờ đăng</option>
                    <option value="1" @if(isset($dataedit)&&$dataedit->status==1)selected @endif >Đã đăng</option>
                    <option value="2" @if(isset($dataedit)&&$dataedit->status==2)selected @endif >Xóa</option>
                </select>
            </span>
        </p>
        <script>
                                                    function loadNhaSanXuat(){
                                                    var request = jQuery.ajax({
                                                    url: "{{URL::action('ProductController@postManuAjax')}}",
                                                            type: "POST"
                                                    });
                                                            request.done(function(msg) {
                                                            jQuery('#manufacture').empty().html(msg);
                                                            }
                                                            );
                                                    }
        </script>
        <p class="stdformbutton">
            <button class="submit radius2" type="button" onclick="checkValid()" value="Thêm mới">@if(isset($dataedit))Cập nhật @else Thêm mới @endif </button>
            <button type="button" onclick="window.location.href ='{{URL::action('ProductController@getView')}}';" class="stdbtn">Quay lại danh sách sản phẩm</button>
        </p>
    </form>
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