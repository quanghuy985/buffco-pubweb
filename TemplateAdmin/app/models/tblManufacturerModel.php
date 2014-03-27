<?php

class tblManufacturerModel extends Eloquent{
    
    protected $table = 'tblmanufacturer';
    public $timestamps = false;
    
    public function addManufacturer($Name,$Description,$Place,$time,$status){
        $this->manufacturerName = $Name;
        $this->manufacturerDescription = $Description;
        $this->manufacturerPlace = $Place;
        $this->time = $time;
        $this->status = 0;
        $result = $this->save();
        return $result;        
    }
    
    
    public function updateManufacturer($Id,$Name,$Description,$Place,$time,$status) {
    // $tableAdmin = new TblAdminModel();
        $tableManufacturer = $this->where('id', '=', $Id);
        $arraysql = array('id' => $historyId);
        if ($Name != '') {
            $arraysql = array_merge($arraysql, array("manufacturerName" => $Name));
        }
        if ($Description != '') {
            $arraysql = array_merge($arraysql, array("manufacturerDescription" => $Description));
        }
        if ($Place != '') {
            $arraysql = array_merge($arraysql, array("manufacturerPlace" => $Place));
        }
        if ($time != '') {
            $arraysql = array_merge($arraysql, array("time" => $time));
        }if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        

        $checkupdate = $tableManufacturer->update($arraysql);
        if ($checkupdate > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function deleteManufacturer($manufacturerId) {
        $checkdel = $this->where('id', '=', $manufacturerId)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function findManufacturer($keyword, $per_page) {
        $manufacturerArray = DB::table('tblmanufacturer')->where('id', 'LIKE', '%' . $keyword . '%')->orWhere('manufacturerName', 'LIKE', '%' . $keyword . '%')->orWhere('manufacturerDescription', 'LIKE', '%' . $keyword . '%')->orWhere('manufacturerPlace', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $manufacturerArray;
    }
    
    public function selectAllManufacturer($per_page,$orderby){
        $allManufacturer = DB::table('tblmanufacturer')->select('tblmanufacturer.id', 'tblmanufacturer.manufacturerName','tblmanufacturer.manufacturerDescription','tblmanufacturer.manufacturerPlace','tblmanufacturer.time','tblmanufacturer.status')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allManufacturer;
    }
    
    public function getManufacturerById($id){
        $arrManufacturer = DB::table('tblmanufacturer')->where('id','=',$id)->get();
        return $arrManufacturer;
    }
    
    
    
}
