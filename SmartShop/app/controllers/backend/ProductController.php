<?php

namespace BackEnd;

use BackEnd,
    View,
    Lang,
    Redirect,
    Session,
    Input,
    Validator;

class ProductController extends \BaseController {

    public function getProductAdd() {
        $tblCateProduct = new tblCategoryProductModel();
        $catlist = $tblCateProduct->allCateProductParent();
        $catlistrt = array('' => 'Không');
        foreach ($catlist as $value) {
            $catlistrt = $catlistrt + array($value->id => $value->cateName);
        }
        $allcatelist = $tblCateProduct->allCateProductList();
        $tblManu = new tblManufacturerModel();
        $listmanu = $tblManu->selectAll();
        $listmanuarray = array();
        foreach ($listmanu as $item) {
            $listmanuarray = $listmanuarray + array($item->id => $item->manufacturerName);
        }
        return View::make('backend.product.addproduct')->with('listcate', $catlistrt)->with('listallcate', $allcatelist)->with('arraymanu', $listmanuarray);
    }

    public function postProductAdd() {
        $rules = array(
            "productName" => "required",
            "productCode" => "required|unique:tbl_product",
            "productDescription" => "required"
        );
        $slug = new SlugGen();
        $tblCateProduct = new tblCategoryProductModel();
        $inputs = Input::all();
        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.products'));
        if (!$validate->fails()) {
            $tblProduct = new TblProductModel();
            $idp = $tblProduct->insertProduct($inputs['productCode'], $inputs['productName'], $inputs['productDescription'], $inputs['productAttributes'], str_replace(',', '', $inputs['productPrice']), str_replace(',', '', $inputs['salesPrice']), strtotime($inputs['startSales']), strtotime($inputs['endSales']), $inputs['quantity'], $slug->makeSlugs($inputs['productName']), $inputs['productTag'], $inputs['manufactureID'], 1, $inputs['check2'], $inputs['images']);
            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::back();
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput($inputs)->withErrors($validate->messages());
        }
    }

    public function getProductEdit($id = '') {
        $tblCateProduct = new tblCategoryProductModel();
        $catlist = $tblCateProduct->allCateProductParent();
        $catlistrt = array('' => 'Không');
        foreach ($catlist as $value) {
            $catlistrt = $catlistrt + array($value->id => $value->cateName);
        }
        $allcatelist = $tblCateProduct->allCateProductList();
        $tblManu = new tblManufacturerModel();
        $listmanu = $tblManu->selectAll();
        $listmanuarray = array();
        foreach ($listmanu as $item) {
            $listmanuarray = $listmanuarray + array($item->id => $item->manufacturerName);
        }
        $tblProduct = new TblProductModel();
        $product = $tblProduct->getProductById($id);
        $catlist = $tblProduct->getCatProductById($id);
        return View::make('backend.product.addproduct')->with('productedit', $product)->with('listcate', $catlistrt)->with('listallcate', $allcatelist)->with('arraymanu', $listmanuarray)->with('catlistselect', $catlist);
    }

    public function postProductEdit() {
        $rules = array(
            "productName" => "required",
            "productCode" => "required|unique:tbl_product",
            "productDescription" => "required"
        );
        $slug = new SlugGen();
        $tblCateProduct = new tblCategoryProductModel();
        $inputs = Input::all();
        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.products'));
        if (!$validate->fails()) {

            $tblProduct = new TblProductModel();
            $idp = $tblProduct->updateProduct($inputs['id'], $inputs['productCode'], $inputs['productName'], $inputs['productDescription'], $inputs['productAttributes'], str_replace(',', '', $inputs['productPrice']), str_replace(',', '', $inputs['salesPrice']), strtotime($inputs['startSales']), strtotime($inputs['endSales']), $inputs['quantity'], $slug->makeSlugs($inputs['productName'] . '-' . $inputs['id']), $inputs['productTag'], $inputs['manufactureID'], 1, $inputs['check2'], $inputs['images']);
            Session::flash('alert_success', Lang::get('messages.update.success'));
            return Redirect::back();
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput($inputs)->withErrors($validate->messages());
        }
    }

