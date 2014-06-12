<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use BackEnd,
    View,
    Input,
    Validator,
    Lang,
    Session,
    Mail,
    Redirect;

class FeedbackController extends \BaseController {

    public function getFeedBack() {
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

    public function getRepFeedBack($id) {
        $tblFeedbackModel = new tblFeedbackModel();
        $feedbackData = $tblFeedbackModel->getFeedbackbyID($id);
        if (empty($feedbackData)) {
            return Response::view('backend.404Page', array(), 404);
        }
        return View::make('backend.feedback.repFeedback')->with('feedbackdata', $feedbackData[0]);
    }

    public function postTraLoi() {
        $contentFeedback = Input::get('feedbackContent');
        $contentReply = Input::get('feedbackReplyContent');
        $rules = array('feedbackReplyContent' => 'required|min:20');
        $validate = Validator::make(Input::all(), $rules, array(), Lang::get('backend/attributes.feedback'));
        if ($validate->fails()) {
            Session::flash('alert_error', Lang::get('messages.reply.error'));
            return Redirect::back()->withErrors($validate->messages())->withInput(Input::all());
        }
        $tblFeedbackModel = new tblFeedbackModel();
        $tblFeedbackModel->updateFeedback(Input::get('id'), 1);
        $objAdmin = Session::get('adminSession');
        $historyContent = Lang::get('backend/history.feedback.reply') . ':' . Input::get('feedbackSubject');
        Mail::send('emails.feedback.feedback', array('noidung' => $contentFeedback, 'traloi' => $contentReply), function($message) {
            $message->from('no-rep@pubweb.vn', 'Pubweb.vn');
            $message->to(Input::get('userEmail'));
            $message->subject(Input::get('feedbackSubject') . ' - ' . Input::get('feedbackTime'));
        });
        Session::flash('alert_success', Lang::get('messages.reply.success'));
        return Redirect::action('\BackEnd\FeedbackController@getFeedBack');
    }

    public function postXoaPhanHoi() {
        $tblFeedbackModel = new tblFeedbackModel();
        $tblFeedbackModel->updateFeedback(Input::get('id'), '2');
        $arrFeedback = $tblFeedbackModel->allFeedback(1);
        $link = $arrFeedback->links();
        return View::make('backend.feedback.AjaxFeedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
    }

}
