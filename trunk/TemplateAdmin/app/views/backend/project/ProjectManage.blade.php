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
    jQuery.post("{{URL::action('ProjectController@postDelmulte')}}", {multiid: addon}).done(function(data) {
    window.location = '{{URL::action('ProjectController@getProjectView')}}';
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
    url: "{{URL::action('ProjectController@postAjaxsearch')}}?keywordsearch=" + jQuery('#searchblur').val(),
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
    url: "{{URL::action('ProjectController@postFillterProject')}}",
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
            url: "{{URL::action('ProjectController@postAjaxpagion')}}?page=" + page,
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
    url: "{{URL::action('ProjectController@postDeleteProject')}}?id=" + id,
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
    url: "{{URL::action('ProjectController@postProjectActive')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
            });
            return true;
    }
</script>


<div class="pageheader notab">
    <h1 class="pagetitle">Dự án</h1>
    <span class="pagedesc">Quản lý dự án</span>
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
            <h3>Bảng dự án</h3>
        </div>
            
        <div class="tableoptions">
            <button class="deletepromulti" title="table1">Xóa đã chọn</button> &nbsp;
            <select class="radius3" name="oderbyoption1" id="oderbyoption1">
                <option value="">Tất cả</option>
                <option value="0">Chờ đăng</option>
                <option value="1">Đã đăng</option>
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
                <col class="con0" style="width: 14%">
                <col class="con1" style="width: 20%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 10%">
                
            </colgroup>
            <thead>
                <tr>
                    <th class="head0"><input type="checkbox" class="checkall" name="checkall" ></th> 
                    <th class="head1">Ngày bắt đầu</th>
                    <th class="head1">Ngày kết thúc</th>
                    <th class="head0">Miêu tả</th>
                    <th class="head1">Nội dung</th>
                    <th class="head0">Khởi tạo</th>
                    <th class="head1">Tình trạng</th>
                    <th class="head1">Chức năng</th>
                </tr>  
            </thead>

            <tbody id="tableproduct">    
                @if(isset($arrayProject))
                @foreach($arrayProject as $item)
                <tr> 
                    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td> 
                    <td><label value="project"></label><?php echo date('d/m/Y', $item->from); ?></td> 
                    <td><label value="project"></label><?php echo date('d/m/Y', $item->to); ?></td>
                    <td><label value="project">{{str_limit( $item->projectDescription, 30, '...')}}</label></td> 
                    <td><label value="project">{{str_limit($item->projectContent, 30, '...')}} </label></td> 
                    <td><label value="project"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    <td><label value="project">
                            <?php
                            if ($item->status == 0) {
                                echo "chờ đăng";
                            } else if ($item->status == 1) {
                                echo "đã đăng";
                            } else if ($item->status == 2) {
                                echo "đã xóa";
                            }
                            ?>
                        </label>
                    </td> 
                    <td>
                        <a href="{{URL::action('ProjectController@getProjectEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="Kích hoạt"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="Đăng bài"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif
                    </td> 
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="8">{{$link}}</td>
                </tr>
                @endif
                @endif
                
            </tbody>
        </table>
        
        <div class="contenttitle2" id="editProject">
            <h3>Thêm/Sửa dự án</h3>
        </div>
            
            
        <form class="stdform stdform2" id="addProjectForm" method="post" action="@if(isset($dataProject)) {{URL::action('ProjectController@postUpdateProject')}} @else {{URL::action('ProjectController@postAddProject')}}@endif">

            <p>
                <input type="hidden" name="idproject" id="idproject" value="@if(isset($dataProject)){{$dataProject->id}}@endif"/>
                <input type="hidden" name="status" id="status" value="@if(isset($dataProject)){{$dataProject->status}}@endif"/>
                
            </p>
            <p>
                <label>Ngày bắt đầu</label>
                <span class="field">
                    <input type="text" id="datepicker" name="from" placeholder="From" value="@if(isset($dataProject)){{date('Y-m-d', $dataProject->from)}}@endif" width="100px"/>
                </span>
            </p>
            
            <p>
                <label>Ngày kết thúc</label>
                <span class="field"><input type="text" id="datepicker1" name="to" placeholder="To" value="@if(isset($dataProject)){{date('Y-m-d', $dataProject->to)}}@endif" width="100px"></span>
            </p>

            <p>
                <label>Mô tả dự án</label>
                <span class="field"><textarea cols="80" rows="5" id="description" class="ckeditor" name="description" placeholder="Mô tả dự án">@if(isset($dataProject)){{$dataProject->projectDescription}}@endif</textarea></span>
            </p>
            
            <p>
                <label>Nội dung dự án</label>
                <span class="field"><textarea cols="80" rows="5" id="content" class="ckeditor" name="content" placeholder="Nội dung dự án">@if(isset($dataProject)){{$dataProject->projectContent}}@endif</textarea></span>
            </p>           
            

            <p>
                <label>Trạng thái</label>
                <span class="field">
                    <select name="status">
                        <option value="0" @if(isset($dataProject)&& $dataProject->status==0)selected@endif >Chờ kích hoạt</option>
                        <option value="1" @if(isset($dataProject)&& $dataProject->status==1)selected@endif>Kích hoạt</option>
                        <option value="2" @if(isset($dataProject)&& $dataProject->status==2)selected@endif>Xóa</option>
                    </select>
                </span>
            </p>
            
            <p class="stdformbutton">
                <button class="submit radius2">@if(isset($dataProject))Cập nhật @else Thêm mới @endif</button>
                <input type="reset" class="reset radius2" value="Làm lại">
            </p>
        </form>
    </div>
</div>
@endsection

