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
        $objorder = new TblOrderModel();
        $orderdata = $objorder->allOrder(10);
        $page = $orderdata->links();
        if ($thongbao == '') {
            return View::make('backend.orderproduct')->with('orderdata', $orderdata)->with('page', $page);
        } else {
            return View::make('backend.orderproduct')->with('orderdata', $orderdata)->with('page', $page)->with('thongbao', $thongbao);
        }
    }

    public function getEdit($edit) {
        $objorder = new TblOrderModel();
        $orderdata = $objorder->getOrderById($edit);
        return View::make('backend.orderproductedit')->with('orderdata', $orderdata);
    }

    public function postEdit() {
        $rules = array(
            "domain" => "required",
            "diskspace" => "required|numeric",
            "expdate" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objorder = new TblOrderModel();
            $check = $objorder->updateOrder(Input::get('idedit'), Input::get('domaintype'), Input::get('domain'), Input::get('diskspace'), strtotime(Input::get('expdate')), Input::get('status'));
            return Redirect::action('OrderController@getViewAll', array('thongbao' => 'Cập nhật thành công'));
        } else {
            return Redirect::action('OrderController@getViewAll', array('thongbao' => 'Cập lỗi ! Bạn vui lòng cập nhật lại .'));
        }
    }

    public function postPagin() {
        $objorder = new TblOrderModel();
        $orderby = Session::get('orderfillter');
        $orderdata = $objorder->fillterOrder('', 10, $orderby);
        $page = $orderdata->links();
        return View::make('backend.orderproductajax')->with('orderdata', $orderdata)->with('page', $page);
    }

    public function postFillterOrder() {
        Session::put('orderfillter', Input::get('oderbyoption1'));
        $objorder = new TblOrderModel();
        $orderdata = $objorder->fillterOrder('', 10, Input::get('oderbyoption1'));
        $page = $orderdata->links();
        return View::make('backend.orderproductajax')->with('orderdata', $orderdata)->with('page', $page);
    }

    public function postSearchOrder() {
        $objorder = new TblOrderModel();
        $orderdata = $objorder->fillterOrder(Input::get('keyword'), 10, '');
        $page = $orderdata->links();
        return View::make('backend.orderproductajax')->with('orderdata', $orderdata)->with('page', $page);
    }

    public function postDel() {
        $objGsp = new TblOrderModel();
        $data = $objGsp->DeleteOrder(Input::get('id'));
        $orderdata = $objGsp->allOrder(10);
        $page = $orderdata->links();
        return View::make('backend.orderproductajax')->with('orderdata', $orderdata)->with('page', $page);
    }

    public function getOderServices($thongbao = '') {
        $tblOrderServics = new TblServicesOrderModel();
        $orderdata = $tblOrderServics->AllServicesOrder(10);
        $page = $orderdata->links();
        return View::make('backend.orderservice')->with('orderdata', $orderdata)->with('page', $page);
        if ($thongbao == '') {
            return View::make('backend.orderservice')->with('orderdata', $orderdata)->with('page', $page);
        } else {
            return View::make('backend.orderservice')->with('orderdata', $orderdata)->with('page', $page)->with('thongbao', $thongbao);
        }
    }

    public function getOderServicesEdit($id) {
        $tblOrderServics = new TblServicesOrderModel();
        $orderdata = $tblOrderServics->AllServicesOrderById($id);
        return View::make('backend.orderservicesedit')->with('orderdataedit', $orderdata);
        ;
    }

    public function postOderServicesEdit() {
        $objorder = new TblServicesOrderModel();
        $check = $objorder->updateServicesOrder(Input::get('idedit'), Input::get('status'));
        return Redirect::action('OrderController@getOderServices', array('thongbao' => 'Cập nhật thành công'));
    }

    public function postFillterOrderServices() {
        Session::put('orderfillterservices', Input::get('oderbyoption1'));
        $objorder = new TblServicesOrderModel();
        $orderdata = $objorder->fillterOrderServices('', 10, Input::get('oderbyoption1'));
        $page = $orderdata->links();
        return View::make('backend.orderservicesajax')->with('orderdata', $orderdata)->with('page', $page);
    }

    public function postSearchOrderServices() {
        $objorder = new TblServicesOrderModel();
        $orderdata = $objorder->fillterOrderServices(Input::get('keyword'), 10, '');
        $page = $orderdata->links();
        return View::make('backend.orderservicesajax')->with('orderdata', $orderdata)->with('page', $page);
    }

    public function postDelServices() {
        $objGsp = new TblServicesOrderModel();
        $data = $objGsp->DeleteServicesOrder(Input::get('id'));
        $orderdata = $objGsp->AllServicesOrder(10);
        $page = $orderdata->links();
        return View::make('backend.orderservicesajax')->with('orderdata', $orderdata)->with('page', $page);
    }

}
