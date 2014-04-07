<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProjectController extends Controller {

    public static $rules = array();
    
    

    public function getProjectView($msg='') {
        $objProject = new tblProjectModel();
        $check = $objProject->selectAllProject(5,'id');        
        //var_dump($check);
        $link = $check->links();
        if($msg!=''){
            return View::make('backend.project.ProjectManage')->with('arrayProject', $check)->with('link',$link)->with('msg',$msg);
        }else{
            return View::make('backend.project.ProjectManage')->with('arrayProject', $check)->with('link',$link);
        }
    }
    
    public function getProjectEdit() {
        $objProject = new tblProjectModel();
        $data = $objProject->getProjectById(Input::get('id'));  
        
        //var_dump($data);
        return View::make('backend.project.ProjectManage')->with('dataProject', $data);
    }
    
    public function postUpdateProject() {
        $objProject = new tblProjectModel();
        $rules = array(
            "from" => "required",
            "to" => "required",
            "description" => "required",
            "content" => "required",
            "status" => "required"
            );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $from = strtotime(Input::get('from'));
            $to = strtotime(Input::get('to'));
            if($from>$to){
                return Redirect::action('ProjectController@getProjectView',array('msg'=>'Ngày bắt đầu không được lớn hơn ngày kết thúc'));
            }else{
                $objProject->updateProject(Input::get('idproject'),$from, $to, Input::get('description'), Input::get('content'), Input::get('status'));            
                return Redirect::action('ProjectController@getProjectView',array('msg'=>'cap nhat thanh cong'));
            }
        } else {
            return Redirect::action('ProjectController@getProjectView',array('msg'=>'cap nhat that bai'));
        }
    }
    
    public function getAddProject() {
        return View::make('backend.project.ProjectManage');
    }
    
//    public function postAddProject(){
//        $objProject = new tblProjectModel();
//        $from = strtotime(Input::get('from'));
//        $to = strtotime(Input::get('to'));
//        
//    }

    public function postAddProject() {
        $rules = array(
            "from" => "required",
            "to" => "required",
            "description" => "required",
            "content" => "required",
            "status" => "required"
        );
        $objProject = new tblProjectModel();
        
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $from = strtotime(Input::get('from'));
            $to = strtotime(Input::get('to'));
            if($from>$to){
                return Redirect::action('ProjectController@getProjectView',array('msg'=>'Ngày bắt đầu không được lớn hơn ngày kết thúc'));
            }else{
                $objProject->addProject($from, $to, Input::get('description'), Input::get('content'), Input::get('status'));      
                return Redirect::action('ProjectController@getProjectView',array('msg'=>'them moi thanh cong'));
            }
        } else {
            return Redirect::action('ProjectController@getProjectView',array('msg'=>'them moi that bai'));
        }
    }
    
    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objProject = new tblProjectModel();
                $objProject->deleteProject($item);
            }
        }
        $objProject = new tblProjectModel();
        $data = $objProject->findProject('', 5, 'id', '');
        $link = $data->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $data)->with('link', $link);
    }
    
    public function postDeleteProject(){
        $objProject = new tblProjectModel();        
        $objProject->deleteProject(Input::get('id'));
        
        $arrayProject = $objProject->selectAllProject(10,'id');        
        $link = $arrayProject->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $arrayProject)->with('link', $link);
    }
    
    public function postProjectActive() {
        $objProject = new tblProjectModel();
        $objProject->updateProject(Input::get('id'),'', '', '', '', Input::get('status'));
        $arrayProject = $objProject->selectAll(10);
        $link = $arrayProject->links();
        return View::make('backend.project.Projectajax')->with('dataProject', $arrayProject)->with('link', $link);
    }
    
    public function getAjaxsearch() {
        $objProject = new tblProjectModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objProject->SearchProject(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objProject->SearchProject(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.project.ProjectManage')->with('arrayProject', $data)->with('link', $link);
    }
    
    public function postAjaxsearch() {
        $objProject = new tblProjectModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objProject->SearchProject(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objProject->SearchProject(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.project.Projectajax')->with('dataProject', $data)->with('link', $link);
    }

    public function postAjaxpagion() {
        if (Session::has('keywordsearch') && Input::get('page') != '') {
            $keyw = Session::get('keywordsearch');
            $objProject = new tblProjectModel();
            $data = '';
            if (Session::has('oderbyoption1')) {
                $tatus = Session::get('oderbyoption1');
                $data = $objProject->findProject($keyw[0], 10, 'id', $tatus[0]);
            } else {
                $data = $objProject->findProject($keyw[0], 10, 'id', '');
            }
            $link = $data->links();
            return View::make('backend.project.Projectajax')->with('dataProject', $data)->with('link', $link);
        } else {
            Session::forget('keywordsearch');
            $objProject = new tblProjectModel();
            $tatus = Session::get('oderbyoption1');
            $data = $objProject->findProject('', 10, 'id', $tatus[0]);
            $link = $data->links();
            return View::make('backend.project.Projectajax')->with('dataProject', $data)->with('link', $link);
        }
    }
    
    public function getFillterProject() {
        Session::forget('keywordsearch');
        $objProject = new tblProjectModel();
        $data = $objProject->findProject('', 10, 'id', Input::get('oderbyoption1'));
        
        //echo count($data);
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.project.ProjectManage')->with('arrayProject', $data)->with('link', $link);
    }
    
    public function postFillterProject() {
        Session::forget('keywordsearch');
        $objProject = new tblProjectModel();
        $data = $objProject->findProject('', 10, 'id', Input::get('oderbyoption1'));
        
        //echo count($data);
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.project.Projectajax')->with('dataProject', $data)->with('link', $link);
    }
    
    
    
}
    



    


