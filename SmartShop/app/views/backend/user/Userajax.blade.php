
<?php
$i = ($arrUser->getCurrentPage() - 1) * 10 + 1;
?>
@if(count($arrUser)>0)
@foreach($arrUser as $item)
<tr>
    <td class="text-center"><label value="cateNews">{{$i++}}</label></td>
    <td><a href="{{URL::action('\BackEnd\UserController@getUserDetail')}}/{{$item->id}}">{{$item->email}}</a></td>
    <td><label value="user">{{str_limit($item->phone, 10, '...')}} </label></td>
    <td><label value="user">
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
        <a href="{{URL::action('\BackEnd\UserController@getUserEdit')}}?id={{$item->id}}"
           title="Sửa">{{Lang::get('general.edit')}}</a>
        @if($item->status=='2')
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="javascript: void(0)" onclick="active_element('{{URL::action('\BackEnd\UserController@postActiveUsers')}}',{{$item->id}})" title="{{Lang::get('general.lock')}}">{{Lang::get('general.lock')}}</a>
        @endif
        @if($item->status=='0')
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="javascript: void(0)" onclick="active_element('{{URL::action('\BackEnd\UserController@postPublicUsers')}}',{{$item->id}})" title="{{Lang::get('general.world')}}">{{Lang::get('general.world')}}</a>
        @endif
        @if($item->status!='2')
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="javascript: void(0)" onclick="deleteproduct('{{URL::action('\BackEnd\UserController@postDeleteUsers')}}',{{$item->id}})" title="{{Lang::get('general.delete')}}">{{Lang::get('general.delete')}}</a>
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

