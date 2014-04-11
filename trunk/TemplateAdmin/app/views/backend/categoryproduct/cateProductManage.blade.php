@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
    var request = jQuery.ajax({
    url: "{{URL::action('CategoryProductController@postAjaxpagion')}}?page=" + page,
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
    url: "{{URL::action('CategoryProductController@postDeleteCateProduct')}}?id=" + id,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
             jQuery('#messages1').empty().html(" <div class='notibar msgsuccess'><a class='close'></a><p>Cập nhật thành công.</p> </div>"); 
            });
            return true;
    } else {
    return false;
    }
    })
    }
    function kichhoat(id, stus) {
    var request = jQuery.ajax({
    url: "{{URL::action('CategoryProductController@postCateProductActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            jQuery('#messages1').empty().html(" <div class='notibar msgsuccess'><a class='close'></a><p>Cập nhật thành công.</p> </div>");
            });
            return true;
    }
    //lọc dấu tạo slug
    function locdau() {
        var str = (document.getElementById("cateName").value); // lấy chuỗi dữ liệu nhập vào
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

    function getCheckSlug() {
        var str = (document.getElementById("cateName").value); // lấy chuỗi dữ liệu nhập vào
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
            url: "{{URL::action('CategoryProductController@postCheckSlug')}}?slug=" + str,
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
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ DANH MỤC SẢN PHẨM</h1>
    <span class="pagedesc">Quản lý danh mục</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Bảng danh mục sản phẩm</h3>
    </div>
    <a name="frmEdit"></a>
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
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 10%">
                    <col class="con1" style="width: 15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1">ID</th>
                        <th class="head0">Tên danh mục</th>
                        <th class="head1">Parent</th>
                        <th class="head0">Đường dẫn</th>
                        <th class="head1">Khởi tạo</th>
                        <th class="head0">Tình trạng</th>
                        <th class="head1">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct">
                    @foreach($arrCateProduct as $item)
                    <tr> 

                        <td><label value="cateMenuer">{{$item->id }}</label></td> 
                        <td><label value="cateMenuer">@if($item->cateParent!=0) -- @endif {{str_limit( $item->cateName, 30, '...')}}</label></td> 
                        <td><label value="cateMenuer">{{str_limit($item->cateParent , 30, '...')}}</label></td>
                        <td><label value="cateMenuer">{{str_limit($item->cateSlug , 30, '...')}}</label></td> 
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

                            <a href="{{URL::action('CategoryProductController@getCateProductEdit')}}?id={{$item->id}}&#frmEdit" class="btn btn4 btn_book" title="Sửa"></a>
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
                        <td colspan="7">{{$link}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    <div class="contenttitle2">
        <h3>Bảng thêm và chỉnh sửa</h3>
    </div>
    <form class="stdform stdform2" method="post" action="@if(isset($cateProductData)) {{URL::action('CategoryProductController@postUpdateCateProduct')}} @else {{URL::action('CategoryProductController@postAddCateProduct')}}@endif">

        <p>
            <input type="hidden" name="cateProductID" id="idnews" value="@if(isset($cateProductData)){{$cateProductData->id}}@endif"/>
            <label>Tên danh mục sản phẩm</label>
            <span class="field"><input type="text" id="cateName"  onkeyup="locdau()" onchange="getCheckSlug()" name="cateName" placeholder="Nhập tên danh mục sản phẩm" value="@if(isset($cateProductData)){{$cateProductData->cateName}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Danh mục Cha</label>
            <span class="field">
                <select name="cateParent" id="selection2">
                    <option value="0">không</option>
                    <?php
                    foreach ($arrCateProduct as $item) {
                        if ($item->cateParent == 0) {
                            $selec = '';
                            if (isset($cateProductData) && $item->id == $cateProductData->cateParent) {
                                $selec = 'selected';
                            }
                            echo '<option value="' . $item->id . '" ' . $selec . '> ' . $item->cateName . '</option>';                          
                        }
                    }
                    ?>
                </select>
            </span>
        </p>
        <p>
            <label>Đường dẫn</label>
            <span class="field"><input type="text" name="cateSlug" placeholder="Nhập đường dẫn"  id="cateSlug" value="@if(isset($cateProductData)){{$cateProductData->cateSlug}}@endif" class="longinput"></span>
        </p>       
        <p>
            <label>Mô tả</label>
            <span class="field">
                <textarea  id="cateDescription" rows="5" name="cateDescription" placeholder="Nhập mô tả">@if(isset($cateProductData)){{$cateProductData->cateDescription}}@endif</textarea>                
            </span>
        </p>
         <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status">
                    <option value="0" @if(isset($cateProductData)&& $cateProductData->status==0)selected@endif >Chờ kích hoạt</option>
                    <option value="1" @if(isset($cateProductData)&& $cateProductData->status==1)selected@endif>Kích hoạt</option>
                    <option value="2" @if(isset($cateProductData)&& $cateProductData->status==2)selected@endif>Xóa</option>
                </select>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($cateProductData))Cập nhật @else Thêm mới @endif ">@if(isset($cateProductData))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới" >            
            <a href="{{URL::action('CategoryProductController@getCateProductView')}}" class="btn btn_home"><span>Hủy</span></a>
        </p>
    </form>
</div>
@endsection
