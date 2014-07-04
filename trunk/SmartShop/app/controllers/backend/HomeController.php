<?php

namespace BackEnd;

/**
 * Created by PhpStorm.
 * User: Hoang
 * Date: 5/16/14
 * Time: 4:34 PM
 */
use BackEnd,
    View,
    Lang,
    Redirect,
    Session,
    Input,
    Validator;

class HomeController extends \BaseController {

    public function getHome($from = '', $to = '') {
        $tblUserModel = new tblUserModel();
        $arrNewUsers = $tblUserModel->selectNewUser();
//        $CountUsers = $tblUserModel->selectCoutUser();
        $tblNewModel = new tblNewsModel();
        $arrLastNew = $tblNewModel->selectLastNews();

        $tblOrderModel = new tblOrderModel();
//        $CountOrderOk = $tblOrderModel->CountOrderOk(1);
//        $CountOrderPen = $tblOrderModel->CountOrderOk(0);
        $arrOrdernew = $tblOrderModel->GetNewOrderPen(0, 10);
        if ($to != '' && $to != 'null') {
            $to = $to + 24 * 60 * 60;
        } else {
            $to = time() + 24 * 60 * 60;
        }
        if ($from != '' && $from != 'null') {
            $from = $from;
        } else {
            $from = strtotime(date('m/d/Y', strtotime("-7days", $to)));
        }

        $arrloinhuan = $tblOrderModel->getCountOrderOnDay($from, $to, 1);
        $numdate = intval(($to - $from) / 60 / 60 / 24);
        $dateti = array();
        $arrdateti = array();
        $arrreturn = array();
        for ($i = 0; $i < $numdate; $i ++) {
            $y = $numdate - $i;

            if (strtotime(date('m/d/Y', strtotime("-" . $y . "days", $to))) <= $to) {
                $dateti[] = strtotime(date('m/d/Y', strtotime("-" . $y . "days", $to)));
                $lai = 0;
                foreach ($arrloinhuan as $item) {
                    if ($i == 0) {
                        if ($item->time >= $from && $item->time <= $dateti[$i]) {
                            $lai = $lai + $item->loinhuan;
                        }
                    } else {
                        $j = $i - 1;
                        if ($item->time >= $dateti[$j] && $item->time <= $dateti[$i]) {
                            $lai = $lai + $item->loinhuan;
                        }
                    }
                }
                $arrdateti[] = $lai / 1000;
                $arrreturn+=array($dateti[$i] => $arrdateti[$i]);
            }
        }


        $arrloinhuan1 = $tblOrderModel->getCountOrderOnDay($from, $to);
        $numdate1 = intval(($to - $from) / 60 / 60 / 24);
        $dateti1 = array();
        $arrdateti1 = array();
        $arrreturn1 = array();
        for ($i = 0; $i < $numdate1; $i ++) {
            $y = $numdate1 - $i;
            if (strtotime(date('m/d/Y', strtotime("-" . $y . "days", $to))) <= $to) {
                $dateti1[] = strtotime(date('m/d/Y', strtotime("-" . $y . "days", $to)));
                $lai = 0;
                foreach ($arrloinhuan1 as $item) {
                    if ($i == 0) {
                        if ($item->time >= $from && $item->time <= $dateti[$i]) {
                            $lai = $lai + 1;
                        }
                    } else {
                        $j = $i - 1;
                        if ($item->time >= $dateti[$j] && $item->time <= $dateti[$i]) {
                            $lai = $lai + 1;
                        }
                    }
                }
                $arrdateti1[] = $lai;
                $arrreturn1+=array($dateti1[$i] => $arrdateti1[$i]);
            }
        }

        $timeformanaly = $this->first($arrreturn1);
        $timetoanaly = $this->last($arrreturn1);
        $totalorder = 0;
        foreach ($arrdateti1 as $item) {
            $totalorder+=$item;
        }
        $totalai = 0;
        foreach ($arrdateti as $item) {
            $totalai+=$item;
        }
        $tongtien = 0;
        foreach ($arrloinhuan1 as $item) {
            $tongtien+=$item->totalmoney;
        }
        $static = array(
            'timeformanaly' => $timeformanaly,
            'timetoanaly' => $timetoanaly,
            'totalorder' => $totalorder,
            'totalai' => $totalai,
            'tongtien' => $tongtien,
        );
        $count = new tblCountAll();
        return View::make('backend.admin-home')->with('countall', $count->CountAll())->with('arrstatic', $static)->with('arrreturn1', $arrreturn1)->with('arrreturn', $arrreturn)->with('arrOrdernew', $arrOrdernew)->with('arrNewUsers', $arrNewUsers)->with('CountUsers', $count->CountOrder(1))->with('arrLastNew', $arrLastNew)->with('CountOrderOk', $count->CountOrder('0'))->with('CountOrderPen', $count->CountOrder(2));
    }

    public function first($array) {
        if (!is_array($array))
            return $array;
        if (!count($array))
            return null;
        reset($array);
        return key($array);
    }

