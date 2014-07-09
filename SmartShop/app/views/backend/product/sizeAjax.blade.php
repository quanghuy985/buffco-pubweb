<?php if (!isset($arrSize) || count($arrSize) == 0) { ?>
    <tr>
        <td colspan="9" style="text-align: center;">
            <?php echo Lang::get('general.data_empty'); ?>
        </td>
    </tr>
    <?php
} else {
    ?>
    @foreach($arrSize as $item)
    <tr> 
        <td>{{$item->size_name}}</td> 
        <td>{{$item->size_description}}</td>
        <td>
            <a href="{{URL::action('\BackEnd\ProductController@getSizeEdit')}}/{{$item->id}}"  title="{{Lang::get('general.edit')}}">{{Lang::get('general.edit')}}</a>
            &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: void(0)" onclick="deleteproduct('{{URL::action('\BackEnd\ProductController@postDeleteSize')}}',{{$item->id}})"title="{{Lang::get('general.delete')}}">{{Lang::get('general.delete')}}</a>
        </td> 
    </tr> 
    @endforeach
    @if($link!='')
    <tr>
        <td colspan="7">{{$link}}</td>
    </tr>
    @endif
<?php } ?>