@foreach($arrCatProduct as $item)
<?php
if ($item->cateParent == 0) {
    ?>
    <option value="{{$item->id}}">{{$item->cateName}}</option>
    <?php
    foreach ($arrCatProduct as $item1) {
        if ($item1->cateParent == $item->id) {
            echo '<option value="' . $item1->id . '" >-- ' . $item1->cateName . '</option>';
        }
    }
}
?>
@endforeach
