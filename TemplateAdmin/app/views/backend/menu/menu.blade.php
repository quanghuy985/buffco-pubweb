@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    

    
    function xoasanpham(id) {
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('\BackEnd\MenuController@postDeleteMenu')}}?id=" + id,
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
    url: "{{URL::action('\BackEnd\MenuController@postMenuActive')}}?id=" + id + '&status=' + stus,
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
    jQuery(document).ready(function() {
            jQuery('.external').hide();
            jQuery('#catenews').hide();
            jQuery('#cateproduct').hide();
            jQuery('#internal').hide();
    jQuery('#url').change(function() {
        if (jQuery('#url').val() == '1') {
                jQuery('#internal').hide();
                jQuery('.external').hide();
                jQuery('#catenews').hide();
                jQuery('#cateproduct').hide();
                jQuery('#home').show();
        } else if (jQuery('#url').val() == '2') {
                jQuery('#internal').show();
                jQuery('.external').hide();
                jQuery('#catenews').hide();
                jQuery('#cateproduct').hide();
                jQuery('#home').hide();
        } else if (jQuery('#url').val() == '3') {
                jQuery('#internal').hide();
                jQuery('.external').show();
                jQuery('#catenews').hide();
                jQuery('#cateproduct').hide();
                jQuery('#home').hide();
        } else if (jQuery('#url').val() == '4') {
                jQuery('#internal').hide();
                jQuery('.external').hide();
                jQuery('#catenews').show();
                jQuery('#cateproduct').hide();
                jQuery('#home').hide();
        }else if (jQuery('#url').val() == '5') {
                jQuery('#internal').hide();
                jQuery('.external').hide();
                jQuery('#catenews').hide();
                jQuery('#cateproduct').show();
                jQuery('#home').hide();
        }
    });
            jQuery('#cateproduct').change(function(){
    jQuery("#urlValue").val(jQuery('#cateproduct').val());
    });
            jQuery('#catenews').change(function(){
    jQuery('#urlValue').val(jQuery('#catenews').val());
    });
            jQuery('#parent').change(function(){
    jQuery('#parentvalue').val(jQuery('#parent').val());
            
    });
    
            
            jQuery('#externalValue').change(function(){
    jQuery('#urlValue').val(jQuery('#externalValue').val());
    });
            jQuery('#internal').change(function(){
    jQuery("#urlValue").val(jQuery('#internal').val());
    });
    jQuery('#home').change(function(){
    jQuery("#urlValue").val(jQuery('#home').val());
    });
    
            jQuery("#addMenu").validate({
    rules: {
    menuName: {
    required: true

    },
            urlValue: {
    required: true

    },
            menuParent: {
    required: true,
            number: true
    },
            menuPosition: {
    required: true,
            number: true
    }

    },
            messages: {
    menuName: {
    required: 'Tên là trường bắt buộc'

    },
            urlValue: {
    required: 'Đường dẫn trường bắt buộc'

    },
            menuParent: {
    required: 'Vui lòng nhập parent',
            number: 'Giá trị phải là số'
    },
            menuPosition: {
    required: 'Vui lòng nhập vị trí ',
            number: 'Giá trị phải là số'
    }
    }
    });
    });
</script>
<style>
    form select{
        margin-left:6px;
    }
