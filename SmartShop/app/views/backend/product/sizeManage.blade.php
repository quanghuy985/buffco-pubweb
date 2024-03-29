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

    .stdform .stdformbutton {
        margin-left: 165px  !important;
    }
</style>
<script>

    jQuery(document).ready(function() {
        jQuery("#size-from").validate({
            rules: {
                size_name: {required: true},
                size_description: {required: true},
            }
        });
    });

</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ KÍCH CỠ SẢN PHẨM</h1>
    <span class="pagedesc">Quản lý kích cỡ </span>
</div>
<div class="contentwrapper">
    <div class="two_fifth">
        <div class="contenttitle2">
            <h3>Bảng thêm và chỉnh sửa</h3>
        </div>
        @if(isset($sizeEdit)) <a class="btn btn_orange btn_link" href="{{action('\BackEnd\ProductController@getSizeView')}}"><span>Thêm mới</span></a>        @endif
        @include('backend.alert')
        @if(isset($sizeEdit))
        {{Form::model($sizeEdit, array('action'=>'\BackEnd\ProductController@postEditSize', 'class'=>'stdform','id'=>'size-from' ))}}
        @else
        {{Form::open(array('action'=>'\BackEnd\ProductController@postAddSize', 'class'=>'stdform', 'id'=>'size-from'))}}
        @endif
        {{Form::hidden('id')}}
        <p>
            {{Form::hidden('id')}}
            <label>Tên kich cỡ</label>
            <span class="field">
                {{Form::text('size_name', null, array('class'=>'longinput', 'id'=>'size_name', 'placeholder'=>Lang::get('placeholder.product_cateName')))}}
            </span>
        </p>
        <p>
            <label>Mô tả</label>
            <span class="field">
                {{Form::textarea('size_description', null, array('id'=>'size_description'))}}
            </span>
        </p>       
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($sizeEdit))Cập nhật @else Thêm mới @endif ">@if(isset($sizeEdit))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới" >      
        </p>
        {{Form::close()}}
    </div>
    <div class="three_fifth">
        <div class="contenttitle2">
            <h3>Bảng kích cỡ sản phẩm</h3>
        </div>  
        <div class="subcontent">
            <div id="messages1">
                @if(isset($thongbao))
                <div class="notibar msgalert">
                    <a class="close"></a>
                    <p>{{$thongbao}}</p>
                </div>
                @endif
            </div>
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb" style="margin-top: 20px">
                <colgroup>
                    <col style="width: 30%" class="con0">
                    <col style="width: 50%" class="con1">
                    <col style="width: 20%" class="con0">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head0">Tên</th>
                        <th class="head1">Mô tả</th>
                        <th class="head0">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct" class="tabledataajax">
                    @include('backend.product.sizeAjax')
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
