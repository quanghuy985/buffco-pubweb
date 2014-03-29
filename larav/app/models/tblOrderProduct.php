<?php

class tblOrderProduct extends Eloquent {

    protected $table = 'tblorder';
    public $timestamps = false;

    public function checkExistSubdomain($subdomain) {
        $check = $this->where('domain', '=', $subdomain)->count();
        return $check;
    }

    public function checkExistSubdomain2($subdomain) {
        $check = $this->where('domain', '=', $subdomain)->count();
        if ($check == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
