@foreach($listallcate as $item)
@if($item->cateParent==0)
<li class="checkboxselect">
    <?php
    $checked = false;
    if (isset($catlistselect)) {
        $checked = in_array($item->id, $catlistselect);
    }
    ?>
    {{Form::checkbox('check2[]', $item->id,$checked)}}{{$item->cateName}}<br />
    <ul>
        @foreach($listallcate as $item1)
        @if($item->id==$item1->cateParent)
        <?php
        $checked2 = false;
        if (isset($catlistselect)) {
            $checked2 = in_array($item1->id, $catlistselect);
        }
        ?>
        <li>{{Form::checkbox('check2[]', $item1->id,$checked2)}}{{$item1->cateName}}<br /></li>
        @endif
        @endforeach
    </ul>
</li>
@endif
@endforeach
<script>
    jQuery('input:checkbox').uniform();</script>