@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader">
    <h1 class="pagetitle">QUẢN LÝ SẢN PHẨM</h1>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Thêm mới</h3>
        </div>

        <form class="stdform stdform2" method="post" action="{{Asset('/upload/upload')}}" accept-charset="UTF-8" enctype="multipart/form-data">
            <p>
                <label>Tên sản phẩm</label>
                <span class="field">
                    <input type="text" name="productname" placeholder="Nhập trên sản phẩm" class="longinput">
                </span>
            </p>
            <p>
                <label>Nhóm sản phẩm</label>
                <span class="field">
                    <select name="categoryproduct" id="selection2">
                        <option value="">Mời bạn chọn</option>
                        <option value="1">Selection One</option>
                        <option value="2">Selection Two</option>
                        <option value="3">Selection Three</option>
                        <option value="4">Selection Four</option>
                    </select>
                </span>
            </p>
            <p>
                <label>Ảnh sản phẩm</label>
                <span class="field">
                    <input type="file" name="fileupload" id="fileupload" class="longinput" >
                </span>
            </p>

            <p>
                <label>Chi tiết sản phẩm</label>
                <span class="field">
                    <textarea class="ckeditor" rows="5" name="productdes" placeholder="Nhập chi tiết sản phẩm"></textarea>
                </span>
            </p>

            <p>
                <label>Giá sản phẩm </label>
                <span class="field">
                    <input type="text" name="productprice"  placeholder="Nhập giá sản phẩm" class="smallinput">
                </span>
            </p>
            <p>
                <label>Giá khuyến mãi </label>
                <span class="field">
                    <input type="text" name="productprom"   placeholder="Nhập giá khuyến mại" class="smallinput">
                </span>
            </p>
            <p>
                <label>Link demo</label>
                <span class="field">
                    <input type="text" name="producturldemo" placeholder="Nhập link demo sản phẩm " class="longinput">
                </span>
            </p>
            <p>
                <label>Version</label>
                <span class="field">
                    <input type="text" name="productversion" placeholder="Nhập version sản phẩm" class="smallinput"> 
                </span>
            </p>  
            <p class="stdformbutton">
                <button class="submit radius2">Thêm mới</button>
                <input type="reset" class="reset radius2" value="Làm lại">
            </p>
        </form>
    </div>
</div>
@endsection