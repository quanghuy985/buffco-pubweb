<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GroupAdminController extends Controller {

    public function getGroupAdminView($thongbao = '') {
        $tblGroupAdminModel = new tblGroupAdminModel();
        $arrGroupAdmin = $tblGroupAdminModel->allGroupAdmin(10);
        $link = $arrGroupAdmin->links();

        $tblRolesModel = new tblRolesModel();
        $arrRoles = $tblRolesModel->allRolesList();

        $tblGroupRolesModel = new tblGroupRolesModel();
        $arrGroupRoles = $tblGroupRolesModel->allGroupRoles();

        return View::make('backend.admin.adminAddRoles')->with('arrRoles', $arrRoles)->with('arrGroupRoles', $arrGroupRoles)->with('arrGroupAdmin', $arrGroupAdmin)->with('link', $link)->with('thongbao', $thongbao);
    }

    public function getGroupAdminEdit() {
        $tblGroupAdminModel = new tblGroupAdminModel();
        $arrGroupAdmin = $tblGroupAdminModel->allGroupAdmin(10);
        $link = $arrGroupAdmin->links();
        $objGroupAdmin = $tblGroupAdminModel->findGroupAdminByID(Input::get('id'));
//Lay ve cac quyen
        $tblRolesModel = new tblRolesModel();
        $arrRoles = $tblRolesModel->allRolesList();
// Lay ve Nhom cac quyen
        $tblGroupRolesModel = new tblGroupRolesModel();
        $arrGroupRoles = $tblGroupRolesModel->allGroupRoles();

        $tblGroupAdminRoles = new tblGroupAdminRolesModel();
        $arrGroupAdminRolesExist = $tblGroupAdminRoles->findRolesByGroupAdmin($objGroupAdmin[0]->id);
        return View::make('backend.admin.adminAddRoles')->with('objGroupAdmin', $objGroupAdmin[0])->with('arrGroupRoles', $arrGroupRoles)->with('arrGroupAdmin', $arrGroupAdmin)->with('link', $link)->with('arrRoles', $arrRoles)->with('arrGroupAdminRolesExist', $arrGroupAdminRolesExist);
    }
    
   
    public function postUpdateGroupAdmin() {
        $tblGroupAdminModel = new tblGroupAdminModel();
        $rules = array(
            "groupAdminName" => "required",
            "groupAdminDescription" => "required",
            "roles" => "required",
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblGroupAdminModel->updateGroupAdmin(Input::get('id'), Input::get('groupAdminName'), Input::get('groupAdminDescription'), Input::get('status'));
            $roles = Input::get('roles');
            $tblGroupAdminRolesModel = new tblGroupAdminRolesModel();
            $tblGroupAdminRolesModel->rolesDelete(Input::get('id'));
            foreach ($roles as $item) {
                $tblGroupAdmin = new tblGroupAdminRolesModel();
                $result = $tblGroupAdmin->addGroupAdminRoles(Input::get('id'), $item);
            }
            if ($result) {
                return Redirect::action('GroupAdminController@getGroupAdminView', array('thongbao' => 'Cập nhật thành công .'));
            } else {
                return Redirect::action('GroupAdminController@getGroupAdminView', array('thongbao' => 'Cập nhật thất bại .'));
            }
        } else {
            return Redirect::action('GroupAdminController@getGroupAdminView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAddGroupAdmin() {
        $tblGroupAdminModel = new tblGroupAdminModel();
        $rules = array(
            "groupAdminName" => "required",
            "groupAdminDescription" => "required",
            "roles" => "required",
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $id = $tblGroupAdminModel->insertGroupAdminGetLastID(Input::get('groupAdminName'), Input::get('groupAdminDescription'), Input::get('status'));
            $roles = Input::get('roles');
            foreach ($roles as $item) {
                $tblGroupAdmin = new tblGroupAdminRolesModel();
                $result = $tblGroupAdmin->addGroupAdminRoles($id, $item);
            }
            if ($result) {
                return Redirect::action('GroupAdminController@getGroupAdminView', array('thongbao' => 'Cập nhật thành công .'));
            } else {
                return Redirect::action('GroupAdminController@getGroupAdminView', array('thongbao' => 'Cập nhật thất bại .'));
            }
        } else {
            return Redirect::action('GroupAdminController@getGroupAdminView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAjaxpagion() {
        $tblGroupAdminModel = new tblGroupAdminModel();
        $arrGroupAdmin = $tblGroupAdminModel->findGroupAdmin('', 10);
        $link = $arrGroupAdmin->links();
        return View::make('backend.admin.groupadminAjax')->with('arrGroupAdmin', $arrGroupAdmin)->with('link', $link);
    }

    public function postDeleteGroupAdmin() {
        $tblGroupAdminModel = new tblGroupAdminModel();
        $tblGroupAdminModel->updateGroupAdmin(Input::get('id'), '', '', '2');

        $arrGroupAdmin = $tblGroupAdminModel->allGroupAdmin(10);
        $link = $arrGroupAdmin->links();
        return View::make('backend.admin.groupadminAjax')->with('arrGroupAdmin', $arrGroupAdmin)->with('link', $link);
    }

    public function postGroupAdminActive() {
        $tblGroupAdminModel = new tblGroupAdminModel();
        $tblGroupAdminModel->updateGroupAdmin(Input::get('id'), '', '', Input::get('status'));

        $arrGroupAdmin = $tblGroupAdminModel->allGroupAdmin(10);
        $link = $arrGroupAdmin->links();
        return View::make('backend.admin.groupadminAjax')->with('arrGroupAdmin', $arrGroupAdmin)->with('link', $link);
    }

}
