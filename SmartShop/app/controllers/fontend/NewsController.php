<?php

namespace FontEnd;

use Session,
    Input,
    Cookie,
    Redirect,
    View;

class NewsController extends \BaseController {

    public function getChuyenMuc($catslug = '') {
        $NewModel = new \FontEnd\NewsModel();
        $arrNews = $NewModel->getNewBySlugCate($catslug, 1);
        $link = $arrNews->links();
        return View::make('fontend.CategoryNews')->with('arrnews', $arrNews)->with('catslugs', $catslug);
    }

    public function postChuyenMucAjax() {
        $catslug = trim(Input::get('catslug'));
        $NewModel = new \FontEnd\NewsModel();
        $arrNews = $NewModel->getNewBySlugCate($catslug, 1);
        $link = $arrNews->links();
        return View::make('fontend.CategoryNewsAjax')->with('arrnews', $arrNews)->with('catslugs', $catslug);
    }

    public function getChiTiet($catslug = '') {
        $NewModel = new \FontEnd\NewsModel();
        $news = $NewModel->getNewBySlug($catslug);
        return View::make('fontend.SingleNews')->with('news', $news);
    }

    public function getTags($tags = '') {
        $NewModel = new \FontEnd\NewsModel();
        $arrNews = $NewModel->getNewByTags($tags, 10);
        return View::make('fontend.CategoryNews')->with('arrnews', $arrNews)->with('tagsslug', $tags);
    }

}
