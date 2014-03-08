<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FeedbackController extends Controller {

    public function getFeedbackView() {
        $tblFeedbackModel = new TblFeedbackModel();
        $check = $tblFeedbackModel->findFeedback('', 10, 'id', '');
        $link = $check->links();
        return View::make('backend.feedbackManage')->with('arrayFeedback', $check)->with('link', $link);
    }

    public function getFeedbackReply() {
        $tblFeedbackModel = new TblFeedbackModel();
        $feedbackData = $tblFeedbackModel->getFeedbackbyID(Input::get('id'));
        return View::make('backend.feedbackAdd')->with('feedbackdata', $feedbackData);
    }

    public function getFeedbackDelete() {
        $tblFeedbackModel = new TblFeedbackModel();
        $tblFeedbackModel->updateFeedback(Input::get('id'), '2');
        return Redirect::action('FeedbackController@getFeedbackView');
    }

    public function postReplyFeedback() {
        $contentFeedback = Input::get('feedbackContent');
        $contentReply = Input::get('feedbackReplyContent');
        $tblFeedbackModel = new TblFeedbackModel();
        $tblFeedbackModel->updateFeedback(Input::get('feedbackID'), '1');
        Mail::send('emails.feedback.feedback', array('noidung' => $contentFeedback, 'traloi' => $contentReply), function($message) {
            $message->from('no-rep@pubweb.vn', 'Pubweb.vn');
            $message->to(Input::get('userEmail'));
            $message->subject(Input::get('feedbackSubject') . ' - ' . Input::get('feedbackTime'));
        });
        return Redirect::action('FeedbackController@getFeedbackView');
    }

    public function postAjaxpagion() {
        if (Session::has('keywordsearch') && Input::get('link') != '') {
            $keyw = Session::get('keywordsearch');
            $tblFeedbackModel = new TblFeedbackModel();
            $data = $tblFeedbackModel->findFeedback($keyw[0], 10, 'id', '');
            $link = $data->links();
            return View::make('backend.feedbackajaxsearch')->with('arrayFeedback', $data)->with('link', $link);
        } else {
            $tblFeedbackModel = new TblFeedbackModel();
            $data = $tblFeedbackModel->findFeedback('', 10, 'id', '');
            $link = $data->links();
            return View::make('backend.feedbackajaxsearch')->with('arrayFeedback', $data)->with('link', $link);
        }
    }

    public function postAjaxsearch() {
        $tblUserModel = new TblFeedbackModel();
        $data = $tblUserModel->findFeedback(Input::get('keywordsearch'), 10, 'id', '');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.feedbackajaxsearch')->with('arrayFeedback', $data)->with('link', $link);
    }

}
