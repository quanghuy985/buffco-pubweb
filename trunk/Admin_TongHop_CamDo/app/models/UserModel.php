<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserModel extends Eloquent implements UserInterface, RemindableInterface {

    protected $table = 'tbl_users';

    public function RegisterUser($allinput) {
        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:tbl_users',
            'r_password' => 'required|between:6,20|confirmed',
            'r_password_confirmation' => 'required|between:6,20',
            'recaptcha_response_field' => 'required|recaptcha',
        );
        $validator = Validator::make($allinput, $rules);
        if ($validator->passes()) {
            $this->email = $allinput['email'];
            $this->password = Hash::make($allinput['r_password']);
            $this->firstname = $allinput['firstname'];
            $this->lastname = $allinput['lastname'];
            $this->dateofbirth = '';
            $this->address = $allinput['r_address'];
            $this->phone = $allinput['phone'];
            $this->verify = '';
            $this->remember_token = '';
            $this->time = time();
            $this->status = 1;
            $this->admin = 0;
            $this->save();
            return true;
        } else {
            return $validator->messages();
        }
    }

    public function RegisterAdmin($allinput, $verify) {
        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:tbl_users',
            'r_password' => 'required|between:6,20|confirmed',
            'r_password_confirmation' => 'required|between:6,20',
            'recaptcha_response_field' => 'required|recaptcha',
        );
        $validator = Validator::make($allinput, $rules);
        if ($validator->passes()) {
            $this->email = $allinput['email'];
            $this->password = Hash::make($allinput['r_password']);
            $this->firstname = $allinput['firstname'];
            $this->lastname = $allinput['lastname'];
            $this->dateofbirth = '';
            $this->address = '';
            $this->phone = '';
            $this->verify = '';
            $this->remember_token = '';
            $this->time = time();
            $this->status = 1;
            $this->admin = 1;
            $this->save();
            return 'true';
        } else {
            return $validator;
        }
    }

    public function CheckUserExist($uemailf) {
        $checku = $this->where('email', '=', $uemailf)->count();
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    protected $hidden = array('password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    

    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail() {
        return $this->email;
    }

    public function getRememberToken() {
        return $this->remember_token;
    }

    public function setRememberToken($value) {
        $this->remember_token = $value;
    }

    public function getRememberTokenName() {
        return 'remember_token';
    }

}
