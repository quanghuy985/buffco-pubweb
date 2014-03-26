<?php

class ServicesController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    public function getServices($thongbao = '') {
        $objGsp = new TblServicesModel();
        $data = $objGsp->AllSServices(10);
        $link = $data->links();
        if ($thongbao != '') {
            return View::make('backend.servicesmanager')->with('datasevices', $data)->with('page', $link)->with('thongbao', $thongbao);
        } else {
            return View::make('backend.servicesmanager')->with('datasevices', $data)->with('page', $link);
        }
    }

    public function getEditServices() {
        $objGsp = new TblServicesModel();
        $data = $objGsp->AllSServices(10);
        $link = $data->links();
        $dataedit = $objGsp->SelectServicesById(Input::get('idedit'));
        return View::make('backend.servicesmanager')->with('datasevicesedit', $dataedit)->with('datasevices', $data)->with('page', $link);
    }

    public function postAddServices() {
        $rules = array(
            "servicesname" => "required",
            "servicesconent" => "required",
            "servicesprice" => "required|numeric"
        );
        $objServices = new TblServicesModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objServices->insertServices(Input::get('servicesname'), Input::get('servicesconent'), Input::get('servicesprice'), Input::get('servicesprom'), Input::get('servicesslug'));
            return Redirect::action('ServicesController@getServices', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('ServicesController@getServices', array('thongbao' => 'Thêm mới không thành công. Bạn vui lòng nhập lại thông tin'));
        }
    }

    public function postUpdateServices() {
        $rules = array(
            "servicesname" => "required",
            "servicesconent" => "required",
            "servicesprice" => "required|numeric"
        );
        $objServices = new TblServicesModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {

            $objServices->updateServices(Input::get('idservices'), Input::get('servicesname'), Input::get('servicesconent'), Input::get('servicesprice'), Input::get('servicesprom'), Input::get('servicesslug'), Input::get('status'));
            return Redirect::action('ServicesController@getServices', array('thongbao' => 'Cập nhật thành công .'));
        }
        else {
         $objGsp = new TblServicesModel();
        $data = $objGsp->AllSServices(10);
        $link = $data->links();
        $dataedit = $objGsp->SelectServicesById(Input::get('idservices'));
        return View::make('backend.servicesmanager')->with('datasevicesedit', $dataedit)->with('datasevices', $data)->with('page', $link)->with('thongbao','Cập nhật không thành công. Bạn vui lòng kiểm tra lại thông tin');
        }
    }

    public function postAjaxpagion() {
        $objGsp = new TblServicesModel();
        $data = $objGsp->AllSServices(10);
        $link = $data->links();
        return View::make('backend.servicesajax')->with('datasevices', $data)->with('page', $link);
    }

    public function postDeleteServices() {
        $objServices = new TblServicesModel();
        $objServices->DeleteServices(Input::get('iddel'));
        $data = $objServices->AllSServices(10);
        $link = $data->links();
        return View::make('backend.servicesajax')->with('datasevices', $data)->with('page', $link);
    }

}
