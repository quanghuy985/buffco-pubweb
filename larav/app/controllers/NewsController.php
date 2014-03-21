<?php

class NewsController extends BaseController {
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

//    public function getChuyenMuc($slug) {
//
//        $file = 'filecache/sql_chuyenmuc.sqlcache';
//
//        $expire = 86400; // 24 hours 
//// Nếu có cache file và còn trong thời gian chưa hết $expire
//        if (file_exists($file) &&
//                filemtime($file) > (time() - $expire)) {
//            // Uunserialize data từ cache file
//            $records = unserialize(file_get_contents($file));
//            $count = count($records);
//            $objNews = new TblNewsModel();
//            if ($count != $objNews->countnews()) {
//                $datanews = $objNews->getAllPostByCategoryId($slug, 10);
//                $pargion = $datanews->links();
//                foreach ($datanews as $item) {
//                    $records1[] = $item;
//                }
//                // Serialize data và push vào cache file
//                $OUTPUT = serialize($records1);
//                $fp = fopen($file, "w");
//                fputs($fp, $OUTPUT);
//                fclose($fp);
//                return View::make('fontend.news')->with('datanews', $records)->with('pargion', $records1);
//            } else {
//                return View::make('fontend.news')->with('datanews', $records);
//            }
//        } else { // Cập nhật cache file
//            $objNews = new TblNewsModel();
//            $datanews = $objNews->getAllPostByCategoryId($slug, 10);
//            $pargion = $datanews->links();
//            foreach ($datanews as $item) {
//                $records[] = $item;
//            }
//            // Serialize data và push vào cache file
//            $OUTPUT = serialize($records);
//            $fp = fopen($file, "w");
//            fputs($fp, $OUTPUT);
//            fclose($fp);
//            return View::make('fontend.news')->with('datanews', $records)->with('pargion', $pargion);
//        } // end else 
//    }
    public function getChuyenMuc($slug = '') {
        $objNews = new TblNewsModel();
        $datanews = $objNews->getAllPostByCategoryId($slug, 2);
        $pargion = $datanews->links();
        $objCate = new TblCategoryNewsModel();
        $datacates = $objCate->getAllByCategory();
        $catname = $objCate->getNameCategory($slug);
        return View::make('fontend.news')->with('datanews', $datanews)->with('pargion', $pargion)->with('catelist', $datacates)->with('catname', $catname[0]);
    }

    public function getBaiViet($slug = '') {
        $objNews = new TblNewsModel();
        $datanews = $objNews->getNewsById($slug);
        $objCate = new TblCategoryNewsModel();
        $datacates = $objCate->getAllByCategory();
        if (count($datanews) == 0) {
            return View::make('fontend.404');
        } else {
            return View::make('fontend.singlenews')->with('datanews', $datanews[0])->with('catelist', $datacates);
        }
    }

    public function postPhantrang() {
        $objNews = new TblNewsModel();
        $datanews = $objNews->getAllPostByCategoryId(Input::get('slug'), 2);
        $pargion = $datanews->links();
        return View::make('fontend.newsAjax')->with('datanews', $datanews)->with('pargion', $pargion);
    }

}
