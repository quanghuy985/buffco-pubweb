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
                <col class="con1" style="width: 24%">
                <col class="con0" style="width: 24%">
                <col class="con1" style="width: 24%">
                <col class="con0" style="width: 25%">
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
                    <td>{{$item->colorCode}}</td>
                    <td>{{$item->time}}</td>
                    <td>A</td>
                </tr>
                <?php $i ++; ?>
                @endforeach
            </tbody>
        </table>


        <div class="contenttitle2">
            <h3>Thêm mới</h3>
        </div>
        <form class="stdform stdform2" method="post" action="{{URL::action("ColorController@postAddColor")}}">

            <p>
                <label>Tên màu</label>
                <span class="field">
                    <input type="text" name="colorname" id="colorname" placeholder="Nhập tên màu" value="" class="longinput"></span>
            </p>
            <p>
                <label>Mã màu</label>
                <span class="field">
                    <input type="text" name="colorpicker" class="width100" id="colorpicker">
                    <span id="colorSelector" class="colorselector">
                        <span></span>
                    </span>
                </span>
            </p>
            <p>
                <label>Trạng thái</label>
                <span class="field">
                    <select name="status">
                        <option value="0">Chờ kích hoạt</option>
                        <option value="1">Kích hoạt</option>
                        <option value="2">Xóa</option>
                    </select>
                </span>
            </p>
            <p class="stdformbutton">
                <button class="submit radius2" value=" Thêm mới  "> Thêm mới  </button>
                <input type="reset" class="reset radius2" value="Làm mới">
            </p>
        </form>
    </div>
</div>
@endsection