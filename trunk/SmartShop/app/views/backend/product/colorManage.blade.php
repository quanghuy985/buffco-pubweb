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
        jQuery("#color-form").validate({
            rules: {
                color_name: {required: true},
                color_code: {required: true},
            }
        });
    });

</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ MÀU SẮC SẢN PHẨM</h1>
    <span class="pagedesc">Quản lý màu sắc</span>
</div>
<div class="contentwrapper">
    <div class="two_fifth">
        <div class="contenttitle2">
            <h3>Bảng thêm và chỉnh sửa</h3>
        </div>
        @if(isset($colorEdit)) <a class="btn btn_orange btn_link" href="{{action('\BackEnd\ProductController@getColorView')}}"><span>Thêm mới</span></a>        @endif
        @include('backend.alert')
        @if(isset($colorEdit))
        {{Form::model($colorEdit, array('action'=>'\BackEnd\ProductController@postEditColor', 'class'=>'stdform','id'=>'color-form'))}}
        @else
        {{Form::open(array('action'=>'\BackEnd\ProductController@postAddColor', 'class'=>'stdform','id'=>'color-form'))}}
        @endif
        {{Form::hidden('id')}}
        <p>
            {{Form::hidden('id')}}
            <label>Tên màu</label>
            <span class="field">
                {{Form::text('color_name', null, array('class'=>'longinput', 'id'=>'color_name', 'placeholder'=>Lang::get('placeholder.product_cateName')))}}
            </span>
        </p>
        <p>
            <label>Mã màu</label>
            <span class="field">
                <span id="colorSelector" class="colorselector">
                    <span style="background-color: <?php
                    if (isset($colorEdit)) {
                        echo $colorEdit->color_code;
                    }
                    ?>"></span>
                </span>
                {{Form::text('color_code', null, array('class'=>'width100', 'id'=>'colorpicker','style'=>' margin-left: 35px;', 'placeholder'=>Lang::get('placeholder.product_cateName')))}}

            </span><!--field-->
        </p>       
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($colorEdit))Cập nhật @else Thêm mới @endif ">@if(isset($colorEdit))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới" >      
        </p>
        {{Form::close()}}
    </div>
    <div class="three_fifth">
        <div class="contenttitle2">
            <h3>Bảng màu sắc sản phẩm</h3>
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
                    <col style="width: 25%" class="con1">
                    <col style="width: 25%" class="con0">
                    <col style="width: 20%" class="con1">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head0">Tên</th>
                        <th class="head1">Mã màu</th>
                        <th class="head0">Hiển thị</th>
                        <th class="head1">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct" class="tabledataajax">
                    @include('backend.product.colorAjax')
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
