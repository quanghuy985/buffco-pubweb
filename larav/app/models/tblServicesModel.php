<?php

class tblServicesModel extends Eloquent {

    protected $table = 'tblservices';
    public $timestamps = false;

    public function getAllServicesAvailable($per_page) {
        $arrayServices = DB::table('tblservices')->where('status', '=', '1')->orderBy('servicesSlug', 'desc')->paginate($per_page);
        return $arrayServices;
    }

    public function SelectServicesById($id) {
        $adminarray = DB::table('tblservices')->where('id', '=', $id)->get();
        return $adminarray[0];
    }

}
