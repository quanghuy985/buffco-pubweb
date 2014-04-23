@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
        var request = jQuery.ajax({
            url: "{{URL::action('SupporterController@postAjaxpagion')}}?page=" + page,
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
                    url: "{{URL::action('SupporterController@postDeleteSupporter')}}?id=" + id,
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {
                    jQuery('#tableproduct').html(msg);
                    jQuery('#messages1').empty().html(" <div class='notibar msgsuccess'><a class='close'></a><p>Xóa thành công.</p> </div>");
                });
                return false;
            } else {
                return false;
            }
        })
    }
    function kichhoat(id, stus) {
        var request = jQuery.ajax({
            url: "{{URL::action('SupporterController@postSupporterActive')}}?id=" + id + "&status=" + stus,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            jQuery('#messages1').empty().html(" <div class='notibar msgsuccess'><a class='close'></a><p>Cập nhật thành công.</p> </div>")
            ;
        });
        return true;
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ SUPPORTTER</h1>
    <span class="pagedesc">Quản lý người hỗ trợ</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Bảng supporter</h3>
    </div>
    <div class="contentwrapper">
        <div class="subcontent">
            <div id="messages1">
                @if(isset($thongbaoError))
                <div class="notibar msgalert">
                    <a class="close"></a>
                    <p>{{$thongbaoError}}</p>
                </div>
                @endif
                @if(isset($thongbaoOk))
                <div class="notibar msgsuccess">
                    <a class="close"></a>
                    <p>{{$thongbaoOk}}</p>
                </div>
                @endif
            </div>
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con1" style="width: 3%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 12%">
                    <col class="con1" style="width: 10%">
                    <col class="con0" style="width: 10%">
                    <col class="con0" style="width: 10%">
                    <col class="con1" style="width: 15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1">STT</th>
                        <th class="head0">Hỗ trợ viên</th>
                        <th class="head1">Nhóm hỗ trợ</th>
                        <th class="head0">Nick Yahoo</th>
                        <th class="head1">Nick Skype</th>
                        <th class="head0">Điện thoại</th>                       
                        <th class="head1">Tình trạng</th>
                        <th class="head1">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct">
<?php $i = 1 ?>
                    @foreach($arrSupporter as $item)
                    <tr> 

                        <td><label value="cateSupporter">{{$i++ }}</label></td> 
                        <td><label value="cateSupporter">{{str_limit( $item->supporterName, 30, '...')}}</label></td> 
                        <td><label value="cateSupporter">{{str_limit($item->supporterGroupName , 30, '...')}}</label></td>
                        <td><label value="cateSupporter">{{str_limit($item->supporterNickYH , 30, '...')}}</label></td> 
                        <td><label value="cateSupporter">{{str_limit($item->supporterNickSkype, 30, '...')}} </label></td>
                        <td><label value="cateSupporter">{{str_limit($item->supporterPhone, 30, '...')}} </label></td>                        
                        <td><label value="cateSupporter"><?php
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

                            <a href="{{URL::action('SupporterController@getSupporterEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
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
                    @if(count($arrSupporter)==0)
                    <tr>
                        <td colspan="9">Không có hỗ trợ viên!</td>
                    </tr>
                    @endif
                    @if($link!='')
                    <tr>
                        <td colspan="9">{{$link}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    <div class="contenttitle2">
        <h3>Bảng thêm và chỉnh sửa</h3>
    </div>
    <form id="frmSuport" class="stdform stdform2" method="post" action="@if(isset($supportData)) {{URL::action('SupporterController@postUpdateSupport')}} @else {{URL::action('SupporterController@postAddSupport')}}@endif">

        <p>
            <input type="hidden" name="idSupport" id="idnews" value="@if(isset($supportData)){{$supportData->id}}@endif"/>

            <label>Chọn nhóm hỗ trợ viên</label>
            <span class="field">

                <select name="cbSupportGroup">
                    <?php
                    foreach ($arrSupporterGroup as $item) {
                        echo '<option  value="' . $item->id . '">' . $item->supporterGroupName . '</option>';
                    }
                    ?>
                </select>
            </span>
        </p>
        <p>
            <label>Họ và tên</label>
            <span class="field"><input type="text" required title="Bản phải nhập họ tên" name="supporterName" placeholder="Nhập họ và tên" value="@if(isset($supportData)){{$supportData->supporterName}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Nick Yahoo</label>
            <span class="field"><input type="text" required title="Bản phải nhập nick yahoo" name="supporterNickYH" placeholder="Nhập nick yahoo" value="@if(isset($supportData)){{$supportData->supporterNickYH}}@endif" class="longinput"></span>
        </p>

        <p>
            <label>Nick Skype</label>
            <span class="field"><input type="text" required title="Bản phải nhập nick skype" name="supporterNickSkype" placeholder="Nhập nick skype" value="@if(isset($supportData)){{$supportData->supporterNickSkype}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Số điện thoại</label>
            <span class="field"><input type="number" required name="supporterPhone" title="Bản phải nhập số điện thoại" placeholder="Nhập số điện thoại" value="@if(isset($supportData)){{$supportData->supporterPhone}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status">
                    <option value="0" @if(isset($supportData)&& $supportData->status==0)selected@endif >Chờ kích hoạt</option>
                    <option value="1" @if(isset($supportData)&& $supportData->status==1)selected@endif>Kích hoạt</option>
                    <option value="2" @if(isset($supportData)&& $supportData->status==2)selected@endif>Xóa</option>
                </select>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" type="button" onclick="submitForm()" value="@if(isset($supportData))Cập nhật @else Thêm mới @endif ">@if(isset($supportData))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới">
        </p>
    </form>
    <script>

        function submitForm() {
            var form = jQuery('#frmSuport');
            if (!form.valid()) {
                return false;
            }
            else {
                form.submit();
            }
        }</script>
</div>
@endsection