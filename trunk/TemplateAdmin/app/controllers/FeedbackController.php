<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FeedbackController extends BaseController {

    public function getPhanHoi() {
        $tblFeedbackModel = new tblFeedbackModel();
        $arrFeedback = $tblFeedbackModel->allFeedback(1);
        $link = $arrFeedback->links();
        return View::make('backend.feedback.feedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
    }

    public function postAjaxPhanHoi() {
        $tblFeedbackModel = new tblFeedbackModel();
        $arrFeedback = $tblFeedbackModel->allFeedback(1);
        $link = $arrFeedback->links();
        return View::make('backend.feedback.AjaxFeedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
    }

    public function postAjaxSearchPhanHoi() {
        $tblFeedbackModel = new tblFeedbackModel();
        $arrFeedback = $tblFeedbackModel->searchFeedback(1, trim(Input::get('keyword')));
        $link = $arrFeedback->links();
        return View::make('backend.feedback.AjaxFeedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
    }

    public function postAjaxLocPhanHoi() {
        $from = strtotime(Input::get('fromtime'));
        $to = strtotime(Input::get('totime'));
        $tblFeedbackModel = new tblFeedbackModel();
        $arrFeedback = $tblFeedbackModel->fillterFeedback(1, $from, $to);
        $link = $arrFeedback->links();
        return View::make('backend.feedback.AjaxFeedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
    }

    public function postAjaxSearchLocPhanHoi() {
        $keyword = trim(Input::get('keyword'));
        $from = strtotime(Input::get('fromtime'));
        $to = strtotime(Input::get('totime'));
        $tblFeedbackModel = new tblFeedbackModel();
        $arrFeedback = $tblFeedbackModel->searchFillterFeedback(1, $keyword, $from, $to);
        $link = $arrFeedback->links();
        return View::make('backend.feedback.AjaxFeedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
    }

    public function getTraLoi() {
        $tblFeedbackModel = new tblFeedbackModel();
        $feedbackData = $tblFeedbackModel->getFeedbackbyID(Input::get('id'));
        return View::make('backend.feedback.repFeedback')->with('feedbackdata', $feedbackData[0]);
    }

    public function postTraLoi() {
        $contentFeedback = Input::get('feedbackContent');
        $contentReply = Input::get('feedbackReplyContent');
        $tblFeedbackModel = new tblFeedbackModel();
        $tblFeedbackModel->updateFeedback(Input::get('feedbackID'), '1');
        Mail::send('emails.feedback.feedback', array('noidung' => $contentFeedback, 'traloi' => $contentReply), function($message) {
            $message->from('no-rep@pubweb.vn', 'Pubweb.vn');
            $message->to(Input::get('userEmail'));
            $message->subject(Input::get('feedbackSubject') . ' - ' . Input::get('feedbackTime'));
        });
        return Redirect::action('FeedbackController@getPhanHoi');
    }

    public function getXoa() {
        
    }

}
