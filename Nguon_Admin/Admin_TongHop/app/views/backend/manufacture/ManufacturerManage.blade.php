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
    .tableoptions{
        margin-top: 20px;
    }
</style>
<script>
    jQuery(document).ready(function() {
        jQuery("#addManufacture").validate({
            rules: {
                manufacturerName: {
                    required: true

                },
                manufDescription: {
                    required: true
                },
                manufacturerPlace: {
                    required: true
                }
            }
        });
    });</script>
<div class="pageheader notab">
    <h1 class="pagetitle">Nhà sản xuất</h1>
    <span class="pagedesc">Quản lý nhà sản xuất</span>
</div>
<div class="contentwrapper">
    <div class="two_fifth">
        <div class="contenttitle2" id="editManuf">
            <h3>Thêm/Sửa nhà sản xuất</h3>
        </div>
        @include('backend.alert')
        @if(isset($arrayManuf))
        {{Form::model($arrayManuf, array('action'=>'\BackEnd\ProductController@postUpdateManufacturer','class'=>'stdform ', 'id'=>'addManufacture'))}}
        @else
        {{Form::open(array('action'=>'\BackEnd\ProductController@postAddManufaturer','class'=>'stdform', 'id'=>'addManufacture'))}}
        @endif
        <p>
            {{Form::hidden('id')}}
            {{Form::hidden('status')}}
        </p>
        <p>
            <label>Tên nhà sản xuất</label>
            <span class="field">
                {{Form::text('manufacturerName', null, array('id'=>'manufacturerName', 'class'=>'longinput','placeholder'=>Lang::get('placeholder.manu_name')))}}
            </span>
        </p>
        <p>
            <script type="text/javascript">

                function BrowseServer() {
                    var finder = new CKFinder();
                    finder.basePath = '../';
                    finder.selectActionFunction = SetFileField;
                    finder.popup();
                }
                function SetFileField(fileUrl) {
                    document.getElementById('xFilePath').value = fileUrl;
                }

            </script>
            <label>Logo nhà sản xuât</label>
            <span class="field">
                {{Form::text('manufacturerLogo', null, array('placeholder'=>Lang::get('placeholder.filePath'),'id'=>'xFilePath', 'class'=>'smallinput'))}}
                <input type="button" class="stdbtn btn_orange" value="{{Lang::get('button.upload')}}" onclick="BrowseServer();" />
            </span>
        </p>
        <p>
            <label>Mô tả</label>
            <span class="field">                    
                <textarea id="des" style="resize: vertical;" rows="5" name="manufDescription" class="longinput">@if(isset($arrayManuf)){{$arrayManuf->manufacturerDescription}}@endif</textarea>
            </span>
        </p>

        <p>
            <label>Nơi sản xuất</label>
            <span class="field">
                {{Form::text('manufacturerPlace', null, array('id'=>'manufacturerPlace', 'class'=>'longinput','placeholder'=>Lang::get('placeholder.address')))}}
            </span>
        </p> 
        <p class="stdformbutton">
            <button class="submit radius2">@if(isset($arrayManuf))Cập nhật @else Thêm mới @endif</button>
            <input type="reset" class="reset radius2" value="Làm lại">
        </p>
        {{Form::close()}}
    </div>
    <div class="three_fifth">
        <div class="contenttitle2">
            <h3>Bảng nhà sản xuất</h3>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb" style="margin-top: 20px;">
            <colgroup>
                <col class="con0" style="width: 2%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 25%">
                <col class="con1" style="width: 25%">
                <col class="con0" style="width: 20%">
                <col class="con1" style="width: 18%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0">{{Lang::get('general.stt')}}</th> 
                    <th class="head1">{{Lang::get('general.product.img')}}</th>
                    <th class="head0">Tên nhà sản xuất</th>
                    <th class="head1">Nơi sản xuất</th>
                    <th class="head0">Khởi tạo</th>
                    <th class="head1">Chức năng</th>
                </tr>  
            </thead>

            <tbody id="tableproduct" class="tabledataajax">
                @include('backend.manufacture.Manufacturerajax')
            </tbody>
        </table>
    </div>
</div>

@endsection

