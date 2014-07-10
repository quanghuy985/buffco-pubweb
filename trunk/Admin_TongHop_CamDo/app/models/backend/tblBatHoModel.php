<?php

class tblBatHoModel extends Eloquent {

    protected $table = 'tblbatho';
    public $timestamps = false;

    public function dangkyBatHo($userID, $bathoDescription, $giatri, $thucchi, $chuky, $laiky, $from, $to, $status) {
        $this->userID = $userID;
        $this->bathoDescription = $bathoDescription;
        $this->giatri = $giatri;
        $this->thucchi = $thucchi;
        $this->chuky = $chuky;
        $this->laiky = $laiky;
        $this->from = $from;
        $this->to = $to;
        $this->time = time();
        $this->status = $status;
        $check = $this->save();
        return $this->id;
    }

    public function getAllBatHo($orderby, $per_page) {
        $arrBatHo = DB::table('tblbatho')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbatho.*', 'tblusers.userLastName', 'tblusers.userFirstName')->where('tblbatho.status', '!=', '2')->orderBy($orderby, 'desc')->paginate($per_page);
        return $arrBatHo;
    }

    public function getBatHoByID($id) {
        $objBatHo = DB::table('tblbatho')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbatho.*', 'tblusers.userLastName as userLastName ', 'tblusers.userFirstName as userFirstName')->where('tblbatho.id', '=', $id)->get();
        //var_dump($objBatHo);
        return $objBatHo[0];
    }

    public function getBatHoByUserID($userid, $status) {
        if ($status != null || $status != '') {
            $objBatHo = DB::table('tblbatho')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbatho.*', 'tblusers.userLastName as userLastName ', 'tblusers.userFirstName as userFirstName', DB::raw('SUM(tblbatho.giatri) as tonggiatri'), DB::raw('COUNT(tblbatho.id) as tongbatho'))->where('tblbatho.userID', '=', $userid)->where('tblbatho.status', '=', $status)->groupBy('tblbatho.userID')->first();
        } else {
            $objBatHo = DB::table('tblbatho')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbatho.*', 'tblusers.userLastName as userLastName ', 'tblusers.userFirstName as userFirstName', DB::raw('SUM(tblbatho.giatri) as tonggiatri'), DB::raw('COUNT(tblbatho.id) as tongbatho'))->where('tblbatho.userID', '=', $userid)->groupBy('tblbatho.userID')->first();
        }
        return $objBatHo;
    }

    public function getBatHoByUserIDReturnArray($userid, $per_page) {
        $arrBatHo = DB::table('tblbatho')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbatho.*', 'tblusers.userLastName as userLastName ', 'tblusers.userFirstName as userFirstName')->where('tblbatho.userID', '=', $userid)->paginate($per_page);
        return $arrBatHo;
    }

    public function getAllUser() {
        $arrUser = DB::table('tblusers')->select('tblusers.id', 'tblusers.userEmail as userEmail', 'tblusers.userFirstName as userFirstName', 'tblusers.userLastName as userLastName')->where('tblusers.status', '=', 1)->get();
        return $arrUser;
    }

    public function getAllBatHoAjax($from, $to, $status, $keyword, $per_page) {
        $query = DB::table('tblbatho')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbatho.*', 'tblusers.userLastName', 'tblusers.userFirstName');
        if ($from != null) {
            $query->whereBetween('tblbatho.to', array(0, $to));
        }if ($to != null) {
            $query->where('tblbatho.from', '>=', $from);
        }if ($from != null && $to != null) {
            $query->whereBetween('tblbatho.from', array($from, $to))->orwhereBetween('tblbatho.to', array($from, $to));
        }
        if ($status != null) {
            $query->where('tblbatho.status', '=', $status);
        }
        if ($keyword != null) {
            $query->where('tblbatho.bathoDescription', 'LIKE', '%' . $keyword . '%')->orWhere('tblUsers.userFirstName', 'LIKE', '%' . $keyword . '%')->orWhere('tblUsers.userLastName', 'LIKE', '%' . $keyword . '%')->orWhere('tblbatho.giatri', 'LIKE', '%' . $keyword . '%')->orWhere('tblbatho.laiky', 'LIKE', '%' . $keyword . '%');
        }
        $results = $query->orderBy('tblbatho.id', 'desc')->paginate($per_page);
        return $results;
    }

