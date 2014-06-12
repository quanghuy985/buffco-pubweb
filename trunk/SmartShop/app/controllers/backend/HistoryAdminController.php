<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HistoryAdminController extends \BaseController {

    public function getHistoryView($msg = '') {
        $objHistory = new tblHistoryAdminModel();

        $check = $objHistory->selectAllHistory(5, 'id');
        //var_dump($check);
        $link = $check->links();
        if ($msg != '') {
            return View::make('backend.historyadmin.HistoryAdminManage')->with('arrayHistory', $check)->with('link', $link)->with('msg', $msg);
        } else {
            return View::make('backend.historyadmin.HistoryAdminManage')->with('arrayHistory', $check)->with('link', $link);
        }
    }

    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objHistory = new tblHistoryAdminModel();
                $objHistory->deleteHistory($item);
            }
        }
        $objHistory = new tblHistoryAdminModel();
        $data = $objHistory->findHistory('', 5, 'id', '');
        $link = $data->links();
        return View::make('backend.historyadmin.HistoryAdminajax')->with('arrayHistory', $data)->with('link', $link);
    }

    public function postDeleteHistory() {
        $objHistory = new tblHistoryAdminModel();
        $objHistory->deleteHistory(Input::get('id'));
        //echo $tblPageModel;
        $arrhistory = $objHistory->selectAllHistory(5, 'id');
        $link = $arrhistory->links();
        return View::make('backend.historyadmin.HistoryAdminajax')->with('arrayHistory', $arrhistory)->with('link', $link);
    }

    public function postHistoryActive() {
        $objHistory = new tblHistoryAdminModel();
        $objHistory->updateHistory(Input::get('id'), Input::get('status'));
        $arrhistory = $objHistory->selectAllHistory(5, 'id');
        $link = $arrhistory->links();
        return View::make('backend.historyadmin.HistoryAdminajax')->with('arrayHistory', $arrhistory)->with('link', $link);
    }

    public function postAjaxhistoryadmin() {
        $objHistory = new tblHistoryAdminModel();
        $data = $objHistory->selectAllHistory(5, 'id');
        $link = $data->links();
        return View::make('backend.historyadmin.HistoryAdminajax')->with('arrayHistory', $data)->with('link', $link);
    }

    public function postAjaxsearch() {
        $objHistory = new tblHistoryAdminModel();
        $data = $objHistory->SearchHistory(trim(Input::get('keyword')), 5, 'id');
        $link = $data->links();
        return View::make('backend.historyadmin.HistoryAdminajax')->with('arrayHistory', $data)->with('link', $link);
    }

    public function postFillterHistory() {
        $objHistory = new tblHistoryAdminModel();
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));
        $data = $objHistory->findHistory(5, $from, $to, Input::get('status'));
        $link = $data->links();
        return View::make('backend.historyadmin.HistoryAdminajax')->with('arrayHistory', $data)->with('link', $link);
    }

    public function getSearchDateHistory() {

        $objHistory = new tblHistoryAdminModel();
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));

        if (isset($from) && isset($to)) {
            $data = $objHistory->findHistoryByDate($from, $to, 5, 'id');
        }
        //echo count($data);
        $link = $data->links();

        return View::make('backend.historyadmin.HistoryAdminManage')->with('arrHistory', $data)->with('link', $link);
    }

    public function postSearchDateHistory() {

        $objHistory = new tblHistoryAdminModel();

        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));


        $data = $objHistory->findHistoryByDate($from, $to, 5, 'id');

        //echo count($data);
        $link = $data->links();

        return View::make('backend.historyadmin.HistoryAdminajax')->with('arrayHistory', $data)->with('link', $link);
    }

}
