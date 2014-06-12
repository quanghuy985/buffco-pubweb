<?php

namespace FontEnd;

use DB;

class ProductModel extends \Eloquent {

    protected $table = 'tbl_product';
    public $timestamps = false;

    public function getAllTags() {
        $arrTags = DB::table('tbl_product')->select('productTag')->where('status', '=', 1)->get();
        $tags = array();
        foreach ($arrTags as $value) {
            $tag = explode(',', $value->productTag);
            foreach ($tag as $item) {
                if (!in_array($item, $tags)) {
                    $tags[] = $item;
                }
            }
        }
        return $tags;
    }

    public function getListManufacture() {
        $arrMenuf = DB::table('tbl_product_manufacturer')->where('status', '=', 1)->get();
        return $arrMenuf;
    }

    public function getAllBestSale($number) {
        $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName',  'tbl_attachment.attachmentURL')->orderBy('quantity_sold', 'desc')->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->take($number)->get();
        return $arrProduct;
    }

    public function getAllProduct($per_page) {
        $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy('tbl_product.id', 'desc')->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductByTag($tag, $per_page) {
        $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy('tbl_product.id', 'desc')->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->where('tbl_product.productTag', 'LIKE', '%' . $tag . '%')->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductFillPrice($manu, $catslug, $typesort = 'asc', $per_page) {
        if ($manu != '') {
            $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy('tbl_product.productPrice', $typesort)->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->whereIn('tbl_product.manufactureID', $manu)->where('tbl_product_category.cateSlug', '=', $catslug)->paginate($per_page);
        } elseif ($manu == '') {
            $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy('tbl_product.productPrice', $typesort)->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->where('tbl_product_category.cateSlug', '=', $catslug)->paginate($per_page);
        }
        return $arrProduct;
    }

    public function getAllProductByCat($catslug, $per_page, $typesort) {
        if ($typesort == '') {
            $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy('tbl_product.id', 'desc')->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->where('tbl_product_category.cateSlug', '=', $catslug)->paginate($per_page);
        } else {
            $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy('tbl_product.productPrice', $typesort)->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->where('tbl_product_category.cateSlug', '=', $catslug)->paginate($per_page);
        }
        return $arrProduct;
    }

    public function getAllProductByCatFillterByPrice($typesort = 'asc', $catslug, $per_page) {
        $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy('tbl_product.productPrice', $typesort)->groupBy('tbl_product.id')->where('tbl_product_category.cateSlug', '=', $catslug)->where('tbl_product.status', '=', 1)->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductFillterByPrice($typesort = 'asc', $per_page) {
        $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy('tbl_product.productPrice', $typesort)->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductFillterByPriceCat($catslug, $typesort = 'asc', $per_page) {
        $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy('tbl_product.productPrice', $typesort)->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->where('tbl_product_category.cateSlug', '=', $catslug)->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductFillter($sortby = 'id', $typesort = 'asc', $manuname, $per_page) {
        if ($manuname != '') {
            $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->leftJoin('tbl_product_manufacturer', 'tbl_product.manufactureID', '=', 'tbl_product_manufacturer.id')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy($sortby, $typesort)->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->where('tbl_product_manufacturer.manufacturerName', '=', $manuname)->paginate($per_page);
        } else {
            $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy($sortby, $typesort)->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->paginate($per_page);
        }
        return $arrProduct;
    }

    public function getAllCatSlug($catslug, $per_page) {
        $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_product_category.cateName', 'tbl_attachment.attachmentURL')->orderBy('tbl_product.id', 'desc')->groupBy('tbl_product.id')->where('tbl_product.status', '=', 1)->where('tbl_product_category.cateSlug', '=', $catslug)->paginate($per_page);
        return $arrProduct;
    }

    public function getAllCat() {
        $arrCategory = DB::table('tbl_product_category')->where('status', '=', 1)->orderBy('cateName')->get();
        return $arrCategory;
    }

    public function getProductById($id) {
        $arrProduct = $this->where('id', '=', $id)->get();
        return $arrProduct;
    }

    public function getProductBySlug($slug) {
        $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_product_manufacturer', 'tbl_product.manufactureID', '=', 'tbl_product_manufacturer.id')->leftJoin('tbl_attachment', 'tbl_attachment.destinyID', '=', 'tbl_product.id')->select('tbl_product.*', 'tbl_product_category.cateSlug', 'tbl_product_category.cateName', 'tbl_product_manufacturer.manufacturerName', 'tbl_attachment.attachmentURL')->groupBy('tbl_product.id')->where('tbl_product.productSlug', '=', $slug)->get();
        return $arrProduct;
    }

    public function getProductRelate($catid, $per) {
        $arrProduct = DB::table('tbl_product')->join('tbl_product_category', 'tbl_product.cateID', '=', 'tbl_product_category.id')->leftJoin('tbl_attachment', 'tbl_product.id', '=', 'tbl_attachment.destinyID')->select('tbl_product.*', 'tbl_attachment.attachmentURL')->where('tbl_product.status', '=', 1)->groupBy('tbl_product.id')->orderBy('tbl_product.id', 'desc')->take($per)->get();
        return $arrProduct;
    }

    public function getAllCategoryProduct() {
        $arrCatProduct = DB::table('tbl_product_category')->where('status', '=', 1)->orderBy('cateName')->get();
        return $arrCatProduct;
    }


    public function updateRate($id, $total_votes, $total_value) {
        $product = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($total_votes != '') {
            $arraysql = array_merge($arraysql, array("total_votes" => $total_votes));
        }
        if ($total_value != '') {
            $arraysql = array_merge($arraysql, array("total_value" => $total_value));
        }
        $arraysql = array_merge($arraysql, array("used_ips" => $_SERVER['REMOTE_ADDR']));
        $arraysql = array_merge($arraysql, array("datevote" => time()));
        $checku = $product->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function generateRandomString($length = 10) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function insertOrder($orderCode, $userID, $receiverName, $receiverPhone, $orderAddress, $status) {
        DB::table('tbl_product_order')->insert(
                array(
                    'orderCode' => $orderCode,
                    'user_id' => $userID,
                    'receiverName' => $receiverPhone,
                    'receiverPhone' => $orderAddress,
                    'orderAddress' => $orderAddress,
                    'time' => time(),
                    'status' => $status
                )
        );
        return true;
    }

    public function insertOrderDetail($orderCode, $productID, $sizeID, $colorID, $amount, $productPrice, $total) {
        DB::table('tbl_product_order_detail')->insert(
                array(
                    'orderCode' => $orderCode,
                    'productID' => $productID,
                    'sizeID' => $sizeID,
                    'colorID' => $colorID,
                    'amount' => $amount,
                    'productPrice' => $productPrice,
                    'total' => $total,
                    'time' => time(),
                    'status' => 1
                )
        );
        return true;
    }

    public function updateOrder($orderCode, $status) {
        DB::table('tbl_product_order')
                ->where('orderCode', '=', $orderCode)
                ->update(array('status' => $status));
    }

}
