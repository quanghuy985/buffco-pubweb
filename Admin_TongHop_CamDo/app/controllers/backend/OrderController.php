<?php

namespace BackEnd;

use BackEnd,
    View,
    Input,
    Validator,
    Lang,
    Session,
    Redirect;

class OrderController extends \BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      | Route::get('/', 'HomeController@showWelcome');
      |
     */

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('checkrole');
    }

    public function postOrderFillterView() {
        $one = strtotime(\Input::get('from'));
        $two = strtotime(\Input::get('to'));
        $three = \Input::get('fillter_status');
        if ($one == '') {
            $one = 'null';
        }
        if ($two == '') {
            $two = 'null';
        }
        if ($three == '') {
            $three = 'null';
        }
        return \Redirect::action('\BackEnd\OrderController@getOrderFillterView', array($one, $two, $three));
    }

    public function getOrderFillterView($one = '', $two = '', $three = '') {
        if ($one == 'null') {
            $one = '';
        }
        if ($two == 'null') {
            $two = '';
        } else {
            $two = $two + 24 * 60 * 60;
        }
        if ($three == 'null') {
            $three = '';
        }
        $tblOderModel = new \BackEnd\tblOrderModel();

        $arrOrder = $tblOderModel->getAllOrderFilter($one, $two, $three, 10);
        $page = $arrOrder->links();
        if (\Request::ajax()) {
            return View::make('backend.order.orderproductajax')->with('arrOrder', $arrOrder)->with('page', $page);
        } else {
            return View::make('backend.order.orderproduct')->with('arrOrder', $arrOrder)->with('page', $page)->with('active_menu', 'orderview');
        }
    }

    public function postOrderSearchView() {
        $two = \Input::get('searchblur');
        if ($two == '') {
            $two = 'null';
        }
        return \Redirect::action('\BackEnd\OrderController@getOrderSearchView', array($two));
    }

    public function getOrderSearchView($two = '') {

        if ($two == 'null') {
            $two = '';
        }
        $tblOderModel = new \BackEnd\tblOrderModel();

        $arrOrder = $tblOderModel->getAllOrderSearch($two, 10);
        $page = $arrOrder->links();
        if (\Request::ajax()) {
            return View::make('backend.order.orderproductajax')->with('arrOrder', $arrOrder)->with('page', $page);
        } else {
            return View::make('backend.order.orderproduct')->with('arrOrder', $arrOrder)->with('page', $page)->with('active_menu', 'orderview');
        }
    }

    public function getEdit($orderCode) {
        $tblOderModel = new tblOrderModel();
        $objOrder = $tblOderModel->getOrderByOrderCode($orderCode);
        return View::make('backend.order.orderproductedit')->with('objOrder', $objOrder)->with('active_menu', 'orderview');
    }

    public function getViewAll() {
        $tblOderModel = new tblOrderModel();
        $orderdata = $tblOderModel->allOrder(10, 'time');
        $page = $orderdata->links();
        if (\Request::ajax()) {
            return View::make('backend.order.orderproductajax')->with('arrOrder', $orderdata)->with('page', $page);
        } else {
            return View::make('backend.order.orderproduct')->with('arrOrder', $orderdata)->with('page', $page)->with('active_menu', 'orderview');
        }
    }

    public function postDeleteOrderFromHistoryUser() {
        $page = \Input::get('page');
        $tblOrderModel = new \BackEnd\tblOrderModel();
        $tblOrderModel->deleteOrder(\Input::get('id'));
        // Lưu lại lịch sử
        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.order.delete') . ' ' . \Input::get('id');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        // Quay lại địa chỉ cũ 
        $objOrder = $tblOrderModel->findOrderByID(\Input::get('id'));

        // Lấy lại data để truyền đi

        $tblUserModel = new \BackEnd\tblUserModel();
        $data = $tblUserModel->getUserById($objOrder->user_id);

        $order = $tblOrderModel->getAllOrderByEmail($data->email, 10);

        $tbluserHistory = new \BackEnd\tblHistoryUserModel();
        $history = $tbluserHistory->getHistoryByUserID($data->id);

        return View::make('backend.user.UserDetail')->with('data', $data)->with('arrorder', $order)->with('arrhistory', $history);
        return \Redirect::to(action('\BackEnd\UserController@getUserDetail') . '?page=' . $page);
    }

    public function postUpdateOrder() {

        $value = \Input::get('btSubmit');
        $tblOderModel = new tblOrderModel();
        $orderCode = Input::get('idOrderCode');

        // Khách hàng bấm nút chờ xử lý
        if ($value == \Lang::get('button.order.btDonothing')) {
            $arrOrder = $tblOderModel->getOrderByOrderCode($orderCode);
            //Kiểm trang trạng thái đơn hàng
            // Nếu đơn hàng cũng đang ở trạng thái chờ xử lý hiển thị thông báo không làm gì
            if ($arrOrder[0]->orderStatus == 0) {
                \Session::flash('alert_info', \Lang::get('messages.order.do_nothing'));
                return Redirect::action('\BackEnd\OrderController@getViewAll');
            }
            //Nếu đơn hàng đang ở trạng thái hoàn tất, thông báo cho khách hàng không thể thay đổi trạng thái đơn hàng đã hoàn tất
            if ($arrOrder[0]->orderStatus == 1) {
                \Session::flash('alert_error', \Lang::get('messages.order.done'));
                return Redirect::action('\BackEnd\OrderController@getViewAll');
            }
            // Nếu đơn hàng đang ở trạng thái hủy, update lại trạng thái đơn hàng và lưu lịch sử không thay đổi số lượng hàng hóa trong kho
            if ($arrOrder[0]->orderStatus == 2 || $arrOrder[0]->orderStatus == 3) {
                $tblOderModel->updateStatusOrderByOrderCode($orderCode, 0);

                $objAdmin = \Auth::user();
                $historyContent = \Lang::get('backend/history.order.active') . ' ' . $orderCode;
                $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
                $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

                \Session::flash('alert_success', \Lang::get('messages.order.wait'));
                return Redirect::action('\BackEnd\OrderController@getViewAll');
            }
        }
        // Khách hàng bấm nút chấp nhận đơn hàng chuyển status = 1
        if ($value == \Lang::get('button.order.btAccept')) {
            $arrOrder = $tblOderModel->getOrderByOrderCode($orderCode);

            if ($arrOrder[0]->orderStatus != 1) {
                // Kiem tra xem tat ca san pham trong don hang co con hang hay khong
                $check = False;
                foreach ($arrOrder as $item) {
                    if ($item->quantity <= $item->quantity_sold) {
                        $check = False;
                    } else {
                        $check = TRUE;
                    }
                }
                // Kiem tra hoan tat neu check == true cho thuc hien don hang neu bang false khong xu ly
                if ($check) {
                    foreach ($arrOrder as $item) {
                        $tblOderModel->updateStatusOrderByOrderCode($orderCode, 1);
                        $tblProductModel = new TblProductModel();
                        $tblProductModel->updateProduct($item->product_id, '', '', '', '', '', '', '', '', '', $item->quantity + $item->amount, '', '', '', '', '', '');
                    }
                    $objAdmin = \Auth::user();
                    $historyContent = \Lang::get('backend/history.order.active') . ' ' . $orderCode;
                    $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
                    $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

                    \Session::flash('alert_success', \Lang::get('messages.order.success'));
                    return Redirect::action('\BackEnd\OrderController@getViewAll');
                }
                // Luong hang trong khoa thoa man don hang nay cho update don hang
                else {
                    \Session::flash('alert_error', \Lang::get('messages.order.not_enough'));
                    return Redirect::action('\BackEnd\OrderController@getViewAll');
                }
            } else {
                \Session::flash('alert_info', \Lang::get('messages.order.done'));
                return Redirect::action('\BackEnd\OrderController@getViewAll');
            }
        }
        // Nếu khách hàng bấm nút hủy đơn hàng
        if ($value == \Lang::get('button.order.btDelete')) {
            $tblOderModel->updateStatusOrderByOrderCode($orderCode, 2);
            // Lưu lịch sử
            $objAdmin = \Auth::user();
            $historyContent = \Lang::get('backend/history.order.delete') . ' ' . $orderCode;
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

            \Session::flash('alert_success', \Lang::get('messages.order.delete'));
            return Redirect::action('\BackEnd\OrderController@getViewAll');
        }
    }

    // Phần chưa sửa ----------------------------------->
    // phiên bản chưa sửa


    public function getThongKe() {
        $tblOderModel = new tblOrderModel();
        $from = Input::get('from');
        $to = Input::get('to');
        $count = $tblOderModel->getCountOrderOnDay(time(), time());
        $count_range = $tblOderModel->getCountOrderOnDay($from, $to);
        return View::make('backend.thongke.order')->with('count', $count);
    }

    public function getThongKeAjax() {
        $tblOderModel = new tblOrderModel();
        $from = Input::get('from');
        $to = Input::get('to');
        $count = $tblOderModel->getNewOrderOnDay(time(), time());
        $count_range = $tblOderModel->getCountOrderOnDay($from, $to);
        return View::make('backend.thongke.ajax')->with('count_range', $count_range);
    }

    public function postThongKeOrderAjax() {
        $tblOderModel = new tblOrderModel();
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));
        $count_range = $tblOderModel->getCountOrderOnDay($from, $to);
        $total_range = $tblOderModel->getTotalOrderOnDay($from, $to);
        return View::make('backend.thongke.ajax')->with('count_range', $count_range);
    }

    public function postThongKePriceAjax() {
        $tblOderModel = new tblOrderModel();
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));
        $total_range = $tblOderModel->getTotalOrderOnDay($from, $to);
        return View::make('backend.thongke.ajaxprice')->with('total_range', $total_range);
    }

    public function postSearchDateOrder() {

        $tblOderModel = new tblOrderModel();

        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));


        $data = $tblOderModel->getOrderByDate($from, $to, 5);

        //echo count($data);
        $link = $data->links();

        return View::make('backend.thongke.orderajax')->with('order', $data)->with('link', $link);
    }

}
