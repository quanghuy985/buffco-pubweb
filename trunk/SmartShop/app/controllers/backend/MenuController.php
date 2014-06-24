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

class MenuController extends \BaseController {

    public function getMenuView($msg = '') {
        $tblMenu = new tblMenuModel();
        $tblpage = new tblPageModel();
        $check = $tblMenu->getAllMenuNewPaginate(10);
        $links = $check->links();
        $start = $check->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $tblcateNews = new tblCategoryNewsModel();
        $tblcateProduct = new tblCategoryProductModel();
        $catepro = $tblcateProduct->allListCateProduct();
        $catenews = $tblcateNews->allCateNewList();
        $menu = $tblpage->getAllPage();
        //$menu = $tblMenu->getMenu();
        $arrMenu = $tblMenu->getAllMenuNew($start, 10);
        if ($msg != '') {
            return View::make('backend.menu.menu')->with('arrMenu', $arrMenu)->with('catenews', $catenews)->with('catepro', $catepro)->with('menu', $menu)->with('link', $links)->with('msg', $msg);
        } else {
            return View::make('backend.menu.menu')->with('arrMenu', $arrMenu)->with('catenews', $catenews)->with('catepro', $catepro)->with('menu', $menu)->with('link', $links);
        }
    }

    public function getMenuEdit($id) {
        $tblMenu = new tblMenuModel();
        $tblpage = new tblPageModel();
        $check = $tblMenu->getAllMenuNewPaginate(10);
        $links = $check->links();
        $start = $check->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $arrMenu = $tblMenu->getAllMenuNew($start, 10);
        $tblcateNews = new tblCategoryNewsModel();
        $tblcateProduct = new tblCategoryProductModel();
        $catepro = $tblcateProduct->allListCateProduct();
        $catenews = $tblcateNews->allCateNewList();
        $menu = $tblpage->getAllPage();
        //$menu = $tblMenu->getMenu();
        $dataedit = $tblMenu->findMenuByID($id);
        return View::make('backend.menu.menu')->with('arrayMenu', $dataedit[0])->with('arrMenu', $arrMenu)->with('catenews', $catenews)->with('catepro', $catepro)->with('menu', $menu)->with('link', $links);
    }

    public function postUpdateMenu() {
        $tblMenu = new tblMenuModel();
        $rules = array(
            "menuName" => "required",
            "urlValue" => "required",
            "parentvalue" => "required",
            "menuPosition" => "required|numeric",
            "status" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblMenu->updateMenu(Input::get('idmenu'), Input::get('menuName'), Input::get('urlValue'), Input::get('parentvalue'), Input::get('menuPosition'), Input::get('status'));

            return Redirect::action('MenuController@getMenuView', array('msg' => 'Cập nhật thành công'));
        } else {
            return Redirect::action('MenuController@getMenuView', array('msg' => 'Cập nhật thất bại'));
        }
    }

    public function getAddMenu() {
        $tblMenu = new tblMenuModel();
        $tblPage = new tblPageModel();
        $tblcateNews = new tblCategoryNewsModel();
        $tblcateProduct = new tblCategoryProductModel();
        $catepro = $tblcateProduct->allListCateProduct();
        $catenews = $tblcateNews->allCateNewList();

        $page = $tblPage->getAllPage();
        //var_dump($page);
        //$menu = $tblMenu->getMenu();
        return View::make('backend.menu.addMenu')->with('page', $page)->with('catenews', $catenews)->with('catepro', $catepro);
    }

    public function postAddMenu() {
        $rules = array(
            "menuName" => "required",
            "urlValue" => "required",
            "parentvalue" => "required",
            "menuPosition" => "required|numeric",
            "status" => "required"
        );
        $menuName = Input::get('menuName');
        $menuURL = Input::get('urlValue');
        $menuParent = Input::get('parentvalue');
        $menuPosition = Input::get('menuPosition');
        $status = Input::get('status');
        $tblMenu = new tblMenuModel();
        $tblMenu->addMenu($menuName, $menuURL, $menuParent, $menuPosition, $status);
        return Redirect::action('MenuController@getMenuView', array('msg' => 'Them moi thanh cong'));
    }

    public function postCheckURL() {
        $tblMenu = new tblMenuModel();
        $count = 0;
        $urlcheck = Input::get('url');
        $count = $tblMenu->countURL($urlcheck);
        return $count;
    }

    public function postDeleteMenu() {
        $tblMenu = new tblMenuModel();
        $tblMenu->deleteMenuByID(Input::get('id'));
        $check = $tblMenu->getAllMenuNewPaginate(10);
        $links = $check->links();
        $start = $check->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $menu = $tblMenu->getMenu();
        $arrMenu = $tblMenu->getAllMenuNew($start, 10);
        return View::make('backend.menu.menuajax')->with('arrMenu', $arrMenu)->with('link', $links);
    }

    public function postMenuActive() {
        $tblMenu = new tblMenuModel();
        $tblMenu->updateMenu(Input::get('id'), '', '', '', '', Input::get('status'));
        $check = $tblMenu->getAllMenuNewPaginate(10);
        $links = $check->links();
        $start = $check->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $menu = $tblMenu->getMenu();
        $arrMenu = $tblMenu->getAllMenuNew($start, 10);
        return View::make('backend.menu.menuajax')->with('arrMenu', $arrMenu)->with('link', $links);
    }

}
