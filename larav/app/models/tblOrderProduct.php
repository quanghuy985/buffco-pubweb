<?php

class tblOrderProduct extends Eloquent {

    protected $table = 'tblorder';
    public $timestamps = false;

    public function checkExistSubdomain($subdomain) {
        $check = $this->where('domain', '=', $subdomain)->count();
        return $check;
    }

}
