<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ServicesController extends Controller {

    public function getAllServices() {
        $tblServicesModel = new tblServicesModel();
        $arrayServices = $tblServicesModel->getAllServicesAvailable(15);
        //$link = $arrayServices->links();
       // var_dump($arrayServices);
        return View::make("fontend.servicesView")->with('arrayServices', $arrayServices);
    }

}
