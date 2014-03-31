<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GroupAdminController extends Controller {

    public function getGroupAdminView() {
        $tblGroupAdminModel = new tblGroupAdminModel();
        $arrGroupAdmin = $tblGroupAdminModel->allGroupAdmin(10);
        $link = $arrGroupAdmin->links();

        $tblRolesModel = new tblRolesModel();
        $arrRoles = $tblRolesModel->allRolesList();

        $tblGroupRolesModel = new tblGroupRolesModel();
        $arrGroupRoles = $tblGroupRolesModel->allGroupRoles();

        return View::make('backend.admin.adminAddRoles')->with('arrRoles', $arrRoles)->with('arrGroupRoles', $arrGroupRoles)->with('arrGroupAdmin', $arrGroupAdmin)->with('link', $link);
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
        var_dump($arrGroupAdminRolesExist);

        //return View::make('backend.admin.adminAddRoles')->with('objGroupAdmin', $objGroupAdmin[0])->with('arrGroupRoles', $arrGroupRoles)->with('arrGroupAdmin', $arrGroupAdmin)->with('link', $link)->with('arrRoles', $arrRoles);
    }

    public function postUpdateGroupAdmin() {
        
    }

    public function postAddGroupAdmin() {
        
    }

    public function postAjaxpagion() {
        $tblGroupAdminModel = new tblGroupAdminModel();
        $arrGroupAdmin = $tblGroupAdminModel->findGroupAdmin('', 10);
        $link = $arrGroupAdmin->links();
        return View::make('backend.admin.groupadminAjax')->with('arrGroupAdmin', $arrGroupAdmin)->with('link', $link);
    }

    public function postDeleteGroupAdmin() {
        
    }

    public function postGroupAdminActive() {
        
    }

}
