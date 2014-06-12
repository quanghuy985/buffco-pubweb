<?php

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    public function __construct() {
//        try {
//            $this->beforeFilter('csrf', array('on' => 'post'));
//        } catch (Illuminate\Session\TokenMismatchException $e) {
//            return Redirect::back()->withInput();
//        }
    }

    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}
