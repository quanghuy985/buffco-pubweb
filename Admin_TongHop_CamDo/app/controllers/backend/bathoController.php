<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class bathoController extends Controller {

    function getAllBatHo() {
        $tblBatHoModel = new tblBatHoModel();
        $arrBatHo = $tblBatHoModel->getAllBatHo('id', 5);
        $arrTienDoDaThu = $tblBatHoModel->getAllTienDoDaThu(1);
        $link = $arrBatHo->links();
        $arrUser = $tblBatHoModel->getAllUser();


        return View::make('backend.camdo.bathoManage')->with('arrBatHo', $arrBatHo)->with('link', $link)->with('arrUser', $arrUser)->with('arrTienDoDaThu', $arrTienDoDaThu);
    }

    function getBatHoEdit() {
        $tblBatHoModel = new tblBatHoModel();
        $arrBatHo = $tblBatHoModel->getAllBatHo('id', 5);
        $link = $arrBatHo->links();
        $objBatHo = $tblBatHoModel->getBatHoByID(Input::get('id'));
        $arrTienDoDaThu = $tblBatHoModel->getAllTienDoDaThu(1);
        // var_dump($objBatHo);
        $arrUser = $tblBatHoModel->getAllUser();
        return View::make('backend.camdo.bathoManage')->with('arrBatHo', $arrBatHo)->with('link', $link)->with('objBatHo', $objBatHo)->with('arrUser', $arrUser)->with('arrTienDoDaThu', $arrTienDoDaThu);
    }

    function postUpdateBatHo() {
        $laiky1 = str_replace(',', '', Input::get('laiky'));
        $giatri1 = str_replace(',', '', Input::get('giatri'));
        $thucchi1 = str_replace(',', '', Input::get('thucchi'));
        $laiky = str_replace(' VND/1 kỳ', '', $laiky1);
        $giatri = str_replace(' VND', '', $giatri1);
        $thucchi = str_replace(' VND', '', $thucchi1);
        $rules = array(
            'bathoDescription' => 'required',
            'giatri' => 'required',
            'thucchi' => 'required',
            'chuky' => 'required|integer',
            'laiky' => 'required',
            'from' => 'required|date',
            'to' => 'required|date',
            'status' => 'required|integer'
        );
        $tblBatHoModel = new tblBatHoModel();
        $validate = Validator::make(Input::all(), $rules, array(), Lang::get('backend/attributes.batho'));
        if (!$validate->fails()) {
            $from = strtotime(Input::get('from'));
            $to = strtotime(Input::get('to'));
            $objHistoryAdmin = new tblHistoryAdminModel();
            if ($from > $to) {
                Session::flash('alert_error', Lang::get('messages.date_begin_end'));
                return Redirect::back()->withInput(Input::all());
            } else {

                $objadmin = Session::get('adminSession');
                $id = $objadmin[0]->id;

                $objbatho = $tblBatHoModel->getBatHoByID(Input::get('id'));

                if ($objbatho->giatri != $giatri || $objbatho->chuky != Input::get('chuky') || $objbatho->laiky != $laiky || $objbatho->from != $from) {
                    $idbatho = $tblBatHoModel->UpdateBatHo(Input::get('id'), Input::get('userID'), Input::get('bathoDescription'), $giatri, $thucchi, Input::get('chuky'), $laiky, $from, $to, Input::get('status'));
                    $tblBatHoModel->xoaTienDo(Input::get('id'));
                    // Add Tien do moi
                    $chuky = Input::get('chuky');
                    $timedukien = $from + $chuky * 24 * 60 * 60;
                    $sochuky = $giatri / $laiky;
                    for ($i = 1; $i <= $sochuky; $i++) {
                        $tblBatHoModel1 = new tblBatHoModel();
                        $timedukien = $i * $chuky * 24 * 60 * 60 + $from;
                        $tblBatHoModel1->addTienDo(Input::get('id'), 'Đợt ' . $i, $timedukien, $laiky);
                    }
                }if ($objbatho->to != $to && $objbatho->chuky == Input::get('chuky')) {
                    // Trường hợp ngày mới cập nhật nhỏ hơn ngày sẵn có
                    if ($to < $objbatho->to) {

                        $idbatho = $tblBatHoModel->UpdateBatHo(Input::get('id'), Input::get('userID'), Input::get('bathoDescription'), $giatri, $thucchi, Input::get('chuky'), $laiky, $from, $to, Input::get('status'));
                        // xóa tiến độ mà time dự kiến lớn hơn thời gian mới
                        $tblBatHoModel->xoaTienDoByDate($to);
                    }

                    $idbatho = $tblBatHoModel->UpdateBatHo(Input::get('id'), Input::get('userID'), Input::get('bathoDescription'), $giatri, $thucchi, Input::get('chuky'), $laiky, $from, $to, Input::get('status'));

                    $chuky = Input::get('chuky');
                    $timedukien = $objbatho->to + $chuky * 24 * 60 * 60;
                    $sochuky = ($to - $from) / ($chuky * 24 * 60 * 60);
                    $arrTiendoBatHo = $tblBatHoModel->getTienDoByID($objbatho->id);
                    // Them tien do 
                    for ($i = count($arrTiendoBatHo) + 1; $i <= $sochuky; $i++) {
                        $tblBatHoModel = new tblBatHoModel();
                        $timedukien = $i * $chuky * 24 * 60 * 60 + $from;
                        $tblBatHoModel->addTienDo(Input::get('id'), 'Đợt ' . $i, $timedukien, $laiky);
                    }
                } else {
                    $idbatho = $tblBatHoModel->UpdateBatHo(Input::get('id'), Input::get('userID'), Input::get('bathoDescription'), '', $thucchi, '', '', '', '', Input::get('status'));
                }
                $objHistoryAdmin->addHistory($id, Lang::get('backend/history.batho.update') . Input::get('bathoDescription'), 0);
                Session::flash('alert_success', Lang::get('messages.update.success'));
                return Redirect::action('bathoController@getAllBatHo');
            }
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate->messages());
        }
    }

    function postAddBatHo() {
        $laiky = str_replace(',', '', Input::get('laiky'));
        $giatri = str_replace(',', '', Input::get('giatri'));
        $thucchi = str_replace(',', '', Input::get('thucchi'));
        $laiky = str_replace(' VND/1 kỳ', '', $laiky);
        $giatri = str_replace(' VND', '', $giatri);
        $thucchi = str_replace(' VND', '', $thucchi);
        $rules = array(
            'bathoDescription' => 'required',
            'giatri' => 'required',
            'thucchi' => 'required',
            'chuky' => 'required|integer',
            'laiky' => 'required',
            'from' => 'required|date',
            'to' => 'required|date',
            'status' => 'required|integer'
        );
        $tblBatHoModel = new tblBatHoModel();
        $validate = Validator::make(Input::all(), $rules, array(), Lang::get('backend/attributes.batho'));
        if (!$validate->fails()) {
            $from = strtotime(Input::get('from'));
            $to = strtotime(Input::get('to'));
            $objHistoryAdmin = new tblHistoryAdminModel();
            if ($from > $to) {
                Session::flash('alert_error', Lang::get('messages.date_begin_end'));
                return Redirect::back()->withInput(Input::all());
            } else {

                $objadmin = Session::get('adminSession');
                $id = $objadmin[0]->id;

                $idbatho = $tblBatHoModel->dangkyBatHo(Input::get('userID'), Input::get('bathoDescription'), $giatri, $thucchi, Input::get('chuky'), $laiky, $from, $to, Input::get('status'));
                // Add Tien Do
                $chuky = Input::get('chuky');
                $timedukien = $from + $chuky * 24 * 60 * 60;
                $sochuky = $giatri / $laiky;
                for ($i = 1; $i <= $sochuky; $i++) {
                    $timedukien = $i * $chuky * 24 * 60 * 60 + $from;
                    $tblBatHoModel->addTienDo($idbatho, 'Đợt ' . $i, $timedukien, $laiky);
                }

                $objHistoryAdmin->addHistory($id, Lang::get('backend/history.batho.add') . Input::get('bathoDescription'), 0);
                Session::flash('alert_success', Lang::get('messages.add.success'));
                return Redirect::action('bathoController@getAllBatHo');
            }
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate->messages());
        }
    }

    function postUserAjax() {
        $tblBatHoModel = new tblBatHoModel();
        $arrUser = $tblBatHoModel->getAllUser();
        return View::make('backend.camdo.UserAjax')->with('arrUser', $arrUser);
    }

    function postAjaxpagion() {
        $fromLoc = strtotime(Input::get('fromLoc'));
        $toLoc = strtotime(Input::get('toLoc'));
        $status = Input::get('status');
        $keyword = Input::get('keyword');
        $tblBatHoModel = new tblBatHoModel();
        $arrBatHo = $tblBatHoModel->getAllBatHoAjax($fromLoc, $toLoc, $status, $keyword, 5);
        $arrTienDoDaThu = $tblBatHoModel->getAllTienDoDaThu(1);
        $link = $arrBatHo->links();
        return View::make('backend.camdo.bathoManageAjax')->with('arrBatHo', $arrBatHo)->with('link', $link)->with('arrTienDoDaThu', $arrTienDoDaThu);
    }



    function getHuiChiTietByUserID() {
        $userID = Input::get('userid');
        $tblBatHoModel = new tblBatHoModel();
        $arrBatHoDaChoi = $tblBatHoModel->getBatHoByUserID($userID, '');
        $arrBatHoChuaHet = $tblBatHoModel->getBatHoByUserID($userID, '0');
        $arrBatHo = $tblBatHoModel->getBatHoByUserIDReturnArray($userID, 5);
        //var_dump($arrBatHoChuaHet);
        $link = $arrBatHo->links();
        return View::make('backend.camdo.bathoDetail')->with('arrBatHo', $arrBatHo)->with('arrBatHoDaChoi', $arrBatHoDaChoi)->with('arrBatHoChuaHet', $arrBatHoChuaHet)->with('link', $link);
    }

    function postDeleteBatHo() {
        $tblBatHoModel = new tblBatHoModel();
        $tblBatHoModel->DeleteBatHoByID(Input::get('id'));
        $arrBatHo = $tblBatHoModel->getAllBatHo('id', 5);
        $arrTienDoDaThu = $tblBatHoModel->getAllTienDoDaThu(1);
        $link = $arrBatHo->links();
        return View::make('backend.camdo.bathoManageAjax')->with('arrBatHo', $arrBatHo)->with('link', $link)->with('arrTienDoDaThu', $arrTienDoDaThu);
    }

    function postBatHoActive() {
        $tblBatHoModel = new tblBatHoModel();
        $tblBatHoModel->UpdateBatHo(Input::get('id'), '', '', '', '', '', '', '', '', Input::get('status'));
        $arrBatHo = $tblBatHoModel->getAllBatHo('id', 5);
        $arrTienDoDaThu = $tblBatHoModel->getAllTienDoDaThu(1);
        $link = $arrBatHo->links();
        return View::make('backend.camdo.bathoManageAjax')->with('arrBatHo', $arrBatHo)->with('link', $link)->with('arrTienDoDaThu', $arrTienDoDaThu);
    }

    function postChiTietBatHo() {
        $tblBatHoModel = new tblBatHoModel();
        $objBatHo = $tblBatHoModel->getBatHoByID(Input::get('id'));
        return View::make('backend.camdo.ChiTietBatHoByIDAjax')->with('objBatHo', $objBatHo);
    }

    function postCapNhatTienDo() {
        $tblBatHoModel = new tblBatHoModel();
        $arrTienDo = $tblBatHoModel->getTienDoByID(Input::get('id'));
        return View::make('backend.camdo.bathoTienDoThanhToan')->with('arrTienDo', $arrTienDo);
    }

    function postUpdateTienDo() {
        $id = Input::get('id');
        $timetra = strtotime(Input::get('timetra'));
        $sotientra = str_replace(',', '', Input::get('sotientra'));
        $tblBatHoModel = new tblBatHoModel();
        $check = $tblBatHoModel->UpdateBatHoDetail($id, $timetra, $sotientra, Input::get('status'));
        $arrTienDo = $tblBatHoModel->getTienDoByID(Input::get('idbh'));
        //var_dump($arrTienDo);
        return View::make('backend.camdo.bathoTienDoThanhToanAjax')->with('arrTienDo', $arrTienDo);
    }

    function postTienDoPhaiThu() {
        $tblBatHoModel = new tblBatHoModel();
        $arrTienDoPhaiThu = $tblBatHoModel->getBatHoByDate(time() - 5 * 24 * 60 * 60, time() + 5 * 24 * 60 * 60, 0);
        return View::make('backend.camdo.bathoTienDoThanhToan')->with('arrTienDo', $arrTienDoPhaiThu);
    }

}
