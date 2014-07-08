@extends("backend.template")
@section("contentadmin")
<style>
    .stdform label {
        float: left;
        padding: 5px 20px 0 0;
        text-align: right;
        width: 35%;
    }
    .stdform span.field, .stdform div.field {
        display: block;
        margin-left: 35%;
        position: relative;
    }
    .three_fifth {
        width: 55.9%;
    }
</style>
<script>
    function toSlug(e) {
        var str = e.value;
        if (str != '') {
        str = str.toLowerCase(); 
                str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
                str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
                str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
                str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
                str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
                str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
                str = str.replace(/đ/g, "d");
                str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, "-");
                str = str.replace(/-+-/g, "-"); 
                str = str.replace(/^\-+|\-+$/g, ""); 
                document.getElementById("cateSlug").value = str;
        }
    }
    jQuery(document).ready(function() {
        jQuery("#edit-cat-products").validate({
            rules: {
                cateName: {required: true},
                cateSlug: {required: true},
            }
        });
    });
</script>

<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ DANH MỤC SẢN PHẨM</h1>
    <span class="pagedesc">Quản lý danh mục</span>
</div>
<div class="contentwrapper">
    <div class="two_fifth">
        <div class="contenttitle2">
            <h3>Bảng thêm và chỉnh sửa</h3>
        </div>
        @if(isset($cateProductData)) <a class="btn btn_orange btn_link" href="{{action('\BackEnd\CategoryProductController@getCateProductView')}}"><span>Thêm mới</span></a>        @endif
        @include('backend.alert')
        @if(isset($cateProductData))
        {{Form::model($cateProductData, array('action'=>'\BackEnd\CategoryProductController@postUpdateCateProduct', 'class'=>'stdform','id'=>'edit-cat-products' ))}}
        @else
        {{Form::open(array('action'=>'\BackEnd\CategoryProductController@postAddCateProduct', 'class'=>'stdform', 'id'=>'edit-cat-products'))}}
        @endif
        <p>
            {{Form::hidden('id')}}
            <label>Tên danh mục sản phẩm</label>
            <span class="field">
                {{Form::text('cateName', null, array('class'=>'longinput', 'id'=>'cateName', 'placeholder'=>Lang::get('placeholder.product_cateName'),"onkeyup"=>"toSlug(this)", "onchange"=>"toSlug(this)"))}}
            </span>
        </p>
        <p>
            <label>Danh mục Cha</label>
            <span class="field">
                {{Form::select('cateParent',$listcate)}}
            </span>
        </p>
        <p>
            <label>Đường dẫn</label>
            <span class="field">
                {{Form::text('cateSlug', null, array('class'=>'longinput', 'id'=>'cateSlug', 'placeholder'=>Lang::get('placeholder.product_cateName'), "onchange"=>"toSlug(this)"))}}     
            </span>
        </p>       
        <p>
            <label>Mô tả</label>
            <span class="field">
                <textarea  id="cateDescription" rows="5" name="cateDescription" placeholder="Nhập mô tả">@if(isset($cateProductData)){{$cateProductData->cateDescription}}@endif</textarea>                
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($cateProductData))Cập nhật @else Thêm mới @endif ">@if(isset($cateProductData))Cập nhật @else Thêm mới @endif </button>
            @if(isset($cateProductData))
            <input type="reset" class="reset radius2" value="Làm mới" >      
            @endif
        </p>
        {{Form::close()}}
    </div>
    <div class="three_fifth">
        <div class="contenttitle2">
            <h3>Bảng danh mục sản phẩm</h3>
        </div>  
        <div class="subcontent">
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb" style="margin-top: 20px">
                <colgroup>
                    <col style="width: 30%" class="con0">
                    <col style="width: 25%" class="con1">
                    <col style="width: 25%" class="con0">
                    <col style="width: 20%" class="con1">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head0">Tên</th>
                        <th class="head1">Mô tả</th>
                        <th class="head0">Đường dẫn tĩnh</th>
                        <th class="head1">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct" class="tabledataajax">
                    @foreach($arrCateProduct as $item)
                    <tr> 
                        <td><label value="cateMenuer">@if($item->cateParent!=0) — @endif @if($item->cateParent==0) <strong> @endif{{ $item->cateName}} @if($item->cateParent==0) </strong> @endif</label></td> 
                        <td><label value="cateMenuer">{{str_limit($item->cateDescription , 30, '...')}}</label></td>
                        <td><label value="cateMenuer">{{$item->cateSlug}}</label></td> 
                        <td>
                            <a href="{{URL::action('\BackEnd\CategoryProductController@getCateProductEdit')}}/{{$item->id}}"  title="Sửa"> Sửa</a>
                            &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})"title="Xóa">Xóa</a>

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

</div>
@endsection
