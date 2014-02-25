<?php

class TblServicesModel extends Eloquent {

    protected $table = 'tblservices';
    public $timestamps = false;

    public function insertServices($servicesName, $servicesContent, $servicesPrices, $servicesPromotion, $servicesSlug) {
        $this->servicesName = $servicesName;
        $this->servicesContent = $servicesContent;
        $this->servicesPrices = $servicesPrices;
        $this->servicesPromotion = $servicesPromotion;
        $this->servicesSlug = $servicesSlug;
        $this->servicesTime = time();
        $this->status = 1;
        $this->save();
    }

    public function updateServices($id, $servicesName, $servicesContent, $servicesPrices, $servicesPromotion, $servicesSlug, $staus) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($servicesName != '') {
            $arraysql = array_merge($arraysql, array("servicesName" => $servicesName));
        }
        if ($servicesContent != '') {
            $arraysql = array_merge($arraysql, array("servicesContent" => $servicesContent));
        }
        if ($servicesPrices != '') {
            $arraysql = array_merge($arraysql, array("servicesPrices" => $servicesPrices));
        }
        if ($servicesPromotion != '') {
            $arraysql = array_merge($arraysql, array("servicesPromotion" => $servicesPromotion));
        }
        if ($servicesSlug != '') {
            $arraysql = array_merge($arraysql, array("servicesSlug" => $servicesSlug));
        }

        if ($staus != '') {
            $arraysql = array_merge($arraysql, array("status" => $staus));
        }

        $checku = $supporter->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function DeleteServices($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function AllSServices($per_page) {
        $adminarray = $this->paginate($per_page);
        return $adminarray;
    }

}
