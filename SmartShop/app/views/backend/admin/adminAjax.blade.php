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
    <td><label value="cateMenuer"><a href="{{URL::action('\BackEnd\AdminController@getAdminDetail')}}?email={{$item->email}}">{{str_limit( $item->email, 30, '...')}}</a></label></td>
    <td><label value="cateMenuer">{{str_limit( $item->firstname.' '.$item->lastname, 30, '...')}}</label></td>
    <td><label value="cateMenuer">{{str_limit( $item->phone, 30, '...')}} </label>
    </td>
    <td><label value="cateMenuer">
            <?php
            if (array_key_exists($item->status, $user_status)) {
                echo $user_status[$item->status];
            }
            ?>
        </label>
    </td>
    <td>
        <a title="{{Lang::get('general.edit')}}" href="<?php echo action('\BackEnd\AdminController@getAdminEdit') ?>/{{$item->email}}"> {{Lang::get('general.edit')}}</a>
        @if($item->status=='2')
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a title="{{Lang::get('general.active')}}" href="javascript:void(0);" onclick="kickhoat('{{URL::action('\BackEnd\AdminController@postAdminActive')}}','{{$item->email}}',{{$arrayAdmin->getCurrentPage()}});"> {{Lang::get('general.active')}}</a>
        @endif
        @if($item->status=='0')
        @endif
        @if($item->status!='2')
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a title="{{Lang::get('general.delete')}}" href="javascript:void(0);" onclick="deleteproduct('{{URL::action('\BackEnd\AdminController@postDeleteAdmin')}}','{{$item->email}}',{{$arrayAdmin->getCurrentPage()}});"> {{Lang::get('general.delete')}}</a>
        @endif

    </td>
</tr>
@endforeach
@if($link!='')
<tr>
    <td colspan="6">{{$link}}</td>
</tr>
@endif