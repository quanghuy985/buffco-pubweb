@extends("templateadmin2.mainfire")

@section("contentadmin")

<div class="pageheader notab">
    <h1 class="pagetitle">Nhà sản xuất</h1>
    <span class="pagedesc"> Thêm sửa nhà sản xuất</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Mẫu nhập nhà sản xuất</h3>
        </div>       
        
        
        <form class="stdform stdform2" method="post" action="@if(isset($arrayManuf)) {{URL::action('ManufacturerController@postUpdateManufacturer')}} @else {{URL::action('ManufacturerController@postAddManufaturer')}}@endif">

            <p>
                <input type="hidden" name="idmanuf" id="idmanuf" value="@if(isset($arrayManuf)){{$arrayManuf->id}}@endif"/>
                <input type="hidden" name="status" id="status" value="@if(isset($arrayManuf)){{$arrayManuf->status}}@endif"/>
                
            </p>
            <p>
                <label>Tên nhà sản xuất</label>
                <span class="field"><input type="text" name="manufName" placeholder="Nhập tên nhà sản xuất" value="@if(isset($arrayManuf)){{$arrayManuf->manufacturerName}}@endif" class="longinput"></span>
            </p>

            <p>
                <label>Mô tả</label>
                <span class="field"><input type="text" name="manufDescription" placeholder="Nhập 1 đoạn miêu tả ngắn gọn " value="@if(isset($arrayManuf)){{$arrayManuf->manufacturerDescription}}@endif" class="longinput"></span>
            </p>
            
            <p>
                <label>Nơi sản xuất</label>
                <span class="field"><input type="text" name="manufPlace" placeholder="Nhập địa chỉ" value="@if(isset($arrayManuf)){{$arrayManuf->manufacturerPlace}}@endif" class="longinput"></span>
            </p> 

            <p>
                <label>Trạng thái</label>
                <span class="field">
                    <select name="status">
                        <option value="0" @if(isset($arrayManuf)&& $arrayManuf->status==0)selected@endif >Chờ kích hoạt</option>
                        <option value="1" @if(isset($arrayManuf)&& $arrayManuf->status==1)selected@endif>Kích hoạt</option>
                        <option value="2" @if(isset($arrayManuf)&& $arrayManuf->status==2)selected@endif>Xóa</option>
                    </select>
                </span>
            </p>
            
            <p class="stdformbutton">
                <button class="submit radius2">@if(isset($arrayManuf))Cập nhật @else Thêm mới @endif</button>
                <input type="reset" class="reset radius2" value="Làm lại">
            </p>
        </form>
    </div>
</div>
@endsection
