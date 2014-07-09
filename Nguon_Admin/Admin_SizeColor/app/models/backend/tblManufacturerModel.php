<?php

namespace BackEnd;

use DB,
    BackEnd;

class tblManufacturerModel extends \Eloquent {

    protected $table = 'tbl_product_manufacturer';
    public $timestamps = false;

    public function addManufacturer($Name, $Description, $logo, $Place) {
        $this->manufacturerName = $Name;
        $this->manufacturerDescription = $Description;
        $this->manufacturerPlace = $Place;
        $this->manufacturerLogo = $logo;
        $this->time = time();
        $this->status = 1;
        $result = $this->save();
        return $this;
    }

    public function updateManufacturer($id, $Name, $Description, $logo, $Place) {
        $tableManufacturer = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($Name != '') {
            $arraysql = array_merge($arraysql, array("manufacturerName" => $Name));
        }
        if ($Description != '') {
            $arraysql = array_merge($arraysql, array("manufacturerDescription" => $Description));
        }
        if ($Place != '') {
            $arraysql = array_merge($arraysql, array("manufacturerPlace" => $Place));
        }
        if ($logo != '') {
            $arraysql = array_merge($arraysql, array("manufacturerLogo" => $logo));
        }
        $checkupdate = $tableManufacturer->update($arraysql);
        return $checkupdate;
    }

    public function deleteManufacturer($manufacturerId) {
        $checkdel = $this->where('id', '=', $manufacturerId)->delete();

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

    public function selectAllManufacturer($per_page) {
        $allManufacturer = DB::table('tbl_product_manufacturer')->orderBy('manufacturerName')->paginate($per_page);
        return $allManufacturer;
    }

    public function selectAll() {
        $allManufacturer = DB::table('tbl_product_manufacturer')->orderBy('manufacturerName')->get();
        return $allManufacturer;
    }

    public function getManufacturerById($id) {
        $arrManufacturer = DB::table('tbl_product_manufacturer')->where('id', '=', $id)->first();
        return $arrManufacturer;
    }

}
