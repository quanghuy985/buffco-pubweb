<?php

class ProductController extends Controller {

    public function getView() {
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProduct(10);
        $link = $arrProduct->links();
        return View::make('backend.product.viewproduct')->with('dataproduct', $arrProduct)->with('link', $link);
    }

    public function getAddProduct($thongbao = '') {
        $tblManu = new tblManufacturerModel();
        $arrManu = $tblManu->selectAll();
        $tblCateProduct = new tblCategoryProductModel();
        $arrCatProduct = $tblCateProduct->allCateProduct(1000);
        $tblColor = new tblColorModel();
        $arrColor = $tblColor->selectAll();
        $tblSize = new tblSizeModel();
        $arrSize = $tblSize->getAllSize();
        $tblTag = new tblTagModel();
        $arrmuti = $tblTag->getAll();
        return View::make('backend.product.addproduct')->with('arrmuti', $arrmuti)->with('arrSize', $arrSize)->with('arrColor', $arrColor)->with('arrManu', $arrManu)->with('arrCatProduct', $arrCatProduct)->with('thongbao', $thongbao);
    }

    public function postAddProduct() {
        
        $rules = array(
            "productGroup" => "required",
            "nameProduct" => "required",
            "productCode" => "required",
            "productDescription" => "required",
            "productPrice" => "required",
            "productSlug" => "required",
            "producttags" => "required",
            "manufacture" => "required"
        );
        $productName = Input::get('nameProduct');
        $productCode = Input::get('productCode');
        $cateID = Input::get('productGroup');
        $productDescription = Input::get('productDescription');
        $attributes = Input::get('productAttributes');
        $productPrice = Input::get('productPrice');
        $salesPrice = Input::get('salesPrice');
        $startSales = Input::get('datetosales');
        $endSales = Input::get('datefromsales');
        $productSlug = Input::get('productSlug');
        $productTag = Input::get('producttags');
        $manufactureID = Input::get('manufacture');
        // $status = Input::get('status');
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblProduct = new TblProductModel();
            $idproduct = $tblProduct->themProduct($productCode, $cateID, $productName, $productDescription, $attributes, $productPrice, $salesPrice, strtotime($startSales), strtotime($endSales), $productSlug, $productTag, $manufactureID, 1);
            if ($idproduct != NULL || $idproduct != '') {
                $attList = Input::get('ImagePath');
                if ($attList != '') {
                    $itemlist = explode(',', $attList);
                    foreach ($itemlist as $item) {
                        $tblAttach = new tblAttachmentModel();
                        $tblAttach->addAttachment($idproduct, $item);
                    }
                }
                $mausacsanpham = Input::get('mausacsanpham');
                $sizesanphamr = Input::get('sizesanphamr');
                $soluongsanpham = Input::get('soluongsanpham');
                $i = 0;
                if ($mausacsanpham != '' && $sizesanphamr != '') {
                    foreach ($mausacsanpham as $itemmau) {
                        $storemodel = new tblStoreModel();
                        $size = $sizesanphamr[$i];
                        $soluong = $soluongsanpham[$i];
                        $checkstore = $storemodel->checkStore($idproduct, $size, $itemmau);
                        if (count($checkstore) > 0) {
                            $storemodel = new tblStoreModel();
                            $storemodel->updateSoLuong($checkstore[0]->id, $soluong + $checkstore[0]->soluongnhap);
                        } else {
                            $storemodel = new tblStoreModel();
                            $storemodel->addStore($idproduct, $size, $itemmau, $soluong, 1);
                        }
                    }
                }

                $phanloai = Input::get('loaisanpham');
                if ($phanloai != '') {
                    foreach ($phanloai as $itemmau) {
                        $tblPMeta = new tblPMetaModel();
                        $tblPMeta->insertPMeta($idproduct, $itemmau);
                    }
                }
            }

           return Redirect::action('ProductController@getAddProduct', array('thongbaoloi' => 'Thêm mới thành công.'));
        } else {
            return Redirect::action('ProductController@getAddProduct', array('thongbaoloi' => 'Thêm mới không thành công. Vui lòng thử lại!'));
        }
    }

    public function editProduct($id, $thongbao, $thongbaoloi) {
        $tblProduct = new TblProductModel();
        $dataProduct = $tblProduct->getProductById($id);
        $tblStore = new tblStoreModel();
        $dataStore = $tblStore->getStoreByProductID($id);
        $tblAttach = new tblAttachmentModel();
        $dataimg = $tblAttach->getAttachmentByProductId($id); //  
        $tblManu = new tblManufacturerModel();
        $arrManu = $tblManu->selectAll();
        $tblCateProduct = new tblCategoryProductModel();
        $arrCatProduct = $tblCateProduct->allCateProduct(1000);
        $tblColor = new tblColorModel();
        $arrColor = $tblColor->selectAll();
        $tblSize = new tblSizeModel();
        $arrSize = $tblSize->getAllSize();
        $tblTag = new tblTagModel();
        $arrmuti = $tblTag->getAll();
        $tblPMeta = new tblPMetaModel();
        $arrPmeta = $tblPMeta->getMetaByProductID($id);
        return View::make('backend.product.addproduct')->with('dataedit', $dataProduct[0])->with('arrmuti', $arrmuti)->with('arrSize', $arrSize)->with('arrColor', $arrColor)->with('arrManu', $arrManu)->with('arrCatProduct', $arrCatProduct)->with('dataStore', $dataStore)->with('dataimg', $dataimg)->with('arrPmeta', $arrPmeta)->with('thongbao', $thongbao)->with('thongbaoloi', $thongbaoloi);
    }

    public function getEditProduct($id = '') {
        if ($id != '') {
            return $this->editProduct($id, '', '');
        } else {
            return Redirect::action('ProductController@getView');
        }
    }

    public function postEditProduct() {
        $rules = array(
            "productGroup" => "required",
            "nameProduct" => "required",
            "productCode" => "required",
            "productDescription" => "required",
            "productPrice" => "required",
            "producttags" => "required",
            "manufacture" => "required"
        );
        $pid = Input::get('pid');
        $productName = Input::get('nameProduct');
        $productCode = Input::get('productCode');
        $cateID = Input::get('productGroup');
        $productDescription = Input::get('productDescription');
        $attributes = Input::get('productAttributes');
        $productPrice = Input::get('productPrice');
        $salesPrice = Input::get('salesPrice');
        $startSales = Input::get('datetosales');
        $endSales = Input::get('datefromsales');
        $productTag = Input::get('producttags');
        $manufactureID = Input::get('manufacture');
        $status = Input::get('status');
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblProduct = new TblProductModel();
            $tblProduct->updateProduct($pid, $productCode, $cateID, $productName, $productDescription, $attributes, $productPrice, $salesPrice, strtotime($startSales), strtotime($endSales), '', $productTag, $manufactureID, $status);
            if ($pid != NULL || $pid != '') {
                $attList = Input::get('ImagePath');
                $tblAttach = new tblAttachmentModel();
                $tblAttach->deleteAttachmentByDestinyID($pid);
                if ($attList != '') {
                    $itemlist = explode(',', $attList);
                    foreach ($itemlist as $item) {
                        $tblAttach = new tblAttachmentModel();
                        $tblAttach->addAttachment($pid, $item);
                    }
                }
                $mausacsanpham = Input::get('mausacsanpham');
                $sizesanphamr = Input::get('sizesanphamr');
                $soluongsanpham = Input::get('soluongsanpham');
                $i = 0;
                $storemodel = new tblStoreModel();
                $storemodel->deleteStoreByProID($pid);
                if ($mausacsanpham != '' && $sizesanphamr != '') {
                    foreach ($mausacsanpham as $itemmau) {
                        $storemodel = new tblStoreModel();
                        $size = $sizesanphamr[$i];
                        $soluong = $soluongsanpham[$i];
                        $checkstore = $storemodel->checkStore($pid, $size, $itemmau);
                        if (count($checkstore) > 0) {
                            $storemodel = new tblStoreModel();
                            $storemodel->updateSoLuong($checkstore[0]->id, $soluong + $checkstore[0]->soluongnhap);
                        } else {
                            $storemodel = new tblStoreModel();
                            $storemodel->addStore($pid, $size, $itemmau, $soluong, 1);
                        }
                    }
                }

                $phanloai = Input::get('loaisanpham');
                $tblPMeta = new tblPMetaModel();
                $tblPMeta->deletePMetaByPId($pid);
                if ($phanloai != '') {
                    foreach ($phanloai as $itemmau) {
                        $tblPMeta = new tblPMetaModel();
                        $tblPMeta->insertPMeta($pid, $itemmau);
                    }
                }
            }
            return $this->editProduct($pid, 'Cập nhật thành công', '');
        } else {
            return $this->editProduct($pid, '', 'Cập nhật không thành công');
        }
    }

    public function postCateAjax() {
        $tblCateProduct = new tblCategoryProductModel();
        $arrCatProduct = $tblCateProduct->allCateProduct(1000);
        return View::make('backend.product.categoryAjax')->with('arrCatProduct', $arrCatProduct);
    }

    public function postManuAjax() {
        $objManufactuer = new tblManufacturerModel();
        $arrManu = $objManufactuer->selectAll(1000);
        return View::make('backend.product.manuAjax')->with('arrManu', $arrManu);
    }

    public function postAjaxsearch() {
        $objGsp = new TblProductModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        }
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.product.productajaxsearch')->with('dataproduct', $data)->with('page', $link);
    }

    public function postAjaxpagion() {

        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProduct(1);
        $link = $arrProduct->links();
        return View::make('backend.product.productajaxsearch')->with('dataproduct', $arrProduct)->with('link', $link);
    }

    public function postAjaxpagionFillter() {
        $fromdate = Input::get('timeform');
        $todate = Input::get('timeto');
        $orderby = Input::get('oderbyoption');
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProductFillter(strtotime($fromdate), strtotime($todate), $orderby, 1);
        $link = $arrProduct->links();
        return View::make('backend.product.productajaxsearch')->with('dataproduct', $arrProduct)->with('link', $link);
    }

    public function postAjaxpagionSearch() {
        $keyword = Input::get('keyword');
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProductSearch($keyword, 1);
        $link = $arrProduct->links();
        return View::make('backend.product.productajaxsearch')->with('dataproduct', $arrProduct)->with('link', $link);
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

    public function postCheckSlug() {
        $tblProduct = new TblProductModel();
        $count = 0;
        $slugcheck = Input::get('slug');
        $count = $tblProduct->countSlug($slugcheck);
        return $count;
    }

    public function postCheckProductCode() {
        $tblProduct = new TblProductModel();
        $objProduct = $tblProduct->getProductByCode(Input::get('code'));
        foreach ($objProduct as $item) {
            if ($item->id == Input::get('id')) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }

}
