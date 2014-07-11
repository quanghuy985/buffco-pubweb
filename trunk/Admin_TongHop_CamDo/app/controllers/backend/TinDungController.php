<?php

namespace BackEnd;

use BackEnd,
    View,
    Lang,
    Redirect,
    Session,
    Input,
    Validator;

class TinDungController extends \BaseController {

    public function getThemMoi() {
        return View::make('backend.camdo.vayTien');
    }

}
