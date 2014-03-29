<?php

class ProductController extends BaseController {

    public function getChuyenMuc($catslug = '') {
        $objsanpham = new TblProductModel();
        $datapro = $objsanpham->getAllProductByCategorySlug($catslug, 10);
        $cateback = $objsanpham->getProductCatSlug1($catslug);
        //     var_dump($cateback);
        $link = $datapro->links();
        return View::make('fontend.product')->with('productdata', $datapro)->with('pargion', $link)->with('slugcate', $cateback[0]);
    }

    public function postAjaxChuyenMuc() {
        $objsanpham = new TblProductModel();
        $datapro = $objsanpham->getAllProductByCategorySlug(Input::get('slug'), 10);
        //    var_dump($datapro);
        $link = $datapro->links();
        return View::make('fontend.productAjax')->with('productdata', $datapro)->with('pargion', $link);
    }

    public function getDangKyWebsite($catslug = '') {
        if (!Session::has('userSession')) {
            Session::forget('urlBack');
            Session::push('urlBack', URL::current());
            return Redirect::to('tai-khoan/dang-nhap');
        } else {
            $objsanpham = new TblProductModel();
            $dataproduct = $objsanpham->getAllProductBySlug($catslug);
            $objdomain = new TblDomainModel();
            $domainlist = $objdomain->getDomainList();
            return View::make('fontend.checkout')->with('dataproductsingle', $dataproduct[0])->with('domainlist', $domainlist);
        }
    }

    public function getChiTiet($catslug = '') {
        $objsanpham = new TblProductModel();
        $dataproduct = $objsanpham->getAllProductBySlug($catslug);
        $relateproduct = $objsanpham->getAllProductByCatID($dataproduct[0]->cateID);
        $cateback = $objsanpham->getProductCatSlug($dataproduct[0]->cateID);
        return View::make('fontend.sigleproduct')->with('backcate', $cateback[0])->with('dataproductsingle', $dataproduct[0])->with('relate', $relateproduct);
    }

