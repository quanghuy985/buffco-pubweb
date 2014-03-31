@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
    var request = jQuery.ajax({
    url: "{{URL::action('SupporterGroupController@postAjaxpagion')}}?page=" + page,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
    }
    function xoasanpham(id) {
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('SupporterGroupController@postDeleteSupporterGroup')}}?id=" + id,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
            return true;
    } else {
    return false;
    }
    })
    }
    function kichhoat(id, stus) {
    var request = jQuery.ajax({
    url: "{{URL::action('SupporterGroupController@postSupporterGroupActive')}}?id=" + id + "&status=" + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);     
             jQuery('#messages1').empty().html(" <div class='notibar msgsuccess'><a class='close'></a><p>Cập nhật thành công.</p> </div>"); 
        });
            return true;
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ NHÓM HỖ TRỢ VIÊN</h1>
    <span class="pagedesc">Quản lý nhóm hỗ trợ viên</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Nhóm hỗ trợ viên</h3>
    </div>
    <div class="contentwrapper">
        <div class="subcontent">
             <div id="messages1">
            @if(isset($thongbao))
            <div class="notibar msgalert">
                <a class="close"></a>
                <p>{{$thongbao}}</p>
            </div>
            @endif
             </div>
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con1" style="width: 5%">
                    <col class="con0" style="width: 25%">
                    <col class="con1" style="width: 25%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 25%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1">ID</th>
                        <th class="head0">Tên nhóm</th>
                        <th class="head1">Khởi tạo</th>
                        <th class="head0">Tình trạng</th>
                        <th class="head1">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct">
                    @foreach($arrSupporterGroup as $item)
                    <tr> 

                        <td><label value="cateMenuer">{{$item->id }}</label></td> 
                        <td><label value="cateMenuer">{{str_limit( $item->supporterGroupName, 30, '...')}}</label></td>
                        <td><label value="cateMenuer"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td> 
                        <td><label value="cateMenuer"><?php
                                if ($item->status == 0) {
                                    echo "chờ kích hoạt";
                                } else if ($item->status == 1) {
                                    echo "đã kích hoạt";
                                } else if ($item->status == 2) {
                                    echo "đã xóa";
                                }
                                ?>
                            </label>
                        </td> 
                        <td>

                            <a href="{{URL::action('SupporterGroupController@getSupporterGroupEdit')}}?id={{$item->id}}&#frmEdit" class="btn btn4 btn_book" title="Sửa"></a>
                            @if($item->status=='2')
                            <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="Khởi tạo"></a>
                            @endif
                            @if($item->status=='0')
                            <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="Kích hoạt"></a>
                            @endif
                            @if($item->status!='2')
                            <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                            @endif

                        </td> 
                    </tr> 
                    @endforeach
                    @if($link!='')
                    <tr>
                        <td colspan="4">{{$link}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    <div class="contenttitle2">
        <h3>Bảng thêm và chỉnh sửa</h3>
    </div>
    <a name="frmEdit"></a>
    <form class="stdform stdform2" method="post" action="@if(isset($SupporterGroupData)) {{URL::action('SupporterGroupController@postUpdateSupporterGroup')}} @else {{URL::action('SupporterGroupController@postAddSupporterGroup')}}@endif">

        <p>
            <input type="hidden" name="id" id="idnews" value="@if(isset($SupporterGroupData)){{$SupporterGroupData->id}}@endif"/>
            <label>Tên nhóm hỗ trợ viên</label>
            <span class="field"><input type="text" name="supporterGroupName" placeholder="Nhập tên nhóm hỗ trợ viên" value="@if(isset($SupporterGroupData)){{$SupporterGroupData->supporterGroupName}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status">
                    <option value="0" @if(isset($SupporterGroupData)&& $SupporterGroupData->status==0)selected@endif >Chờ kích hoạt</option>
                    <option value="1" @if(isset($SupporterGroupData)&& $SupporterGroupData->status==1)selected@endif>Kích hoạt</option>
                    <option value="2" @if(isset($SupporterGroupData)&& $SupporterGroupData->status==2)selected@endif>Xóa</option>
                </select>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($SupporterGroupData))Cập nhật @else Thêm mới @endif ">@if(isset($SupporterGroupData))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới">
        </p>
    </form>
</div>

@endsection

