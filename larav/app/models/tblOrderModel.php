<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblOrderModel extends Eloquent {

    protected $table = 'tblOrder';
    public $timestamps = false;

    public function getOrderByUserId($id) {
        $obj = DB::table('tblorder')->where('userID', '=', $id)->paginate(10);
        return $obj;
    }

    public function addNewOrder($userID, $productID, $domain, $domainType, $orderAmount) {
        $this->userID = $userID;
        $this->productID = $productID;
        $this->domain = $domain;
        $this->domainType = $domainType;
        $this->orderAmount = $orderAmount;
        $this->diskStore = 200;
        $this->advertising = 0;
        $this->orderTime = time();
        $this->status = 0;
        $this->save();
    }

    public function getOrderByDomain($domain) {
        $objOrder = DB::table('tblOrder')->where('domain', '=', $domain)->get();
        return $objOrder;
    }

    public function updateOrderGoBoQuangCao($domain) {
        $checkdel = $this->where('domain', '=', $domain)->update(array('advertising' => 1));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //tính tổng dung lượng của 1 domain đã đăng ký
    public function getTotalStoreByServices($userEmail, $start, $per_page) {
        $obj = DB::select('select  tblorder.domain , tblservices.servicesName,SUM(tblservices.servicesPrices)* 100/15 as Tongcong, max(tblservicesorder.dateExp) as ngayhethan 
            from tblservices
            INNER JOIN tblservicesorder on tblservicesorder.servicesID = tblservices.id 
            INNER Join tblorder on tblservicesorder.orderID = tblorder.id
            inner join tblusers on tblorder.userID = tblusers.id
            where tblusers.userEmail = ?              
            group by tblorder.domain 
            LIMIT ?,?            
            ', array($userEmail, $start, $per_page));
        return $obj;
    }

    public function getTotalStoreByServicesAjax($userEmail, $per_page) {
        $obj = DB::select('select  tblorder.domain , tblservices.servicesName,SUM(tblservices.servicesPrices)* 100/15 as Tongcong, max(tblservicesorder.dateExp) as ngayhethan 
            from tblservices
            INNER JOIN tblservicesorder on tblservicesorder.servicesID = tblservices.id 
            INNER Join tblorder on tblservicesorder.orderID = tblorder.id
            inner join tblusers on tblorder.userID = tblusers.id
            where tblusers.userEmail = ?              
            group by tblorder.domain                      
            ', array($userEmail));
        return Paginator::make($obj, count($obj), $per_page);
    }

}
