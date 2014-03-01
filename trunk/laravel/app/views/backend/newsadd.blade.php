@extends("templateadmin2.mainfire")

@section("contentadmin")

<div class="pageheader notab">
    <h1 class="pagetitle">TIN TỨC</h1>
    <span class="pagedesc"> Thêm mới tin tức</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Mẫu nhập tin tức</h3>
        </div>
        <form class="stdform stdform2" method="post" action="@if(isset($datan)) {{URL::action('NewsController@postUpdateNews')}} @else {{URL::action('NewsController@postAddNews')}}@endif">

            <p>
                <input type="hidden" name="idnews" id="idnews" value="@if(isset($datan)){{$datan->id}}@endif"/>
                <input type="hidden" name="status" id="status" value="@if(isset($datan)){{$datan->status}}@endif"/>
                <label>Chọn mục hiển thị bài viết</label>
                <span class="field">
                    <select name="cbCateNews">
                        @foreach($arrayCate as $item)
                        <option value="{{$item->id}}" @if(isset($datan))@if($item->id==$datan->catenewsID)selected@endif@endif>{{$item->catenewsName}}</option>
                        @endforeach
                    </select>
                </span>
            </p>
            <p>
                <label>Tiêu đề bài viết</label>
                <span class="field"><input type="text" name="newstitle" placeholder="Nhập tiêu đề bài viết" value="@if(isset($datan)){{$datan->newsName}}@endif" class="longinput"></span>
            </p>

            <p>
                <label>Miêu tả tin tức</label>
                <span class="field"><input type="text" name="newsdescription" placeholder="Nhập 1 đoạn miêu tả ngắn gọn bài viết" value="@if(isset($datan)){{$datan->newsDescription}}@endif" class="longinput"></span>
            </p>

            <p>
                <label>Nội dung bài viết <small>Nhập nội dung bài viết trong mục</small></label>
                <span class="field"><textarea cols="80" rows="5" id="location2" class="ckeditor" name="newsContent" placeholder="Nội dung bài viết">@if(isset($datan)){{$datan->newsContent}}@endif</textarea></span>
            </p>

            <p>
                <label>Nhập từ khóa</label>
                <span class="field"><input type="text" name="newsKeywords" placeholder="Nhập từ khóa cho bài viết eg:Hình sự,Tin mới" value="@if(isset($datan)){{$datan->newsKeywords}}@endif" class="longinput"></span>
            </p>

            <p>
                <label>Nhập Tag</label>
                <span class="field"><input type="text" name="newstag" placeholder="Ví dụ : vụ-án, hình-sự, free-site, " value="@if(isset($datan)){{$datan->newsTag}}@endif" class="longinput"></span>
            </p>
            <p>
                <label>Link tới bài viết</label>
                <span class="field"><input type="text" name="newsSlug" placeholder="Ví dụ: pubweb.vn/tinngoaiweb/vu-an-hinh-su ; vu-an-hinh-su là từ được nhập" value='@if(isset($datan)){{$datan->newsSlug}}@endif' class="longinput"></span>
            </p>

            <p class="stdformbutton">
                <button class="submit radius2" value="@if(isset($datan))Cập nhật @else Thêm mới @endif ">@if(isset($datan))Cập nhật @else Thêm mới @endif </button>
                <input type="reset" class="reset radius2" value="Làm mới">
            </p>
        </form>
    </div>
</div>
@endsection
