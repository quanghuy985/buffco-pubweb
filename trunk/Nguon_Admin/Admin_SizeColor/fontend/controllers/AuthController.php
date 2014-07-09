<?php

namespace App\Modules\Fontend\Controllers;

use fontend,
    Input,
    Redirect,
    View;


class AuthController extends \BaseController {

    /**
     * Display login screen
     * @return View
     */
    public function getLogin() {
        $tbl = new \App\Modules\Fontend\Models\Product();
        var_dump($tbl->getAllProduct(10));
        return View::make('fontend::login');
    }

}
