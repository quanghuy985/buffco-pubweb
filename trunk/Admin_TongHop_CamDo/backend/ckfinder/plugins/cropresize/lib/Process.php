<?php

include('Boot.php');

$image = new Image();

if ( $image->isPosted() ) {
    $new_file = $image->resize();
    echo 'Ảnh đã cắt thành công và được lưu vào thư mục với tên : \''.$new_file.'\'';
}
