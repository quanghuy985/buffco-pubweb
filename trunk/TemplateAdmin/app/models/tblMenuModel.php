<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblMenuModel extends Eloquent {

    protected $guarded = array();
    protected $table = 'tblMenu';
    public $timestamps = false;
    public static $rules = array();



    public function addMenu($menuName, $menuURL, $menuParent, $menuPosition, $status) {
        $this->menuName = $menuName;
        $this->menuURL = $menuURL;
        $this->menuParent = $menuParent;
        $this->menuPosition = $menuPosition;
        $this->time = time();
        $this->status = $status;
        $result = $this->save();
        return $result;
    }

    public function updateMenu($id, $menuName, $menuURL, $menuParent, $menuPosition, $status) {
        $objMenu = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
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
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objMenu->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findMenuByID($id) {
        $objMenu = DB::table('tblMenu')->where('id', '=', $id)->get();
        return $objMenu;
    }

    public function allMenu($per_page) {
        $arrMenu = DB::table('tblMenu')->orderBy('id', 'desc')->paginate($per_page);
        return $arrMenu;
    }

    public function getMenu() {
        $arrMenu = DB::table('tblMenu')->get();
        return $arrMenu;
    }

    public function deleteMenuByID($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function countURL($url) {
        $objectMenu = DB::table('tblmenu')->where('menuURL', 'LIKE', $url . '%')->count();
        return $objectMenu;
    }

    public function getAllMenuNew($start, $per_page) {
        $results = DB::select("select a.menuName as N1,a.menuName as menuName,a.menuParent as menuParent,a.menuName as menuParentName,a.id as id,a.menuURL as menuURL,a.menuPosition as menuPosition,a.time as time,a.status as status FROM `tblmenu` as a where a.menuParent=0
        UNION ALL
        select a.menuName as N1,b.menuName as menuName,b.menuParent as menuParent,a.menuName as menuParentName,b.id as id,b.menuURL as menuURL,b.menuPosition as menuPosition ,b.time as time,b.status as status  FROM `tblmenu` as a INNER JOIN `tblmenu` as b On a.id = b.menuParent
        ORDER BY menuParent,N1
        LIMIT ?,?", array($start, $per_page));
        return $results;
    }

    public function getAllMenuNewPaginate($per_page) {
        $results = DB::select("select a.menuName as N1,a.menuName as menuName,a.menuParent as menuParent,a.menuName as menuParentName,a.id as id,a.menuURL as menuURL,a.menuPosition as menuPosition,a.time as time,a.status as status FROM `tblmenu` as a where a.menuParent=0
        UNION ALL
        select a.menuName as N1,b.menuName as menuName,b.menuParent as menuParent,a.menuName as menuParentName,b.id as id,b.menuURL as menuURL,b.menuPosition as menuPosition ,b.time as time,b.status as status  FROM `tblmenu` as a INNER JOIN `tblmenu` as b On a.id = b.menuParent
        ORDER BY menuParent,N1
       ");
        return Paginator::make($results, count($results), $per_page);
    }

}
