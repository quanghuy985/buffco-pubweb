<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class StatisticController extends Controller {

    public function getUserView() {
        $TblUsers = new TblUsersModel();
        $userActive= $TblUsers->getCountUserByStt(0);
        $userActived= $TblUsers->getCountUserByStt(1);
        return View::make('backend.statisticUser')->with('userNoActive',$userActive)->with('userAvtived',$userActived);
    }
    public function getProductView(){
        $TblProduct= new TblProductModel();
        //sản phẩm đã active
        $productActive = $TblProduct->GetProductByStt(1);
        //sản phẩm chưa active
        $productNoActive= $TblProduct->GetProductByStt(0);
        //top 10 sản phẩm mua nhiểu nhất
        $toptenProduct= $TblProduct->getTopTenProduct();       
        return View::make('backend.statisticProduct')->with('productActive',$productActive)->with('productNoActive',$productNoActive)->with('toptenProduct',$toptenProduct);
    }    
}
