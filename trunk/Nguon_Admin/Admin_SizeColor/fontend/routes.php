<?php

Route::controller('longin', 'App\Modules\Fontend\Controllers\AuthController');


Route::group(array('before' => 'checks'), function() {
        Route::controller('taikhoan', 'App\Modules\Fontend\Controllers\UserController');
    Route::controller('giohang', 'App\Modules\Fontend\Controllers\OrderController');
    Route::controller('sanpham', 'App\Modules\Fontend\Controllers\ProductController');
    Route::get('sanpham', 'App\Modules\Fontend\Controllers\ProductController@getSanPham');
});
View::composer(array('fontend::CategoryProduct'), function($view) {
    $tblProduct = new App\Modules\Fontend\Models\ProductModel();
    $arrCat = $tblProduct->getAllCategoryProduct();
    $arrManu = $tblProduct->getListManufacture();
    $arrColor = $tblProduct->getListColor();
    $arrSize = $tblProduct->getListSize();
    $bestsale = $tblProduct->getAllBestSale(5);
    $tags = $tblProduct->getAllTags();
    $view->with('catarray', $arrCat)->with('arrManu', $arrManu)->with('arrColor', $arrColor)->with('arrSize', $arrSize)->with('bestsalse', $bestsale)->with('tags', $tags);
});
View::composer(array('fontend::ProductSingle', 'fontend::CartProduct', 'fontend::CategoryProductTags'), function($view) {
    $tblProduct = new App\Modules\Fontend\Models\ProductModel();
    $arrCat = $tblProduct->getAllCategoryProduct();
    $arrManu = $tblProduct->getListManufacture();
    $bestsale = $tblProduct->getAllBestSale(5);
    $tags = $tblProduct->getAllTags();
    $view->with('catarray', $arrCat)->with('arrManu', $arrManu)->with('bestsalse', $bestsale)->with('tags', $tags);
});
