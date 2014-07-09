<?php

namespace App\Modules\Fontend\Controllers;

use fontend,
    Input,
    Redirect,
    Cart,
    View;

class OrderController extends \BaseController {

    public function postAddCart() {

        $datacart = array(
            'id' => \Input::get('id') . '-' . \Input::get('size') . '-' . \Input::get('color'),
            'name' => \Input::get('name'),
            'size' => \Input::get('size'),
            'color' => \Input::get('color'),
            'price' => \Input::get('price'),
            'sale' => \Input::get('sale'),
            'slug' => \Input::get('slug'),
            'productcode' => \Input::get('code'),
            'quantity' => \Input::get('qty'),
            'image' => \Input::get('img')
        );

        \Cart::insert($datacart);
        $total = 0;
        foreach (\Cart::contents() as $item) {
            $total = $total + $item->quantity;
        }
        echo $total;
    }

    public function postUpdateCart() {
        $idProduct = Input::get('idcart');
        $size = Input::get('size');
        $color = Input::get('color');
        $pID = explode("-", $idProduct);
        //id moi
        $checkID = $pID[0] . '-' . $size . '-' . $color;
        $soluong = Input::get('quantity');
        $productcurent = array();
        foreach (\Cart::contents() as $item) {
            if ($item->id == $idProduct) {
                $productcurent = $item;
            }
        }
        $test = false;
        $iditem = array();
        $dem = 0;
        foreach (\Cart::contents() as $item) {
            if ($item->id == $idProduct) {

                if ($checkID == $idProduct) {
                    $dem = 1;
                    $iditem = $item;
                }
                if ($checkID != $idProduct) {
                    foreach (\Cart::contents() as $item1) {
                        if ($item1->id == $checkID && $idProduct != $item1->id) {
                            $dem = 2;
                            $iditem = $item1;
                        } else {
                            $dem = 1;
                            $iditem = $item1;
                        }
                    }
                }
            }
        }
        if ($dem == 2) {
            foreach (\Cart::contents() as $item) {
                if ($item->id == $checkID) {
                    $item->quantity = $item->quantity + $soluong;
                    foreach (\Cart::contents() as $itemdel) {
                        if ($itemdel->id == $productcurent->id) {
                            $itemdel->remove();
                        }
                    }
                }
            }
            $test == true;
        }
        if ($dem == 1) {
            $datacart = array(
                'id' => $checkID,
                'name' => $iditem->name,
                'size' => $size,
                'color' => $color,
                'price' => $iditem->price,
                'sale' => $iditem->sale,
                'slug' => $iditem->slug,
                'productcode' => $iditem->productcode,
                'quantity' => $soluong,
                'image' => $iditem->image
            );
            foreach (\Cart::contents() as $itemdel) {
                if ($itemdel->id == $idProduct) {
                    $itemdel->remove();
                }
            }
            \Cart::insert($datacart);
        }
         $tongtien = \Cart::total();
        $tongtiensaukhuyenmai = 0;
        $arrid = array();
        foreach (\Cart::contents() as $itemdel) {
            $exid = explode('-', $itemdel->id);
            if (!in_array($exid[0], $arrid)) {
                $arrid[] = $exid[0];
            }
            if ($itemdel->sale != '') {
                $tongtiensaukhuyenmai = $tongtiensaukhuyenmai + $itemdel->sale * $itemdel->quantity;
            } else {
                $tongtiensaukhuyenmai = $tongtiensaukhuyenmai + $itemdel->price * $itemdel->quantity;
            }
        }
        $objp = new \App\Modules\Fontend\Models\ProductModel();
        $sizelist = $objp->getListSizeByIdProduct($arrid);
        $colorlist = $objp->getListColorByIdProduct($arrid);
        return View::make('fontend::CartProductAjax')->with('size', $sizelist)->with('color', $colorlist)->with('listcart', \Cart::contents())->with('tongtien', $tongtiensaukhuyenmai)->with('tongcong', $tongtien);
    }

    public function postDelCart() {
        \Cart::destroy();
    }

    public function getGioHang() {
        $tongtien = \Cart::total();
        $tongtiensaukhuyenmai = 0;
        $arrid = array();
        foreach (\Cart::contents() as $itemdel) {
            $exid = explode('-', $itemdel->id);
            if (!in_array($exid[0], $arrid)) {
                $arrid[] = $exid[0];
            }
            if ($itemdel->sale != '') {
                $tongtiensaukhuyenmai = $tongtiensaukhuyenmai + $itemdel->sale * $itemdel->quantity;
            } else {
                $tongtiensaukhuyenmai = $tongtiensaukhuyenmai + $itemdel->price * $itemdel->quantity;
            }
        }
        $objp = new \App\Modules\Fontend\Models\ProductModel();
        $sizelist = $objp->getListSizeByIdProduct($arrid);
        $colorlist = $objp->getListColorByIdProduct($arrid);
        return View::make('fontend::CartProduct')->with('size', $sizelist)->with('color', $colorlist)->with('listcart', \Cart::contents())->with('tongtien', $tongtiensaukhuyenmai)->with('tongcong', $tongtien);
    }

}
