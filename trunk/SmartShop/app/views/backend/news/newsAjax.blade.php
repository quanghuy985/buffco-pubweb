<?php
$i = 1;
$data_status = Lang::get('general.data_status2');
unset($data_status[3]);
?>
@foreach($arrayNews as $item)
<tr>
    <td><label value="cateNews">{{$i++}}</label></td>
    <td><label value="cateNews"><a href="{{URL::action('\BackEnd\NewsController@getNewsEdit')}}/{{$item->id}}">{{str_limit( $item->newsName, 30, '...')}}</a></label></td>
    <td><label value="cateNews">{{str_limit($item->newsDescription, 30, '...')}} </label></td>
    <td><label value="cateNews"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td>
    <td><label value="cateNews">
            <?php
            if(array_key_exists($item->status, $data_status)){
                echo $data_status[$item->status];
            }
            ?>
        </label>
    </td>
    <td>
        <a href="{{URL::action('\BackEnd\NewsController@getNewsEdit')}}/{{$item->id}}" class="btn btn4 btn_book" title="{{Lang::get('button.btn.book')}}"></a>
        @if($item->status=='2')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="{{Lang::get('button.btn.flag')}}"></a>
        @endif
        @if($item->status=='0')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="{{Lang::get('button.btn.world')}}"></a>
        @endif
        @if($item->status!='2')
        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="{{Lang::get('button.btn.trash')}}"></a>
        @endif
    </td>
</tr>
@endforeach
@if($link!='')
<tr>
    <td colspan="8">{{$link}}</td>
</tr>
@endif
@if(count($arrayNews)==0)
<tr>
    <td colspan="8">{{Lang::get('general.data_empty')}}</td>
</tr>
@endif