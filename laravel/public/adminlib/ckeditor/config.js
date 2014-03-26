/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.filebrowserBrowseUrl = 'http://localhost/laravel/public/adminlib/ckfinder/ckfinder.html';
            config.filebrowserImageBrowseUrl = 'http://localhost/laravel/public/adminlib/ckfinder/ckfinder.html?type=Images';
            config.filebrowserFlashBrowseUrl = 'http://localhost/laravel/public/adminlib/ckfinder/ckfinder.html?type=Flash';
            config.filebrowserUploadUrl = 'http://localhost/laravel/public/adminlib/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
            config.filebrowserImageUploadUrl = 'http://localhost/laravel/public/adminlib/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
            config.filebrowserFlashUploadUrl = 'http://localhost/laravel/public/adminlib/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
