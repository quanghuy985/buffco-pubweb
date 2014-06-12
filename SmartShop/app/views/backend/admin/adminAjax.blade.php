<?php
$i = 1;
if (Input::get('page') > 1) {
    $i = (Input::get('page') - 1) * 10 + 1;
}
$user_status = Lang::get('general.user_status');
?>
@foreach($arrayAdmin as $item)
<tr>
    <td><label value="cateMenuer">{{$i++ }}</label></td>
    <td><label value="cateMenuer">{{str_limit( $item->email, 30, '...')}}</label></td>
    <td><label value="cateMenuer">{{str_limit( $item->firstname.' '.$item->lastname, 30, '...')}}</label></td>
    <td><label value="cateMenuer"><a href="{{URL::action('\BackEnd\GroupAdminController@getGroupAdminEdit')}}?id={{$item->group_admin_id}}">{{str_limit( $item->groupadminName, 30, '...')}}</a> </label>

    </td>
    <td><label value="cateMenuer"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td>
    <td><label value="cateMenuer">
            <?php
            if (array_key_exists($item->status, $user_status)) {
                echo $user_status[$item->status];
            }
            ?>
        </label>
    </td>
    <td>
        <a href="{{URL::action('\BackEnd\AdminController@getAdminEdit')}}?id={{$item->email}}" class="btn btn4 btn_book" title="{{Lang::get('button.btn2.book')}}"></a>
        @if($item->status=='2')
        <a href="javascript: void(0)" onclick="kichhoat('{{$item->id}}', 0)" class="btn btn4 btn_flag" title="{{Lang::get('button.btn2.flag')}}"></a>
        @endif
        @if($item->status=='0')
        <a href="javascript: void(0)" onclick="kichhoat('{{$item->id}}', 1)" class="btn btn4 btn_world" title="{{Lang::get('button.btn2.world')}}"></a>
        @endif
        @if($item->status!='2')
        <a href="javascript: void(0)" onclick="xoasanpham('{{$item->email}}')" class="btn btn4 btn_trash" title="{{Lang::get('button.btn2.trash')}}"></a>
        @endif

    </td>
</tr>
@endforeach
@if($link!='')
<tr>
    <td colspan="7">{{$link}}</td>
</tr>
@endif