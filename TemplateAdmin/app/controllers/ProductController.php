<?php

class ProductController extends Controller {
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
        //lấy danh sách nhà cung cấp   
        $tblManu = new tblManufacturerModel();
        $arrManu = $tblManu->selectAll(1000);
        //lấy danh sách các khuyến mại
        $tblPromotion = new tblPromotionModel();
        $objPromotion = $tblPromotion->getAllPromotion(1000);
        //lấy danh sách danh mục sản phẩm
        $objCateproduct = new TblCategoryProductModel();
        $data = $objCateproduct->getAllCategoryProductPaginate(10000);
        return View::make('backend.product.addproduct')->with('catproduct', $data)->with('arrPromotion', $objPromotion)->with('arrManu', $arrManu);
    }

    public function postAddProduct() {
        $rules = array(
            "cateID" => "required",
            "productName" => "required",
            "productDescription" => "required",
            "productPrice" => "required",
            "promotionID" => "required",
            "productSlug" => "required",
            "productTag" => "required",
            "manufactureID" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objproduct = new TblProductModel();
            $objproduct->insertProduct(Input::get('cateID'), Input::get('productName'), Input::get('productDescription'), Input::get('productPrice'), Input::get('promotionID'), Input::get('productSlug'), Input::get('productTag'), Input::get('manufactureID'), Input::get('status'));
            $idPro = $objproduct->id;
            $arrTags = Input::get('tag');
            foreach ($arrTags as $item) {
                $tblPMeta = new tblPMetaModel();
                $tblPMeta->insertPMeta($idPro, $item);
            }
            $objCateproduct = new TblCategoryProductModel();
            //lấy danh sách các khuyến mại
            $tblPromotion = new tblPromotionModel();
            $objPromotion = $tblPromotion->getAllPromotion(1000);
            //lấy danh sách danh mục sản phẩm
            $data = $objCateproduct->getAllCategoryProductPaginate(1000);
            //lấy sản phẩm theo id          
            $datap = $objproduct->getProductById($idPro);
            //lấy danh sách tag của sản phẩm
            $tblTag = new tblTagModel();
            $arrTag = $tblTag->getTagByCateID($datap[0]->cateID);
            //lấy danh sách các tag đã được chọn
            $tblPMetaModel = new tblPMetaModel();
            $arrTaged = $tblPMetaModel->getTagByProductID($idPro);
            //lấy danh sách nhà cung cấp   
            $tblManu = new tblManufacturerModel();
            $arrManu = $tblManu->selectAll(1000);
            return View::make('backend.product.addproduct')->with('catproduct', $data)->with('dataedit', $datap[0])->with('arrPromotion', $objPromotion)->with('arrTag', $arrTag)->with('arrTaged', $arrTaged)->with('arrManu',$arrManu)->with('thongbao', 'Sản phẩm đã được cập nhật thành công');
        }
        else{
            
        }
    }

    public function getEditProduct() {
        if (Input::get('idedit') == '') {
            return Redirect::action('ProductController@getView');
        } else {
            $objCateproduct = new TblCategoryProductModel();
            //lấy danh sách các khuyến mại
            $tblPromotion = new tblPromotionModel();
            $objPromotion = $tblPromotion->getAllPromotion(1000);
            //lấy danh sách danh mục sản phẩm
            $data = $objCateproduct->getAllCategoryProductPaginate(1000);
            //lấy sản phẩm theo id
            $objproduct = new TblProductModel();
            $datap = $objproduct->getProductById(Input::get('idedit'));
            //lấy danh sách tag của sản phẩm
            $tblTag = new tblTagModel();
            $arrTag = $tblTag->getTagByCateID($datap[0]->cateID);
            //lấy danh sách các tag đã được chọn
            $tblPMetaModel = new tblPMetaModel();
            $arrTaged = $tblPMetaModel->getTagByProductID(Input::get('idedit'));

            $tblManu = new tblManufacturerModel();
            $arrManu = $tblManu->selectAll(1000);
            return View::make('backend.product.addproduct')->with('catproduct', $data)->with('dataedit', $datap[0])->with('arrPromotion', $objPromotion)->with('arrTag', $arrTag)->with('arrTaged', $arrTaged)->with('arrManu', $arrManu);
        }
    }

    public function postTagByCateID() {
        $tblTag = new tblTagModel();
        $arrTag = $tblTag->getTagByCateID(Input::get('cateID'));
        //lấy danh sách các tag đã được chọn
        if (Input::get('productID') != '') {
            $tblPMetaModel = new tblPMetaModel();
            $arrTaged = $tblPMetaModel->getTagByProductID(Input::get('productID'));
            return View::make('backend.product.viewTag')->with('arrTag', $arrTag)->with('arrTaged', $arrTaged);
        } else {
            return View::make('backend.product.viewTag')->with('arrTag', $arrTag);
        }
    }

    public function postEditProduct() {
        $rules = array(
            "cateID" => "required",
            "productName" => "required",
            "productDescription" => "required",
            "productPrice" => "required",
            "promotionID" => "required",
            "productSlug" => "required",
            "productTag" => "required",
            "manufactureID" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objproduct = new TblProductModel();
            $objproduct->updateProduct(Input::get('idpro'), Input::get('cateID'), Input::get('productName'), Input::get('productDescription'), Input::get('productPrice'), Input::get('promotionID'), Input::get('productSlug'), Input::get('productTag'), Input::get('manufactureID'), Input::get('status'));
            $idPro = Input::get('idpro');
            $arrTags = Input::get('tag');
            foreach ($arrTags as $item) {
                $tblPMeta = new tblPMetaModel();
                $tblPMeta->deletePMetaByPId($idPro);
            }
            foreach ($arrTags as $item) {
                $tblPMeta = new tblPMetaModel();
                $tblPMeta->insertPMeta($idPro, $item);
            }
            $objCateproduct = new TblCategoryProductModel();
            //lấy danh sách các khuyến mại
            $tblPromotion = new tblPromotionModel();
            $objPromotion = $tblPromotion->getAllPromotion(1000);
            //lấy danh sách danh mục sản phẩm
            $data = $objCateproduct->getAllCategoryProductPaginate(1000);
            //lấy sản phẩm theo id          
            $datap = $objproduct->getProductById(Input::get('idpro'));
            //lấy danh sách tag của sản phẩm
            $tblTag = new tblTagModel();
            $arrTag = $tblTag->getTagByCateID($datap[0]->cateID);
            //lấy danh sách các tag đã được chọn
            $tblPMetaModel = new tblPMetaModel();
            $arrTaged = $tblPMetaModel->getTagByProductID(Input::get('idpro'));
            //lấy danh sách nhà sản xuất
 $tblManu = new tblManufacturerModel();
            $arrManu = $tblManu->selectAll(1000);
            return View::make('backend.product.addproduct')->with('catproduct', $data)->with('dataedit', $datap[0])->with('arrPromotion', $objPromotion)->with('arrTag', $arrTag)->with('arrTaged', $arrTaged)->with('arrManu',$arrManu)->with('thongbao', 'Sản phẩm đã được cập nhật thành công');
        }
    }

    public function getView() {
        if (Session::has('keywordsearch') && Input::get('page') != '') {
            $keyw = Session::get('keywordsearch');
            $objGsp = new TblProductModel();
            $data = $objGsp->FindProduct($keyw[0], 10, 'id', '');
            $link = $data->links();
            return View::make('backend.product.viewproduct')->with('dataproduct', $data)->with('page', $link);
        } else {
            Session::forget('keywordsearch');
            $objGsp = new TblProductModel();
            $data = $objGsp->FindProduct('', 10, 'id', '');
            $link = $data->links();
            return View::make('backend.product.viewproduct')->with('dataproduct', $data)->with('page', $link);
        }
    }

    public function postAjaxsearch() {
        $objGsp = new TblProductModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.product.productajaxsearch')->with('dataproduct', $data)->with('page', $link);
    }

    public function postAjaxpagion() {
        if (Session::has('keywordsearch') && Input::get('page') != '') {
            $keyw = Session::get('keywordsearch');
            $objGsp = new TblProductModel();
            $data = '';
            if (Session::has('oderbyoption1')) {
                $tatus = Session::get('oderbyoption1');
                $data = $objGsp->FindProduct($keyw[0], 10, 'id', $tatus[0]);
            } else {
                $data = $objGsp->FindProduct($keyw[0], 10, 'id', '');
            }
            $link = $data->links();
            return View::make('backend.product.productajaxsearch')->with('dataproduct', $data)->with('page', $link);
        } else {
            Session::forget('keywordsearch');
            $objGsp = new TblProductModel();
            $tatus = Session::get('oderbyoption1');
            $data = $objGsp->FindProduct('', 10, 'id', $tatus[0]);
            $link = $data->links();
            return View::make('backend.product.productajaxsearch')->with('dataproduct', $data)->with('page', $link);
        }
    }

    public function postFillterProduct() {
        Session::forget('keywordsearch');
        $objGsp = new TblProductModel();
        $data = $objGsp->FindProduct('', 10, 'id', Input::get('oderbyoption1'));
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.product.productajaxsearch')->with('dataproduct', $data)->with('page', $link);
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
        return View::make('backend.product.viewproduct')->with('dataproduct', $data)->with('page', $link);
    }

    public function postDel() {
        $objGsp = new TblProductModel();
        $objGsp->DeleteProduct(Input::get('id'));
        $objGsp = new TblProductModel();
        $data = $objGsp->FindProduct('', 10, 'id', '');
        $link = $data->links();
        return View::make('backend.product.productajaxsearch')->with('dataproduct', $data)->with('page', $link);
    }

    public function getLo() {
        echo 'adas';
        
    }

}
