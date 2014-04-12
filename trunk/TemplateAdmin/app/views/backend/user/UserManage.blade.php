@extends("templateadmin2.mainfire")
@section("contentadmin")

<script>
    
    
    jQuery(document).ready(function() {

    jQuery('.deletepromulti').click(function() {
    var addon = '';
            av = document.getElementsByName("checkboxidfile");
            for (e = 0; e < av.length; e++) {
    if (av[e].checked == true) {
    addon += av[e].value + ',';
    }
    }
    if (addon != '') {
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    jQuery.post("{{URL::action('UserController@postDelmulte')}}", {multiid: addon}).done(function(data) {
    window.location = '{{URL::action('UserController@getUserView')}}';
    });
            return false;
    } else {
    return false;
    }
    });
    } else {
    jAlert('Bạn chưa chọn giá trị', 'Thông báo');
    }
    });
            jQuery('#searchblur').keypress(function(e) {
    // Enter pressed?
    if (e.which == 10 || e.which == 13) {
    var request = jQuery.ajax({
    url: "{{URL::action('UserController@postAjaxsearch')}}?keywordsearch=" + jQuery('#searchblur').val(),
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
    jQuery('#tableproduct').html(msg);
    });
    }
    });
            jQuery("#fillterfunction").click(function() {
    alert(jQuery('#oderbyoption').val());
    });
            jQuery("#loctheotieuchi").click(function() {
    var request = jQuery.ajax({
    url: "{{URL::action('UserController@postFillterUser')}}",
            data: {selectoptionnum: jQuery('#selectoptionnum').val(), oderbyoption: jQuery('#oderbyoption').val(), oderbyoption1: jQuery('#oderbyoption1').val()},
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
    jQuery('#tableproduct').html(msg);
    });
    });
    });
            function phantrang(page) {
            var request = jQuery.ajax({
            url: "{{URL::action('UserController@postAjaxpagion')}}?page=" + page,
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
    url: "{{URL::action('UserController@postDeleteUser')}}?id=" + id,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
    jQuery('#tableproduct').html(msg);
    });
            return false;
    } else {
    return false;
    }
    })
    }

    function kichhoat(id, stus) {
    var request = jQuery.ajax({
    url: "{{URL::action('UserController@postUserActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
    jQuery('#tableproduct').html(msg);
    });
            return true;
    }
</script>
<script>
    jQuery(document).ready(function(){
    jQuery("#addUserForm").validate({
    rules: {
            userEmail: {
                required: true,
                email: true
            },            
            userFirstName: {
                required: true
            },
            userLastName: {
                required: true
            },
            userAddress: {
                required: true
            },
            userPhone: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 11
        }

            },
    messages: {
            userEmail: {
                required: 'Email là trường bắt buộc',
                email: 'Email chưa đúng định dạng'
            },            
            userFirstName: {
                required: 'Vui lòng nhập họ và đệm'
            },
            userLastName: {
                required: 'Vui lòng nhập tên '
            },
            userAddress: {
                required: 'Vui lòng nhập địa chỉ'
            },
            userPhone: {
                required: 'Vui lòng nhập số điện thoại để chúng tôi liên lạc',
                number:'Số điện thoại phải là số',
                minlength: 'Số điện thoại không đúng',
                maxlength: 'Số điện thoại không đúng'
            }
        }
        });
    });
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">Quản lý thành viên</h1>
    <span class="pagedesc">Quản lý thành viên</span>
</div>

