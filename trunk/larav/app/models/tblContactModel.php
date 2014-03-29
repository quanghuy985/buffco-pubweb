<?php

class tblContactModel extends Eloquent {

    protected $table = 'tblfeedback';
    public $timestamps = false;

    public function addNews($feedbackUserEmail, $feedbackUserName, $feedbackSubject, $feedbackContent) {
        $this->feedbackUserEmail = $feedbackUserEmail;
        $this->feedbackUserName = $feedbackUserName;
        $this->feedbackSubject = $feedbackSubject;
        $this->feedbackContent = $feedbackContent;
        $this->feedbackTime = time();
        $this->status = 0;
        $this->save();
    }

}
