@foreach($arrayCate as $item)
@if($item->catenewsParent==0)
<li class="checkboxselect">
    <?php
    $checked = false;
    if (isset($catlistselect)) {
        $checked = in_array($item->id, $catlistselect);
    }
    ?>
    {{Form::checkbox('catlist[]', $item->id,$checked)}}{{$item->catenewsName}}<br />
    <ul>
        @foreach($arrayCate as $item1)
        @if($item->id==$item1->catenewsParent)
        <?php
        $checked2 = false;
        if (isset($catlistselect)) {
            $checked2 = in_array($item1->id, $catlistselect);
        }
        ?>
        <li>{{Form::checkbox('catlist[]', $item1->id,$checked2)}}{{$item1->catenewsName}}<br /></li>
        @endif
        @endforeach
    </ul>
</li>
@endif
@endforeach
<script>
    jQuery('input:checkbox').uniform();</script>