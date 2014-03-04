<?php

class UploadModel extends Eloquent {

    public function postUpload($file) {
        $destinationPath = 'uploadimg/' . date("Y") . '/' . date("m") . '/';
        $filename = $file->getClientOriginalName();
        $fileext = $file->getClientOriginalExtension();
        $filesize = $file->getClientSize();
        $filetype = $file->getClientMimeType();
        $fileeror = $file->getError();
        $checkcode = substr(md5(strtotime("now")), 1, 20) . substr(md5(strtotime("now")), 1, 20);
        $allowedExts = array("gif", "jpeg", "jpg", "png", "PNG", "GIF", "JPEG", "JPG");
        $allowedSizes = 2097152;
        $allowedtype = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
        if ($fileeror > 0) {
            return FALSE;
        } else {
            if (in_array($fileext, $allowedExts) && in_array($filetype, $allowedtype) && $filesize <= $allowedSizes) {
                $upload_success = Input::file('fileupload')->move($destinationPath, $checkcode . '.' . $fileext);
                if ($upload_success) {
                    $urlimg = $destinationPath . $checkcode . '.' . $fileext;
                    return $urlimg;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        }
    }

    public function postUploadMulti($files) {
        foreach ($files as $file) {
            $destinationPath = 'uploadimg/' . date("Y") . '/' . date("m") . '/';
            $filename = $file->getClientOriginalName();
            $fileext = $file->getClientOriginalExtension();
            $filesize = $file->getClientSize();
            $filetype = $file->getClientMimeType();
            $fileeror = $file->getError();
            $checkcode = substr(md5(strtotime("now")), 1, 20) . substr(md5(strtotime("now")), 1, 20);
            $allowedExts = array("gif", "jpeg", "jpg", "png", "PNG", "GIF", "JPEG", "JPG");
            $allowedSizes = 2097152;
            $allowedtype = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
            if ($fileeror > 0) {
                return FALSE;
            } else {
                if (in_array($fileext, $allowedExts) && in_array($filetype, $allowedtype) && $filesize <= $allowedSizes) {
                    $upload_success = Input::file('fileupload')->move($destinationPath, $checkcode . '.' . $fileext);
                    if ($upload_success) {
                        echo $destinationPath . $checkcode . '.' . $fileext;
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                } else {
                    return FALSE;
                }
            }
        }
    }

}
