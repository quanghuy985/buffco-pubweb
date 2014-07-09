<?php

namespace FontEnd;

use Session,
    Input,
    Cookie,
    Redirect,
    View;

class AuthController extends \BaseController {

    /**
     * Display login screen
     * @return View
     */
    public function getLogin() {
        $tbl = new \FontEnd\Product();
        var_dump($tbl->getAllProduct(10));
        return View::make('fontend.login');
    }

}
