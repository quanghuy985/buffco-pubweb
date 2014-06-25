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

    public function getProjectView() {
        if (\Request::ajax()) {
            $objProject = new tblProjectModel();
            $check = $objProject->selectAllProject(1, 'id');
            //var_dump($check);
            $link = $check->links();
            return View::make('backend.project.Projectajax')->with('dataProject', $check)->with('link', $link);
        } else {
            $objProject = new tblProjectModel();
            $check = $objProject->selectAllProject(1, 'id');
            //var_dump($check);
            $link = $check->links();
            return View::make('backend.project.ProjectManage')->with('arrayProject', $check)->with('link', $link);
        }
    }

    public function getProjectEdit($id) {
        $objProject = new tblProjectModel();
        $data = $objProject->getProjectById($id);
        if (empty($data)) {
            return Response::view('backend.404Page', array(), 404);
        }
        return View::make('backend.project.Projectadd')->with('dataProject', $data);
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
                $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');
                Session::flash('alert_success', Lang::get('messages.update.success'));
                return Redirect::back();
            }
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate);
        }
    }

    public function getAddProject() {
        return View::make('backend.project.Projectadd');
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
                $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');
                Session::flash('alert_success', Lang::get('messages.add.success'));
                return Redirect::action('\BackEnd\ProjectController@getProjectView');
            }
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate);
        }
    }

    public function postDelmulte() {
        $objHistoryAdmin = new tblHistoryAdminModel();
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objProject = new tblProjectModel();
                $objProject->deleteProject($item);

               $objAdmin = \Auth::user();
                $historyContent = Lang::get('backend/history.project.delete') . $item;
                $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
                $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');
            }
        }
        $objProject = new tblProjectModel();
        $data = $objProject->selectAllProject(5, 'id');
        $link = $data->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $data)->with('link', $link);
    }

    public function postDeleteProject() {
        $objProject = new tblProjectModel();
        $objProject->deleteProject(Input::get('id'));
            $project = $objProject->getProjectById(Input::get('id'));
    $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.project.delete') . $project->projectName;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');

        $arrayProject = $objProject->selectAllProject(5, 'id');
        $link = $arrayProject->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $arrayProject)->with('link', $link);
    }

    public function postProjectActive() {
        $objProject = new tblProjectModel();
        $objProject->updateProject(Input::get('id'), '', '', '', '', '', '', Input::get('status'));
         $project = $objProject->getProjectById(Input::get('id'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.project.update') . $project->projectName;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');
        $arrayProject = $objProject->selectAllProject(5, 'id');
        $link = $arrayProject->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $arrayProject)->with('link', $link);
    }

    public function postAjaxsearch() {
        $objProject = new tblProjectModel();
        $data = $objProject->SearchProject(trim(Input::get('keyword')), 5, 'id');
        $link = $data->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $data)->with('link', $link);
    }

    public function postFillterProject() {

        $objProject = new tblProjectModel();
        //echo Input::get('status');
        $data = $objProject->findProject('', 5, 'id', Input::get('status'));
        //echo count($data);
        $link = $data->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $data)->with('link', $link);
    }

    public function postAjaxproject() {
        $objProject = new tblProjectModel();
        $check = $objProject->selectAllProject(5, 'id');
        $link = $check->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $check)->with('link', $link);
    }

}

