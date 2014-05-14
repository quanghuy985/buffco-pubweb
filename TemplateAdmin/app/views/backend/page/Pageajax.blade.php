
@foreach($arrayPage as $item)
<tr> 
    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td> 
    <td><label value="page">{{str_limit($item->pageName, 30, '...')}}</label></td> 
    <td><label value="page">{{str_limit($item->pageKeywords, 30, '...')}} </label></td> 
    <td><label value="page">{{str_limit($item->pageTag, 30, '...')}} </label></td> 
    <td><label value="page">{{str_limit($item->pageSlug, 30, '...')}} </label></td> 
    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
    <td><label value="page">
            <?php
            $selectData = Lang::get('general.data_status');
            if(array_key_exists($item->status, $selectData)){
                echo $selectData[$item->status];
            }
            ?>
        </label>
    </td> 
    <td>
        <a href="{{URL::action('PageController@getPageEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="{{Lang::get('button.btn.book')}}"></a>
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
