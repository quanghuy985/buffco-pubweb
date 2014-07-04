@if(isset($arrayManufacturer))
<?php
$i = ($arrayManufacturer->getCurrentPage() - 1) * 10 + 1;
?>
@foreach($arrayManufacturer as $item)

<tr> 
    <td><label value="cateSupporter">{{$i++ }}</label></td>
    <td>
        <?php
        $pieces = explode(",", $item->manufacturerLogo);
        ?>
        <?php $url = Timthumb::link($pieces[0], 30, 30, 0); ?>
        <a title="{{Lang::get('general.edit')}}" href="<?php echo action('\BackEnd\ManufacturerController@getManufacturerEdit') ?>/{{$item->id}}"> <img src="{{Asset($url)}}" /></a>
    </td>    
    <td><label value="manuf">{{$item->manufacturerName}}</label></td> 
    <td><label value="manuf">{{$item->manufacturerPlace}} </label></td> 
    <td><label value="manuf"></label><?php echo date('d/m/Y', $item->time); ?></td>  
    <td>
        <a href="{{URL::action('\BackEnd\ManufacturerController@getManufacturerEdit')}}/{{$item->id}}"  title="{{Lang::get('general.edit')}}">{{Lang::get('general.edit')}}</a>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="javascript: void(0)" onclick="deleteproduct('{{URL::action('\BackEnd\ManufacturerController@postDeleteManufacturer')}}',{{$item->id}})" title="{{Lang::get('general.delete')}}">{{Lang::get('general.delete')}}</a>
    </td> 
</tr> 

@endforeach
@if($link!='')
<tr>
    <td colspan="7">{{$link}}</td>
</tr>
@endif
@endif