</style>
<div class="pageheader notab">
    <h1 class="pagetitle">Quản lý menu</h1>
    <span class="pagedesc">Quản lý các menu</span>
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
            <h3>Bảng quản lý menu</h3>
        </div>

        <div class="tableoptions">
           
           
            
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 3%">
                <col class="con0" style="width: 10%">
                <col class="con1" style="width: 15%">
                <col class="con0" style="width: 10%">
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 10%">                
                <col class="con1" style="width: 10%">
                <col class="con0" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head1"></th>
                    <th class="head1">Tên menu</th>
                    <th class="head0">Đường dẫn</th>
                    <th class="head1">Parent</th>
                    <th class="head0">Vị trí</th>
                    <th class="head1">Khởi tạo</th>
                    <th class="head0">Tình trạng</th>
                    <th class="head1">Chức năng</th>
                </tr>  
            </thead>

            <tbody id="tableproduct"> 


                @if(isset($arrMenu))
                @foreach($arrMenu as $item)
                <tr> 
                    <td><input type="hidden" value="{{$item->id}}"/></td> 
                    <td>@if($item->menuParent ==0) <strong> @endif <label value="page">@if($item->menuParent !=0) &nbsp;-&nbsp; @endif <a href="{{URL::action('\BackEnd\MenuController@getMenuEdit')}}/{{$item->id}}">{{str_limit( $item->menuName, 30, '...')}}</a></label>@if($item->menuParent ==0) </strong> @endif</td>
                    <td><label value="page">{{str_limit($item->menuURL, 30, '...')}} </label></td> 
                    <td><label value="page">@if ($item->menuParent == 0 ) {{ 'Cha' }} @else {{str_limit($item->menuParentName , 30, '...')}} @endif </label></td> 
                    <td><label value="page">{{$item->menuPosition}} </label></td> 
                    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    <td><label value="page">
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
                        
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item -> id}}, 0)" class="btn btn4 btn_world" title="Chờ kích hoạt"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item -> id}}, 1)" class="btn btn4 btn_flag" title="Kích hoạt"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item -> id}})" class="btn btn4 btn_trash" title="Xóa"></a>
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


    </div>


    <div class="contenttitle2">
        <h3>Them/sua menu</h3>
    </div>
    <form class="stdform stdform2" id="addMenu" method="post" action="@if(isset($arrayMenu)) {{URL::action('\BackEnd\MenuController@postUpdateMenu')}} @else {{URL::action('\BackEnd\MenuController@postAddMenu')}}@endif">

        <p>
            <input type="hidden" name="idmenu" id="idmanuf" value="@if(isset($arrayMenu)){{$arrayMenu->id}}@endif"/>
            <input type="hidden" name="status" id="status" value="@if(isset($arrayMenu)){{$arrayMenu->status}}@endif"/>

        </p>
        <p>
            <label>Tên Menu</label>
            <span class="field">
                <input type="text" id="menuName" name="menuName" placeholder="Nhập tên menu" value="@if(isset($arrayMenu)){{$arrayMenu->menuName}}@endif" class="longinput">
            </span>

        </p>

        <p>
            <label>Đường dẫn</label>
            <span class="field">
                <input type="text" id="urlValue" name="urlValue" value="@if(isset($arrayMenu)){{$arrayMenu->menuURL}}@else {{Asset('fontend')}} @endif"/>
                <select id="url">
                    <option value="1">Trang chủ</option>
                    <option value="2">Trang trong</option>
                    <option value="3">Trang ngoài</option>
                    <option value="4">Danh mục tin tức</option>
                    <option value="5">Danh mục sản phẩm</option>                    
                </select><br/>  
                <select name="home" id="home" size="5">                    
                    <option value="{{action('HomeController@getHome1')}}">Trang chủ</option>  
                    
                </select>
                <select name="internal" id="internal" size="5">                    
                    @if(isset($menu))
                    @foreach($menu as $item)
                    <option value="{{action('PageController@getPageBySlug')}}?slug={{$item->pageSlug}}">{{$item->pageName}}</option>                        
                    @endforeach
                    @endif
                </select>
                <select name="catenews" id="catenews" size="5">
                    <option value="{{action('NewsController@getNewsView')}}">Tất cả tin tức</option>                        
                    @if(isset($catenews))
                    @foreach($catenews as $item)
                    <option value="@if($item->catenewsParent ==0) {{action('ProductController@getNewsByCategoryParent')}}?cateslug={{$item->cateSlug}} @else {{action('NewsController@getNewsByCategory')}}?cateslug={{$item->catenewsSlug}}">@if($item->catenewsParent ==0)  <strong> @endif @if($item->catenewsParent !=0) &nbsp;-&nbsp; @endif {{$item->catenewsName}} @if($item->catenewsParent ==0) </strong> @endif</option>                        
                    @endforeach
                    @endif
                </select>
                <select name="cateproduct" id="cateproduct" size="5">
                    <option value="{{action('ProductController@getProduct')}}">Tất cả sản phẩm</option>                    
                    @if(isset($catepro))
                    @foreach($catepro as $item)
                    <option value="@if($item->cateParent ==0) {{action('ProductController@getProductByCategoryParent')}}?cateslug={{$item->cateSlug}} @else {{action('ProductController@getProductByCategory')}}?cateslug={{$item->cateSlug}} @endif">@if($item->cateParent ==0) <strong> @endif @if($item->cateParent !=0) &nbsp;-&nbsp; @endif {{$item->cateName}} @if($item->cateParent ==0) </strong> @endif</option>                        
                    @endforeach
                    @endif
                </select>                
                <label class="external" style="margin-right:-185px;margin-left: -10px;">URL:</label>
                <input type="text" class="external" id="externalValue" style="width: 40%;margin-top:10px "/>
                
            </span>
        </p>

        <p>
            <label>Parent</label>
            <span class="field">
                <select name="parent" id="parent">
                    <option value="0">Khong</option>
                    <?php
                    foreach ($arrMenu as $item) {
                        if ($item->menuParent == 0) {
                            $selec = '';
                            if (isset($arrayMenu) && $item->id == $arrayMenu->menuParent) {
                                $selec = 'selected';
                            }
                            echo '<option value="' . $item->id . '" ' . $selec . '> ' . $item->menuName . '</option>';
                        }
                    }
                    ?>                    
                </select>
                <input type="hidden" id='parentvalue' value="0" name="parentvalue"/>
                
            </span>
        </p> 
        <p>
            <label>Vị trí</label>
            <span class="field">
                <input type="text" name="menuPosition" placeholder="Nhập vị trí" value="@if(isset($arrayMenu)){{$arrayMenu->menuPosition}}@endif" class="longinput">

            </span>
        </p> 

        <p>
            <label>Trạng thái</label>
            <span class="field">
                <select name="status">
                    <option value="0" @if(isset($arrayMenu)&& $arrayMenu->status==0)selected@endif >Chờ kích hoạt</option>
                    <option value="1" @if(isset($arrayMenu)&& $arrayMenu->status==1)selected@endif>Kích hoạt</option>
                    <option value="2" @if(isset($arrayMenu)&& $arrayMenu->status==2)selected@endif>Xóa</option>
                </select>
            </span>
        </p>

        <p class="stdformbutton">
            <button class="submit radius2">@if(isset($arrayMenu))Cập nhật @else Thêm mới @endif</button>
            <input type="reset" class="reset radius2" value="Làm lại">
        </p>
    </form>
</div>
@endsection

