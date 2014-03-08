@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
        var request = jQuery.ajax({
            url: "{{URL::action('PageController@postAjaxpagion')}}?page=" + page,
            type: "POST",
            dataType: "html"
        }
        );
        request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
        });
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">TRANG</h1>
    <span class="pagedesc">Quản lý các trang</span>
</div>
<div class="contentwrapper">
    <div class="contenttitle2">
        <h3>Bảng trang</h3>
    </div>
    <div class="contentwrapper">
        <div class="subcontent">

            <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
                <colgroup>

                    <col class="con1" style="width: 3%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 14%">
                    <col class="con0" style="width: 20%">
                    <col class="con1" style="width: 15%">
                    <col class="con0" style="width: 13%">
                    <col class="con1" style="width: 15%">
                </colgroup>
                <thead>
                    <tr>

                        <th class="head1">ID</th>
                        <th class="head0">Tên trang</th>
                        <th class="head1">Tag</th>
                        <th class="head0">Slug</th>
                        <th class="head1">Khởi tạo</th>
                        <th class="head0">Tình trạng</th>
                        <th class="head1">Chức năng</th>
                    </tr>  
                </thead>

                <tbody id="tableproduct">
                    <?php $i = 1 ?>
                    @foreach($pagedata as $item)
                    <tr> 
                        <td><label value="cateNews">{{$i++ }}</label></td> 
                        <td><label value="cateNews">{{str_limit( $item->pageName, 30, '...')}}</label></td> 
                        <td><label value="cateNews">{{$item->pageTag }}</label></td> 
                        <td><label value="cateNews">{{str_limit($item->pageSlug, 30, '...')}} </label></td> 
                        <td><label value="cateNews"><?php echo date('d/m/Y h:i:s', $item->pageTime); ?></label></td> 
                        <td><label value="cateNews"><?php
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

                            <a href="{{URL::action('PageController@getPageEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                            @if($item->status=='2')
                            <a href="{{URL::action('PageController@getPageActive')}}?id={{$item->id}}" class="btn btn4 btn_flag" title="Kích hoạt"></a>
                            @endif
                            @if($item->status=='0')
                            <a href="{{URL::action('PageController@getPagePost')}}?id={{$item->id}}" class="btn btn4 btn_world" title="Đăng trang"></a>
                            @endif
                            @if($item->status!='2')
                            <a href="{{URL::action('PageController@getPageDelete')}}?id={{$item->id}}" class="btn btn4 btn_trash" title="Xóa"></a>
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
</div>
@endsection

