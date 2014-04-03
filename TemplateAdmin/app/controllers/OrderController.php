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
        $orderdata = $tblOderModel->getAllOrder(10);
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
        return View::make('backend.donhang.orderproductedit')->with('objOrder', $objOrder);
    }

    public function postOrderActive($orderCode) {
        
    }

    public function postPagin() {
        $tblOderModel = new tblOrderModel();
        $orderby = Session::get('orderfillter');
        $orderdata = $tblOderModel->fillterOrder('', 10, $orderby);
        $page = $orderdata->links();
        return View::make('backend.orderproductajax')->with('orderdata', $orderdata)->with('page', $page);
    }

    public function postFillterOrder() {
        Session::put('orderfillter', Input::get('oderbyoption1'));
        $tblOderModel = new tblOrderModel();
        $orderdata = $tblOderModel->fillterOrder('', 10, Input::get('oderbyoption1'));
        $page = $orderdata->links();
        return View::make('backend.orderproductajax')->with('orderdata', $orderdata)->with('page', $page);
    }

    public function postSearchOrder() {
        $tblOderModel = new tblOrderModel();
        $orderdata = $tblOderModel->fillterOrder(Input::get('keyword'), 10, '');
        $page = $orderdata->links();
        return View::make('backend.orderproductajax')->with('orderdata', $orderdata)->with('page', $page);
    }

    public function postDel() {
        $objGsp = new tblOrderModel();
        $data = $objGsp->DeleteOrder(Input::get('id'));
        $orderdata = $objGsp->allOrder(10);
        $page = $orderdata->links();
        return View::make('backend.orderproductajax')->with('orderdata', $orderdata)->with('page', $page);
    }

    public function postUpdateOrder() {
        $orderCode = Input::get('idOrderCode');
        $status = Input::get('status');
        $tblOderModel = new tblOrderModel();
        $arrOrder = $tblOderModel->getOrderByOrderCode($orderCode);

        foreach ($arrOrder as $item) {
            $productID = $item->productID;
            $type = $item->type;
            $amount = $item->amount;

            $tblStoreModel = new tblStoreModel();
            $store = $tblStoreModel->findStoreByProductIDAndType($productID, $type);

            $soluongton = $store[0]->soluongnhap - $store[0]->soluongban;

            if ($amount > $soluongton) {
                $objOrder = $tblOderModel->getOrderByOrderCode($orderCode);
                return View::make('backend.donhang.orderproductedit')->with('objOrder', $objOrder)->with('thongbao', 'Số lượng hàng trong kho không đủ để thực hiện đơn hàng này!');
            } else {
                $newAmount = $store[0]->soluongban + $amount;
                $tblStoreModel->updateStore($store[0]->id, '', '', '', $newAmount, '');
                $tblOderModel->updateStatusOrderByOrderCode($orderCode, $status);
                Redirect::action('OrderController@getViewAll')->with('thongbao', 'Đã xử lý đơn đặt hàng thành công!');
            }
        }
    }

}
