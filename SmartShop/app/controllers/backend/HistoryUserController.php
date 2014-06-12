<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HistoryUserController extends \BaseController {

    public function getHistoryView($msg = '') {
        $objHistory = new tblHistoryUserModel();

        $check = $objHistory->selectAllHistory(5, 'id');
        //var_dump($check);
        $link = $check->links();
        if ($msg != '') {
            return View::make('backend.historyuser.HistoryManage')->with('arrHistory', $check)->with('link', $link)->with('msg', $msg);
        } else {
            return View::make('backend.historyuser.HistoryManage')->with('arrHistory', $check)->with('link', $link);
        }
    }

    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objHistory = new tblHistoryUserModel();
                $objHistory->deleteHistory($item);
            }
        }
        $objHistory = new tblHistoryUserModel();
        $data = $objHistory->findHistory('', 5, 'id', '');
        $link = $data->links();
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
    }

    public function postDeleteHistory() {
        $objHistory = new tblHistoryUserModel();
        $objHistory->deleteHistory(Input::get('id'));
        //echo $tblPageModel;
        $arrhistory = $objHistory->selectAllHistory(5, 'id');
        $link = $arrhistory->links();
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $arrhistory)->with('link', $link);
    }

    public function postHistoryActive() {
        $objHistory = new tblHistoryUserModel();
        $objHistory->updateHistory(Input::get('id'), Input::get('status'));
        $arrhistory = $objHistory->selectAllHistory(5, 'id');
        $link = $arrhistory->links();
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $arrhistory)->with('link', $link);
    }

    public function postAjaxhistoryuser() {
        $objHistory = new tblHistoryUserModel();
        $data = $objHistory->selectAllHistory(5, 'id');
        $link = $data->links();
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
    }

    public function postAjaxsearch() {
        $objHistory = new tblHistoryUserModel();
        $data = $objHistory->SearchHistory(trim(Input::get('keyword')), 5, 'id');
        $link = $data->links();
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
    }

    public function postFillterHistory() {

        $objHistory = new tblHistoryUserModel();
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));
        $data = $objHistory->findHistory(5, $from, $to, Input::get('status'));
        $link = $data->links();
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
    }

    public function getSearchDateHistory() {

        $objHistory = new tblHistoryUserModel();
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));

        if (isset($from) && isset($to)) {
            $data = $objHistory->findHistoryByDate($from, $to, 5, 'id');
        }
        //echo count($data);
        $link = $data->links();

        return View::make('backend.historyuser.HistoryManage')->with('arrHistory', $data)->with('link', $link);
    }

    public function postSearchDateHistory() {

        $objHistory = new tblHistoryUserModel();

        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));


        $data = $objHistory->findHistoryByDate($from, $to, 5, 'id');

        //echo count($data);
        $link = $data->links();

        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
    }

}
