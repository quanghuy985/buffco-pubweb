@extends("templatebackend.admin")
@section("titlepage")
SẢN PHẨM
@endsection
@section("contentadmin")
<article class="module width_full">
    <header>
        <h3>Thếm mới sản phẩm</h3>
    </header>
    <form method="post" action="{{Asset('/')}}">
        <div class="module_content">
            <fieldset>
                <label>Tên sản phẩm</label>
                <input type="text" name="productname" placeholder="Nhập trên sản phẩm">
            </fieldset>
            <fieldset>
                <label>Ảnh sản phẩm</label>
                <input type="file" name="productimg">
                <input type="button" value="Tải lên" class="alt_btn">
            </fieldset>
            <fieldset>
                <label style="float: none;">Chi tiết sản phẩm</label>
            </fieldset>
            <textarea class="ckeditor" rows="5" name="productdes" placeholder="Nhập chi tiết sản phẩm"></textarea>

            <fieldset>
                <label>Giá sản phẩm</label>
                <input type="text" name="productprice" style="width: 24%;" placeholder="Nhập giá sản phẩm">
                <label>Giá khuyến mãi</label>
                <input type="text" name="productprom"  style="width: 24%;" placeholder="Nhập giá khuyến mại">
            </fieldset>
            <fieldset>
                <label>Link demo</label>
                <input type="text" name="producturldemo" placeholder="Nhập link demo sản phẩm ">
            </fieldset>
            <fieldset>
                <label>Version</label>
                <input type="text" name="productversion" placeholder="Nhập version sản phẩm"> 
            </fieldset>


        </div>
        <footer>
            <div class="submit_link">
                <input type="submit" value="Thêm mới" class="alt_btn">
                <input type="submit" value="Làm mới" class="alt_btn">
            </div>
        </footer>
    </form>
</article>
@endsection