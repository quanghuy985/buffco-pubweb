@if(isset($arrmuti))
@foreach($arrmuti as $item)
<?php $select = ''; ?>
@if(isset($arrPmeta)) 
@foreach($arrPmeta as $item1)
@if($item1->tagID == $item->id)
<?php $select = 'selected'; ?>
@endif
@endforeach
@endif
<option <?php echo $select; ?> value="{{$item->id}}" >{{$item->tagKey}}</option>
@endforeach
@endif