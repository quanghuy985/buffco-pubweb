<?php

namespace App\Modules\Fontend\Controllers;

use fontend,
    Input,
    Redirect,
    View;

class ProductController extends \BaseController {

    public function __construct() {
        $tblp = new \App\Modules\Fontend\Models\ProductModel();
        $data = $tblp->getAllProduct(12);
        $link = $data->links();
        return View::make('fontend::CategoryProduct')->with('arrProduct', $data)->with('link', $link);
    }

    public function getSanPham($slugcat = '') {
        if ($slugcat == '') {
            $tblp = new \App\Modules\Fontend\Models\ProductModel();
            $data = $tblp->getAllProduct(12);
            $link = $data->links();
            return View::make('fontend::CategoryProduct')->with('arrProduct', $data)->with('link', $link);
        } else {
            $tblp = new \App\Modules\Fontend\Models\ProductModel();
            $data = $tblp->getAllProductByCat($slugcat, 12, '');
            $link = $data->links();
            return View::make('fontend::CategoryProduct')->with('arrProduct', $data)->with('link', $link)->with('slucat', $slugcat);
        }
    }

    public function getTags($tags = '') {
        $tblp = new \App\Modules\Fontend\Models\ProductModel();
        $data = $tblp->getAllProductByTag($tags, 12);
        $link = $data->links();
        return View::make('fontend::CategoryProductTags')->with('arrProduct', $data)->with('link', $link)->with('tagname', $tags);
    }

    public function postTagsAjax() {
        if (\Request::ajax()) {
            $tags = \Input::get('tags');
            $tblp = new \App\Modules\Fontend\Models\ProductModel();
            $data = $tblp->getAllProductByTag($tags, 12);
            $link = $data->links();
            return View::make('fontend::CategoryProductAjax')->with('arrProduct', $data)->with('link', $link)->with('tags', $tags);
        }
    }

    public function getCategoryProduct() {
        $tblp = new \App\Modules\Fontend\Models\ProductModel();
        $dataCat = $tblp->getAllCategoryProduct();
        var_dump($dataCat);
    }

    public function getChiTiet($slug = '') {
        $tblp = new \App\Modules\Fontend\Models\ProductModel();
        $data = $tblp->getProductBySlug($slug);
        $color = $tblp->getColorBySlug($data[0]->id);
        $size = $tblp->getSizeBySlug($data[0]->id);
        $soluong = $tblp->getStoreBySlug($data[0]->id);
        return View::make('fontend::ProductSingle')->with('product', $data)->with('color', $color)->with('size', $size)->with('store', $soluong);
    }

    public function postDanhGia() {
        $ip = $_SERVER['REMOTE_ADDR'];
        //      $vote_sent = preg_replace("/[^0-9]/", "", $input[stars]);
        $tblProduct = new \App\Modules\Fontend\Models\ProductModel();
        $product = $tblProduct->getProductById(\Input::get('id'));
        if (!isset($_COOKIE['rating_' . \Input::get('id')])) {
            $check = $tblProduct->updateRate(\Input::get('id'), $product[0]->total_votes + 1, $product[0]->total_value + \Input::get('total_value'));
            setcookie("rating_" . \Input::get('id'), 1, time() + 2592000);
        }
        $tblProduct = new \App\Modules\Fontend\Models\ProductModel();
        $product1 = $tblProduct->getProductById(\Input::get('id'));
        for ($i = 0; $i < 5; $i++) {
            $j = $i + 1;
            if ($i < @number_format($product1[0]->total_value / $product1[0]->total_votes, 1) - 0.5) {
                $class = "active";
            } else {
                $class = "";
            }
            echo '<li class="' . $class . '" onclick="danhgia(' . $j . ',' . \Input::get('id') . ')">
                                    <i class="fa fa-star-o empty tr_all_hover"></i>
                                    <i class="fa fa-star active tr_all_hover"></i>
                                </li>';
        }
    }

    public function postSanPhamAjax() {
        $tblp = new \App\Modules\Fontend\Models\ProductModel();
        $data = $tblp->getAllProduct(12);
        $link = $data->links();
        return View::make('fontend::CategoryProductAjax')->with('arrProduct', $data)->with('link', $link);
    }

    public function postSanPhamCatAjax() {
        $tblp = new \App\Modules\Fontend\Models\ProductModel();
        $slugcat = \Input::get('slugcat');
        $data = $tblp->getAllProductByCat($slugcat, 12, Input::get('loctheogia'));
        $link = $data->links();
        return View::make('fontend::CategoryProductAjax')->with('arrProduct', $data)->with('link', $link);
    }

    public function postLocTheoGiaSanPhamAjax() {
        $tblp = new \App\Modules\Fontend\Models\ProductModel();
        $data = $tblp->getAllProductFillterByPrice(\Input::get('loctheogia'), 12);
        $link = $data->links();
        return View::make('fontend::CategoryProductAjax')->with('arrProduct', $data)->with('link', $link);
    }

    public function postLocTheoGiaSanPhamCatAjax() {
        $tblp = new \App\Modules\Fontend\Models\ProductModel();
        $slugcat = \Input::get('slugcat');
        $data = $tblp->getAllProductFillterByPriceCat($slugcat, \Input::get('loctheogia'), 12);
        $link = $data->links();
        return View::make('fontend::CategoryProductAjax')->with('arrProduct', $data)->with('link', $link);
    }

    public function getSanPham1() {
        echo 'asd2345';
    }

    public function postLocDuLieu() {
        $catslug = Input::get('catslugfillter');
        $tblp = new \App\Modules\Fontend\Models\ProductModel();
        $data = $tblp->getAllProductFill(Input::get('listmunu'), Input::get('size'), $catslug, 2);
        $link = $data->links();
        return View::make('fontend::CategoryProductAjax')->with('arrProduct', $data)->with('link', $link);
    }

    public function postLocDuLieuAjax() {
        $catslug = Input::get('catslugfillter');
        $tblp = new \App\Modules\Fontend\Models\ProductModel();
        $data = $tblp->getAllProductFillPrice(Input::get('listmunu'), Input::get('size'), $catslug, 2, Input::get('loctheogia'));
        $link = $data->links();
        return View::make('fontend::CategoryProductAjax')->with('arrProduct', $data)->with('link', $link);
    }

}