    public function UpdateBatHo($id, $userID, $bathoDescription, $giatri, $thucchi, $chuky, $laiky, $from, $to, $status) {
        $objBatHo = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($userID != '') {
            $arraysql = array_merge($arraysql, array("userID" => $userID));
        }
        if ($bathoDescription != '') {
            $arraysql = array_merge($arraysql, array("bathoDescription" => $bathoDescription));
        }
        if ($giatri != '') {
            $arraysql = array_merge($arraysql, array("giatri" => $giatri));
        }
        if ($thucchi != '') {
            $arraysql = array_merge($arraysql, array("thucchi" => $thucchi));
        }
        if ($chuky != '') {
            $arraysql = array_merge($arraysql, array("chuky" => $chuky));
        }
        if ($laiky != '') {
            $arraysql = array_merge($arraysql, array("laiky" => $laiky));
        }
        if ($from != '') {
            $arraysql = array_merge($arraysql, array("from" => $from));
        }
        if ($to != '') {
            $arraysql = array_merge($arraysql, array("to" => $to));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objBatHo->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function DeleteBatHoByID($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getTienDoByID($bathoID) {
        $arrBatHo = DB::table('tblbathodetail')->leftJoin('tblbatho', 'tblbatho.id', '=', 'tblbathodetail.bathoid')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbathodetail.*', 'tblbatho.bathoDescription', 'tblusers.userLastName as userLastName ', 'tblusers.userFirstName as userFirstName')->where('tblbathodetail.bathoid', '=', $bathoID)->get();
        return $arrBatHo;
    }

    public function UpdateBatHoDetail($id, $timetra, $sotientra, $status) {
        $objBatHoDetail = DB::table('tblbathodetail')->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($timetra != '') {
            $arraysql = array_merge($arraysql, array("timetra" => $timetra));
        }
        if ($sotientra != '') {
            $arraysql = array_merge($arraysql, array("sotientra" => $sotientra));
        } if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objBatHoDetail->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addTienDo($bathoid, $name, $timedukien, $sotiendukien) {
        DB::table('tblbathodetail')->insert(array(
            'bathoid' => $bathoid,
            'name' => $name,
            'timedukien' => $timedukien,
            'timetra' => NULL,
            'sotiendukien' => $sotiendukien,
            'sotientra' => Null,
            'status' => 0
        ));
    }

    public function xoaTienDo($bathoid) {
        $checkdel = DB::table('tblbathodetail')->where('bathoid', '=', $bathoid)->delete();

        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getBatHoByDate($from, $to, $status) {
        $arrBatHo = DB::table('tblbathodetail')->leftJoin('tblbatho', 'tblbatho.id', '=', 'tblbathodetail.bathoid')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbathodetail.*', 'tblbatho.bathoDescription', 'tblusers.userLastName as userLastName ', 'tblusers.userFirstName as userFirstName')->where('tblbathodetail.status', '=', $status)->whereBetween('tblbathodetail.timedukien', array($from, $to))->get();
        return $arrBatHo;
    }

    public function getAllTienDoDaThu($status) {
        $arrBatHo = DB::table('tblbathodetail')->leftJoin('tblbatho', 'tblbatho.id', '=', 'tblbathodetail.bathoid')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbathodetail.*', DB::raw('SUM(tblbathodetail.sotientra) as dathu'))->where('tblbathodetail.status', '=', $status)->groupBy('tblbathodetail.bathoid')->get();
        return $arrBatHo;
    }

    public function xoaTienDoByDate($to) {
        $checkdel = DB::table('tblbathodetail')->where('timedukien', '>', $to)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllBatHoByDateStatus($from, $to, $status) {
        $query = DB::table('tblbatho')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbatho.*', 'tblusers.userLastName', 'tblusers.userFirstName')->where('tblbatho.status', '!=', 2);
        if ($to != null && $from == null) {
            $query->whereBetween('tblbatho.from', array(0, $to));
        }
        if ($from != null && $to == null) {
            $query->where('tblbatho.from', '>=', $from);
        }
        if ($from != null && $to != null) {
            $query->whereBetween('tblbatho.from', array($from, $to));
        }
        if ($status != null) {
            $query->where('tblbatho.status', '=', $status);
        }
        $results = $query->orderBy('tblbatho.id', 'desc')->get();
        return $results;
    }

    public function getAllTienDoByDateStatus($from, $to, $status, $groupby) {
        $query = DB::table('tblbathodetail')->leftJoin('tblbatho', 'tblbatho.id', '=', 'tblbathodetail.bathoid')->leftJoin('tblUsers', 'tblUsers.id', '=', 'tblbatho.userID')->select('tblbathodetail.*', 'tblbatho.bathoDescription', 'tblusers.userLastName as userLastName ', 'tblusers.userFirstName as userFirstName')->where('tblbatho.status', '!=', 2);
        if ($to != null && $from == null) {
            $query->whereBetween('tblbathodetail.timetra', array(0, $to));
        }
        if ($from != null && $to == null) {
            $query->where('tblbathodetail.timetra', '>=', $from);
        }
        if ($from != null && $to != null) {
            $query->whereBetween('tblbathodetail.timetra', array($from, $to));
        }
        if ($status != null) {
            $query->where('tblbathodetail.status', '=', $status);
        }
        if ($groupby != null) {
            $query->selectRaw(DB::raw('SUM(tblbathodetail.sotientra) as tongsotiendatra'));
        }
        $results = $query->get();
        return $results;
    }

}
