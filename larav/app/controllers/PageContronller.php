<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PageContronller extends Controller {

    public function getCauHoiThuongGap() {
        return View::make('fontend.FAQs');
    }

    public function getBaoMat() {
        return View::make('fontend.BaoMat');
    }

    public function getThoaThuanNguoiDung() {
        return View::make('fontend.ThoaThuanNguoiDung');
    }

}
