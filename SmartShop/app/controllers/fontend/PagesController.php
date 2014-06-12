<?php

namespace FontEnd;

use Session,
    Input,
    Cookie,
    Redirect,
    View;

class PagesController extends \BaseController {

    public function getTrang($slug = '') {
        $tblPage = new \FontEnd\PagesModel();
        $arrayPage = $tblPage->getPageBySlug($slug);
        return View::make('fontend.Pages')->with('arrayPage', $arrayPage);
    }

}
