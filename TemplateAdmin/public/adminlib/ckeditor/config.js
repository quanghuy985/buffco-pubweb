/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.filebrowserBrowseUrl = 'adminlib/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = 'adminlib/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = 'adminlib/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = 'adminlib/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = 'adminlib/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = 'adminlib/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
