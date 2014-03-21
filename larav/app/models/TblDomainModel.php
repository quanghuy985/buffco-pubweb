<?php

class TblDomainModel extends Eloquent {

    protected $table = 'tbldomainlist';
    public $timestamps = false;

    public function getDomainByExt($ext) {
        $data = DB::table('tbldomainlist')->where('extDomain', '=', $ext)->get();
        return $data;
    }

    public function getDomainList() {
        $domainlist = $this->where('status', '=', 1)->get();
        return $domainlist;
    }

}
