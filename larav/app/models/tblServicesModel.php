<?php

class tblServicesModel extends Eloquent {

    protected $table = 'tblservices';
    public $timestamps = false;

    public function getAllServicesAvailable() {
        $arrayServices = DB::table('tblservices')->where('status', '=', '1')->get();
        return $arrayServices;
    }

    public function SelectServicesBySlug($id) {
        $adminarray = DB::table('tblservices')->where('servicesSlug', '=', $id)->get();
        return $adminarray;
    }

}
