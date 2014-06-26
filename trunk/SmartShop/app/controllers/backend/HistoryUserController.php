<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use View;

class HistoryUserController extends \BaseController {

    public function getUserHistory($user_id = '') {
        $objHistory = new \BackEnd\tblHistoryUserModel();
        $tblUserModel = new \BackEnd\tblUserModel();
        $objUser = $tblUserModel->getUserById($user_id);
        $check = $objHistory->getHistoryByUserIDPagination($user_id, 10);
        //var_dump($check);
        $link = $check->links();
        if (\Request::ajax()) {
              return View::make('backend.historyuser.HistoryUserajax')->with('arrHistory', $check)->with('link', $link);
        } else {
            return View::make('backend.historyuser.HistoryManage')->with('objUser', $objUser)->with('arrHistory', $check)->with('link', $link);
        }
    }

    public function getHistoryUserSearchView($user_id = '', $two = '') {
        if ($user_id == 'null') {
            $user_id = '';
        }
        if ($two == 'null') {
            $two = '';
        }
        $tblUserModel = new \BackEnd\tblUserModel();
        $objUser = $tblUserModel->getUserById($user_id);
        $objHistory = new \BackEnd\tblHistoryUserModel();
        $arrHistory = $objHistory->FindHistoryUserRow($two, $user_id, 10);


        $link = $arrHistory->links();
        if (\Request::ajax()) {
            return View::make('backend.historyuser.HistoryUserajax')->with('arrHistory', $arrHistory)->with('link', $link);
        } else {
            return View::make('backend.historyuser.HistoryManage')->with('objUser', $objUser)->with('arrHistory', $arrHistory)->with('link', $link);
        }
    }

    public function postHistoryUserSearchView() {
        $user_id = \Input::get('user_id');
        $two = \Input::get('searchblur');
        if ($user_id == '') {
            $user_id = 'null';
        }
        if ($two == '') {
            $two = 'null';
        }
        return \Redirect::action('\BackEnd\HistoryUserController@getHistoryUserSearchView', array($user_id, $two));
    }

    public function postHistoryUserFillterView() {
        $one = strtotime(\Input::get('from'));
        $two = strtotime(\Input::get('to'));
        $three = \Input::get('fillter_status');
        $user_id = \Input::get('user_id');
        if ($one == '') {
            $one = 'null';
        }
        if ($two == '') {
            $two = 'null';
        } else {
            $two = $two + 24 * 60 * 60;
        }
        if ($three == '') {
            $three = 'null';
        }
        return \Redirect::action('\BackEnd\HistoryUserController@getHistoryUserFillterView', array($one, $two, $three, $user_id));
    }

    public function getHistoryUserFillterView($one = '', $two = '', $three = '', $user_id = '') {
        if ($one == 'null') {
            $one = '';
        }
        if ($two == 'null') {
            $two = '';
        }
        if ($three == 'null') {
            $three = '';
        }
        $tblUserModel = new \BackEnd\tblUserModel();
        $objUser = $tblUserModel->getUserById($user_id);
        $objHistory = new \BackEnd\tblHistoryUserModel();
        $arrHistory = $objHistory->getAllHistoryUser($one, $two, $three, $user_id, 10);
        $link = $arrHistory->links();
        if (\Request::ajax()) {
            return View::make('backend.historyuser.HistoryUserajax')->with('arrHistory', $arrHistory)->with('link', $link);
        } else {
            return View::make('backend.historyuser.HistoryManage')->with('objUser', $objUser)->with('arrHistory', $arrHistory)->with('link', $link);
        }
    }

    public function postDelmulte() {
        $objHistory = new \BackEnd\tblHistoryUserModel();
        $user_id = \Input::get('user');
        $pieces1 = explode(",", \Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objHistory->deleteHistory($item);
            }
        }

        $tblUserModel = new \BackEnd\tblUserModel();
        $objUser = $tblUserModel->getUserById($user_id);
        $check = $objHistory->getHistoryByUserIDPagination($user_id, 10);
        //var_dump($check);
        $link = $check->links();
        if (\Request::ajax()) {
            return View::make('backend.historyuser.HistoryUserajax')->with('arrHistory', $check)->with('link', $link);
        } else {
            return View::make('backend.historyuser.HistoryManage')->with('objUser', $objUser)->with('arrHistory', $check)->with('link', $link);
        }
    }

    public function postHistoryActive() {
        $tblUserModel = new \BackEnd\tblUserModel();
        $user_id = \Input::get('user');
        $objUser = $tblUserModel->getUserById($user_id);
        $objHistory = new \BackEnd\tblHistoryUserModel();
        $objHistory->updateHistory(\Input::get('id'), \Input::get('status'));

        $check = $objHistory->getHistoryByUserIDPagination($user_id, 10);
        //var_dump($check);
        $link = $check->links();
        if (\Request::ajax()) {
            return View::make('backend.historyuser.HistoryUserajax')->with('arrHistory', $check)->with('link', $link);
        } else {
            return View::make('backend.historyuser.HistoryManage')->with('objUser', $objUser)->with('arrHistory', $check)->with('link', $link);
        }
    }

    // Phiên bản chưa sửa ----------------->
}
