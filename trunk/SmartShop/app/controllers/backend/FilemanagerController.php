<?php

namespace BackEnd;

class FilemanagerController extends \BaseController {

    function getFileManager() {
        return \View::make('backend.files.filemanager')->with('active_menu', 'filemanager');
    }

    //get view
}
