@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ THUỘC TÍNH SẢN PHẨM</h1>
    <span class="pagedesc">Quản lý màu sắc</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Bảng phản hồi</h3>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
            <colgroup>
                <col class="con0" style="width: 3%">
                <col class="con1" style="width: 30%">
                <col class="con0" style="width: 30%">
                <col class="con1" style="width: 27%">
                <col class="con0" style="width: 10%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0 nosort">STT</th>
                    <th class="head1">Tên màu</th>
                    <th class="head0">Mã màu</th>
                    <th class="head1">Thời gian</th>
                    <th class="head0 nosort">Chức năng</th>
                </tr>  
            </thead>
            <tfoot>
                <tr>
                    <th class="head0 ">STT</th>
                    <th class="head1">Tên màu</th>
                    <th class="head0">Mã màu</th>
                    <th class="head1">Thời gian</th>
                    <th class="head0">Chức năng</th>
                </tr> 
            </tfoot>
            <tbody>
                <?php $i = 1; ?>
                @foreach($datacolor as $item)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$item->colorName}}</td>
                    <td>{{$item->colorCode}}<span class="colorselector">
                            <span style="background: {{$item->colorCode}}"></span>
                        </span></td>
                    <td>{{date('d/m/Y h:i:s',$item->time)}}</td>
                    <td>
                        <a href="{{URL::action("ColorController@getEditColor")}}/{{$item->id}}" class="btn btn4 btn_edit " title="Chỉnh sửa"></a>

                        <a href="javascript:void(0)" onclick="xoasanpham(5)" class="btn btn4 btn_trash" title="Xóa"></a>
                    </td>
                </tr>
                <?php $i ++; ?>
                @endforeach
            </tbody>
        </table>


        <div class="contenttitle2">
            <h3>@if(isset($coloredit)) Chỉnh sửa @else Thêm mới @endif</h3>
        </div>
        <form class="stdform stdform2" method="post" action="@if(isset($coloredit)){{URL::action("ColorController@postEditColor")}}@else{{URL::action("ColorController@postAddColor")}}@endif">

            <p>
                <input type="hidden" value="@if(isset($coloredit)){{$coloredit->id}}@endif" name="idcolor"/>
                <label>Tên màu</label>
                <span class="field">
                    <input type="text" name="colorname" id="colorname" placeholder="Nhập tên màu" value="@if(isset($coloredit)){{$coloredit->colorName}}@endif" class="longinput"></span>
            </p>
            <p>
                <label>Mã màu</label>
                <span class="field">
                    <input type="text" name="colorpicker" class="width100" id="colorpicker" value="@if(isset($coloredit)){{$coloredit->colorCode}}@endif">
                    <span id="colorSelector" class="colorselector">
                        <span style="background: @if(isset($coloredit)){{$coloredit->colorCode}}@endif;"></span>
                    </span>
                </span>
            </p>
            <p class="stdformbutton">
                <button class="submit radius2" value=" Thêm mới  ">@if(isset($coloredit)) Cập nhật @else Thêm mới @endif </button>
                <input type="reset" class="reset radius2" value="Làm mới">
            </p>
        </form>
    </div>
</div>
@endsection