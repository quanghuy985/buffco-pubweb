@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    jQuery(document).ready(function() {
        jQuery('.external').hide();
        jQuery('#catenews').hide();
        jQuery('#cateproduct').hide();

        jQuery('#url').change(function() {
            if (jQuery('#url').val() == '1') {
                jQuery('#internal').show();
                jQuery('.external').hide();
                jQuery('#catenews').hide();
                jQuery('#cateproduct').hide();
            } else if (jQuery('#url').val() == '2') {
                jQuery('#internal').hide();
                jQuery('.external').show();
                jQuery('#catenews').hide();
                jQuery('#cateproduct').hide();
            } else if (jQuery('#url').val() == '3') {
                jQuery('#internal').hide();
                jQuery('.external').hide();
                jQuery('#catenews').show();
                jQuery('#cateproduct').hide();
            } else if (jQuery('#url').val() == '4') {
                jQuery('#internal').hide();
                jQuery('.external').hide();
                jQuery('#catenews').hide();
                jQuery('#cateproduct').show();
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
            alert(jQuery('#parentvalue').val());
        });
        
        jQuery('#externalValue').change(function(){
            jQuery('#urlValue').val(jQuery('#externalValue').val());
        });
        
        jQuery('#internal').change(function(){           
            jQuery("#urlValue").val(jQuery('#internal').val());
             
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

<div class="pageheader notab">
    <h1 class="pagetitle">Menu</h1>
    <span class="pagedesc"> Thêm mới menu</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Mẫu nhập menu</h3>
        </div>
        <form class="stdform stdform2" id="addMenu" method="post" action="@if(isset($arrayMenu)) {{URL::action('MenuController@postUpdateMenu')}} @else {{URL::action('MenuController@postAddMenu')}}@endif">

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
                    <input type="text" id="urlValue" name="urlValue" value=""/>
                    <select id="url">
                        <option value="1">Trang trong</option>
                        <option value="2">Trang ngoài</option>
                        <option value="3">Danh mục tin tức</option>
                        <option value="4">Danh mục sản phẩm</option>
                    </select><br/>                    
                    <select name="internal" id="internal" size="5">
                        <option value="0"></option>
                        @if(isset($page))
                        @foreach($page as $item)
                        <option value="{{action('PageController@getPageBySlug')}}/{{$item->pageSlug}}">{{$item->pageName}}</option>                        
                        @endforeach
                        @endif
                    </select>
                    <select name="catenews" id="catenews" size="5">
                        @if(isset($catenews))
                        @foreach($catenews as $item)
                        <option value="{{$item->catenewsSlug}}">{{$item->catenewsName}}</option>                        
                        @endforeach
                        @endif
                    </select>
                    <select name="cateproduct" id="cateproduct" size="5">
                        @if(isset($catepro))
                        @foreach($catepro as $item)
                        <option value="{{action('CategoryProductController@getCategoryProductBySlugCate')}}/{{$item->cateSlug}}">{{$item->cateName}}</option>                        
                        @endforeach
                        @endif
                    </select>

                    <label class="external" style="margin-right:-185px;margin-left: -20px;">URL:</label><input type="text" class="external" id="externalValue" style="width: 40%;margin-top:10px "/>

                </span>
            </p>

            <p>
                <label>Parent</label>
                <span class="field">
                    <select name="parent" id="parent">
                        <option value="0">Khong</option>
                        @if(isset($menu))
                        @foreach($menu as $item)
                        <option value="{{$item->id}}">{{$item->menuName}}</option>                        
                        @endforeach
                        @endif
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
        @endsection