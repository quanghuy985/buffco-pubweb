<?php

class OrderController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    public function getViewAll($thongbao = '') {
        $tblOderModel = new tblOrderModel();
        $orderdata = $tblOderModel->allOrder(10, 'time');
        $page = $orderdata->links();

        if ($thongbao == '') {
            return View::make('backend.donhang.orderproduct')->with('arrOrder', $orderdata)->with('page', $page);
        } else {
            return View::make('backend.donhang.orderproduct')->with('arrOrder', $orderdata)->with('page', $page)->with('thongbao', $thongbao);
        }
    }

    public function getEdit($orderCode) {
        $tblOderModel = new tblOrderModel();
        $objOrder = $tblOderModel->getOrderByOrderCode($orderCode);
        $arrayStore = array();
        foreach ($objOrder as $item) {
            $productID = $item->productID;
            $sizeID = $item->sizeID;
            $colorID = $item->colorID;
            $amount = $item->amount;

            $tblStoreModel = new tblStoreModel();
            $store = $tblStoreModel->findStoreByProductIDAndType($productID, $sizeID, $colorID);

            array_push($arrayStore, $store[0]);
        }
        // var_dump($objOrder);
        return View::make('backend.donhang.orderproductedit')->with('objOrder', $objOrder)->with('arrayStore', $arrayStore);
    }


    public function postAjaxOrder() {
        $tblOderModel = new tblOrderModel();
        $orderdata = $tblOderModel->allOrder(10, 'time');
        $page = $orderdata->links();
        return View::make('backend.donhang.orderproduct')->with('arrOrder', $orderdata)->with('page', $page);
    }

    public function postAjaxSearchOrder() {
        $tblOderModel = new tblOrderModel();
        $orderdata = $tblOderModel->searchOrders(10, trim(Input::get('keyword')));
        $link = $orderdata->links();
        return View::make('backend.donhang.orderproductajax')->with('arrOrder', $orderdata)->with('page', $link);
    }

    public function postAjaxOrderFilter() {
        $from = strtotime(Input::get('fromtime'));
        $to = strtotime(Input::get('totime'));
        $status = Input::get('status');

        $tblOderModel = new tblOrderModel();
        $arrOrder = $tblOderModel->fillterOrders(10, $from, $to, $status);
        // var_dump($arrNews);
        $link = $arrOrder->links();
        return View::make('backend.donhang.orderproductajax')->with('arrOrder', $arrOrder)->with('page', $link);
    }

    public function postDel() {
        $objGsp = new tblOrderModel();
        $data = $objGsp->DeleteOrder(Input::get('id'));
        $orderdata = $objGsp->allOrder(10, 'time');

        $page = $orderdata->links();
        return View::make('backend.donhang.orderproductajax')->with('arrOrder', $orderdata)->with('page', $page);
    }

    public function postUpdateOrder() {
        $tblOderModel = new tblOrderModel();
        $orderCode = Input::get('idOrderCode');
        $status = Input::get('status');
        $arrayStore = array();
        if ($status == 0) {
            return Redirect::action('OrderController@getViewAll', array('thongbao' => 'Bạn chưa xử lý đơn hàng!'));
        }
        if ($status == 1) {
            $arrOrder = $tblOderModel->getOrderByOrderCode($orderCode);
            if ($arrOrder[0]->orderStatus == 0 || $arrOrder[0]->orderStatus == 2) {
                // Kiem tra xem tat ca san pham trong don hang co con hang hay khong
                $check = False;
                foreach ($arrOrder as $item) {
                    $productID = $item->productID;
                    $sizeID = $item->sizeID;
                    $colorID = $item->colorID;
                    $amount = $item->amount;

                    $tblStoreModel = new tblStoreModel();
                    $store = $tblStoreModel->findStoreByProductIDAndType($productID, $sizeID, $colorID);

                    $soluongton = $store[0]->soluongnhap - $store[0]->soluongban;

                    if ($amount > $soluongton) {
                        $check = False;
//                        array_push($arrayStore, $store[0]);
//                        $objOrder = $tblOderModel->getOrderByOrderCode($orderCode);
//                        return View::make('backend.donhang.orderproductedit')->with('objOrder', $objOrder)->with('arrayStore', $arrayStore)->with('thongbao', 'Số lượng hàng trong kho không đủ để thực hiện đơn hàng này!');
                    } else {
                        $check = TRUE;
//                        $newAmount = $store[0]->soluongban + $amount;
//                        $tblStoreModel->updateStore($store[0]->id, '', '', '', $newAmount, '');
//                        $tblOderModel->updateStatusOrderByOrderCode($orderCode, $status);
                    }
                }
                // Kiem tra hoan tat neu check == true cho thuc hien don hang neu bang false khong xu ly
                if ($check) {
                    foreach ($arrOrder as $item) {
                        $productID = $item->productID;
                        $sizeID = $item->sizeID;
                        $colorID = $item->colorID;
                        $amount = $item->amount;

                        $tblStoreModel = new tblStoreModel();
                        $store = $tblStoreModel->findStoreByProductIDAndType($productID, $sizeID, $colorID);

                        $soluongton = $store[0]->soluongnhap - $store[0]->soluongban;

                        $newAmount = $store[0]->soluongban + $amount;
                        $tblStoreModel->updateStore($store[0]->id, '', '', '', $newAmount, '');
                        $tblOderModel->updateStatusOrderByOrderCode($orderCode, $status);
                    }
                    return Redirect::action('OrderController@getViewAll', array('thongbao' => 'Đã xử lý đơn đặt hàng thành công!'));
                }
                // Luong hang trong khoa thoa man don hang nay cho update don hang
                else {
                    array_push($arrayStore, $store[0]);
                    $objOrder = $tblOderModel->getOrderByOrderCode($orderCode);
                    return View::make('backend.donhang.orderproductedit')->with('objOrder', $objOrder)->with('arrayStore', $arrayStore)->with('thongbao', 'Số lượng hàng trong kho không đủ để thực hiện đơn hàng này!');
                }
            } else {
                return Redirect::action('OrderController@getViewAll', array('thongbao' => 'Không thể cập nhật đơn hàng!'));
            }
        }
        if ($status == 2) {
            $tblOderModel->updateStatusOrderByOrderCode($orderCode, $status);
            return Redirect::action('OrderController@getViewAll', array('thongbao' => 'Đã xóa đơn đặt hàng!'));
        }
    }

}
