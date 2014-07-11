@foreach($arrUser as $itemUser)
<option value="{{$itemUser->id}}">{{$itemUser->userLastName.' '.$itemUser->userFirstName}}</option>
@endforeach