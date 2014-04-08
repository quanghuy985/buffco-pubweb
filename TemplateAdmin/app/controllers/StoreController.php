<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class StoreController extends Controller {

    public function getStoreView($msg = '') {
        $objSize = new tblSizeModel();

        $check = $objSize->selectAllSize(10, 'id');
        //var_dump($check);
        $link = $check->links();
        if ($msg != '') {
            return View::make('backend.SizeManage')->with('arrSize', $check)->with('link', $link)->with('msg', $msg);
        } else {
            return View::make('backend.SizeManage')->with('arrSize', $check)->with('link', $link);
        }
    }

    public function getStoreEdit() {
        $objSize = new tblSizeModel();
        $data = $objSize->getSizeByID(Input::get('id'));

        //var_dump($data);
        return View::make('backend.SizeManage')->with('arraySize', $data);
    }

    public function postUpdateStore() {
        $objSize = new tblSizeModel();
        $rules = array(
            "sizeName" => "required",
            "sizeDescription" => "required",
            "sizeValue" => "required",
            "status" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objSize->updateSize(Input::get('idsize'), Input::get('sizeName'), Input::get('sizeDescription'), Input::get('sizeValue'), Input::get('status'));
            return Redirect::action('SizeController@getSizeView', array('msg' => 'cap nhat thanh cong'));
        } else {
            return Redirect::action('SizeController@getSizeView', array('msg' => 'cap nhat that bai'));
        }
    }
 public function postUpdateSoLuong() {
        $objStore = new tblStoreModel();
        $rules = array(
            "soluongnhap" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objStore->updateStore(Input::get('id'),'','','',  Input::get('soluongnhap'),  Input::get('status'));
            return 'true';
        } else {
           return 'false';
        }
    }
    public function getAddStore() {
        return View::make('backend.SizeManage');
    }

    public function postAddStore() {
        $rules = array(
            "sizeName" => "required",
            "sizeDescription" => "required",
            "sizeValue" => "required"
        );
        $objSize = new tblSizeModel();

        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objSize->addSize(Input::get('sizeName'), Input::get('sizeDescription'), Input::get('sizeValue'));

            return Redirect::action('SizeController@getSizeView', array('msg' => 'them moi thanh cong'));
        } else {
            return Redirect::action('SizeController@getSizeView', array('msg' => 'them moi that bai'));
        }
    }

    public function postAddStoreAjax() {
        $rules = array(
            "proID" => "required",
            "sizeID" => "required",
            "colorID" => "required",
            "soluongnhap" => "required",
            "storeStatus"=> "required"
        );
        $objStore = new tblStoreModel();

        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objStore->addStore(Input::get('proID'), Input::get('sizeID'), Input::get('colorID'), Input::get('soluongnhap'),Input::get('storeStatus') );
            return 'true';
        } else {
            return 'false';
        }
    }
    public function postStoreByProductIDAjax(){
        $tblStore= new tblStoreModel();
        $arrStore= $tblStore->findStoreByProductID(Input::get('proID'));
        return View::make('backend.product.viewStore')->with('arrStore',$arrStore);
    }

    public function postCheckExitStore() {
        $tblStore = new tblStoreModel();
        $check = $tblStore->findStoreByProductIDAndType(Input::get('proID'), Input::get('sizeID'), Input::get('colorID'));       
       return count($check);
    }
    public function postCheckSoLuong() {
        $tblStore = new tblStoreModel();
        $check = $tblStore->getStoreById(Input::get('id'));  
        if($check[0]->soluongban > (int)Input::get('soluongnhap'))
            return 'true';
        else
            return 'false';
    }

    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objSize = new tblSizeModel();
                $objSize->deleteSize($item);
            }
        }
        $objSize = new tblSizeModel();
        $data = $objSize->FindSize('', 5, 'id', '');
        $link = $data->links();
        return View::make('backend.Sizeajax')->with('arraySize', $data)->with('link', $link);
    }

    public function postDeleteStore() {
        $objSize = new tblSizeModel();
        $objSize->deleteSize(Input::get('id'));
        //echo $tblPageModel;
        $arrsize = $objSize->selectAllSize(10, 'id');
        $link = $arrsize->links();
        return View::make('backend.Sizeajax')->with('arraySize', $arrsize)->with('link', $link);
    }

    public function postSizeActive() {
        $objSize = new tblSizeModel();
        $objSize->updateSize(Input::get('id'), '', '', '', Input::get('status'));
        $arrsize = $objSize->allSize(10);
        $link = $arrsize->links();
        return View::make('backend.Sizeajax')->with('arraySize', $arrsize)->with('link', $link);
    }

    public function getAjaxsearch() {
        $objSize = new tblSizeModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objSize->FindSize(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objSize->FindSize(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.SizeManage')->with('arrPage', $data)->with('link', $link);
    }

    public function postAjaxsearch() {
        $objSize = new tblSizeModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objSize->FindSize(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objSize->FindSize(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.Sizeajax')->with('arraySize', $data)->with('link', $link);
    }

    public function postAjaxpagion() {
        if (Session::has('keywordsearch') && Input::get('page') != '') {
            $keyw = Session::get('keywordsearch');
            $objSize = new tblSizeModel();
            $data = '';
            if (Session::has('oderbyoption1')) {
                $tatus = Session::get('oderbyoption1');
                $data = $objSize->FindSize($keyw[0], 10, 'id', $tatus[0]);
            } else {
                $data = $objSize->FindSize($keyw[0], 10, 'id', '');
            }
            $link = $data->links();
            return View::make('backend.Sizeajax')->with('arraySize', $data)->with('link', $link);
        } else {
            Session::forget('keywordsearch');
            $objSize = new tblSizeModel();
            $tatus = Session::get('oderbyoption1');
            $data = $objSize->FindSize('', 10, 'id', $tatus[0]);
            $link = $data->links();
            return View::make('backend.Sizeajax')->with('arraySize', $data)->with('link', $link);
        }
    }

    public function getFillterSize() {
        Session::forget('keywordsearch');
        $objSize = new tblSizeModel();
        $data = $objSize->FindSize('', 10, 'id', Input::get('oderbyoption1'));

        //echo count($data);
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.SizeManage')->with('arrSize', $data)->with('link', $link);
    }

    public function postFillterSize() {
        Session::forget('keywordsearch');
        $objSize = new tblSizeModel();
        $data = $objSize->FindSize('', 10, 'id', Input::get('oderbyoption1'));

        //echo count($data);
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.Sizeajax')->with('arraySize', $data)->with('link', $link);
    }

}