    public function last($array) {
        if (!is_array($array))
            return $array;
        if (!count($array))
            return null;
        end($array);
        return key($array);
    }

    public function postHome() {

        $one = Input::get('timeform');
        $two = Input::get('timeto');
        if ($one == '') {
            $one = 'null';
        } else {
            $one = strtotime($one);
        }
        if ($two == '') {
            $two = 'null';
        } else {
            $two = strtotime($two);
        }
        return Redirect::action('\BackEnd\HomeController@getHome', array($one, $two));
    }

    public function getProfileAdmin() {

        $email = \Auth::user()->email;
        $tblAdminModel = new \BackEnd\tblUserModel();
        $data = $tblAdminModel->getUserByEmail($email, 1);
        return View::make('backend.admin.adminEditProfile')->with('dataProfile', $data);
    }

    public function postProfileAdmin() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->UpdateUser(\Auth::user()->id, \Auth::user()->mail, \Input::get('password'), \Input::get('firstname'), \Input::get('lastname'), \Input::get('dateofbirth'), \Input::get('address'), \Input::get('phone'), \Input::get('status'), 1, '');

        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.admin.profile');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        \Session::flash('alert_success', \Lang::get('messages.update.success'));
        return \Redirect::action('\BackEnd\HomeController@getProfileAdmin');
    }

    public function getUserHistory($user_id = '') {
        $objHistory = new \BackEnd\tblHistoryUserModel();
        $tblUserModel = new \BackEnd\tblUserModel();
        $objUser = $tblUserModel->getUserById($user_id);
        $check = $objHistory->getHistoryByUserIDPagination($user_id, 10);
        //var_dump($check);
        $link = $check->links();
        if (\Request::ajax()) {
            return View::make('backend.admin.adminHistoryAjax')->with('arrHistory', $check)->with('link', $link);
        } else {
            return View::make('backend.admin.adminHistory')->with('objUser', $objUser)->with('arrHistory', $check)->with('link', $link);
        }
    }

    public function postDelmulte() {
        $objHistory = new \BackEnd\tblHistoryUserModel();
        $user_id = \Input::get('user');
        $pieces1 = explode(",", \Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objHistory->deleteHistory($item);
            }
        }

        $tblUserModel = new \BackEnd\tblUserModel();
        $objUser = $tblUserModel->getUserById($user_id);
        $check = $objHistory->getHistoryByUserIDPagination($user_id, 10);
        //var_dump($check);
        $link = $check->links();
        if (\Request::ajax()) {
            return View::make('backend.admin.adminHistoryAjax')->with('arrHistory', $check)->with('link', $link);
        } else {
            return View::make('backend.admin.adminHistory')->with('objUser', $objUser)->with('arrHistory', $check)->with('link', $link);
        }
    }

    public function postHistoryActive() {
        $tblUserModel = new \BackEnd\tblUserModel();
        $user_id = \Input::get('user');
        $objUser = $tblUserModel->getUserById($user_id);
        $objHistory = new \BackEnd\tblHistoryUserModel();
        $objHistory->updateHistory(\Input::get('id'), \Input::get('status'));

        $check = $objHistory->getHistoryByUserIDPagination($user_id, 10);
        //var_dump($check);
        $link = $check->links();
        if (\Request::ajax()) {
            return View::make('backend.admin.adminHistoryAjax')->with('arrHistory', $check)->with('link', $link);
        } else {
            return View::make('backend.admin.adminHistory')->with('objUser', $objUser)->with('arrHistory', $check)->with('link', $link);
        }
    }

    public function postHistoryUserFillterView() {
        $one = strtotime(\Input::get('from'));
        $two = strtotime(\Input::get('to'));
        $three = \Input::get('fillter_status');
        $user_id = \Input::get('user_id');
        if ($one == '') {
            $one = 'null';
        }
        if ($two == '') {
            $two = 'null';
        } else {
            $two = $two + 24 * 60 * 60;
        }
        if ($three == '') {
            $three = 'null';
        }
        return \Redirect::action('\BackEnd\HomeController@getHistoryUserFillterView', array($one, $two, $three, $user_id));
    }

    public function getHistoryUserFillterView($one = '', $two = '', $three = '', $user_id = '') {
        if ($one == 'null') {
            $one = '';
        }
        if ($two == 'null') {
            $two = '';
        }
        if ($three == 'null') {
            $three = '';
        }
        $tblUserModel = new \BackEnd\tblUserModel();
        $objUser = $tblUserModel->getUserById($user_id);
        $objHistory = new \BackEnd\tblHistoryUserModel();
        $arrHistory = $objHistory->getAllHistoryUser($one, $two, $three, $user_id, 10);
        $link = $arrHistory->links();
        if (\Request::ajax()) {
            return View::make('backend.admin.adminHistoryAjax')->with('arrHistory', $arrHistory)->with('link', $link);
        } else {
            return View::make('backend.admin.adminHistory')->with('objUser', $objUser)->with('arrHistory', $arrHistory)->with('link', $link);
        }
    }

}
