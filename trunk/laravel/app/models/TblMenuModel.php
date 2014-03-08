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
        $checkdel = $this->where('id', '=', $menuID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteMenuChild($menuID) {
        $checkdel = $this->where('menuParent', '=', $menuID)->update(array('status' => 2));
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
        $alladmin = DB::table('tblMenu')->paginate($per_page);
        return $alladmin;
    }

    public function SelectMenuById($id) {
        $adminarray = DB::table('tblMenu')->where('id', '=', $id)->get();
        return $adminarray[0];
    }

    public function getAllMenu($start, $per_page) {
        $results = DB::select("select a.menuName as N1,a.menuName as menuName,a.menuURL as menuURL,a.menuParent as menuParent,a.menuPosition as menuPosition,a.id as id,a.menuTime as menuTime,a.status as status FROM `tblmenu` as a where a.menuParent=0
        UNION ALL
        select a.menuName as N1,b.menuName as menuName,b.menuURL as menuURL,b.menuParent as menuParent,b.menuPosition as menuPosition,b.id as id,b.menuTime as menuTime,b.status as status  FROM `tblmenu` as a INNER JOIN `tblmenu` as b On a.id = b.menuParent
        ORDER BY N1,menuParent
        LIMIT ?,?", array($start, $per_page));
        return $results;
    }

    public function getAllMenuPagin($per_page) {
        $results1 = DB::select("select a.menuName as N1,a.menuName as menuName,a.menuURL as menuURL,a.menuParent as menuParent,a.menuPosition as menuPosition,a.id as id,a.menuTime as menuTime,a.status as status FROM `tblmenu` as a where a.menuParent=0
        UNION ALL
        select a.menuName as N1,b.menuName as menuName,b.menuURL as menuURL,b.menuParent as menuParent,b.menuPosition as menuPosition,b.id as id,b.menuTime as menuTime,b.status as status  FROM `tblmenu` as a INNER JOIN `tblmenu` as b On a.id = b.menuParent
        ORDER BY N1,menuParent");
        return Paginator::make($results1, count($results1), $per_page);
        ;
    }

}
