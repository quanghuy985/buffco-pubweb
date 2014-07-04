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
public function __construct() {
        parent::__construct();
        $this->beforeFilter('checkrole');
    }
    public function getFeedBack() {
        $tblFeedbackModel = new tblFeedbackModel();
        $arrFeedback = $tblFeedbackModel->allFeedback(1);
        $link = $arrFeedback->links();
        if (\Request::ajax()) {
            return View::make('backend.feedback.AjaxFeedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
        } else {

            return View::make('backend.feedback.feedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
        }
    }

    public function postSearchFeedBack() {
        $one = \Input::get('searchblur');
        if ($one == '') {
            $one = 'null';
        }
        return \Redirect::action('\BackEnd\FeedbackController@getSearchFeedBack', array($one));
    }

    public function getSearchFeedBack($one = '') {
        if ($one == 'null') {
            $one = '';
        }
        $tblFeedbackModel = new tblFeedbackModel();
        $arrFeedback = $tblFeedbackModel->searchFeedback(1, $one);
        $link = $arrFeedback->links();
        if (\Request::ajax()) {
            return View::make('backend.feedback.AjaxFeedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
        } else {
            return View::make('backend.feedback.feedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
        }
    }

    public function postFillterFeedBack() {
        $one = \Input::get('timeform');
        $two = \Input::get('timeto');
        $three = \Input::get('fillter_status');
        if ($one == '') {
            $one = 'null';
        } else {
            $one = strtotime($one);
        }
        if ($two == '') {
            $two = 'null';
        } else {
            $two = strtotime($two) + 24 * 60 * 60;
        }
        if ($three == '') {
            $three = 'null';
        }
        return \Redirect::action('\BackEnd\FeedbackController@getFillterFeedBack', array($one, $two, $three));
    }

    public function getFillterFeedBack($one = '', $two = '', $three = '') {
        $tblFeedbackModel = new tblFeedbackModel();
        $arrFeedback = $tblFeedbackModel->searchFillterFeedback(1, $one, $two, $three);
        $link = $arrFeedback->links();
        if (\Request::ajax()) {
            return View::make('backend.feedback.AjaxFeedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
        } else {

            return View::make('backend.feedback.feedbackManage')->with('arrayFeedback', $arrFeedback)->with('links', $link);
        }
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
        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.feedback.reply') . ' ' . Input::get('userEmail');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
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
        $tblFeedbackModel->deleteFeedback(Input::get('id'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.feedback.delete') . ' ' . Input::get('id');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        return \Redirect::action('\BackEnd\FeedbackController@getFeedBack');
    }

}
