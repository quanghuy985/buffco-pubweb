<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use BackEnd,
    View,
    Lang,
    Redirect,
    Session,
    Input,
    Validator;

class ProjectController extends \BaseController {

    public static $rules = array();

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('checkrole');
    }

    public function postDeleteProject() {
        $id = \Input::get('id');
        $objProject = new tblProjectModel();
        $objProject->ChangStatusProject($id, 2);
        return \Redirect::action('\BackEnd\ProjectController@getProjectView');
    }

    public function postActiveProject() {
        $id = \Input::get('id');
        $objProject = new tblProjectModel();
        $objProject->ChangStatusProject($id, 0);
        return \Redirect::action('\BackEnd\ProjectController@getProjectView');
    }

    public function postPublicProject() {
        $id = \Input::get('id');
        $objProject = new tblProjectModel();
        $objProject->ChangStatusProject($id, 1);
        return \Redirect::action('\BackEnd\ProjectController@getProjectView');
    }

    public function getProjectView() {
        if (\Request::ajax()) {
            $objProject = new tblProjectModel();
            $check = $objProject->selectAllProject(10, 'id');
            return View::make('backend.project.Projectajax')->with('arrayProject', $check)->with('link', $check->links());
        } else {
            $objProject = new tblProjectModel();
            $check = $objProject->selectAllProject(10, 'id');
            return View::make('backend.project.ProjectManage')->with('arrayProject', $check)->with('link', $check->links())->with('active_menu', 'projectview');
        }
    }

    public function getProjectEdit($id) {
        $objProject = new tblProjectModel();
        $data = $objProject->getProjectById($id);
        if (empty($data)) {
            return Response::view('backend.404Page', array(), 404);
        }
        return View::make('backend.project.Projectadd')->with('dataProject', $data)->with('active_menu', 'projectview');
    }

    public function postUpdateProject($pid) {
        $objProject = new tblProjectModel();
        $rules = array(
            "projectName" => "required|max:255",
            "from" => "required|date",
            "to" => "required|date",
            "projectDescription" => "required",
            "projectContent" => "required",
            "status" => "required|integer"
        );
        $validate = Validator::make(Input::all(), $rules, array(), Lang::get('backend/attributes.project'));
        if (!$validate->fails()) {
            $from = strtotime(Input::get('from'));
            $to = strtotime(Input::get('to'));
            if ($from > $to) {
                Session::flash('alert_error', Lang::get('messages.date_begin_end'));
                return Redirect::back()->withInput(Input::all());
            } else {
                $attList = Input::get('ImagePath');
                $objProject->updateProject($pid, Input::get('projectName'), $from, $to, Input::get('projectDescription'), Input::get('projectContent'), $attList, Input::get('status'));
                $objAdmin = \Auth::user();
                $historyContent = Lang::get('backend/history.project.update') . Input::get('projectName');
                $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
                $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
                Session::flash('alert_success', Lang::get('messages.update.success'));
                return Redirect::back();
            }
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate);
        }
    }

    public function getAddProject() {
        return View::make('backend.project.Projectadd')->with('active_menu', 'projectadd');
    }

    public function postAddProject() {
        $rules = array(
            "projectName" => "required|max:255",
            "from" => "required|date",
            "to" => "required|date",
            "projectDescription" => "required|max:255",
            "projectContent" => "required|max:255",
            "status" => "required|integer"
        );
        $objProject = new tblProjectModel();

        $validate = Validator::make(Input::all(), $rules, array(), Lang::get('backend/attributes.project'));
        if (!$validate->fails()) {
            $from = strtotime(Input::get('from'));
            $to = strtotime(Input::get('to'));
            if ($from > $to) {
                Session::flash('alert_error', Lang::get('messages.date_begin_end'));
                return Redirect::back()->withInput(Input::all());
            } else {
                $attList = Input::get('ImagePath');
                $idproject = $objProject->addProject(Input::get('projectName'), $from, $to, Input::get('projectDescription'), Input::get('projectContent'), $attList, Input::get('status'));

                $objAdmin = \Auth::user();
                $historyContent = Lang::get('backend/history.project.create') . Input::get('projectName');
                $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
                $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
                Session::flash('alert_success', Lang::get('messages.add.success'));
                return Redirect::action('\BackEnd\ProjectController@getProjectView');
            }
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate);
        }
    }

    public function postFillterProjectView() {
        $one = Input::get('fillter_status');
        if ($one == '') {
            $one = 'null';
        }
        return \Redirect::action('\BackEnd\ProjectController@getFillterProjectView', array($one));
    }

    public function getFillterProjectView($one = '') {
        if ($one == 'null') {
            $one = '';
        }

        $tblProjectModel = new tblProjectModel();
        $check = $tblProjectModel->FillterAllProject(10, 'id', $one);
        if (\Request::ajax()) {
            return View::make('backend.project.Projectajax')->with('arrayProject', $check)->with('link', $check->links());
        } else {
            return View::make('backend.project.ProjectManage')->with('arrayProject', $check)->with('link', $check->links())->with('active_menu', 'projectview');
        }
    }

    public function postSeaechProjectView() {
        $one = Input::get('key_word');
        if ($one == '') {
            $one = 'null';
        }
        return \Redirect::action('\BackEnd\ProjectController@getSeaechProjectView', array($one));
    }

    public function getSeaechProjectView($one = '') {
        if ($one == 'null') {
            $one = '';
        }

        $tblProjectModel = new tblProjectModel();
        $check = $tblProjectModel->SearchAllProject(10, 'id', $one);
        if (\Request::ajax()) {
            return View::make('backend.project.Projectajax')->with('arrayProject', $check)->with('link', $check->links());
        } else {
            return View::make('backend.project.ProjectManage')->with('arrayProject', $check)->with('link', $check->links())->with('active_menu', 'projectview');
        }
    }

}