    public function getProductView($cat_id = '') {
        $tblCateProduct = new tblCategoryProductModel();
        $allcatelist = $tblCateProduct->allCateProductList();
        $tblProduct = new TblProductModel();
        if ($cat_id != '') {
            $arrProduct = $tblProduct->getAllProductNewByCatId($cat_id, 5, 1);
        } else {
            $arrProduct = $tblProduct->getAllProductNew('id', 'desc', 5, 1);
        }
        if (\Request::ajax()) {
            return View::make('backend.product.productajax')->with('allcatelist', $allcatelist)->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        } else {
            return View::make('backend.product.viewproduct')->with('allcatelist', $allcatelist)->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        }
    }

    public function getFillterProduct($cat_id = '') {
        $tblCateProduct = new tblCategoryProductModel();
        $allcatelist = $tblCateProduct->allCateProductList();
        $tblProduct = new TblProductModel();
        if ($cat_id != '') {
            $arrProduct = $tblProduct->getAllProductNewByCatId($cat_id, 5, 1);
        } else {
            $arrProduct = $tblProduct->getAllProductNew('id', 'desc', 5, 1);
        }
        if (\Request::ajax()) {
            return View::make('backend.product.productajax')->with('allcatelist', $allcatelist)->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        } else {
            return View::make('backend.product.viewproduct')->with('allcatelist', $allcatelist)->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        }
    }

    public function postDeleteProduct() {
        $id = \Input::get('id');
        $tblProduct = new TblProductModel();
        $check = $tblProduct->deleteProduct($id);
        $arrProduct = $tblProduct->getAllProductNew('id', 'desc', 5, 1);
        return View::make('backend.product.productajax')->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
    }

