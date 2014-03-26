<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ContactController extends Controller {

    public function getContactView($susscess = '') {
        return View::make('fontend.contact')->with('susscess', $susscess);
    }

    public function postContact() {
        $tblContactModel = new tblContactModel();
        try {
            $rules = array(
                "name" => "required",
                "email" => "required",
                "subject" => "required",
                "message" => "required",
            );
            if (!Validator::make(Input::all(), $rules)->fails()) {
                $tblContactModel->addNews(Input::get('name'), Input::get('email'), Input::get('subject'), Input::get('message'));
                return View::make('fontend.contact')->with('susscess', '1');
            } else {
                return View::make('fontend.contact')->with('susscess', '2');
            }
        } catch (Exception $ex) {
            return View::make('fontend.contact')->with('susscess', '2');
        }
    }

}
