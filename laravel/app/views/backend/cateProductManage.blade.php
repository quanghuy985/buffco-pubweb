@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
    var request = jQuery.ajax({
    url: "{{URL::action('cateProductController@postAjaxpagion')}}?page=" + page,
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
    url: "{{URL::action('cateProductController@postDeleteCateProduct')}}?id=" + id,
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
    url: "{{URL::action('cateProductController@postCateProductActive')}}?id=" + id + '&status=' + stus,
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
    <h1 class="pagetitle">QUẢN LÝ DANH MỤC SẢN PHẨM</h1>
    <span class="pagedesc">Quản lý danh mục</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Bảng danh mục sản phẩm</h3>
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
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 10%">
                    <col class="con1" style="width: 15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="head1">ID</th>
                        <th class="head0">Tên danh mục</th>
                        <th class="head1">Parent</th>
                        <th class="head0">Đường dẫn</th>
                        <th class="head1">Khởi tạo</th>
                        <th class="head0">Tình trạng</th>
                        <th class="head1">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct">
                    @foreach($arrayCateProduct as $item)
                    <tr> 

                        <td><label value="cateMenuer">{{$item->id }}</label></td> 
                        <td><label value="cateMenuer">@if($item->cateParent!=0) -- @endif {{str_limit( $item->cateName, 30, '...')}}</label></td> 
                        <td><label value="cateMenuer">{{str_limit($item->cateParent , 30, '...')}}</label></td>
                        <td><label value="cateMenuer">{{str_limit($item->cateSlug , 30, '...')}}</label></td> 
                        <td><label value="cateMenuer"><?php echo date('d/m/Y h:i:s', $item->cateTime); ?></label></td> 
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

                            <a href="{{URL::action('cateProductController@getCateProductEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
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
                        <td colspan="7">{{$link}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    <div class="contenttitle2">
        <h3>Bảng thêm và chỉnh sửa</h3>
    </div>
    <form class="stdform stdform2" method="post" action="@if(isset($cateProductData)) {{URL::action('cateProductController@postUpdateCateProduct')}} @else {{URL::action('cateProductController@postAddCateProduct')}}@endif">

        <p>
            <input type="hidden" name="cateProductID" id="idnews" value="@if(isset($cateProductData)){{$cateProductData->id}}@endif"/>
            <label>Tên danh mục sản phẩm</label>
            <span class="field"><input type="text" name="cateName" placeholder="Nhập tên danh mục sản phẩm" value="@if(isset($cateProductData)){{$cateProductData->cateName}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Danh mục Cha</label>
            <span class="field">
                <select name="cateParent" id="selection2">
                    <option value="0">không</option>
                    <?php
                    foreach ($arrayCateProduct as $item) {
                        if ($item->cateParent == 0) {
                            $selec = '';
                            if (isset($cateProductData) && $item->id == $cateProductData->cateParent) {
                                $selec = 'selected';
                            }
                            echo '<option value="' . $item->id . '" ' . $selec . '> ' . $item->cateName . '</option>';
//                            foreach ($arrayMenu as $item1) {
//                                if ($item1->menuParent == $item->id) {
//                                    $selec1 = '';
//                                    if (isset($cateProductData) && $item1->id == $cateProductData->menuID) {
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
            <label>Đường dẫn</label>
            <span class="field"><input type="text" name="cateSlug" placeholder="Nhập đường dẫn" value="@if(isset($cateProductData)){{$cateProductData->cateSlug}}@endif" class="longinput"></span>
        </p>
        <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status">
                    <option value="0" @if(isset($cateProductData)&& $cateProductData->status==0)selected@endif >Chờ kích hoạt</option>
                    <option value="1" @if(isset($cateProductData)&& $cateProductData->status==1)selected@endif>Kích hoạt</option>
                    <option value="2" @if(isset($cateProductData)&& $cateProductData->status==2)selected@endif>Xóa</option>
                </select>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2" value="@if(isset($cateProductData))Cập nhật @else Thêm mới @endif ">@if(isset($cateProductData))Cập nhật @else Thêm mới @endif </button>
            <input type="reset" class="reset radius2" value="Làm mới">
        </p>
    </form>
</div>
@endsection
