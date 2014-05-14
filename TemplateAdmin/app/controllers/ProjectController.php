<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProjectController extends Controller {

    public static $rules = array();

    public function getProjectView($msg = '') {
        $objProject = new tblProjectModel();
        $check = $objProject->selectAllProject(5, 'id');
        //var_dump($check);
        $link = $check->links();
        if ($msg != '') {
            return View::make('backend.project.ProjectManage')->with('arrayProject', $check)->with('link', $link)->with('msg', $msg);
        } else {
            return View::make('backend.project.ProjectManage')->with('arrayProject', $check)->with('link', $link);
        }
    }

    public function getProjectEdit() {
        $objProject = new tblProjectModel();
        $tblAttach = new tblAttachmentProjectModel();
        $dataimg = $tblAttach->getAttachmentByProjectId(Input::get('id'));
        $data = $objProject->getProjectById(Input::get('id'));
        $check = $objProject->selectAllProject(5, 'id');
        return View::make('backend.project.Projectadd')->with('dataProject', $data)->with('dataimg', $dataimg)->with('arrayProject', $check);
    }

    public function postUpdateProject() {
        $objProject = new tblProjectModel();
        $pid = Input::get('id');
        $rules = array(            "projectName" => "required|max:255",
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
            $objHistoryAdmin = new tblHistoryAdminModel();
            if ($from > $to) {
                Session::flash('alert_error', Lang::get('messages.date_begin_end'));
                return Redirect::back()->withInput(Input::all());
            } else {
                $objadmin = Session::get('adminSession');
                $id = $objadmin[0]->id;
                $objProject->updateProject(Input::get('id'), Input::get('projectName'), $from, $to, Input::get('projectDescription'), Input::get('projectContent'), Input::get('status'));
                if ($pid != NULL || $pid != '') {
                    $attList = Input::get('ImagePath');
                    $tblAttach = new tblAttachmentProjectModel();
                    $tblAttach->deleteAttachmentByProjectID($pid);
                    if ($attList != '') {
                        $arr = explode(',', $attList);
                        foreach ($arr as $item) {
                            $att = new tblAttachmentProjectModel();
                            $att->addAttachment($pid, $item);
                        }
                    }
                }
                $objHistoryAdmin->addHistory($id, Lang::get('backend/history.project.update') . Input::get('projectDescription'), 0);
                Session::flash('alert_success', Lang::get('messages.update.success'));
                return Redirect::back();
            }
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate);//('ProjectController@getProjectView', array('msg' => 'cap nhat that bai'));
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
            $objHistoryAdmin = new tblHistoryAdminModel();

            if ($from > $to) {
                Session::flash('alert_error', Lang::get('messages.date_begin_end'));
                return Redirect::back()->withInput(Input::all());
            } else {

                $objadmin = Session::get('adminSession');
                $id = $objadmin[0]->id;

                $idproject = $objProject->addProject(Input::get('projectName'), $from, $to, Input::get('projectDescription'), Input::get('projectContent'), Input::get('status'));
                if ($idproject != NULL || $idproject != '') {

                    $attList = Input::get('ImagePath');
                    if ($attList != '') {
                        $arr = explode(',', $attList);
                        foreach ($arr as $item) {
                            $att = new tblAttachmentProjectModel();
                            $att->addAttachment($idproject, $item);
                        }
                    }
                }
                $objHistoryAdmin->addHistory($id, Lang::get('backend/history.project.create') . Input::get('projectDescription'), 0);
                Session::flash('alert_success', Lang::get('messages.create.success'));
                return Redirect::action('ProjectController@getProjectView');
            }
        } else {
            Session::flash('alert_error', Lang::get('messages.create.error'));
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

                $objadmin = Session::get('adminSession');
                $id = $objadmin[0]->id;
                $objHistoryAdmin->addHistory($id, Lang::get('backend/history.project.delete'), 0);
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

        $objadmin = Session::get('adminSession');
        $id = $objadmin[0]->id;
        $objHistoryAdmin = new tblHistoryAdminModel();
        $objHistoryAdmin->addHistory($id, Lang::get('backend/history.project.delete'), 0);

        $arrayProject = $objProject->selectAllProject(5, 'id');
        $link = $arrayProject->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $arrayProject)->with('link', $link);
    }

    public function postProjectActive() {
        $objProject = new tblProjectModel();
        $objProject->updateProject(Input::get('id'), '', '', '', '', '', Input::get('status'));
        $objHistoryAdmin = new tblHistoryAdminModel();
        $objadmin = Session::get('adminSession');
        $id = $objadmin[0]->id;
        $objHistoryAdmin->addHistory($id, Lang::get('backend/history.project.active'), 0);

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
