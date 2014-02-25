<?php

class TblMenuModel extends Eloquent {

    protected $table = 'tblMenu';
    public $timestamps = false;

    public function addnewMenu($menuName, $menuURL, $menuParent, $menuPosition) {
        $this->menuName = $menuName;
        $this->menuURL = $menuURL;
        $this->menuParent = $menuParent;
        $this->menuPosition = $menuPosition;
        $this->menuTime = time();
        $this->status = 0;
        $this->save();
    }

    public function updateMenu($menuID, $menuName, $menuURL, $menuParent, $menuPosition, $menuStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableMenu = $this->where('id', '=', $menuID);
        $arraysql = array('id' => $menuID);
        if ($menuName != '') {
            $arraysql = array_merge($arraysql, array("menuName" => $menuName));
        }
        if ($menuURL != '') {
            $arraysql = array_merge($arraysql, array("menuURL" => $menuURL));
        }
        if ($menuParent != '') {
            $arraysql = array_merge($arraysql, array("menuParent" => $menuParent));
        }
        if ($menuPosition != '') {
            $arraysql = array_merge($arraysql, array("menuPosition" => $menuPosition));
        }
        if ($menuStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $menuStatus));
        }

        $checku = $tableMenu->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteMenu($menuID) {
        $checkdel = $this->where('id', '=', $menuID)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findMenu($keyword, $per_page) {
        $menuArray = DB::table('tblMenu')->where('menuName', 'LIKE', '%' . $keyword . '%')->orWhere('menuURL', 'LIKE', '%' . $keyword . '%')->orWhere('status', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $menuArray;
    }

    public function selectMenu($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function allMenu($per_page) {
        $alladmin = $this->paginate($per_page);
        return $alladmin;
    }

}
