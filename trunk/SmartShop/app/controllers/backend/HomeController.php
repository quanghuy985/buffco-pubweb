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


        $arrloinhuan = $tblOrderModel->getCountOrderOnDay($from, $to);
        $numdate1 = intval(($to - $from) / 60 / 60 / 24);
        $dateti1 = array();
        $arrdateti1 = array();
        $arrreturn1 = array();
        for ($i = 0; $i < $numdate1; $i ++) {
            $y = $numdate1 - $i;
            if (strtotime(date('m/d/Y', strtotime("-" . $y . "days", $to))) <= $to) {
                $dateti1[] = strtotime(date('m/d/Y', strtotime("-" . $y . "days", $to)));
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
        $static = array(
            'timeformanaly' => $timeformanaly,
            'timetoanaly' => $timetoanaly,
            'totalorder' => $totalorder,
            'totalai' => $totalai,
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

}
