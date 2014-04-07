<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HistoryUserController extends Controller {

    public function getHistoryView($msg = '') {
        $objHistory = new tblHistoryUserModel();
        
        $check = $objHistory->selectAllHistory(10,'id');        
        //var_dump($check);
        $link = $check->links();
        if($msg!=''){
            return View::make('backend.historyuser.HistoryManage')->with('arrHistory', $check)->with('link',$link)->with('msg',$msg);
        }else{
            return View::make('backend.historyuser.HistoryManage')->with('arrHistory', $check)->with('link',$link);
        }
    } 
    
    
    
    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objHistory = new tblHistoryUserModel();
                $objHistory->deleteHistory($item);
            }
        }
        $objHistory = new tblHistoryUserModel();
        $data = $objHistory->findHistory('', 5, 'id', '');
        $link = $data->links();
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
    }
    
    public function postDeleteHistory(){
        $objHistory = new tblHistoryUserModel();
        $objHistory->deleteHistory(Input::get('id'));
        //echo $tblPageModel;
        $arrhistory = $objHistory->selectAllHistory(10,'id');        
        $link = $arrhistory->links();
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $arrhistory)->with('link', $link);
    }
    
    public function postHistoryActive() {
        $objHistory = new tblHistoryUserModel();
        $objHistory->updateHistory(Input::get('id'),Input::get('status'));
        $arrhistory = $objHistory->selectAllHistory(10,'id');
        $link = $arrhistory->links();
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $arrhistory)->with('link', $link);
    }
    
    public function getAjaxsearch() {
        $objHistory = new tblHistoryUserModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objHistory->findHistory(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objHistory->findHistory(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.historyuser.HistoryManage')->with('arrHistory', $data)->with('link', $link);
    }
    
    public function postAjaxsearch() {
        $objHistory = new tblHistoryUserModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objHistory->findHistory(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objHistory->findHistory(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
    }

    public function postAjaxpagion() {
        if (Session::has('keywordsearch') && Input::get('page') != '') {
            $keyw = Session::get('keywordsearch');
            $objHistory = new tblHistoryUserModel();
            $data = '';
            if (Session::has('oderbyoption1')) {
                $tatus = Session::get('oderbyoption1');
                $data = $objHistory->findHistory($keyw[0], 10, 'id', $tatus[0]);
            } else {
                $data = $objHistory->findHistory($keyw[0], 10, 'id', '');
            }
            $link = $data->links();
            return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
        } else {
            Session::forget('keywordsearch');
            $objHistory = new tblHistoryUserModel();
            $tatus = Session::get('oderbyoption1');
            $data = $objHistory->findHistory('', 10, 'id', $tatus[0]);
            $link = $data->links();
            return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
        }
    }
    
    public function getFillterHistory() {
        Session::forget('keywordsearch');
        $objHistory = new tblHistoryUserModel();
        $data = $objHistory->findHistory('', 10, 'id', Input::get('oderbyoption1'));
        
        //echo count($data);
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.historyuser.HistoryManage')->with('arrHistory', $data)->with('link', $link);
    }
    
    public function postFillterHistory() {
        Session::forget('keywordsearch');
        $objHistory = new tblHistoryUserModel();
        $data = $objHistory->findHistory('', 10, 'id', Input::get('oderbyoption1'));
        
        //echo count($data);
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
    }
    
    public function getSearchDateHistory() {
        
        $objHistory = new tblHistoryUserModel();
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));
        
        if(isset($from) && isset($to)){ 
            $data = $objHistory->findHistoryByDate($from,$to, 10, 'id');
        }        
        //echo count($data);
        $link = $data->links();
        
        return View::make('backend.historyuser.HistoryManage')->with('arrHistory', $data)->with('link', $link);
    }
    
    public function postSearchDateHistory() {
        
        $objHistory = new tblHistoryUserModel();        
        
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));
        
        
        $data = $objHistory->findHistoryByDate($from,$to, 10, 'id'); 
        
        //echo count($data);
        $link = $data->links();
       
        return View::make('backend.historyuser.HistoryUserajax')->with('arrayHistory', $data)->with('link', $link);
    }

}
