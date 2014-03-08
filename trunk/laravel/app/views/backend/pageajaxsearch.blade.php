<?php $i = ($pagedata->getCurrentPage() - 1) * 10 + 1; ?>
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