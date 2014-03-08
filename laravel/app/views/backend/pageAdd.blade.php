@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ CÁC TRANG</h1>
    <span class="pagedesc">Thêm mới trang</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Mẫu nhập trang</h3>
        </div>
        <form class="stdform stdform2" method="post" action="@if(isset($pagedata)) {{URL::action('PageController@postUpdatePage')}} @else {{URL::action('PageController@postAddPage')}}@endif">

            <p>
                <input type="hidden" name="idPage" id="idnews" value="@if(isset($pagedata)){{$pagedata->id}}@endif"/>
                <input type="hidden" name="status" id="status" value="@if(isset($pagedata)){{$pagedata->status}}@endif"/>
            </p>
            <p>
                <label>Tên trang</label>
                <span class="field"><input type="text" name="pageName" placeholder="Nhập tên của trang" value="@if(isset($pagedata)){{$pagedata->pageName}}@endif" class="longinput"></span>
            </p>
            <p>
                <label>Nội dung của trang <small>Nhập nội dung trang trong mục</small></label>
                <span class="field"><textarea cols="80" rows="5" id="location2" class="ckeditor" name="pageContent" placeholder="Nội dung trang">@if(isset($pagedata)){{$pagedata->pageContent}}@endif</textarea></span>
            </p>

            <p>
                <label>Nhập Tag</label>
                <span class="field"><input type="text" name="pageTag" placeholder="Ví dụ : about-us, tin tuc, free-site, " value="@if(isset($pagedata)){{$pagedata->pageTag}}@endif" class="longinput"></span>
            </p>
            <p>
                <label>Link ngắn gọn tới trang</label>
                <span class="field"><input type="text" name="pageSlug" placeholder="Ví dụ: pubweb.vn/about-us ; about-us là từ được nhập" value='@if(isset($pagedata)){{$pagedata->pageSlug}}@endif' class="longinput"></span>
            </p>

            <p class="stdformbutton">
                <button class="submit radius2" value="@if(isset($pagedata))Cập nhật @else Thêm mới @endif ">@if(isset($pagedata))Cập nhật @else Thêm mới @endif </button>
                <input type="reset" class="reset radius2" value="Làm mới">
            </p>
        </form>
    </div>
</div>
@endsection