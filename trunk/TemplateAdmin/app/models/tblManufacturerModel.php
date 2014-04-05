<?php

class tblManufacturerModel extends Eloquent{
    
    protected $table = 'tblmanufacturer';
    public $timestamps = false;
    
    public function addManufacturer($Name,$Description,$Place,$status){
        $this->manufacturerName = $Name;
        $this->manufacturerDescription = $Description;
        $this->manufacturerPlace = $Place;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;        
    }
    
    
    public function updateManufacturer($Id,$Name,$Description,$Place,$status) {
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
            $manufarray = DB::table('tblmanufacturer')->select('tblmanufacturer.*')->where('tblmanufacturer.manufacturerDescription', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $manufarray = DB::table('tblmanufacturer')->select('tblmanufacturer.*')->where('tblmanufacturer.manufacturerDescription', 'LIKE', '%' . $keyword . '%')->where('tblmanufacturer.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $manufarray;
    }
    
    public function SearchManufacturer($keyword, $per_page, $orderby, $status) {
        $manufarray = '';
        
        $manufarray = DB::table('tblmanufacturer')->select('tblmanufacturer.*')->where('tblmanufacturer.manufacturerName', 'LIKE', '%' . $keyword . '%')->orwhere('tblmanufacturer.manufacturerPlace', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        
        return $manufarray;
    }
    
    
    public function selectAllManufacturer($per_page,$orderby){
        $allManufacturer = DB::table('tblmanufacturer')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allManufacturer;
    }
    
    public function selectAll($per_page){
        $allManufacturer = DB::table('tblmanufacturer')->paginate($per_page);
        return $allManufacturer;
    }
    
    public function getManufacturerById($id){
        $arrManufacturer = DB::table('tblmanufacturer')->where('id','=',$id)->get();
        return $arrManufacturer[0];
    }
    
    
    
}
