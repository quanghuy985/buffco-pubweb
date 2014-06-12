<?php

namespace FontEnd;

use Session,
    Input,
    Cookie,
    Redirect,
    View;

class OrderController extends \BaseController {

    public function postThemGioHang() {
        $datacart = array(
            'id' => trim(Input::get('id')) . '-' . trim(Input::get('size')) . '-' . trim(Input::get('color')),
            'name' => trim(Input::get('name')),
            'size' => trim(Input::get('size')),
            'color' => trim(Input::get('color')),
            'price' => trim(Input::get('price')),
            'sale' => trim(Input::get('sale')),
            'slug' => trim(Input::get('slug')),
            'productcode' => trim(Input::get('code')),
            'quantity' => trim(Input::get('qty')),
            'image' => trim(Input::get('img'))
        );

        Cart::insert($datacart);
        $total = 0;
        foreach (Cart::contents() as $item) {
            $total = $total + $item->quantity;
        }
        echo $total;
    }

    public function postDeleteItemCart() {
        $idProduct = trim(Input::get('idcart'));
        foreach (Cart::contents() as $item) {
            if ($item->id == $idProduct) {
                $item->remove();
            }
        }
        $tongtien = Cart::total();
        $tongtiensaukhuyenmai = 0;
        $arrid = array();
        foreach (Cart::contents() as $itemdel) {
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
        $objp = new \FontEnd\ProductModel();
        $sizelist = $objp->getListSizeByIdProduct($arrid);
        $colorlist = $objp->getListColorByIdProduct($arrid);
        return View::make('fontend.CartProductAjax')->with('size', $sizelist)->with('color', $colorlist)->with('listcart', Cart::contents())->with('tongtien', $tongtiensaukhuyenmai)->with('tongcong', $tongtien);
    }

    public function postUpdateCart() {
        $idProduct = trim(Input::get('idcart'));
        $size = trim(Input::get('size'));
        $color = trim(Input::get('color'));
        $pID = explode("-", $idProduct);
        //id moi
        $checkID = $pID[0] . '-' . $size . '-' . $color;
        $soluong = trim(Input::get('quantity'));
        $productcurent = array();
        foreach (Cart::contents() as $item) {
            if ($item->id == $idProduct) {
                $productcurent = $item;
            }
        }
        $test = false;
        $iditem = array();
        $dem = 0;
        foreach (Cart::contents() as $item) {
            if ($item->id == $idProduct) {

                if ($checkID == $idProduct) {
                    $dem = 1;
                    $iditem = $item;
                }
                if ($checkID != $idProduct) {
                    foreach (Cart::contents() as $item1) {
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
            foreach (Cart::contents() as $item) {
                if ($item->id == $checkID) {
                    $item->quantity = $item->quantity + $soluong;
                    foreach (Cart::contents() as $itemdel) {
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
            foreach (Cart::contents() as $itemdel) {
                if ($itemdel->id == $idProduct) {
                    $itemdel->remove();
                }
            }
            Cart::insert($datacart);
        }
        $tongtien = Cart::total();
        $tongtiensaukhuyenmai = 0;
        $arrid = array();
        foreach (Cart::contents() as $itemdel) {
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
        $objp = new \FontEnd\ProductModel();
        $sizelist = $objp->getListSizeByIdProduct($arrid);
        $colorlist = $objp->getListColorByIdProduct($arrid);
        return View::make('fontend.CartProductAjax')->with('size', $sizelist)->with('color', $colorlist)->with('listcart', Cart::contents())->with('tongtien', $tongtiensaukhuyenmai)->with('tongcong', $tongtien);
    }

    public function postDelCart() {
        Cart::destroy();
    }

    public function getGioHang() {
        $tongtien = Cart::total();
        $tongtiensaukhuyenmai = 0;
        $arrid = array();
        foreach (Cart::contents() as $itemdel) {
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
        $objp = new \FontEnd\ProductModel();
        $sizelist = $objp->getListSizeByIdProduct($arrid);
        $colorlist = $objp->getListColorByIdProduct($arrid);
        return View::make('fontend.CartProduct')->with('size', $sizelist)->with('color', $colorlist)->with('listcart', Cart::contents())->with('tongtien', $tongtiensaukhuyenmai)->with('tongcong', $tongtien);
    }

    function generateRandomString($length = 10) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function postGioHang() {
        if (!Session::has('userSession')) {
            Session::forget('urlBack');
            Session::push('urlBack', URL::current());
            return Redirect::action('UserController@getDangKy');
        } else {
            $tongtiensaukhuyenmai = 0;
            foreach (Cart::contents() as $itemdel) {
                if ($itemdel->sale != '') {
                    $tongtiensaukhuyenmai = $tongtiensaukhuyenmai + $itemdel->sale * $itemdel->quantity;
                } else {
                    $tongtiensaukhuyenmai = $tongtiensaukhuyenmai + $itemdel->price * $itemdel->quantity;
                }
            }
            $thanhtoan = trim(Input::get('radio_2'));
            $orderCode = 'PUBWEB -' . $this->generateRandomString(5) . rand(10000000, 100000000);
            $user = Session::get('userSession');
            $receiverName = trim(Input::get('nguoinhan'));
            $receiverPhone = trim(Input::get('dienthoainhan'));
            $orderAddress = trim(Input::get('diachinhan'));
            $productorder = new \FontEnd\ProductModel();
            $productorder->insertOrder($orderCode, $user[0]->id, $receiverName, $receiverPhone, $orderAddress, 0);
            $productorder->updateOrder($orderCode, 1);
            foreach (Cart::contents() as $itemdel) {
                $exid = explode('-', $itemdel->id);
                $productorder = new \FontEnd\ProductModel();
                $total = 0;
                $priceproduct = 0;
                if ($itemdel->sale != '') {
                    $total = $total + $itemdel->sale * $itemdel->quantity;
                    $priceproduct = $itemdel->sale;
                } else {
                    $total = $total + $itemdel->price * $itemdel->quantity;
                    $priceproduct = $itemdel->price;
                }
                $productorder->insertOrderDetail($orderCode, $exid[0], $itemdel->size, $itemdel->color, $itemdel->quantity, $priceproduct, $total);
                $itemdel->remove();
            }
            //Đặt hàng
            if ($thanhtoan == 0) {
                return Redirect::action('OrderController@getGioHang');
            }
            //Thanh toán qua bảo kim
            if ($thanhtoan == 1) {
                $link = 'https://www.nganluong.vn/advance_payment.php';
                $receiver = 'hoangnham01@gmail.com';
                $product = $orderCode;
                $price = $tongtiensaukhuyenmai;
                $return_url = action('OrderController@getGioHang');
                $comment = trim(Input::get('ghichu'));
                $buildurl = $link . '?receiver=' . $receiver . '&product=' . $product . '&price=' . $price . '&return_url=' . $return_url . '&comments=' . $comment;
//            header('Location: ' . $buildurl);

                $data = array('receiver' => $receiver, 'product' => $product, 'price' => $price, 'return_url' => $return_url, 'comments' => $comment);

// use key 'http' even if you send the request to https://...
                $options = array(
                    'http' => array(
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($data),
                    ),
                );
                $context = stream_context_create($options);
                $result = file_get_contents($link, false, $context);
                foreach (Cart::contents() as $itemdel) {
                    $itemdel->remove();
                }
                echo $result;
            }
        }
    }

}
