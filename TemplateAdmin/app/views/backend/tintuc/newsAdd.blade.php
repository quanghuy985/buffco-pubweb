@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function locdau() {
        var str = (document.getElementById("newstitle").value); // lấy chuỗi dữ liệu nhập vào
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
        document.getElementById("newsSlug").value = str; // xuất kết quả xữ lý ra
    }


    function getCheckSlug() {
        var str = (document.getElementById("newstitle").value); // lấy chuỗi dữ liệu nhập vào
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
            url: "{{URL::action('NewsController@postCheckSlug')}}?slug=" + str,
            type: "POST"
        });
        request.done(function(msg) {
            if (msg != '') {
                if (msg == '0') {
                    document.getElementById("newsSlug").value = str;
                    return false;
                } else {
                    document.getElementById("newsSlug").value = str + '-' + msg;
                    return false;
                }
            }
        });
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">TIN TỨC</h1>
    <span class="pagedesc"> Thêm mới tin tức</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Mẫu nhập tin tức</h3>
        </div>
        <form class="stdform stdform2" method="post" action="@if(isset($objNews)) {{URL::action('NewsController@postUpdateNews')}} @else {{URL::action('NewsController@postAddNews')}}@endif">

            <p>
                <input type="hidden" name="idnews" id="idnews" value="@if(isset($objNews)){{$objNews->id}}@endif"/>
                <input type="hidden" name="status" id="status" value="@if(isset($objNews)){{$objNews->status}}@endif"/>
                <label>Chọn mục hiển thị bài viết</label>
                <span class="field">

                    <select name="cbCateNews">
                        <?php
                        foreach ($arrayCate as $item) {
                            if ($item->catenewsParent == 0) {
                                echo '<option  value="' . $item->id . '">' . $item->catenewsName . '</option>';
                                foreach ($arrayCate as $item1) {
                                    if ($item1->catenewsParent == $item->id) {
                                        echo '<option value="' . $item1->id . '">-- ' . $item1->catenewsName . '</option>';
                                    }
                                }
                            }
                        }
                        ?>
                    </select>
                </span>
            </p>
            <p>
                <label>Tiêu đề bài viết</label>
                <span class="field"><input type="text" name="newstitle" id="newstitle" onkeyup="locdau()" onchange="getCheckSlug()" placeholder="Nhập tiêu đề bài viết" value="@if(isset($objNews)){{$objNews->newsName}}@endif" class="longinput"></span>
            </p>

            <p>
                <label>Miêu tả tin tức</label>
                <span class="field"><input type="text" name="newsdescription" placeholder="Nhập 1 đoạn miêu tả ngắn gọn bài viết" value="@if(isset($objNews)){{$objNews->newsDescription}}@endif" class="longinput"></span>
            </p>

            <p>
                <label>Nội dung bài viết <small>Nhập nội dung bài viết trong mục</small></label>
                <span class="field"><textarea cols="80" rows="5" id="location2" class="ckeditor" name="newsContent" placeholder="Nội dung bài viết">@if(isset($objNews)){{$objNews->newsContent}}@endif</textarea></span>
            </p>

            <p>
                <label>Nhập từ khóa</label>
                <span class="field"> 
                    <input name="newsKeywords" id="tags" class="longinput" value="@if(isset($objNews)){{$objNews->newsKeywords}}@endif" />
                </span>
            </p>

            <p>
                <label>Nhập Tag</label>
                <span class="field"> 
                    <input name="newstag" id="tags1" class="longinput" value="@if(isset($objNews)){{$objNews->newsTag}}@endif" />
                </span>

            </p>
            <p>
                <label>Link tới bài viết</label>
                <span class="field"><input type="text" name="newsSlug" id="newsSlug" placeholder="Ví dụ: pubweb.vn/tinngoaiweb/vu-an-hinh-su ; vu-an-hinh-su là từ được nhập" value='@if(isset($objNews)){{$objNews->newsSlug}}@endif' class="longinput"></span>
            </p>

            <p class="stdformbutton">
                <button class="submit radius2" value="@if(isset($objNews))Cập nhật @else Thêm mới @endif ">@if(isset($objNews))Cập nhật @else Thêm mới @endif </button>
                <input type="reset" class="reset radius2" value="Làm mới">
            </p>
        </form>
    </div>
</div>
@endsection
