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
        $data = $objProject->getProjectById(Input::get('id'));
        $check = $objProject->selectAllProject(5, 'id');
        //var_dump($check);
        $link = $check->links();
        //var_dump($data);
        return View::make('backend.project.ProjectManage')->with('dataProject', $data)->with('arrayProject', $check)->with('link', $link);
    }

    public function postUpdateProject() {
        $objProject = new tblProjectModel();
        $rules = array(
            "from" => "required",
            "to" => "required",
            "description" => "required",
            "content" => "required",
            "status" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $from = strtotime(Input::get('from'));
            $to = strtotime(Input::get('to'));
            $objHistoryAdmin = new tblHistoryAdminModel();
            if ($from > $to) {
                return Redirect::action('ProjectController@getProjectView', array('msg' => 'Ngày bắt đầu không được lớn hơn ngày kết thúc'));
            } else {

                $objadmin = Session::get('adminSession');
                $id = $objadmin[0]->id;


                $objProject->updateProject(Input::get('idproject'), $from, $to, Input::get('description'), Input::get('content'), Input::get('status'));
                $objHistoryAdmin->addHistory($id, 'Edit project ' . Input::get('description'), 0);
                return Redirect::action('ProjectController@getProjectView', array('msg' => 'cap nhat thanh cong'));
            }
        } else {
            return Redirect::action('ProjectController@getProjectView', array('msg' => 'cap nhat that bai'));
        }
    }



    public function postAddProject() {
        $rules = array(
            "from" => "required",
            "to" => "required",
            "description" => "required",
            "content" => "required",
            "status" => "required"
        );
        $objProject = new tblProjectModel();


        if (!Validator::make(Input::all(), $rules)->fails()) {
            $from = strtotime(Input::get('from'));
            $to = strtotime(Input::get('to'));
            $objHistoryAdmin = new tblHistoryAdminModel();

            if ($from > $to) {
                return Redirect::action('ProjectController@getProjectView', array('msg' => 'Ngày bắt đầu không được lớn hơn ngày kết thúc'));
            } else {

                $objadmin = Session::get('adminSession');
                $id = $objadmin[0]->id;


                $objProject->addProject($from, $to, Input::get('description'), Input::get('content'), Input::get('status'));
                $objHistoryAdmin->addHistory($id, 'Them project ' . Input::get('description'), 0);
                return Redirect::action('ProjectController@getProjectView', array('msg' => 'them moi thanh cong'));
            }
        } else {
            return Redirect::action('ProjectController@getProjectView', array('msg' => 'them moi that bai'));
        }
    }

    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objProject = new tblProjectModel();
                $objProject->deleteProject($item);

                $objadmin = Session::get('adminSession');
                $id = $objadmin[0]->id;
                $objHistoryAdmin->addHistory($id, 'Xoa project', 0);
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
        $objHistoryAdmin->addHistory($id, 'Xoa project', 0);

        $arrayProject = $objProject->selectAllProject(5, 'id');
        $link = $arrayProject->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $arrayProject)->with('link', $link);
    }

    public function postProjectActive() {
        $objProject = new tblProjectModel();
        $objProject->updateProject(Input::get('id'), '', '', '', '', Input::get('status'));

        $objadmin = Session::get('adminSession');
        $id = $objadmin[0]->id;
        $objHistoryAdmin->addHistory($id, 'active project', 0);

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
