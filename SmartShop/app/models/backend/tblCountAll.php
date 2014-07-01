<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblCountAll extends \Eloquent {

    public function CountAll() {
        $allcount = array(
            'CountNews' => $this->CountNews(),
            'CountProduct' => $this->CountProduct(),
            'CountOrder' => $this->CountOrder(),
            'CountCustomer' => $this->CountCustomer(),
            'CountSupporter' => $this->CountSupporter(),
            'CountFeedBack' => $this->CountFeedBack(),
            'CountProject' => $this->CountProject(),
            'CountPage' => $this->CountPage(),
            'CountAdmin' => $this->CountAdmin(),
            'CountMenu' => $this->CountMenu(),
        );
        return $allcount;
    }

    public function CountNews($status = '') {
        $count = \DB::table('tbl_news');
        if ($status == '') {
            $count->where('status', '!=', 2);
        } else {
            $count->where('status', '=', $status);
        }
        $count = $count->count();
        return $count;
    }

    public function CountProduct($status = '') {
        $count = \DB::table('tbl_product');
        if ($status == '') {
            $count->where('status', '!=', 2);
        } else {
            $count->where('status', '=', $status);
        }
        $count = $count->count();
        return $count;
    }

    public function CountOrder($status = '') {
        $count = \DB::table('tbl_product_order');
        if ($status == '') {
            $count->where('status', '!=', 2);
        } else {
            $count->where('status', '=', $status);
        }
        $count = $count->count();
        return $count;
    }

    public function CountCustomer($status = '') {
        $count = \DB::table('tbl_users')->where('admin', 0);
        if ($status == '') {
            $count->where('status', '!=', 2);
        } else {
            $count->where('status', '=', $status);
        }
        $count = $count->count();
        return $count;
    }

    public function CountSupporter($status = '') {
        $count = \DB::table('tbl_supporter');
        if ($status == '') {
            $count->where('status', '!=', 2);
        } else {
            $count->where('status', '=', $status);
        }
        $count = $count->count();
        return $count;
    }

    public function CountFeedBack($status = '') {
        $count = \DB::table('tbl_feed_back');
        if ($status == '') {
            $count->where('status', '!=', 2);
        } else {
            $count->where('status', '=', $status);
        }
        $count = $count->count();
        return $count;
    }

    public function CountProject($status = '') {
        $count = \DB::table('tbl_projects');
        if ($status == '') {
            $count->where('status', '!=', 2);
        } else {
            $count->where('status', '=', $status);
        }
        $count = $count->count();
        return $count;
    }

    public function CountPage($status = '') {
        $count = \DB::table('tbl_pages');
        if ($status == '') {
            $count->where('status', '!=', 2);
        } else {
            $count->where('status', '=', $status);
        }
        $count = $count->count();
        return $count;
    }

    public function CountAdmin($status = '') {
        $count = \DB::table('tbl_users')->where('admin', 1);
        if ($status == '') {
            $count->where('status', '!=', 2);
        } else {
            $count->where('status', '=', $status);
        }
        $count = $count->count();
        return $count;
    }

    public function CountMenu($status = '') {
        $count = \DB::table('menu_group')->count();
        return $count;
    }

}
