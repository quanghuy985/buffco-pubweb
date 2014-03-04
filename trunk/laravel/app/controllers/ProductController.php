<?php

class ProductController extends BaseController {
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

    public function getAddProduct() {
        $objCateproduct = new TblCategoryProductModel();
        $data = $objCateproduct->all();
        return View::make('backend.addproduct')->with('catproduct', $data);
    }

    public function postAddProduct() {
        $rules = array(
            "productname" => "required",
            "productdes" => "required",
            "productprice" => "required|numeric"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objproduct = new TblProductModel();
            $upload = new UploadModel();
            $checkup = $upload->postUpload(Input::file('fileupload'));
            if ($checkup == FALSE) {
                echo 'khong upload dc';
            } else {
                $objproduct->insertProduct(Input::get('categoryproduct'), Input::get('productname'), $checkup, Input::get('productdes'), Input::get('productprice'), Input::get('productprom'), Input::get('producturldemo'), Input::get('productslug'), Input::get('productversion'));
                $objCateproduct = new TblCategoryProductModel();
                $data = $objCateproduct->all();
                return View::make('backend.addproduct')->with('catproduct', $data)->with('thongbao', 'Sản phẩm của bạn đã được thêm vào cơ sở dữ liệu.');
            }
        }
    }

    public function getEditProduct() {
        if (Input::get('idedit') == '') {
            return Redirect::action('ProductController@getView');
        } else {
            $objCateproduct = new TblCategoryProductModel();
            $data = $objCateproduct->all();
            $objproduct = new TblProductModel();
            $datap = $objproduct->SelectProductById(Input::get('idedit'));
            return View::make('backend.addproduct')->with('catproduct', $data)->with('dataedit', $datap);
        }
    }

    public function postEditProduct() {
        $rules = array(
            "productname" => "required",
            "productdes" => "required",
            "productprice" => "required|numeric"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objproduct = new TblProductModel();
            $datap = $objproduct->SelectProductById(Input::get('idpro'));
            $upload = new UploadModel();
            if (Input::file('fileupload') == NULL) {
                $objproduct->updateProduct(Input::get('idpro'), Input::get('categoryproduct'), Input::get('productname'), '', Input::get('productdes'), Input::get('productprice'), Input::get('productprom'), Input::get('producturldemo'), Input::get('productslug'), Input::get('productversion'), time(), Input::get('status'));
                $objCateproduct = new TblCategoryProductModel();
                $data = $objCateproduct->all();
                return View::make('backend.addproduct')->with('catproduct', $data)->with('dataedit', $datap)->with('thongbao', 'Sản phẩm của bạn đã được cập nhật .');
            } else {
                $checkup = $upload->postUpload(Input::file('fileupload'));
                if ($checkup == FALSE) {
                    echo 'khong upload dc';
                } else {
                    $objproduct->updateProduct(Input::get('idpro'), Input::get('categoryproduct'), Input::get('productname'), $checkup, Input::get('productdes'), Input::get('productprice'), Input::get('productprom'), Input::get('producturldemo'), Input::get('productslug'), Input::get('productversion'), time(), Input::get('status'));
                    $objCateproduct = new TblCategoryProductModel();
                    $data = $objCateproduct->all();
                    return View::make('backend.addproduct')->with('catproduct', $data)->with('dataedit', $datap)->with('thongbao', 'Sản phẩm của bạn đã được cập nhật .');
                }
            }
        }
    }

    public function getView() {
        if (Session::has('keywordsearch') && Input::get('page') != '') {
            $keyw = Session::get('keywordsearch');
            $objGsp = new TblProductModel();
            $data = $objGsp->FindProduct($keyw[0], 10, 'id', '');
            $link = $data->links();
            return View::make('backend.viewproduct')->with('data', $data)->with('page', $link);
        } else {
            Session::forget('keywordsearch');
            $objGsp = new TblProductModel();
            $data = $objGsp->FindProduct('', 10, 'id', '');
            $link = $data->links();
            return View::make('backend.viewproduct')->with('data', $data)->with('page', $link);
        }
    }

    public function postAjaxsearch() {
        $objGsp = new TblProductModel();
        $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.productajaxsearch')->with('data', $data)->with('page', $link);
    }

    public function postAjaxpagion() {
        if (Session::has('keywordsearch') && Input::get('page') != '') {
            $keyw = Session::get('keywordsearch');
            $objGsp = new TblProductModel();
            $data = $objGsp->FindProduct($keyw[0], 10, 'id', '');
            $link = $data->links();
            return View::make('backend.productajaxsearch')->with('data', $data)->with('page', $link);
        } else {
            Session::forget('keywordsearch');
            $objGsp = new TblProductModel();
            $tatus = Session::get('oderbyoption1');
            $data = $objGsp->FindProduct('', 10, 'id', $tatus[0]);
            $link = $data->links();
            return View::make('backend.productajaxsearch')->with('data', $data)->with('page', $link);
        }
    }

    public function postFillterProduct() {
        $objGsp = new TblProductModel();
        $data = $objGsp->FindProduct('', 10, 'id', Input::get('oderbyoption1'));
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.productajaxsearch')->with('data', $data)->with('page', $link);
    }

    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objGsp = new TblProductModel();
                $objGsp->DeleteProduct($item);
            }
        }
        $objGsp = new TblProductModel();
        $data = $objGsp->FindProduct('', 10, 'id', '');
        $link = $data->links();
        return View::make('backend.viewproduct')->with('data', $data)->with('page', $link);
    }

    public function postDel() {
        $objGsp = new TblProductModel();
        $objGsp->DeleteProduct(Input::get('id'));
        $objGsp = new TblProductModel();
        $data = $objGsp->FindProduct('', 10, 'id', '');
        $link = $data->links();
        return View::make('backend.productajaxsearch')->with('data', $data)->with('page', $link);
    }

//    public function getAjaxsearch() {
//        var_dump(Input::get('page'));
//        if (Session::has('keywordsearch')) {
//            $keyw = Session::get('keywordsearch');
//            $objGsp = new TblSupporterGroupModel();
//            $data = $objGsp->FindGSupport($keyw[0], 10);
//            $link = $data->links();
//            return View::make('backend.viewproduct')->with('data', $data)->with('page', $link);
//        } else {
//            $objGsp = new TblSupporterGroupModel();
//            $data = $objGsp->AllGSupport(2);
//            $link = $data->links();
//            return View::make('backend.viewproduct')->with('data', $data)->with('page', $link);
//        }
//    }



    public function getLo() {
        echo 'adas';
    }

}
