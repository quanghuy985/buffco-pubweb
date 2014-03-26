<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PageController extends Controller {

    public function getPageView($id = '') {
        $tblPageModel = new tblPageModel();
        $datapage = $tblPageModel->getPageById($id);
        return View::make('fontend.pageclient')->with('datapage', $datapage);
    }

}
