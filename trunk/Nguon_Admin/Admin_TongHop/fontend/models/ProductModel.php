<?php

namespace App\Modules\Fontend\Models;

use DB;

class ProductModel extends \Eloquent {

    protected $table = 'tblproduct';
    public $timestamps = false;

    public function getAllTags() {
        $arrTags = DB::table('tblproduct')->select('productTag')->where('status', '=', 1)->get();
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
        $arrMenuf = DB::table('tblmanufacturer')->where('status', '=', 1)->get();
        return $arrMenuf;
    }

    public function getListColor() {
        $arrColor = DB::table('tblcolor')->where('status', '=', 1)->get();
        return $arrColor;
    }

    public function getListColorByIdProduct($lisrid) {
        $arrSizereturn = array();
        for ($i = 0; $i < count($lisrid); $i++) {
            $arrSize = DB::table('tblcolor')->join('tblstore', 'tblcolor.id', '=', 'tblstore.colorID')->where('tblcolor.status', '=', 1)->where('tblstore.productID', $lisrid[$i])->select('tblcolor.*')->distinct()->get();
            if ($arrSize != NULL) {
                $arrSizereturn[] = array(
                    'productid' => $lisrid[$i],
                    'value' => $arrSize
                );
            }
        }

        return $arrSizereturn;
    }

    public function getListSizeByIdProduct($lisrid) {
        $arrSizereturn = array();
        for ($i = 0; $i < count($lisrid); $i++) {
            $arrSize = DB::table('tblsize')->join('tblstore', 'tblsize.id', '=', 'tblstore.sizeID')->where('tblsize.status', '=', 1)->where('tblstore.productID', $lisrid[$i])->select('tblsize.*')->distinct()->get();
            if ($arrSize != NULL) {
                $arrSizereturn[] = array(
                    'productid' => $lisrid[$i],
                    'value' => $arrSize
                );
            }
        }

        return $arrSizereturn;
    }

    public function getListSize() {
        $arrSize = DB::table('tblsize')->where('status', '=', 1)->get();
        return $arrSize;
    }

    public function getAllBestSale($number) {
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('daban', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->take($number)->get();
        return $arrProduct;
    }

    public function getAllProduct($per_page) {
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductByTag($tag, $per_page) {
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->where('tblproduct.productTag', 'LIKE', '%' . $tag . '%')->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductFill($manu, $size, $catslug = '', $per_page) {
        if ($manu != '' && $size != '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->whereIn('tblproduct.manufactureID', $manu)->where('tblstore.sizeID', '=', $size)->where('tblcategoryproduct.cateSlug', '=', $catslug)->paginate($per_page);
        } elseif ($manu == '' && $size != '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->where('tblcategoryproduct.cateSlug', '=', $catslug)->where('tblstore.sizeID', '=', $size)->paginate($per_page);
        } elseif ($manu != '' && $size == '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->whereIn('tblproduct.manufactureID', $manu)->where('tblcategoryproduct.cateSlug', '=', $catslug)->paginate($per_page);
        } elseif ($manu == '' && $size == '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->where('tblcategoryproduct.cateSlug', '=', $catslug)->paginate($per_page);
        }
        return $arrProduct;
    }

    public function getAllProductFillPrice($manu, $size, $catslug = '', $per_page, $typesort = 'asc') {
        if ($manu != '' && $size != '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.productPrice', $typesort)->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->whereIn('tblproduct.manufactureID', $manu)->where('tblstore.sizeID', '=', $size)->where('tblcategoryproduct.cateSlug', '=', $catslug)->paginate($per_page);
        } elseif ($manu == '' && $size != '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.productPrice', $typesort)->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->where('tblcategoryproduct.cateSlug', '=', $catslug)->where('tblstore.sizeID', '=', $size)->paginate($per_page);
        } elseif ($manu != '' && $size == '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.productPrice', $typesort)->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->whereIn('tblproduct.manufactureID', $manu)->where('tblcategoryproduct.cateSlug', '=', $catslug)->paginate($per_page);
        } elseif ($manu == '' && $size == '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.productPrice', $typesort)->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->where('tblcategoryproduct.cateSlug', '=', $catslug)->paginate($per_page);
        }
        return $arrProduct;
    }

    public function getAllProductByCat($catslug, $per_page, $typesort) {
        if ($typesort == '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->where('tblcategoryproduct.cateSlug', '=', $catslug)->paginate($per_page);
        } else {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.productPrice', $typesort)->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->where('tblcategoryproduct.cateSlug', '=', $catslug)->paginate($per_page);
        }
        return $arrProduct;
    }

    public function getAllProductByCatFillterByPrice($typesort = 'asc', $catslug, $per_page) {
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.productPrice', $typesort)->groupBy('tblproduct.id')->where('tblcategoryproduct.cateSlug', '=', $catslug)->where('tblproduct.status', '=', 1)->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductFillterByPrice($typesort = 'asc', $per_page) {
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.productPrice', $typesort)->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductFillterByPriceCat($catslug, $typesort = 'asc', $per_page) {
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.productPrice', $typesort)->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->where('tblcategoryproduct.cateSlug', '=', $catslug)->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductFillter($sortby = 'id', $typesort = 'asc', $manuname, $per_page) {
        if ($manuname != '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->leftJoin('tblmanufacturer', 'tblproduct.manufactureID', '=', 'tblmanufacturer.id')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy($sortby, $typesort)->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->where('tblmanufacturer.manufacturerName', '=', $manuname)->paginate($per_page);
        } else {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy($sortby, $typesort)->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->paginate($per_page);
        }
        return $arrProduct;
    }

    public function getAllCatSlug($catslug, $per_page) {
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->leftJoin('tblattachment', 'tblproduct.id', '=', 'tblattachment.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'), 'tblattachment.attachmentURL')->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', 1)->where('tblcategoryproduct.cateSlug', '=', $catslug)->paginate($per_page);
        return $arrProduct;
    }

    public function getAllCat() {
        $arrCategory = DB::table('tblcategoryproduct')->where('status', '=', 1)->orderBy('cateName')->get();
        return arrCategory;
    }

    public function getProductById($id) {
        $arrProduct = $this->where('id', '=', $id)->get();
        return $arrProduct;
    }

    public function getProductBySlug($slug) {
        $arrProduct = DB::table('tblproduct')->leftJoin('tblmanufacturer', 'tblproduct.manufactureID', '=', 'tblmanufacturer.id')->leftJoin('tblattachment', 'tblattachment.productID', '=', 'tblproduct.id')->select('tblproduct.*', 'tblmanufacturer.manufacturerName', 'tblattachment.attachmentURL')->where('tblproduct.productSlug', '=', $slug)->get();
        return $arrProduct;
    }

    public function getColorBySlug($id) {
        $arrColor = DB::table('tblcolor')->join('tblstore', 'tblcolor.id', '=', 'tblstore.colorID')->select('tblcolor.*')->where('tblstore.productID', '=', $id)->groupBy('tblcolor.id')->get();
        return $arrColor;
    }

    public function getStoreBySlug($id) {
        $arrColor = DB::table('tblstore')->select(DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->where('productID', '=', $id)->get();
        return $arrColor;
    }

    public function getSizeBySlug($id) {
        $arrColor = DB::table('tblsize')->join('tblstore', 'tblsize.id', '=', 'tblstore.sizeID')->select('tblsize.*')->where('tblstore.productID', '=', $id)->groupBy('tblsize.id')->get();
        return $arrColor;
    }

    public function getAllCategoryProduct() {
        $arrCatProduct = DB::table('tblcategoryproduct')->where('status', '=', 1)->orderBy('cateName')->get();
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

}