    public function postDangKyWebsite() {
        $objProduct = new TblProductModel();
        $dataproduct = $objProduct->getProductById(Input::get('idproduct'));
        $user = Session::get('userSession');
        $domailcheck = Input::get('domaintype');
        $error = FALSE;
        $domain = '';
        if ($domailcheck == 'domain') {
            $domain = Input::get('temmiencheck') . '.' . Input::get('duoitenmien');
            $objdomain = new TblDomainModel();
            if (Input::get('temmiencheck') != '') {
                $domain = Input::get('temmiencheck') . '.' . Input::get('duoitenmien');
                $true = true;
                /**
                 * 1. Kiểm tra tên miền có đúng định dạng không
                 * Tên miền chứ ký tự số và chữ, hoặc ký tự '-'
                 * Không có ký tự '-' nằm ở đầu hoặc cuối, và không có 2 ký tự '-' liên tiếp
                 */
                if (!preg_match('/^([a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?)$/i', Input::get('temmiencheck')) || strpos(Input::get('temmiencheck'), '--') !== false) {
                    $error = 'Tên miền không đúng định dạng cho phép .';
                    $true = false;
                }

                if ($true == true) {
                    /**
                     * 2. Kiểm tra tên miền tại whois.net.vn
                     */
                    $kq = file_get_contents("http://www.whois.net.vn/whois.php?domain=" . $domain);
                    /**
                     * 3. Kết quả bằng 1: đã đăng ký, 0: chưa đăng ký
                     */
                    if ($kq == 1) {
                        $error = 'Tên miền đã đăng ký .';
                    } else {//chua dang ky
                        $data = $objdomain->getDomainByExt(trim(Input::get('duoitenmien')));
                        $objUser = new tblUsersModel();
                        $checkreturn = $objUser->truPCash($user[0]->userEmail, $dataproduct[0]->productPrice + $data[0]->setupCash + $data[0]->maintainCash);
                        if ($checkreturn) {
                            $objOrderProduct = new tblOrderProduct();
                            $check = $objOrderProduct->checkExistSubdomain($domain);
                            if ($check == 0) {
                                $objOrder = new tblOrderModel();
                                $objOrder->addNewOrder($user[0]->id, $dataproduct[0]->id, $domain, 'domain', $dataproduct[0]->productPrice + $data[0]->setupCash + $data[0]->maintainCash);
                                $history = new tblHistoryModel();
                                $history->insertHistory($user[0]->id, "Đăng ký giao diện cho tên miền " . $domain . " . Chi phí là : " . $dataproduct[0]->productPrice + $data[0]->setupCash + $data[0]->maintainCash . " Pcash");
                                $error = false;
                            } else {
                                $error = 'Tên miền đã đăng ký .';
                            }
                        } else {
                            $error = 'Số Pcash trông tài khoản của bạn không đủ để thực hiện thanh tooán này';
                        }
                    }
                }
            } else {
                $error = 'Tên miền không được để trống';
            }
            $objsanpham = new TblProductModel();
            $dataproduct1 = $objsanpham->getAllProductBySlug($dataproduct[0]->productSlug);
            $objdomain = new TblDomainModel();
            $domainlist = $objdomain->getDomainList();
            return View::make('fontend.checkout')->with('dataproductsingle', $dataproduct1[0])->with('domainlist', $domainlist)->with('thongbao', $error);
        }
        if ($domailcheck == 'subdomain') {
            $domain = Input::get('subdomaininput') . '.pubweb.vn';
            $error = FALSE;
            $true = true;
            if (!preg_match('/^([a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?)$/i', Input::get('subdomaininput')) || strpos(Input::get('subdomaininput'), '--') !== false || Input::get('subdomaininput') == '') {
                $error = 'Tên miền không đúng định dạng cho phép .';
                $true = false;
            }
            if ($true == true) {
                $objdomain = new tblOrderProduct();
                $check = $objdomain->checkExistSubdomain(Input::get('subdomaininput') . '.pubweb.vn');
                if ($check > 0) {
                    $error = 'Tên miền đã đăng ký .';
                } else {
                    if ($dataproduct[0]->productPrice == 0) {
                        $objOrder = new tblOrderModel();
                        $objOrder->addNewOrder($user[0]->id, $dataproduct[0]->id, $domain, 'subdomain', $dataproduct[0]->productPrice);
                        $history = new tblHistoryModel();
                        $history->insertHistory($user[0]->id, "Đăng ký giao diện cho tên miền " . $domain . " . Chi phí là : miễn phí Pcash");
                        $error = FALSE;
                    } else {
                        $objUser = new tblUsersModel();
                        $checkreturn = $objUser->truPCash($user[0]->userEmail, $dataproduct[0]->productPrice);
                        if ($checkreturn) {
                            $objOrder = new tblOrderModel();
                            $objOrder->addNewOrder($user[0]->id, $dataproduct[0]->id, $domain, 'subdomain', $dataproduct[0]->productPrice);
                            $history = new tblHistoryModel();
                            $history->insertHistory($user[0]->id, "Đăng ký giao diện cho tên miền " . $domain . " . Chi phí là : " . $dataproduct[0]->productPrice . " Pcash");
                        } else {
                            $error = 'Số Pcash trông tài khoản của bạn không đủ để thực hiện thanh tooán này';
                        }
                    }
                }
            } else {
                $error = 'Tên miền không đúng định dạng cho phép .';
            }
            $objsanpham = new TblProductModel();
            $dataproduct1 = $objsanpham->getAllProductBySlug($dataproduct[0]->productSlug);
            $objdomain = new TblDomainModel();
            $domainlist = $objdomain->getDomainList();
            return View::make('fontend.checkout')->with('dataproductsingle', $dataproduct1[0])->with('domainlist', $domainlist)->with('thongbao', $error);
        }
    }

}
