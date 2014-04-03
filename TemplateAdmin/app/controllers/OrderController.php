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
        // var_dump($objOrder);
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
        //var_dump($arrOrder);
        foreach ($arrOrder as $item) {
            $productID = $item->productID;
            $tblStoreModel = new tblStoreModel();
            $store = $tblStoreModel->findStoreByProductID($productID);
        }
    }

}
