@extends("backend.template")
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
    jQuery.post("{{URL::action('\BackEnd\ManufacturerController@postDelmulte')}}", {multiid: addon}).done(function(data) {
    window.location = '{{URL::action('\BackEnd\ManufacturerController@getManufactureView')}}';
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
    url: "{{URL::action('\BackEnd\ManufacturerController@postAjaxsearch')}}?keywordsearch=" + jQuery('#searchblur').val(),
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
    url: "{{URL::action('\BackEnd\ManufacturerController@postFillterManufacturer')}}",
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
            url: "{{URL::action('\BackEnd\ManufacturerController@postAjaxpagion')}}?page=" + page,
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
    url: "{{URL::action('\BackEnd\ManufacturerController@postDeleteManufacturer')}}?id=" + id,
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
    url: "{{URL::action('\BackEnd\ManufacturerController@postManufacturerActive')}}?id=" + id + '&status=' + stus,
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
    jQuery("#addManufacture").validate({
    rules: {
    manufName: {
    required: true

    },
            manufDescription: {
            required: true

            },
            manufPlace: {
            required: true
            }


    },
            messages: {
            manufName: {
            required: 'Tên là trường bắt buộc'

            },
                    manufDescription: {
                    required: 'Mô tả là trường bắt buộc'

                    },
                    manufPlace: {
                    required: 'Nơi sản xuất là bắt buộc'
                    },
                    userLastName: {
                    required: 'Vui lòng nhập tên'
                    }

            }
    });
    });</script>
<div class="pageheader notab">
    <h1 class="pagetitle">Nhà sản xuất</h1>
    <span class="pagedesc">Quản lý nhà sản xuất</span>
</div>

<div class="contentwrapper">
    @include('backend.alert')
    <div class="subcontent">

        <div class="contenttitle2">
            <h3>Bảng nhà sản xuất</h3>
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
                <col class="con1" style="width: 20%">
                <col class="con0" style="width: 14%">
                <col class="con1" style="width: 20%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 10%">

            </colgroup>
            <thead>
                <tr>
                    <th class="head0"></th> 
                    <th class="head1">Tên nhà sản xuất</th>
                    <th class="head0">Miêu tả</th>
                    <th class="head1">Nơi sản xuất</th>
                    <th class="head0">Khởi tạo</th>
                    <th class="head1">Tình trạng</th>
                    <th class="head1">Chức năng</th>
                </tr>  
            </thead>

            <tbody id="tableproduct"> 


                @if(isset($arrayManufacturer))
                @foreach($arrayManufacturer as $item)
                <tr> 
                    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td> 
                    <td><label value="manuf">{{str_limit( $item->manufacturerName, 30, '...')}}</label></td> 
                    <td><label value="manuf">{{str_limit( $item->manufacturerDescription, 30, '...')}}</label></td> 
                    <td><label value="manuf">{{str_limit($item->manufacturerPlace, 30, '...')}} </label></td> 
                    <td><label value="manuf"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    <td><label value="manuf">
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
                        <a href="{{URL::action('\BackEnd\ManufacturerController@getManufacturerEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="Chờ kích hoạt"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="Đã kích hoạt"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif
                    </td> 
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="7">{{$link}}</td>
                </tr>
                @endif

                @endif
            </tbody>
        </table>

        <div class="contenttitle2" id="editManuf">
            <h3>Thêm/Sửa nhà sản xuất</h3>
        </div>
        @if(isset($arrayManuf))
        <script>jQuery(document).ready(function() {
            jQuery('html, body').animate({scrollTop: jQuery("#addManufacture").offset().top}, 1000);
            })</script>
        {{Form::model($arrayManuf, array('action'=>'\BackEnd\ManufacturerController@postUpdateManufacturer','class'=>'stdform stdform2', 'id'=>'addManufacture'))}}
        @else
        {{Form::open(array('action'=>'\BackEnd\ManufacturerController@postAddManufaturer','class'=>'stdform stdform2', 'id'=>'addManufacture'))}}
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

        <p>
            <label>Trạng thái</label>
            <span class="field">
                <?php
                $data_status = Lang::get('general.user_status');
                echo Form::select('status', $data_status);
                ?>
            </span>
        </p>

        <p class="stdformbutton">
            <button class="submit radius2">@if(isset($arrayManuf))Cập nhật @else Thêm mới @endif</button>
            <input type="reset" class="reset radius2" value="Làm lại">
        </p>
        {{Form::close()}}
    </div>
</div>
@endsection

