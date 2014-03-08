<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MenuController extends Controller {

    public function getMenuView($thongbao = '') {
        $tblMenuModel = new TblMenuModel();
        $menuData = $tblMenuModel->getAllMenuPagin(10);
        $link = $menuData->links();
        $start = $menuData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $data = $tblMenuModel->getAllMenu($start, 10);
        if ($thongbao != '') {
            return View::make('backend.menuManage')->with('arrayMenu', $data)->with('link', $link)->with('thongbao', $thongbao);
        } else {
            return View::make('backend.menuManage')->with('arrayMenu', $data)->with('link', $link);
        }
    }

    public function postAjaxpagion() {
        $tblMenuModel = new TblMenuModel();
        $menuData = $tblMenuModel->getAllMenuPagin(10);
        $link = $menuData->links();
        $start = $menuData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $data = $tblMenuModel->getAllMenu($start, 10);
        return View::make('backend.menuAjax')->with('arrayMenu', $data)->with('link', $link);
    }

    public function postDeleteMenu() {
        $tblMenuModel = new TblMenuModel();
        $dataedit = $tblMenuModel->SelectMenuById(Input::get('id'));
        if ($dataedit->menuParent == 0) {
            $tblMenuModel->deleteMenuChild($dataedit->id);
        }
        $tblMenuModel->deleteMenu(Input::get('id'));
        $menuData = $tblMenuModel->allMenu(10);
        $link = $menuData->links();
        return View::make('backend.menuAjax')->with('arrayMenu', $menuData)->with('link', $link);
    }

    public function getMenuEdit() {
        $tblMenuModel = new TblMenuModel();
        $menuData = $tblMenuModel->allMenu(10);
        $link = $menuData->links();
        $dataedit = $tblMenuModel->SelectMenuById(Input::get('id'));
        return View::make('backend.menuManage')->with('menuData', $dataedit)->with('arrayMenu', $menuData)->with('link', $link);
    }

    public function postMenuActive() {
        $tblMenuModel = new TblMenuModel();
        $tblMenuModel->updateMenu(Input::get('id'), '', '', '', '', Input::get('status'));
        $menuData = $tblMenuModel->allMenu(10);
        $link = $menuData->links();
        return View::make('backend.menuAjax')->with('arrayMenu', $menuData)->with('link', $link);
    }

    public function postUpdateMenu() {
        $rules = array(
            "menuName" => "required",
            "menuURL" => "required",
            "menuParent" => "required",
            "menuPosition" => "required|numeric"
        );
        $tblMenuModel = new TblMenuModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblMenuModel->updateMenu(Input::get('idMenu'), Input::get('menuName'), Input::get('menuURL'), Input::get('menuParent'), Input::get('menuPosition'), Input::get('status'));
            return Redirect::action('MenuController@getMenuView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('MenuController@getMenuView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAddMenu() {
        $rules = array(
            "menuName" => "required",
            "menuURL" => "required",
            "menuParent" => "required",
            "menuPosition" => "required|numeric"
        );
        $tblMenuModel = new TblMenuModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblMenuModel->addnewMenu(Input::get('menuName'), Input::get('menuURL'), Input::get('menuParent'), Input::get('menuPosition'));
            return Redirect::action('MenuController@getMenuView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('MenuController@getMenuView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

}
