<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($arrTag)) {
    foreach ($arrTag as $itemTag) {
        if (isset($arrTaged)) {
            $checked = '';
            foreach ($arrTaged as $itemTaged) {
                if ($itemTaged->tagID == $itemTag->id) {
                    $checked = 'checked';
                    break;
                } else {
                    $checked = '';
                }
            }
            echo '<input ' . $checked . ' type="checkbox" value="' . $itemTag->id . '" name="tag[]" />' . $itemTag->tagKey . ':  ' . $itemTag->tagValue . ' <br />';
        } else {
            echo '<input type="checkbox" value="' . $itemTag->id . '" name="tag[]" />' . $itemTag->tagKey . ':  ' . $itemTag->tagValue . ' <br />';
        }
    }
    if(count($arrTag)==0){
        echo '<p style="color:red;">Không có tag nào trong danh mục này</p>';
    }
}
?>