<?php

class DomainController extends BaseController {

    public function postDomainCheck() {
        $objdomain = new TblDomainModel();

        if (Input::get('tenmien') != '') {
            $domain = trim(Input::get('tenmien')) . '.' . trim(Input::get('duoi'));
            $true = true;
            if (!preg_match('/^([a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?)$/i', Input::get('tenmien')) || strpos(Input::get('tenmien'), '--') !== false) {
                echo '';
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
                    echo '';
                } else {//chua dang ky
                        $data = $objdomain->getDomainByExt(trim(Input::get('duoi')));
                        $trave = json_encode($data[0]);
                        echo $trave;
                }
            }
        } else {
            echo '';
        }
    }

    public function postSubDomainCheck() {
        $true = true;
        if (!preg_match('/^([a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?)$/i', Input::get('subdomain')) || strpos(Input::get('subdomain'), '--') !== false || Input::get('subdomain') == '') {
            echo '1';
            $true = false;
        }
        if ($true == true) {
            $objdomain = new tblOrderProduct();
            $check = $objdomain->checkExistSubdomain(Input::get('subdomain') . '.pubweb.vn');
            echo ($check);
        } else {
            echo '1';
        }
    }

}
