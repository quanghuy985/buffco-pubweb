<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use BackEnd,
    View,
    Redirect,
    Validator,
    Input,
    Session,
    Lang;

class MenusController extends \BaseController {

    public function getMenus($id = 1) {
        $menus = new \BackEnd\Menu();
        $catProduct = new tblCategoryproductModel();
        $allcatpeoduct = $catProduct->allCateProductList();
        $catnews = new tblCategoryNewsModel();
        $alltnews = $catnews->allCateNew();
        $pages = new tblPageModel();
        $allpage = $pages->getAllPage();
        return \View::make('backend.menu.menunew')->with('catprolist', $allcatpeoduct)->with('catnewlist', $alltnews)->with('pageslist', $allpage)->with('menu', $menus->index($id))->with('jsmenu', 'haha');
    }

    public function postUpdateMenu() {
        $menus = new \BackEnd\Menu();
        $menus->save_position(\Input::get('easymm'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.menu.update') . \Input::get('easymm');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
    }

    public function postDeleteMenu() {
        $menus = new \BackEnd\Menu();
        $response = $menus->deletemenu(\Input::get('id'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.menu.delete') . \Input::get('title');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        echo json_encode($response);
    }

    public function getEditMenu() {
        $menus = new \BackEnd\Menu();
        return \View::make('backend.menu.menu_edit')->with('menu_edit', $menus->edit(\Input::get('id')));
    }

    public function postEditMenuEdit() {
        $menus = new \BackEnd\Menu();
        $response = $menus->saveedit(\Input::get('title'), \Input::get('menu_id'), \Input::get('url'), \Input::get('class'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.menu.update') . \Input::get('title');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        echo json_encode($response);
    }

    public function getAddGroupMenu() {
        return \View::make('backend.menu.menu_group_add');
    }

    public function postAddGroupMenu() {
        $menus = new \BackEnd\Menu();
        $response = $menus->add_group(\Input::get('title'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.menu.addGroup') . \Input::get('title');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        echo json_encode($response);
    }

    public function postUpdateGroupMenu() {
        $menus = new \BackEnd\Menu();
        $response = $menus->edit_group(\Input::get('id'), \Input::get('title'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.menu.updateGroup') . \Input::get('title');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        echo json_encode($response);
    }

    public function postDeleteGroupMenu() {
        $menus = new \BackEnd\Menu();
        $response = $menus->delete_group(\Input::get('id'));


        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.menu.deleteGroup') . \Input::get('title');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        echo json_encode($response);
    }

    public function postAddMenu() {
        $menus = new \BackEnd\Menu();
        $response = $menus->add_menu(\Input::get('title'), \Input::get('url'), \Input::get('class'), \Input::get('group_id'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.menu.add') . \Input::get('title');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        echo json_encode($response);
    }

}