    public function postFillterProduct() {
        if (\Request::ajax()) {
            $tblProduct = new TblProductModel();
            $cat = \Input::get('value1');
            $status = \Input::get('value2');
            if ($cat == '' && $status == '') {
                $arrProduct = $tblProduct->getAllProductNew('id', 'desc', 5, 1);
            }
            if ($cat != '' && $status == '') {
                $arrProduct = $tblProduct->getAllProductNewByCatId($cat, 5, 1);
            }
            if ($cat == '' && $status != '') {
                $arrProduct = $tblProduct->getAllProductNew('id', 'desc', 5, $status);
            }
            if ($cat != '' && $status != '') {
                $arrProduct = $tblProduct->getAllProductNewByCatId($cat, 5, $status);
            }
            return View::make('backend.product.productajax')->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        }
    }

//
//    public function getView() {
//        $tblProduct = new TblProductModel();
//        $arrProduct = $tblProduct->getAllProduct('', '', '', '', 10);
//        $link = $arrProduct->links();
//        return View::make('backend.product.viewproduct')->with('dataproduct', $arrProduct)->with('link', $link);
//    }
//
//    public function getAddProduct($thongbao = '') {
//        $tblManu = new tblManufacturerModel();
//        $arrManu = $tblManu->selectAll();
//        $tblCateProduct = new tblCategoryProductModel();
//        $arrCatProduct = $tblCateProduct->allCateProduct(1000);
//        $tblColor = new tblColorModel();
//        $arrColor = $tblColor->selectAll();
//        $tblSize = new tblSizeModel();
//        $arrSize = $tblSize->getAllSize();
//        $tblTag = new tblTagModel();
//        $arrmuti = $tblTag->getAll();
//        return View::make('backend.product.addproduct')->with('arrmuti', $arrmuti)->with('arrSize', $arrSize)->with('arrColor', $arrColor)->with('arrManu', $arrManu)->with('arrCatProduct', $arrCatProduct)->with('thongbao', $thongbao);
//    }
//
//    public function postAddProduct() {
//        $rules = array(
//            "productGroup" => "required",
//            "nameProduct" => "required",
//            "productCode" => "required",
//            "productDescription" => "required",
//            "productPrice" => "required",
//            "productSlug" => "required",
//            "producttags" => "required",
//            "manufacture" => "required"
//        );
//        $productName = Input::get('nameProduct');
//        $productCode = Input::get('productCode');
//        $cateID = Input::get('productGroup');
//        $productDescription = Input::get('productDescription');
//        $attributes = Input::get('productAttributes');
//        $productPrice = Input::get('productPrice');
//        $salesPrice = Input::get('salesPrice');
//        $startSales = Input::get('datetosales');
//        $endSales = Input::get('datefromsales');
//        $productSlug = Input::get('productSlug');
//        $productTag = Input::get('producttags');
//        $manufactureID = Input::get('manufacture');
//        // $status = Input::get('status');
//        $tblProduct = new TblProductModel();
//        $count = $tblProduct->countSlug($productSlug);
//        if ($count > 0) {
//            return Redirect::action('ProductController@getAddProduct', array('thongbaoloi' => 'Đường dẫn ngắn gọn đã tồn tại. Vui lòng thử lại!'));
//        }
//        if (!Validator::make(Input::all(), $rules)->fails()) {
//            $tblProduct = new TblProductModel();
//            $idproduct = $tblProduct->themProduct($productCode, $cateID, $productName, $productDescription, $attributes, $productPrice, $salesPrice, strtotime($startSales), strtotime($endSales), $productSlug, $productTag, $manufactureID, 1);
//            if ($idproduct != NULL || $idproduct != '') {
//                $attList = Input::get('ImagePath');
//                if ($attList != '') {
//                    $itemlist = explode(',', $attList);
//                    foreach ($itemlist as $item) {
//                        $tblAttach = new tblAttachmentModel();
//                        $tblAttach->addAttachment($idproduct, $item);
//                    }
//                }
//                $mausacsanpham = Input::get('mausacsanpham');
//                $sizesanphamr = Input::get('sizesanphamr');
//                $soluongsanpham = Input::get('soluongsanpham');
//                $i = 0;
//                if ($mausacsanpham != '' && $sizesanphamr != '') {
//                    foreach ($mausacsanpham as $itemmau) {
//                        $storemodel = new tblStoreModel();
//                        $size = $sizesanphamr[$i];
//                        $soluong = $soluongsanpham[$i];
//                        $checkstore = $storemodel->checkStore($idproduct, $size, $itemmau);
//                        if (count($checkstore) > 0) {
//                            $storemodel = new tblStoreModel();
//                            $storemodel->updateSoLuong($checkstore[0]->id, $soluong + $checkstore[0]->soluongnhap);
//                        } else {
//                            $storemodel = new tblStoreModel();
//                            $storemodel->addStore($idproduct, $size, $itemmau, $soluong, 1);
//                        }
//                        $i++;
//                    }
//                }
//
//                $phanloai = Input::get('loaisanpham');
//                if ($phanloai != '') {
//                    foreach ($phanloai as $itemmau) {
//                        $tblPMeta = new tblPMetaModel();
//                        $tblPMeta->insertPMeta($idproduct, $itemmau);
//                    }
//                }
//            }
//
//            return $this->editProduct($idproduct, 'Thêm mới thành công', '');
//        } else {
//            return Redirect::action('ProductController@getAddProduct', array('thongbaoloi' => 'Thêm mới không thành công. Vui lòng thử lại!'));
//        }
//    }
//
//    public function editProduct($id, $thongbao, $thongbaoloi) {
//        $tblProduct = new TblProductModel();
//        $dataProduct = $tblProduct->getProductById($id);
//        $tblStore = new tblStoreModel();
//        $dataStore = $tblStore->getStoreByProductID($id);
//        $tblAttach = new tblAttachmentModel();
//        $dataimg = $tblAttach->getAttachmentByProductId($id); //  
//        $tblManu = new tblManufacturerModel();
//        $arrManu = $tblManu->selectAll();
//        $tblCateProduct = new tblCategoryProductModel();
//        $arrCatProduct = $tblCateProduct->allCateProduct(1000);
//        $tblColor = new tblColorModel();
//        $arrColor = $tblColor->selectAll();
//        $tblSize = new tblSizeModel();
//        $arrSize = $tblSize->getAllSize();
//        $tblTag = new tblTagModel();
//        $arrmuti = $tblTag->getAll();
//        $tblPMeta = new tblPMetaModel();
//        $arrPmeta = $tblPMeta->getMetaByProductID($id);
//        return View::make('backend.product.addproduct')->with('dataedit', $dataProduct[0])->with('arrmuti', $arrmuti)->with('arrSize', $arrSize)->with('arrColor', $arrColor)->with('arrManu', $arrManu)->with('arrCatProduct', $arrCatProduct)->with('dataStore', $dataStore)->with('dataimg', $dataimg)->with('arrPmeta', $arrPmeta)->with('thongbao', $thongbao)->with('thongbaoloi', $thongbaoloi);
//    }
//
//    public function getEditProduct($id = '') {
//        if ($id != '') {
//            return $this->editProduct($id, '', '');
//        } else {
//            return Redirect::action('ProductController@getView');
//        }
//    }
//
//    public function postEditProduct() {
//        $rules = array(
//            "productGroup" => "required",
//            "nameProduct" => "required",
//            "productCode" => "required",
//            "productDescription" => "required",
//            "productPrice" => "required",
//            "producttags" => "required",
//            "manufacture" => "required"
//        );
//        $pid = Input::get('pid');
//        $productName = Input::get('nameProduct');
//        $productCode = Input::get('productCode');
//        $cateID = Input::get('productGroup');
//        $productDescription = Input::get('productDescription');
//        $attributes = Input::get('productAttributes');
//        $productPrice = Input::get('productPrice');
//        $salesPrice = Input::get('salesPrice');
//        $startSales = Input::get('datetosales');
//        $endSales = Input::get('datefromsales');
//        $productTag = Input::get('producttags');
//        $manufactureID = Input::get('manufacture');
//        $status = Input::get('status');
//
//        if (!Validator::make(Input::all(), $rules)->fails()) {
//            $tblProduct = new TblProductModel();
//            $tblProduct->updateProduct($pid, $productCode, $cateID, $productName, $productDescription, $attributes, $productPrice, $salesPrice, strtotime($startSales), strtotime($endSales), '', $productTag, $manufactureID, $status);
//            if ($pid != NULL || $pid != '') {
//                $attList = Input::get('ImagePath');
//                $tblAttach = new tblAttachmentModel();
//                $tblAttach->deleteAttachmentByDestinyID($pid);
//                if ($attList != '') {
//                    $itemlist = explode(',', $attList);
//                    foreach ($itemlist as $item) {
//                        $tblAttach = new tblAttachmentModel();
//                        $tblAttach->addAttachment($pid, $item);
//                    }
//                }
//                $mausacsanpham = Input::get('mausacsanpham');
//                $sizesanphamr = Input::get('sizesanphamr');
//                $soluongsanpham = Input::get('soluongsanpham');
//                $i = 0;
//                $storemodel = new tblStoreModel();
//                $storemodel->deleteStoreByProID($pid);
//                if ($mausacsanpham != '' && $sizesanphamr != '') {
//                    foreach ($mausacsanpham as $itemmau) {
//                        $storemodel = new tblStoreModel();
//                        $size = $sizesanphamr[$i];
//                        $soluong = $soluongsanpham[$i];
//                        $checkstore = $storemodel->checkStore($pid, $size, $itemmau);
//                        if (count($checkstore) > 0) {
//                            $storemodel = new tblStoreModel();
//                            $storemodel->updateSoLuong($checkstore[0]->id, $soluong + $checkstore[0]->soluongnhap);
//                        } else {
//                            $storemodel = new tblStoreModel();
//                            $storemodel->addStore($pid, $size, $itemmau, $soluong, 1);
//                        }
//                        $i++;
//                    }
//                }
//
//                $phanloai = Input::get('loaisanpham');
//                $tblPMeta = new tblPMetaModel();
//                $tblPMeta->deletePMetaByPId($pid);
//                if ($phanloai != '') {
//                    foreach ($phanloai as $itemmau) {
//                        $tblPMeta = new tblPMetaModel();
//                        $tblPMeta->insertPMeta($pid, $itemmau);
//                    }
//                }
//            }
//            return $this->editProduct($pid, 'Cập nhật thành công', '');
//        } else {
//            return $this->editProduct($pid, '', 'Cập nhật không thành công');
//        }
//    }
//
//    public function postCateAjax() {
//        $tblCateProduct = new tblCategoryProductModel();
//        $arrCatProduct = $tblCateProduct->allCateProduct(1000);
//        return View::make('backend.product.categoryAjax')->with('arrCatProduct', $arrCatProduct);
//    }
//
//    public function postManuAjax() {
//        $objManufactuer = new tblManufacturerModel();
//        $arrManu = $objManufactuer->selectAll(1000);
//        return View::make('backend.product.manuAjax')->with('arrManu', $arrManu);
//    }
//
//    public function postAjaxpagion() {
//        $from = Input::get('from');
//        $to = Input::get('to');
//        $status = Input::get('status');
//        $keyword = Input::get('keyword');
//        $tblProduct = new TblProductModel();
//        $arrProduct = $tblProduct->getAllProduct($from, $to, $status, $keyword, 10);
//        $link = $arrProduct->links();
//        return View::make('backend.product.productajax')->with('dataproduct', $arrProduct)->with('link', $link);
//    }
//
//    public function postFillterProduct() {
//        $from = Input::get('from');
//        $to = Input::get('to');
//        $status = Input::get('status');
//        $keyword = Input::get('keyword');
//        $objGsp = new TblProductModel();
//        $data = $objGsp->getAllProduct($from, $to, $status, $keyword, 10);
//        $link = $data->links();
//        return View::make('backend.product.productajax')->with('dataproduct', $data)->with('link', $link);
//    }
//
//    public function postDelmulte() {
//        $pieces1 = explode(",", Input::get('multiid'));
//        foreach ($pieces1 as $item) {
//            if ($item != '') {
//                $objGsp = new TblProductModel();
//                $objGsp->DeleteProduct($item);
//            }
//        }
//        $objGsp = new TblProductModel();
//        $data = $objGsp->FindProduct('', 10, 'id', '');
//        $link = $data->links();
//        return View::make('backend.product.viewproduct')->with('dataproduct', $data)->with('page', $link);
//    }
//
//    public function postDel() {
//        $objGsp = new TblProductModel();
//        $objGsp->DeleteProduct(Input::get('id'));
//        return 'true';
//    }
//
//    public function postActive() {
//        $objGsp = new TblProductModel();
//        $objGsp->updateProduct(Input::get('id'), '', '', '', '', '', '', '', '', '', '', '', '', 1);
//        return 'true';
//    }
//
//    public function postCheckSlug() {
//        $tblProduct = new TblProductModel();
//        $count = 0;
//        $slugcheck = Input::get('slug');
//        $count = $tblProduct->countSlug($slugcheck);
//        return $count;
//    }
//
//    public function postCheckProductCode() {
//        $tblProduct = new TblProductModel();
//        $objProduct = $tblProduct->getProductByCode(Input::get('code'));
//        foreach ($objProduct as $item) {
//            if ($item->id == Input::get('id')) {
//                return 'true';
//            } else {
//                return 'false';
//            }
//        }
//    }
}
