<?php $i = ($arrSupporter->getCurrentPage() - 1) * 10 + 1;
$support_status = Lang::get('general.supporter_status'); ?>
@foreach($arrSupporter as $item)
<tr>

    <td><label value="cateSupporter">{{$i++ }}</label></td>
    <td><label value="cateSupporter">{{str_limit( $item->supporterName, 30, '...')}}</label></td>
    <td><label value="cateSupporter">{{str_limit($item->supporterGroupName , 30, '...')}}</label></td>
    <td><label value="cateSupporter">{{str_limit($item->supporterNickYH , 30, '...')}}</label></td>
    <td><label value="cateSupporter">{{str_limit($item->supporterNickSkype, 30, '...')}} </label></td>
    <td><label value="cateSupporter">{{str_limit($item->supporterPhone, 30, '...')}} </label></td>
    <td><label value="cateSupporter">{{str_limit($item->time, 30, '...')}} </label></td>
    <td><label value="cateSupporter">
            <?php
            if (array_key_exists($item->status, $support_status)) {
                echo $support_status[$item->status];
            }
            ?>
        </label>
    </td>
    <td>

        <a href="{{URL::action('\BackEnd\SupporterController@getSupporterEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="{{Lang::get('button.btn3.book')}}"></a>
        @if($item->status=='2')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="{{Lang::get('button.btn3.flag')}}"></a>
        @endif
        @if($item->status=='0')
        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="{{Lang::get('button.btn3.world')}}"></a>
        @endif
        @if($item->status!='2')
        <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="{{Lang::get('button.btn3.trash')}}"></a>
        @endif

    </td>

</tr>
@endforeach
@if(count($arrSupporter)==0)
<tr>
    <td colspan="9">{{Lang::get('general.data_empty')}}</td>
</tr>
@endif
@if($link!='')
<tr>
    <td colspan="9">{{$link}}</td>
</tr>
@endif