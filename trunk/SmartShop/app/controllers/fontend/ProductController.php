<?php

namespace FontEnd;

use Session,
    Input,
    Cookie,
    Redirect,
    View;

class ProductController extends \BaseController {

//    public function __construct() {
//        $tblp = new \FontEnd\ProductModel();
//        $data = $tblp->getAllProduct(12);
//        $link = $data->links();
//        return View::make('fontend.product-category')->with('arrProduct', $data)->with('link', $link);
//    }
//
//    public function postGetColorBySizeId() {
//        $sizeid = Input::get('sizeid');
//        $idproduct = Input::get('idp');
//        $productModel = new \FontEnd\ProductModel();
//        $arraycolor = $productModel->getColorProductBySizeID($sizeid, $idproduct);
//        $lisrColor = array();
//        foreach ($arraycolor as $item) {
//            $lisrColor[] = array(
//                'colorid' => $item->id,
//                'colorname' => $item->colorName
//            );
//        }
//        echo json_encode($lisrColor);
//    }
//
//    public function postGetSizeByColorId() {
//        $colorid = Input::get('colorid');
//        $idproduct = Input::get('idp');
//        $productModel = new \FontEnd\ProductModel();
//        $arraysize = $productModel->getSizeProductByColorID($colorid, $idproduct);
//        $lisrSize = array();
//        foreach ($arraysize as $item) {
//            $lisrSize[] = array(
//                'sizeid' => $item->id,
//                'sizename' => $item->sizeName
//            );
//        }
//        echo json_encode($lisrSize);
//    }

    public function getSanPham($slugcat = '') {
        if ($slugcat == '') {
            $tblp = new \FontEnd\ProductModel();
            $data = $tblp->getAllProduct(12);
            $link = $data->links();
            return View::make('fontend.product-category')->with('arrProduct', $data)->with('link', $link);
        } else {
            $tblp = new \FontEnd\ProductModel();
            $data = $tblp->getAllProductByCat($slugcat, 12, '');
            $link = $data->links();
            return View::make('fontend.product-category')->with('arrProduct', $data)->with('link', $link)->with('slucat', $slugcat);
        }
    }

//    public function getTags($tags = '') {
//        $tblp = new \FontEnd\ProductModel();
//        $data = $tblp->getAllProductByTag($tags, 12);
//        $link = $data->links();
//        return View::make('fontend.product-categoryTags')->with('arrProduct', $data)->with('link', $link)->with('tagname', $tags);
//    }
//
//    public function postTagsAjax() {
//        if (Request::ajax()) {
//            $tags = trim(Input::get('tags'));
//            $tblp = new \FontEnd\ProductModel();
//            $data = $tblp->getAllProductByTag($tags, 12);
//            $link = $data->links();
//            return View::make('fontend.product-categoryAjax')->with('arrProduct', $data)->with('link', $link)->with('tags', $tags);
//        }
//    }
//
//    public function getCategoryProduct() {
//        $tblp = new \FontEnd\ProductModel();
//        $dataCat = $tblp->getAllCategoryProduct();
//    }
//
//    public function getChiTiet($slug = '') {
//        $tblp = new \FontEnd\ProductModel();
//        $data = $tblp->getProductBySlug($slug);
//        $color = $tblp->getColorBySlug($data[0]->id);
//        $size = $tblp->getSizeBySlug($data[0]->id);
//        $soluong = $tblp->getStoreBySlug($data[0]->id);
//        $relateproduct = $tblp->getProductRelate($data[0]->cateID, 6);
//        return View::make('fontend.ProductSingle')->with('relateproduct', $relateproduct)->with('product', $data)->with('color', $color)->with('size', $size)->with('store', $soluong);
//    }
//
//    public function postDanhGia() {
//        $ip = $_SERVER['REMOTE_ADDR'];
//        //      $vote_sent = preg_replace("/[^0-9]/", "", $input[stars]);
//        $tblProduct = new \FontEnd\ProductModel();
//        $product = $tblProduct->getProductById(trim(Input::get('id')));
//        if (!isset($_COOKIE['rating_' . trim(Input::get('id'))])) {
//            $check = $tblProduct->updateRate(trim(Input::get('id')), $product[0]->total_votes + 1, $product[0]->total_value + trim(Input::get('total_value')));
//            setcookie("rating_" . trim(Input::get('id')), 1, time() + 2592000);
//        }
//        $tblProduct = new \FontEnd\ProductModel();
//        $product1 = $tblProduct->getProductById(trim(Input::get('id')));
//        for ($i = 0; $i < 5; $i++) {
//            $j = $i + 1;
//            if ($i < @number_format($product1[0]->total_value / $product1[0]->total_votes, 1) - 0.5) {
//                $class = "active";
//            } else {
//                $class = "";
//            }
//            echo '<li class="' . $class . '" onclick="danhgia(' . $j . ',' . trim(Input::get('id')) . ')">
//                                    <i class="fa fa-star-o empty tr_all_hover"></i>
//                                    <i class="fa fa-star active tr_all_hover"></i>
//                                </li>';
//        }
//    }
//
//    public function postSanPhamAjax() {
//        $tblp = new \FontEnd\ProductModel();
//        $data = $tblp->getAllProduct(12);
//        $link = $data->links();
//        return View::make('fontend.product-categoryAjax')->with('arrProduct', $data)->with('link', $link);
//    }
//
//    public function postSanPhamCatAjax() {
//        $tblp = new \FontEnd\ProductModel();
//        $slugcat = trim(Input::get('slugcat'));
//        $data = $tblp->getAllProductByCat($slugcat, 12, trim(Input::get('loctheogia')));
//        $link = $data->links();
//        return View::make('fontend.product-categoryAjax')->with('arrProduct', $data)->with('link', $link);
//    }
//
//    public function postLocTheoGiaSanPhamAjax() {
//        $tblp = new \FontEnd\ProductModel();
//        $data = $tblp->getAllProductFillterByPrice(trim(Input::get('loctheogia')), 12);
//        $link = $data->links();
//        return View::make('fontend.product-categoryAjax')->with('arrProduct', $data)->with('link', $link);
//    }
//
//    public function postLocTheoGiaSanPhamCatAjax() {
//        $tblp = new \FontEnd\ProductModel();
//        $slugcat = trim(Input::get('slugcat'));
//        $data = $tblp->getAllProductFillterByPriceCat($slugcat, trim(Input::get('loctheogia')), 12);
//        $link = $data->links();
//        return View::make('fontend.product-categoryAjax')->with('arrProduct', $data)->with('link', $link);
//    }
//
//    public function postLocDuLieu() {
//        $catslug = trim(Input::get('catslugfillter'));
//        $tblp = new \FontEnd\ProductModel();
//        $data = $tblp->getAllProductFill(trim(Input::get('listmunu')), trim(Input::get('size')), $catslug, 2);
//        $link = $data->links();
//        return View::make('fontend.product-categoryAjax')->with('arrProduct', $data)->with('link', $link);
//    }
//
//    public function postLocDuLieuAjax() {
//        $catslug = trim(Input::get('catslugfillter'));
//        $tblp = new \FontEnd\ProductModel();
//        $data = $tblp->getAllProductFillPrice(trim(Input::get('listmunu')), trim(Input::get('size')), $catslug, 2, trim(Input::get('loctheogia')));
//        $link = $data->links();
//        return View::make('fontend.product-categoryAjax')->with('arrProduct', $data)->with('link', $link);
//    }
}
