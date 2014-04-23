@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    jQuery(document).ready(function(){
    jQuery("#addPage").validate({
    rules: {
            pageName: {
                required: true
                
            },
            pageKeyword: {
                required: true
                
            },
            pageTag: {
                required: true
            },
            pageSlug: {
                required: true
            }

            },
    messages: {
            pageName: {
                required: 'Tên là trường bắt buộc'
                
            },
            pageKeyword: {
                required: 'Từ khóa là trường bắt buộc'
               
            },
            pageTag: {
                required: 'Vui lòng nhập tag'
            },
            pageSlug: {
                required: 'Vui lòng nhập slug '
            }
        }
        });
    });
</script>

<div class="contenttitle2" id="editPage">
            <h3>Thêm/Sửa trang</h3>
        </div>
        <form class="stdform stdform2" id="addPage" method="post" action="@if(isset($arrayPage)) {{URL::action('PageController@postUpdatePage')}} @else {{URL::action('PageController@postAddPage')}}@endif">

            <p>
                <input type="hidden" name="idpage" id="idpage" value="@if(isset($arrayPage)){{$arrayPage->id}}@endif"/>
                <input type="hidden" name="status" id="status" value="@if(isset($arrayPage)){{$arrayPage->status}}@endif"/>
                
            </p>
            <p>
                <label>Tên trang</label>
                <span class="field"><input type="text" onkeyup="locdau()" onchange="getCheckSlug()" id="pageName" name="pageName" placeholder="Nhập tên nhà sản xuất" value="@if(isset($arrayPage)){{$arrayPage->pageName}}@endif" class="longinput"></span>
                <script>
                        function locdau() {
                        var str = (document.getElementById("pageName").value); // lấy chuỗi dữ liệu nhập vào
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
                                document.getElementById("slug").value = str;
                                document.getElementById("pageSlug").value = str; // xuất kết quả xữ lý ra
                        }

                        function getCheckSlug() {
                        var str = (document.getElementById("pageName").value); // lấy chuỗi dữ liệu nhập vào
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
                                url: "{{URL::action('PageController@postCheckSlug')}}?slug=" + str,
                                        type: "POST"
                                });
                                request.done(function(msg) {
                                if (msg != '') {
                                if (msg == '0') {
                                document.getElementById("slug").value = str;    
                                document.getElementById("pageSlug").value = str;
                                        return false;
                                } else {
                                document.getElementById("slug").value = str + '-' + msg;    
                                document.getElementById("pageSlug").value = str + '-' + msg;
                                        return false;
                                }
                                }
                                });
                        }
                </script>
            </p>

            <p>
                <label>Nội dung</label>
                <span class="field"><textarea cols="80" rows="5" id="location2" class="ckeditor" name="pageContent" placeholder="Nội dung trang">@if(isset($arrayPage)){{$arrayPage->pageContent}}@endif</textarea></span>
            </p>
            
            <p>
                <label>Từ khóa</label>
                <span class="field"><input type="text" name="pageKeyword" placeholder="Nhập từ khóa" value="@if(isset($arrayPage)){{$arrayPage->pageKeywords}}@endif" class="longinput"></span>
            </p> 
            <p>
                <label>Tag</label>
                <span class="field"><input type="text" name="pageTag" placeholder="Nhập tag" value="@if(isset($arrayPage)){{$arrayPage->pageTag}}@endif" class="longinput"></span>
            </p> 
            <p>
                <label>Slug</label>
                <span class="field">
                    <input type="text" name="pageSlug" placeholder="Nhập slug" id="pageSlug" @if(isset($arrayPage)) disabled @endif value="@if(isset($arrayPage)){{$arrayPage->pageSlug}}@endif" class="longinput">
                           <input type="hidden" name="slug" value="@if(isset($arrayPage)){{$arrayPage->pageSlug}}@endif" id="slug"/>       
                </span>
            </p> 

            <p>
                <label>Trạng thái</label>
                <span class="field">
                    <select name="status">
                        <option value="0" @if(isset($arrayPage)&& $arrayPage->status==0)selected@endif >Chờ kích hoạt</option>
                        <option value="1" @if(isset($arrayPage)&& $arrayPage->status==1)selected@endif>Kích hoạt</option>
                        <option value="2" @if(isset($arrayPage)&& $arrayPage->status==2)selected@endif>Xóa</option>
                    </select>
                </span>
            </p>
            
            <p class="stdformbutton">
                <button class="submit radius2">@if(isset($arrayPage))Cập nhật @else Thêm mới @endif</button>
                <input type="reset" class="reset radius2" value="Làm lại">
            </p>
        </form>
@endsection