<?php

namespace App\Modules\Fontend\Controllers;

use fontend,
    Input,
    Redirect,
    View;

class UserController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
      
    }

    public function getDangKy() {
        return View::make('fontend::Register');
    }

    public function postDangNhap() {
        
    }

}
