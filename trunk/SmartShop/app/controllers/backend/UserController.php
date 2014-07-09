<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use BackEnd,
    View;

class UserController extends \BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('checkrole');
    }

    public function postDeleteUsers() {
        $id = \Input::get('id');
        $tblUserModel = new tblUserModel();
        $tblUserModel->UpdateStatus($id, 2);

        $user = $tblUserModel->getUserById($id);
        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.users.delete') . ' ' . $user->email;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        return \Redirect::action('\BackEnd\UserController@getUserView');
    }

    public function postActiveUsers() {
        $id = \Input::get('id');
        $tblUserModel = new tblUserModel();
        $tblUserModel->UpdateStatus($id, 0);

        $user = $tblUserModel->getUserById($id);
        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.users.lock') . ' ' . $user->email;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        return \Redirect::action('\BackEnd\UserController@getUserView');
    }

    public function postPublicUsers() {
        $id = \Input::get('id');
        $tblUserModel = new tblUserModel();
        $tblUserModel->UpdateStatus($id, 1);


        $user = $tblUserModel->getUserById($id);
        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.users.active') . ' ' . $user->email;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        return \Redirect::action('\BackEnd\UserController@getUserView');
    }

    public function postFillterUsers() {
        $one = \Input::get('fillter_status');
        if ($one == '') {
            $one = 'null';
        }
        return \Redirect::action('\BackEnd\UserController@getFillterUsers', array($one));
    }

    public function postSearchUsers() {
        $one = \Input::get('key_word');
        if ($one == '') {
            $one = 'null';
        }
        return \Redirect::action('\BackEnd\UserController@getSearchUsers', array($one));
    }

    public function getFillterUsers($status = '') {
        if ($status == 'null') {
            $status = '';
        }
        if (\Request::ajax()) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', $status);
            $link = $check->links();
            return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', $status);
            $link = $check->links();
            return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link', $link)->with('active_menu', 'userview');
        }
    }

    public function getSearchUsers($keyword = '') {
        if ($keyword == 'null') {
            $keyword = '';
        }
        if (\Request::ajax()) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', '', $keyword);
            $link = $check->links();
            return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', '', $keyword);
            $link = $check->links();
            return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link', $link)->with('active_menu', 'userview');
        }
    }

    public function getUserView() {
        if (\Request::ajax()) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id');
            $link = $check->links();
            return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id');
            $link = $check->links();
            return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link', $link)->with('active_menu', 'userview');
        }
    }

    public function getUserDetail($id = '') {
        $tblOrder = new tblOrderModel();
        if (\Request::ajax()) {
            $order = $tblOrder->getAllOrderByID($id, 10);
            $orderlink = $order->links();
            return View::make('backend.order.historyorder')->with('arrorder', $order)->with('orderlink', $orderlink);
        } else {
            $tblUserModel = new tblUserModel();
            $data = $tblUserModel->getUserByEmail($id, 0);

            $order = $tblOrder->getAllOrderByID($id, 10);

            $orderlink = $order->links();
            return View::make('backend.user.UserDetail')->with('data', $data)->with('arrorder', $order)->with('orderlink', $orderlink)->with('active_menu', 'userview');
        }
    }

    public function postUserDetail() {
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->selectAllUser(5, 'id');
        $link = $check->links();
        return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link', $link);
    }

    public function getUserEdit($id = '') {
        if (\Request::ajax()) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', \ Input::get('orderby'));
            $link = $check->links();
            return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', '');
            $link = $check->links();
            $userdata = $tblUserModel->getUserByEmail($id, 0);
            return View::make('backend.user.UserManage')->with('arrayUsers', $userdata)->with('arrUser', $check)->with('link', $link)->with('active_menu', 'userview');
        }
    }

    public function postUpdateUser() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->UpdateUser(\Input::get('id'), \ Input::get('email'), \ Input::get('password'), \ Input::get('firstname'), \ Input::get('lastname'), \ Input::get('dateofbirth'), \ Input::get('address'), \ Input::get('phone'), \ Input::get('status'), 0, \ Input::get('group_admin_id'));

        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.users.update') . ' ' . \ Input::get('email');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        \Session::flash('alert_success', \ Lang::get('messages.update.success'));
        return \Redirect::action('\BackEnd\UserController@getUserView');
    }

    public function postDelmulte() {
        $pieces1 = explode(',', \ Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $tblUserModel = new tblUserModel();
                $tblUserModel->DeleteUserById($item);

                $objAdmin = \Auth::user();
                $historyContent = \Lang::get('backend/history.users.delete') . ' ' . $item;
                $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
                $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            }
        }
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->getAllUsers(10, 'id');
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function postUserActive() {
        $tblUserModel = new tblUserModel();
        $tblUserModel->UpdateStatus(\Input::get('id'), \ Input::get('status'));

        $objAdmin = \Auth::user();
        $user = $tblUserModel->getUserById(\Input::get('id'));
        $historyContent = \Lang::get('backend/history.users.active') . ' ' . $user->email;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        $check = $tblUserModel->getAllUsers(10, 'id');
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function postDeleteUser() {
        $tblUserModel = new tblUserModel();
        $tblUserModel->DeleteUserById(\Input::get('id'));

        $objAdmin = \Auth::user();
        $user = $tblUserModel->getUserById(\Input::get('id'));
        $historyContent = \Lang::get('backend/history.users.delete') . ' ' . $user->email;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        $check = $tblUserModel->getAllUsers(10, 'id');
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function postAddUser() {
        $tblAdminModel = new tblUserModel();
        $check = $tblAdminModel->RegisterUser(\Input::all(), 0);
        if ($check == 'true') {

            $objAdmin = \Auth::user();
            $historyContent = \Lang::get('backend/history.users.add') . ' ' . \Input::get('email');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

            \Session::flash('alert_success', \ Lang::get('messages.add.success'));
            return \Redirect::action('\BackEnd\UserController@getUserView');
        } else {
            \Session::flash('alert_error', \ Lang::get('messages.add.error'));
            return \Redirect::action('\BackEnd\UserController@getUserView')->withInput()->withErrors($check);
        }
    }

    public function getAjaxsearch() {
        if (\Request::ajax()) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', '', \ Input::get('k'));
            $link = $check->links();
            return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', '', \ Input::get('keywordsearch'));
            $link = $check->links();
            return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link', $link)->with('active_menu', 'userview');
        }
    }

    public function postAjaxsearch() {
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->getAllUsers(10, 'id', '', \ Input::get('keywordsearch'));
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function getFillterUser() {
        if (\Request::ajax()) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', \ Input::get('orderby'));
            $link = $check->links();
            return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', \ Input::get('orderby'));
            $link = $check->links();
            return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link', $link)->with('active_menu', 'userview');
        }
    }

    public function postFillterUser() {
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->getAllUsers(10, 'id', \ Input::get('oderbyoption1'));
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function postAjaxpagion() {
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->getAllUsers(10, 'id', '', \ Input::get('keywordsearch'));
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function getThongKe() {
        $tblUserModel = new tblUserModel();
        $count = $tblUserModel->getCountUserOnDay(time(), time());
        return View::make('backend.thongke.user')->with('count', $count);
    }

    public function postThongKeUserAjax() {
        $tblUserModel = new tblUserModel();
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));
        $count_range = $tblUserModel->getCountUserOnDay($from, $to);
        return View::make('backend.thongke.ajaxuser')->with('count_range', $count_range);
    }

    public function postSearchDateUser() {

        $tblUserModel = new tblUserModel();

        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));


        $data = $tblUserModel->getUserByDate($from, $to, 5);

//echo count($data);
        $link = $data->links();

        return View::make('backend.thongke.Userajax')->with('user', $data)->with('link', $link);
    }

    public function postSearchUserByKeyword() {
        $tblUserModel = new tblUserModel();
        $keyw = \Input::get('keyword');
        $data = $tblUserModel->SearchUsersKey($keyw);
        $html = '';
        foreach ($data as $item) {
            $html = $html . '
                <a href="javascript:void(0);" onclick="addvaluebox(\'' . $item->email . '\')"> <li>
                    <span>' . $item->email . '</span>
                    <span>' . $item->firstname . ' ' . $item->lastname . '</span>
                </li>
            </a>';
        }
        echo $html;
    }

}