<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class StatisticController extends \BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('checkrole');
    }

    public function getThongKeOrder() {
        $tblOderModel = new tblOrderModel();

        $count = $tblOderModel->getCountOrderOnDay(time(), time());
        $total = $tblOderModel->getTotalOrderOnDay(time(), time());

        return View::make('backend.thongke.order')->with('count', $count)->with('total', $total);
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

    public function getThongKeUser() {
        $tblUserModel = new tblUserModel();
        $count = $tblUserModel->getCountUserOnDay(time(), time());
        return View::make('backend.thongke.user')->with('count', $count);
    }

    public function postThongKeUserAjax() {
        $tblUserModel = new tblUserModel();
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));
        $count_range = $tblUserModel->getCountUserOnDay($from, $to);
        return View::make('backend.thongke.ajaxuser')->with('count_range', $count_range);
    }

}
