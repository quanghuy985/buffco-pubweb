<?php

namespace BackEnd;

/**
 * Created by PhpStorm.
 * User: Hoang
 * Date: 5/16/14
 * Time: 4:34 PM
 */
class HomeController extends \BaseController {

    public function getHome() {
        return \View::make('backend.home');
    }

}
