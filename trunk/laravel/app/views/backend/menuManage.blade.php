@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
    var request = jQuery.ajax({
    url: "{{URL::action('MenuController@postAjaxpagion')}}?page=" + page,
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
    url: "{{URL::action('MenuController@postDeleteMenu')}}?id=" + id,
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
    url: "{{URL::action('MenuController@postMenuActive')}}?id=" + id + '&status=' + stus,
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
    <h1 class="pagetitle">QUẢN LÝ MENU</h1>
    <span class="pagedesc">Quản lý thanh menu</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Bảng Menu</h3>
    </div>
    <div class="contentwrapper">
        <div class="subcontent">
            @if(isset($thongbao))
            <div class="notibar msgalert">
                <a class="close"></a>
                <p>{{$thongbao}}</p>
            </div>
            @endif
            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>
                    <col class="con1" style="width: 5%">
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 15%">
                    <col class="con1" style="width: 10%">
                    <col class="con0" style="width: 10%">
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1">ID</th>
                        <th class="head0">Tên Menu</th>
                        <th class="head1">Đường dẫn</th>
                        <th class="head0">Parent</th>
                        <th class="head1">Vị trí</th>
                        <th class="head0">Khởi tạo</th>
                        <th class="head1">Tình trạng</th>
                        <th class="head0">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct">
                    @foreach($arrayMenu as $item)
                    <tr> 

                        <td><label value="cateMenuer">{{$item->id }}</label></td> 
                        <td><label value="cateMenuer">@if($item->menuParent !=0) ---- @endif {{str_limit( $item->menuName, 30, '...')}}</label></td> 
                        <td><label value="cateMenuer">{{str_limit($item->menuURL , 30, '...')}}</label></td>
                        <td><label value="cateMenuer">{{str_limit($item->menuParent , 30, '...')}}</label></td> 
                        <td><label value="cateMenuer">{{str_limit($item->menuPosition, 30, '...')}} </label></td>
                        <td><label value="cateMenuer"><?php echo date('d/m/Y h:i:s', $item->menuTime); ?></label></td> 
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

                            <a href="{{URL::action('MenuController@getMenuEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
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
    <form class="stdform stdform2" method="post" action="@if(isset($menuData)) {{URL::action('MenuController@postUpdateMenu')}} @else {{URL::action('MenuController@postAddMenu')}}@endif">

        <p>
            <input type="hidden" name="idMenu" id="idnews" value="@if(isset($menuData)){{$menuData->id}}@endif"/>
            <label>Tên Menu</label>
            <span class="field"><input type="text" name="menuName" placeholder="Nhập tên menu" value="@if(isset($menuData)){{$menuData->menuName}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Đường dẫn</label>
            <span class="field"><input type="text" name="menuURL" placeholder="Nhập đường dẫn" value="@if(isset($menuData)){{$menuData->menuURL}}@endif" class="longinput"></span>
        </p>

        <p>
            <label>Menu Cha</label>
            <span class="field">
                <select name="menuParent" id="selection2">
                    <option value="0">không</option>
                    <?php
                    foreach ($arrayMenu as $item) {
                        if ($item->menuParent == 0) {
                            $selec = '';
                            if (isset($menuData) && $item->id == $menuData->menuParent) {
                                $selec = 'selected';
                            }
                            echo '<option value="' . $item->id . '" ' . $selec . '> ' . $item->menuName . '</option>';
//                            foreach ($arrayMenu as $item1) {
//                                if ($item1->menuParent == $item->id) {
//                                    $selec1 = '';
//                                    if (isset($menuData) && $item1->id == $menuData->menuID) {
//                                        $selec1 = 'selected';
//                                    }
//                                    echo '<option value="' . $item1->id . '" ' . $selec1 . '>-- ' . $item1->menuName . '</option>';
//                                }
//                            }
                        }
                    }
                    ?>

                </select>
            </span>
        </p>
        <p>
            <label>Vị trí</label>
            <span class="field"><input type="text" name="menuPosition" placeholder="Nhập vị trí" value="@if(isset($menuData)){{$menuData->menuPosition}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status">
                    <option value="0" @if(isset($menuData)&& $menuData->status==0)selected@endif >Chờ kích hoạt</option>
                    <option value="1" @if(isset($menuData)&& $menuData->status==1)selected@endif>Kích hoạt</option>
                    <option value="2" @if(isset($menuData)&& $menuData->status==2)selected@endif>Xóa</option>
                </select>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($menuData))Cập nhật @else Thêm mới @endif ">@if(isset($menuData))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới">
        </p>
    </form>
</div>
@endsection
