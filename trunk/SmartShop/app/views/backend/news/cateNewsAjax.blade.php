<?php
if (count($arrayCateNews) == 0 && isset($arrayCateNews)) {
    ?>
    <tr>
        <td colspan="7">{{Lang::get('general.data_empty')}}</td>
    </tr>
    <?php
} else {
    ?>
    @foreach($arrayCateNews as $item)
    <tr>
        <td>@if($item->catenewsParent ==0) <strong> @endif <label value="cateMenuer">@if($item->catenewsParent!=0) &nbsp;—&nbsp; @endif <a
                        href="{{URL::action('\BackEnd\CateNewsController@getCateNewsEdit')}}/{{$item->id}}">{{str_limit($item->catenewsName, 30, '...')}}</a></label>@if($item->catenewsParent ==0)
            </strong> @endif
        </td>
        <td><label value="cateMenuer">{{str_limit( $item->catenewsDescription, 30, '...')}}</label></td>
        <td><label value="cateMenuer">{{str_limit($item->catenewsSlug , 30, '...')}}</label></td>
        <td>
            <a href="{{URL::action('\BackEnd\CateNewsController@getCateNewsEdit')}}/{{$item->id}}" title="{{Lang::get('general.edit')}}">{{Lang::get('general.edit')}}</a>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="javascript: void(0)" onclick="deleteproduct('{{URL::action('\BackEnd\CateNewsController@postDeleteCateNews')}}',{{$item->id}})" title="{{Lang::get('general.delete')}}">{{Lang::get('general.delete')}}</a>
        </td>
    </tr>
    @endforeach
    @if($link!='')
    <tr>
        <td colspan="7">{{$link}}</td>
    </tr>
    @endif
<?php } ?>