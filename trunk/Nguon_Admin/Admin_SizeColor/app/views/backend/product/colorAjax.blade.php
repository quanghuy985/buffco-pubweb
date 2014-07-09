<?php if (!isset($arrColor) || count($arrColor) == 0) { ?>
    <tr>
        <td colspan="9" style="text-align: center;">
            <?php echo Lang::get('general.data_empty'); ?>
        </td>
    </tr>
    <?php
} else {
    ?>
    @foreach($arrColor as $item)
    <tr> 
        <td>{{$item->color_name}}</td> 
        <td>{{$item->color_code}}</td>
        <td>
            <span class="colorselector" >
                <span style="background: {{$item->color_code}} !important; border-radius: 5px;height: 23px; width: 117px;border: 3px solid #dcdfe4;"></span>
            </span></td> 
        <td>
            <a href="{{URL::action('\BackEnd\ProductController@getColorEdit')}}/{{$item->id}}"  title="{{Lang::get('general.edit')}}">{{Lang::get('general.edit')}}</a>
            &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript: void(0)" onclick="deleteproduct('{{URL::action('\BackEnd\ProductController@postDeleteColor')}}',{{$item->id}})"title="{{Lang::get('general.delete')}}">{{Lang::get('general.delete')}}</a>
        </td> 
    </tr> 
    @endforeach
    @if($link!='')
    <tr>
        <td colspan="7">{{$link}}</td>
    </tr>
    @endif
<?php } ?>