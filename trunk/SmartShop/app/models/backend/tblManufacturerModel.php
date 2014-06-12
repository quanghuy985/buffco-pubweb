<?php

namespace BackEnd;

use DB,
    BackEnd;

class tblManufacturerModel extends \Eloquent {

    protected $table = 'tbl_product_manufacturer';
    public $timestamps = false;

    public function addManufacturer($Name, $Description, $Place, $status) {
        $this->manufacturerName = $Name;
        $this->manufacturerDescription = $Description;
        $this->manufacturerPlace = $Place;
        $this->time = time();
        $this->status = $status;
        $result = $this->save();
        return $this;
    }

    public function updateManufacturer($Id, $Name, $Description, $Place, $status) {
        // $tableAdmin = new TblAdminModel();
        $tableManufacturer = $this->where('id', '=', $Id);
        $arraysql = array('id' => $Id);
        if ($Name != '') {
            $arraysql = array_merge($arraysql, array("manufacturerName" => $Name));
        }
        if ($Description != '') {
            $arraysql = array_merge($arraysql, array("manufacturerDescription" => $Description));
        }
        if ($Place != '') {
            $arraysql = array_merge($arraysql, array("manufacturerPlace" => $Place));
        }if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checkupdate = $tableManufacturer->update($arraysql);
        return $checkupdate;
    }

    public function deleteManufacturer($manufacturerId) {
        $checkdel = $this->where('id', '=', $manufacturerId)->update(array('status' => 2));

        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findManufacturer($keyword, $per_page, $orderby, $status) {
        $manufarray = '';
        if ($status == '') {
            $manufarray = DB::table('tbl_product_manufacturer')->select('tbl_product_manufacturer.*')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $manufarray = DB::table('tbl_product_manufacturer')->select('tbl_product_manufacturer.*')->where('tbl_product_manufacturer.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $manufarray;
    }

    public function SearchManufacturer($keyword, $per_page, $orderby, $status) {
        $manufarray = '';

        $manufarray = DB::table('tbl_product_manufacturer')->select('tbl_product_manufacturer.*')->where('tbl_product_manufacturer.manufacturerName', 'LIKE', '%' . $keyword . '%')->orwhere('tbl_product_manufacturer.manufacturerPlace', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);

        return $manufarray;
    }

    public function selectAllManufacturer($per_page, $orderby) {
        $allManufacturer = DB::table('tbl_product_manufacturer')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allManufacturer;
    }

    public function selectAll() {
        $allManufacturer = DB::table('tbl_product_manufacturer')->orderBy('manufacturerName')->get();
        return $allManufacturer;
    }

    public function getManufacturerById($id) {
        $arrManufacturer = DB::table('tbl_product_manufacturer')->where('id', '=', $id)->get();
        return $arrManufacturer[0];
    }

}
