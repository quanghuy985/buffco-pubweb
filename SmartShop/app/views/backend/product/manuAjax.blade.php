@foreach($arrManu as $item)
<option value="{{$item->id}}">{{$item->manufacturerName}}</option>
@endforeach