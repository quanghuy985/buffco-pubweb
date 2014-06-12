<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblGroupRolesModel extends \Eloquent {

    protected $guarded = array();
    protected $table = 'tblgrouproles';
    public $timestamps = false;
    public static $rules = array();

    public function allGroupRoles() {
        $arrGroupRoles = DB::table('tblgrouproles')->get();
        return $arrGroupRoles;
    }

}
