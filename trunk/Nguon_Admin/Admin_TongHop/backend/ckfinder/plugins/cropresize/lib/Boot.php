<?php

require __DIR__ . '/../../../../../bootstrap/autoload.php';
require_once __DIR__ . '/../../../../../bootstrap/start.php';

class Image {

    /**
     * Image location including filename.
     * Example: /uploads/images/my_folder/my_image.jpg
     * @var
     */
    private $imageUrl;

    /**
     * Filename of image including file type.
     * Example: my_image.jpg
     * @var
     */
    private $fileName;

    /**
     * CKFinder folder name image is located in including slashes.
     * Example: /my_folder/
     * @var
     */
    private $folderName;

    /**
     * Store image dimensions for initial setup of window.
     * @var
     */
    private $imageDimensions = array();

    /**
     * Set base directory
     * @var
     */
    private $baseDir;

    /**
     * Initial value for $_POST error
     * @var
     */
    private $postError = true;

    public function __construct() {

        $this->baseDir = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

        //Set up file location url
        if (isset($_GET['fileUrl']) && !empty($_GET['fileUrl'])) {
            $this->imageUrl = filter_var($_GET['fileUrl'], FILTER_SANITIZE_STRING);
        } else if (isset($_POST['fileUrl']) && !empty($_POST['fileUrl'])) {
            $this->imageUrl = filter_var($_POST['fileUrl'], FILTER_SANITIZE_STRING);
        }

        if (file_exists($this->baseDir . $this->imageUrl)) {
            $this->imageDimensions = getimagesize($this->baseDir . $this->imageUrl);
        }

        //Set up filename
        if (isset($_GET['fileName']) && !empty($_GET['fileName'])) {
            $this->fileName = filter_var($_GET['fileName'], FILTER_SANITIZE_STRING);
        } else if (isset($_POST['fileName']) && !empty($_POST['fileName'])) {
            $this->fileName = filter_var($_POST['fileName'], FILTER_SANITIZE_STRING);
        }

        //Set up folder name
        if (isset($_GET['folderName']) && !empty($_GET['folderName'])) {
            $this->folderName = str_replace('/', '', filter_var($_GET['folderName'], FILTER_SANITIZE_STRING));
        } else if (isset($_POST['folderName']) && !empty($_POST['folderName'])) {
            $this->folderName = str_replace('/', '', filter_var($_POST['folderName'], FILTER_SANITIZE_STRING));
        }
    }

    public function getBaseDir() {
        return $this->baseDir;
    }

    public function isPosted() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($this->imageUrl) && !empty($this->fileName)) {
            $this->postError = false;
            return true;
        }
        return false;
    }

    public function resize() {

        if ($this->postError) {
            return false;
        }

        $targ_w = $_POST['w'];
        $targ_h = $_POST['h'];
        $jpeg_quality = (int) $_POST['imageQuality'];
        $ext_files = pathinfo($this->imageUrl, PATHINFO_EXTENSION);
        $imageUrl1 = Config::get('app.urlbasesitefolder') . str_replace(Config::get('app.url'), '', $this->imageUrl);
        if ($ext_files == "jpg" || $ext_files == "jpeg" || $ext_files == "JPG" || $ext_files == "JPEG") {
            $img_r = imagecreatefromjpeg($this->baseDir . $imageUrl1);
        } else if ($ext_files == "png" || $ext_files == "PNG") {
            $img_r = imagecreatefrompng($this->baseDir . $imageUrl1);
        } else {
            $img_r = imagecreatefromgif($this->baseDir . $imageUrl1);
        }
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);

        $saveDir = dirname($this->baseDir . $imageUrl1);
        $saveFile = $this->createFilename($this->fileName);
        $filename = $saveDir . '/' . $saveFile;

        imagejpeg($dst_r, $filename, $jpeg_quality);
        return $saveFile;
    }

    private function createFilename($fileName) {
        $ext = substr($fileName, strrpos($fileName, "."));
        return basename($fileName, $ext) . '_' . (int) $_POST['w'] . 'x' . (int) $_POST['h'] . $ext;
    }

    public function getWidth() {
        return $this->imageDimensions[0];
    }

    public function getHeight() {
        return $this->imageDimensions[1];
    }

    public function getUrl() {
        return $this->imageUrl;
    }

    public function getName() {
        return $this->fileName;
    }

    public function getFolderName() {
        return $this->folderName;
    }

}
