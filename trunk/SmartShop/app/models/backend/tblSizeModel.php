<?php

namespace BackEnd;


class tblSizeModel extends \Eloquent {

    protected $table = 'tbl_product_size';
    public $timestamps = false;

    public function addSize($size_name, $size_description) {
        $this->size_name = $size_name;
        $this->size_description = $size_description;
        $result = $this->save();
        return $this;
    }

    public function updateSize($id, $size_name, $size_description) {
        $tableSize = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($size_name != '') {
            $arraysql = array_merge($arraysql, array("size_name" => $size_name));
        }
        if ($size_description != '') {
            $arraysql = array_merge($arraysql, array("size_description" => $size_description));
        }
        $checkupdate = $tableSize->update($arraysql);
        return $checkupdate;
    }

    public function deleteSize($id) {
        $checkdel = $this->where('id', '=', $id)->delete();

        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function selectAllSize($per_page) {
        $allSize = $this->orderBy('size_name')->paginate($per_page);
        return $allSize;
    }

    public function selectAllSizeNoPaginate() {
        $allColor = $this->orderBy('size_name')->get();
        return $allColor;
    }

    public function selectSizeEdit($id) {
        $colorEdit = $this->where('id', $id)->first();
        return $colorEdit;
    }

}
