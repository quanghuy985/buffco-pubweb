<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AccountController extends Controller {

    public function getProfileView($check='') {
        $tblUsersModel = new tblUsersModel();
        $datauser = $tblUsersModel->getUserById(3);             
 return View::make('fontend.profile')->with('datauser', $datauser[0])->with('check', $check);
    }

    public function postProfile() {
        $tblUsersModel = new tblUsersModel();       
        try {            
            $tblUsersModel->updateUser(Input::get('hEmail'),'', Input::get('fistName'), Input::get('lastName'), Input::get('address'), Input::get('phone'), Input::get('identify'),'','');
            return Redirect::action('AccountController@getProfileView',$check='1');
        } catch (Exception $ex) {
            return Redirect::action('AccountController@getProfileView',$check='2');
        }
    }

}
