<?php

namespace BackEnd;

class FilemanagerController extends \BaseController {

    function getFileManager() {
        return \View::make('backend.files.filemanager');
    }

    //get view
}
