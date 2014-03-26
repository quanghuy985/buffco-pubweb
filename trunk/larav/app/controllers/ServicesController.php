<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ServicesController extends Controller {

    public function getDichVu() {
        return View::make("fontend.servicesView");
    }

    public function getDangKyDichVu() {
        $tblOrderModel = new tblOrderModel();
        $tblServicesModel = new tblServicesModel();
        if (Session::has('userSession')) {
            $objUser = Session::get('userSession');
            $arrayOrder = $tblOrderModel->getOrderByUserID($objUser[0]->id);
            if ($arrayOrder != null) {
                $objServices = $tblServicesModel->getAllServicesAvailable();
                return View::make("fontend.servicesOrder")->with('objservices', $objServices)->with('objusers', $objUser)->with("arrayOrder", $arrayOrder);
            } else {
                $thongbao = "Bạn phải đăng ký website trước khi dùng dịch vụ của chúng tôi";
                return View::make("fontend.servicesView")->with('thongbao', $thongbao);
            }
        } else {
            Session::forget('urlBack');
            Session::push('urlBack', URL::current());
            //Session::set('ServicesOrderURL', $objServices);
            return View::make("fontend.login");
        }
    }

    public function postDangKyDichVu() {
        $tblServicesModel = new tblServicesModel();
        $tblOrderModel = new tblOrderModel();
        $objServices = '';
        //Kiem tra dang nhap 
        if (Session::has('userSession')) {
            $objUser = Session::get('userSession');
            $arrayOrder = $tblOrderModel->getOrderByUserID($objUser[0]->id);
            if ($arrayOrder != null) {
                $objServices = $tblServicesModel->getAllServicesAvailable();
                return View::make("fontend.servicesOrder")->with('objservices', $objServices)->with('objusers', $objUser)->with("arrayOrder", $arrayOrder);
            } else {
                $thongbao = "Bạn phải đăng ký website trước khi dùng dịch vụ của chúng tôi";
                return View::make("fontend.servicesView")->with('thongbao', $thongbao);
            }
        }
        //chua dang nhap chuyen ve trang login de dang nhap
        else {
            Session::forget('urlBack');
            Session::push('urlBack', URL::current());
            //Session::set('ServicesOrderURL', $objServices);
            return View::make("fontend.login");
        }
    }

    public function postAdvertising() {
        if (Input::get('domain') != '') {
            $tblOrderModel = new tblOrderModel();
            $objOrder = $tblOrderModel->getOrderByDomain(Input::get('domain'));
            // var_dump($objOrder);
            if ($objOrder[0]->advertising == 0) {
                return 'FALSE';
            } else {
                return 'TRUE';
            }
        } else {
            echo 'FALSE';
        }
    }

    public function postServicesPrices() {
        if (Input::get('id') != '') {
            $tblServices = new tblServicesModel();

            $objServices = $tblServices->SelectServicesBySlug(Input::get('id'));

            // var_dump($objOrder);
            if (count($objServices) == 0) {
                return 'FALSE';
            } else {
                return json_encode($objServices[0]);
            }
        } else {
            echo 'FALSE';
        }
    }

}
