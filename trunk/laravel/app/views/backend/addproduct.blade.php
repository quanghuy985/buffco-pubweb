@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ SẢN PHẨM</h1>
    <span class="pagedesc">Thêm sửa xóa sản phẩm</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        @if(isset($thongbao))
        <div class="notibar msgsuccess">
            <a class="close"></a>
            <p>{{$thongbao}}</p>
        </div>
        @endif
        <div class="contenttitle2">
            <h3>Thêm mới</h3>
        </div>

        <form class="stdform stdform2" method="post" action="@if(isset($dataedit)){{URL::action('ProductController@postEditProduct')}} @else {{URL::action('ProductController@postAddProduct')}} @endif" accept-charset="UTF-8" enctype="multipart/form-data">

            <p>
                <label>Tên sản phẩm</label>
                <span class="field">
                    <input type="hidden" name="idpro" value="@if(isset($dataedit)){{$dataedit->id}}@endif"/>
                    <input type="text" name="productname" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($dataedit)){{$dataedit->productName}}@endif">
                </span>
            </p>
            <p>
                <label>Nhóm sản phẩm</label>
                <span class="field">
                    <select name="categoryproduct" id="selection2">
                        <?php
                        foreach ($catproduct as $item) {
                            if ($item->cateParent == 0) {
                                $selec = '';
                                if (isset($dataedit) && $item->id == $dataedit->cateID) {
                                    $selec = 'selected';
                                }

                                echo '<option value="' . $item->id . '" ' . $selec . '> ' . $item->cateName . '</option>';
                                foreach ($catproduct as $item1) {
                                    if ($item1->cateParent == $item->id) {
                                        $selec1 = '';
                                        if (isset($dataedit) && $item1->id == $dataedit->cateID) {
                                            $selec1 = 'selected';
                                        }
                                        echo '<option value="' . $item1->id . '" ' . $selec1 . '>-- ' . $item1->cateName . '</option>';
                                    }
                                }
                            }
                        }
                        ?>

                    </select>
                </span>
            </p>
            <p>
                <label>Ảnh sản phẩm</label>
                <span class="field">
                    <input type="file" name="fileupload" id="fileupload" class="longinput" >
                    @if(isset($dataedit))
                    <br/>
                    <img src="{{Asset('timthumb.php')}}?src={{Asset($dataedit->productUrlImage)}}&w=100&h=100&zc=0&q=70" />
                    @endif
                </span>
            </p>

            <p>
                <label>Chi tiết sản phẩm</label>
                <span class="field">
                    <textarea class="ckeditor" rows="5" name="productdes" placeholder="Nhập chi tiết sản phẩm">@if(isset($dataedit)){{$dataedit->productDescription}}@endif</textarea>
                </span>
            </p>

            <p>
                <label>Giá sản phẩm </label>
                <span class="field">
                    <input type="text" name="productprice"  placeholder="Nhập giá sản phẩm" class="smallinput" value="@if(isset($dataedit)){{$dataedit->productPrice}}@endif">
                </span>
            </p>
            <p>
                <label>Giá khuyến mãi </label>
                <span class="field">
                    <input type="text" name="productprom"   placeholder="Nhập giá khuyến mại" class="smallinput" value="@if(isset($dataedit)){{$dataedit->productPromotion}}@endif">
                </span>
            </p>
            <p>
                <label>Link demo</label>
                <span class="field">
                    <input type="text" name="producturldemo" placeholder="Nhập link demo sản phẩm " class="longinput" value="@if(isset($dataedit)){{$dataedit->productUrlDemo}}@endif">
                </span>
            </p>
            <p>
                <label>Slug</label>
                <span class="field">
                    <input type="text" name="productslug" placeholder="Nhập slug sản phẩm" class="smallinput" value="@if(isset($dataedit)){{$dataedit->productSlug}}@endif"> 
                </span>
            </p>
            <p>
                <label>Version</label>
                <span class="field">
                    <input type="text" name="productversion" placeholder="Nhập version sản phẩm" class="smallinput" value="@if(isset($dataedit)){{$dataedit->productVersion}}@endif"> 
                </span>
            </p>  
            @if(isset($dataedit))
            <p>
                <label>Trạng thái</label>
                <span class="field">
                    <select name="status" id="selection2">
                        <option value="0" @if($dataedit->status==0)selected @endif >Chờ đăng</option>
                        <option value="1" @if($dataedit->status==1)selected @endif >Đã đăng</option>
                        <option value="2" @if($dataedit->status==2)selected @endif >Xóa</option>
                    </select>
                </span>
            </p>
            @endif
            <p class="stdformbutton">
                <button class="submit radius2">@if(isset($dataedit))Cập nhật @else Thêm mới @endif</button>
                <input type="reset" class="reset radius2" value="Làm lại">
            </p>
        </form>
    </div>
</div>
@endsection