<div class="contentwrapper">
    @if(isset($msg))
    <div class="notibar msgalert">
        <a class="close"></a>
        <p>{{$msg}}</p>
    </div>
    @endif
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Bảng quản lý thành viên</h3>
        </div>

        <div class="tableoptions">
            <button class="deletepromulti" title="table1">Xóa đã chọn</button> &nbsp;
            <select class="radius3" name="oderbyoption1" id="oderbyoption1">
                <option value="">Tất cả</option>
                <option value="0">Chờ kích hoạt</option>
                <option value="1">Đã kích hoạt</option>
                <option value="2">Xóa</option>
            </select>&nbsp;
            <button class="radius3" id="loctheotieuchi">Lọc theo tiêu chí</button>
            <div class="dataTables_filter" id="searchformfile"><label>Search: <input id="searchblur" name="searchblur" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;" type="text"></label></div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 3%">
                <col class="con1" style="width: 10%">                                
                <col class="con1" style="width: 10%">
                <col class="con1" style="width: 10%">                
                <col class="con1" style="width: 15%">
                <col class="con1" style="width: 10%">
                <col class="con1" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0"><input type="checkbox" class="checkall" name="checkall" ></th> 
                    <th class="head1">Email</th>
                    <th class="head0">Địa chỉ</th>
                    <th class="head1">Sdt</th>                    
                    <th class="head1">Khởi tạo</th>
                    <th class="head0">Tình trạng</th>
                    <th class="head1">Chức năng</th>
                </tr>  
            </thead>

            <tbody id="tableproduct"> 
                @foreach($arrUser as $item)
                <tr> 
                    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td> 
                    <td><a href="{{URL::action('UserController@getUserDetail')}}?email={{$item->userEmail}}">{{str_limit( $item->userEmail, 10, '...')}}</a></td> 
                    <td><label value="user">{{str_limit( $item->userAddress, 10, '...')}}</label></td>
                    <td><label value="user">{{str_limit($item->userPhone, 10, '...')}} </label></td> 
                    <td><label value="user"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    <td><label value="user">
                            <?php
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
                        <a href="{{URL::action('UserController@getUserEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item -> id}}, 0)" class="btn btn4 btn_flag" title="Chờ kích hoạt"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item -> id}}, 1)" class="btn btn4 btn_world" title="Kích hoạt"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item -> id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif
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

        <div class="contenttitle2" id="editUser">
            <h3>Thêm/Sửa thành viên</h3>
        </div>
        <form class="stdform stdform2" id="addUserForm" method="post" action="@if(isset($arrayUsers)) {{URL::action('UserController@postUpdateUser')}} @else {{URL::action('UserController@postAddUser')}}@endif">

            <p>
                <input type="hidden" name="iduser" id="iduser" value="@if(isset($arrayUsers)){{$arrayUsers->id}}@endif"/>
                <input type="hidden" name="status" id="status" value="@if(isset($arrayUsers)){{$arrayUsers->status}}@endif"/>

            </p>
            <p>
                <label>Email</label>
                <span class="field"><input type="text" name="userEmail" id="userEmail" placeholder="Nhập email" @if(isset($arrayUsers))disabled @endif value="@if(isset($arrayUsers)){{$arrayUsers->userEmail}}@endif" class="longinput"></span>
            </p>

            <p>
                <label>Mật khẩu</label>
                <span class="field"><input type="password" name="userPassword" id="userPassword" placeholder="@if(isset($arrayUsers))Để trống nếu không thay đổi @else Nhập mật khẩu @endif" class="longinput"></span>
            </p>

            <p>
                <label>Firstname</label>
                <span class="field"><input type="text" name="userFirstName" id="userFirstName" placeholder="Nhập họ" value="@if(isset($arrayUsers)){{$arrayUsers->userFirstName}}@endif" class="longinput"></span>
            </p> 
            <p>
                <label>Lastname</label>
                <span class="field"><input type="text" name="userLastName" id="userLastName" placeholder="Nhập tên" value="@if(isset($arrayUsers)){{$arrayUsers->userLastName}}@endif" class="longinput"></span>
            </p> 
            <p>
                <label>Ngày sinh</label>
                <span class="field"><input type="text" name="userDOB" id="datepicker" value="@if(isset($arrayUsers)){{date('d/m/y', $arrayUsers->userDOB)}}@endif" width="100px"></span>
            </p> 
            <p>
                <label>Địa chỉ</label>
                <span class="field"><input type="text" name="userAddress" id="userAddress" placeholder="Nhập địa chỉ" value="@if(isset($arrayUsers)){{$arrayUsers->userAddress}}@endif" class="longinput"></span>
            </p> 
            <p>
                <label>Sdt</label>
                <span class="field"><input type="text" name="userPhone" id="userPhone" placeholder="Nhập sdt" value="@if(isset($arrayUsers)){{$arrayUsers->userPhone}}@endif" class="longinput"></span>
            </p> 
            <p>
                <label>Trạng thái</label>
                <span class="field">
                    <select name="status">
                        <option value="0" @if(isset($arrayUsers)&& $arrayUsers->status==0)selected@endif >Chờ kích hoạt</option>
                        <option value="1" @if(isset($arrayUsers)&& $arrayUsers->status==1)selected@endif>Kích hoạt</option>
                        <option value="2" @if(isset($arrayUsers)&& $arrayUsers->status==2)selected@endif>Xóa</option>
                    </select>
                </span>
            </p>

            <p class="stdformbutton">
                <button class="submit radius2">@if(isset($arrayUsers))Cập nhật @else Thêm mới @endif</button>
                <input type="reset" class="reset radius2" value="Làm lại">
                
            </p>
        </form>
        
    </div>
</div>
@endsection

