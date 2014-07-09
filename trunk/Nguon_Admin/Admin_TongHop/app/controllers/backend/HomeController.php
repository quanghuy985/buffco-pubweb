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

    public function getSearch() {
       return View::make('backend.searach')  ;
    }

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

        $arrloinhuan = $tblUserModel->getUserByDateAnly($from, $to);
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
                            $lai = $lai + 1;
                        }
                    } else {
                        $j = $i - 1;
                        if ($item->time >= $dateti[$j] && $item->time <= $dateti[$i]) {
                            $lai = $lai + 1;
                        }
                    }
                }
                $arrdateti[] = $lai;
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
        $arrloinhuan2 = $tblOrderModel->getCountOrderOnDay($from, $to, 1);
        $numdate2 = intval(($to - $from) / 60 / 60 / 24);
        $dateti2 = array();
        $arrdateti2 = array();
        $arrreturn2 = array();
        $arrdateti3 = array();
        $arrreturn3 = array();
        for ($i = 0; $i < $numdate2; $i ++) {
            $y = $numdate2 - $i;

            if (strtotime(date('m/d/Y', strtotime("-" . $y . "days", $to))) <= $to) {
                $dateti[] = strtotime(date('m/d/Y', strtotime("-" . $y . "days", $to)));
                $lai = 0;
                $lai1 = 0;
                foreach ($arrloinhuan2 as $item) {
                    if ($i == 0) {
                        if ($item->time >= $from && $item->time <= $dateti[$i]) {
                            $lai = $lai + $item->loinhuan;
                            $lai1 = $lai1 + $item->totalmoney;
                        }
                    } else {
                        $j = $i - 1;
                        if ($item->time >= $dateti[$j] && $item->time <= $dateti[$i]) {
                            $lai = $lai + $item->loinhuan;
                            $lai1 = $lai1 + $item->totalmoney;
                        }
                    }
                }
                $arrdateti2[] = $lai / 1000;
                $arrreturn2+=array($dateti[$i] => $arrdateti2[$i]);
                $arrdateti3[] = $lai1 / 1000;
                $arrreturn3+=array($dateti[$i] => $arrdateti3[$i]);
            }
        }
        $timeformanaly = $this->first($arrreturn1);
        $timetoanaly = $this->last($arrreturn1);
        $totalorder = 0;
        foreach ($arrdateti1 as $item) {
            $totalorder+=$item;
        }
        $totauser = 0;
        foreach ($arrdateti as $item) {
            $totauser+=$item;
        }
        $tongtien = 0;
        $totalai = 0;
        foreach ($arrloinhuan2 as $item) {
            $tongtien+=$item->totalmoney;
            $totalai+=$item->loinhuan;
        }
        $static = array(
            'timeformanaly' => $timeformanaly,
            'timetoanaly' => $timetoanaly,
            'totalorder' => $totalorder,
            'totauser' => $totauser,
            'totalai' => $totalai,
            'tongtien' => $tongtien,
        );
        $count = new tblCountAll();
        return View::make('backend.admin-home')->with('arrreturn2', $arrreturn2)->with('arrreturn3', $arrreturn3)->with('countall', $count->CountAll())->with('arrstatic', $static)->with('arrreturn1', $arrreturn1)->with('arrreturn', $arrreturn)->with('arrOrdernew', $arrOrdernew)->with('arrNewUsers', $arrNewUsers)->with('CountUsers', $count->CountOrder(1))->with('arrLastNew', $arrLastNew)->with('CountOrderOk', $count->CountOrder('0'))->with('CountOrderPen', $count->CountOrder(2));
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

        $id = \Auth::user()->id;
        $tblAdminModel = new \BackEnd\tblUserModel();
        $data = $tblAdminModel->getProfileByID($id, 1);
        return View::make('backend.admin.adminEditProfile')->with('dataProfile', $data);
    }

    public function postProfileAdmin() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'dateofbirth' => 'required',
            'address' => 'required',
            'phone' => 'numeric'
        );
        $validator = \Validator::make(\Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.admin'));
        if ($validator->passes()) {
            $tblAdminModel->UpdateUser(\Auth::user()->id, \Auth::user()->mail, \Input::get('password'), \Input::get('firstname'), \Input::get('lastname'), \Input::get('dateofbirth'), \Input::get('address'), \Input::get('phone'), \Input::get('status'), 1, '');

            $objAdmin = \Auth::user();
            $historyContent = \Lang::get('backend/history.admin.profile');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

            \Session::flash('alert_success', \Lang::get('messages.update.success'));
            return \Redirect::action('\BackEnd\HomeController@getProfileAdmin');
        } else {
            \Session::flash('alert_error', \Lang::get('messages.update.error'));
            return \Redirect::action('\BackEnd\HomeController@getProfileAdmin')->withErrors($validator->messages());
        }
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
