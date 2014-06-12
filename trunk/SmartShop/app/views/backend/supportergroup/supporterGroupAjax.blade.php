<?php $i = ($arrSupporterGroup->getCurrentPage() - 1) * 10 + 1; ?>
@if(count($arrSupporterGroup)>0)
@foreach($arrSupporterGroup as $item)
<tr>
    <td><label value="cateMenuer"><?php
            echo $i;
            $i++;
            ?></label></td>
    <td><label value="cateMenuer">{{str_limit( $item->supporterGroupName, 30, '...')}}</label></td>
    <td><label value="cateMenuer"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td>
    <td><label value="cateMenuer"><?php
            $supporter_status = Lang::get('general.supporter_status');
            if (array_key_exists($item->status, $supporter_status)) {
                echo $supporter_status[$item->status];
            }
            ?>
        </label>
    </td>
    <td>

        <a href="{{URL::action('\BackEnd\SupporterGroupController@getSupporterGroupEdit')}}?id={{$item->id}}&#frmEdit" class="btn btn4 btn_book" title="{{Lang::get('button.btn3.book')}}"></a>
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
@if($link!='')
<tr>
    <td colspan="5">{{$link}}</td>
</tr>
@endif
@else
<tr>
    <td colspan="5">{{Lang::get('general.data_empty')}}</td>
</tr>
@endif