@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
        var request = jQuery.ajax({
            url: "{{URL::action('cateNewsController@postAjaxpagion')}}?page=" + page,
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
                    url: "{{URL::action('cateNewsController@postDeleteCateNews')}}?id=" + id,
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
            url: "{{URL::action('cateNewsController@postCateNewsActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
        });
        return true;
    }
    function locdau() {
        var str = (document.getElementById("cateNewsName").value); // lấy chuỗi dữ liệu nhập vào
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
        document.getElementById("catenewsSlug").value = str; // xuất kết quả xữ lý ra
    }


    function getCheckSlug() {
        var str = (document.getElementById("cateNewsName").value); // lấy chuỗi dữ liệu nhập vào
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
                    url: "{{URL::action('cateNewsController@postCheckSlug')}}?slug=" + str,
                    type: "POST"
                });
        request.done(function(msg) {
            if (msg != '') {
                document.getElementById("catenewsSlug").value = str + '-' + msg;
                return false;
            }
        });
    }
</script>

<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ DANH MỤC TIN TỨC</h1>
    <span class="pagedesc">Quản lý danh mục</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Bảng danh mục tin tức</h3>
    </div>
    <div class="contentwrapper">
        <div class="subcontent">

            @if(isset($thongbao))
            <div class="notibar msgalert">
                <a class="close"></a>
                <p>{{$thongbao}}</p>
            </div>
            @endif
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 20%">
                    <col class="con0" style="width: 10%">
                    <col class="con1" style="width: 10%">
                    <col class="con0" style="width: 10%">
                    <col class="con1" style="width: 10%">
                    <col class="con0" style="width: 20%">
                </colgroup>
                <thead>
                    <tr>

                        <th class="head0">Tên danh mục</th>
                        <th class="head1">Miêu tả</th>
                        <th class="head0">Parent</th>
                        <th class="head1">Đường dẫn</th>
                        <th class="head0">Khởi tạo</th>
                        <th class="head1">Tình trạng</th>
                        <th class="head0">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct">
                    @foreach($arrayCateNews as $item)    
                    <tr> 
                        <td>@if($item->catenewsParent ==0) <strong> @endif <label value="cateMenuer">@if($item->catenewsParent !=0) &nbsp;-&nbsp; @endif {{str_limit( $item->catenewsName, 30, '...')}}</label>@if($item->catenewsParent ==0) </strong> @endif</td>
                        <td><label value="cateMenuer">{{str_limit( $item->catenewsDescription, 30, '...')}}</label></td>
                        <td><label value="cateMenuer">@if ($item->catenewsParent == 0 ) {{ 'Cha' }} @else {{str_limit($item->catenewsParentName , 30, '...')}} @endif</label></td>
                        <td><label value="cateMenuer">{{str_limit($item->catenewsSlug , 30, '...')}}</label></td> 
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

                            <a href="{{URL::action('cateNewsController@getCateNewsEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
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
    <form class="stdform stdform2" method="post" action="@if(isset($cateNewsData)) {{URL::action('cateNewsController@postUpdateCateNews')}} @else {{URL::action('cateNewsController@postAddCateNews')}}@endif">

        <p>
            <input type="hidden" name="cateNewsID" id="idnews" value="@if(isset($cateNewsData)){{$cateNewsData->id}}@endif"/>
            <label>Tên danh mục tin tức</label>
            <span class="field"><input type="text" name="cateNewsName" id="cateNewsName" onchange="getCheckSlug()" onkeyup="locdau()" placeholder="Nhập tên danh mục tin tức" value="@if(isset($cateNewsData)){{$cateNewsData->catenewsName}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Miêu tả danh mục</label>
            <span class="field"><input type="text" name="catenewsDescription" placeholder="Nhập miêu tả ngắn gọn danh mục tin tức" value="@if(isset($cateNewsData)){{$cateNewsData->catenewsDescription}}@endif" class="longinput"></span>
        </p>

        <p>
            <label>Danh mục Cha</label>
            <span class="field">
                <select name="catenewsParent" id="selection2">
                    <option value="0">không</option>
                    <?php
                    foreach ($arrayCateNews as $item) {
                        if ($item->catenewsParent == 0) {
                            $selec = '';
                            if (isset($cateNewsData) && $item->id == $cateNewsData->catenewsParent) {
                                $selec = 'selected';
                            }
                            echo '<option value="' . $item->id . '" ' . $selec . '> ' . $item->catenewsName . '</option>';
//                            foreach ($arrayMenu as $item1) {
//                                if ($item1->menuParent == $item->id) {
//                                    $selec1 = '';
//                                    if (isset($cateNewsData) && $item1->id == $cateNewsData->menuID) {
//                                        $selec1 = 'selected';
//                                    }
//                                    echo '<option value="' . $item1->id . '" ' . $selec1 . '>-- ' . $item1->menuName . '</option>';
//                                }
//                            }
                        }
                    }
                    ?>

                </select>
            </span>
        </p>
        <p>
            <label>Đường dẫn</label>
            <span class="field"><input type="text" name="catenewsSlug" id='catenewsSlug' placeholder="Nhập đường dẫn" onchange="" value="@if(isset($cateNewsData)){{$cateNewsData->catenewsSlug}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status">
                    <option value="0" @if(isset($cateNewsData)&& $cateNewsData->status==0)selected@endif >Chờ kích hoạt</option>
                    <option value="1" @if(isset($cateNewsData)&& $cateNewsData->status==1)selected@endif>Kích hoạt</option>
                    <option value="2" @if(isset($cateNewsData)&& $cateNewsData->status==2)selected@endif>Xóa</option>
                </select>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($cateNewsData))Cập nhật @else Thêm mới @endif ">@if(isset($cateNewsData))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới">
        </p>
    </form>
</div>
@endsection
