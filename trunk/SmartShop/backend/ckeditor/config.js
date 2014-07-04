/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config) {
    // Define changes to default configuration here. For example:
    config.language = 'vi';
    config.skin = 'office2013';
    // config.uiColor = '#AADC6E';
    config.toolbar = 'MyToolbar';
    config.enterMode = CKEDITOR.ENTER_BR;
    config.toolbar = [
        {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
        {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker'], items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
        {name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
        {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
        {name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']},
        '/',
        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
        {name: 'colors', items: ['TextColor', 'BGColor']},
        {name: 'tools', items: ['Maximize', 'ShowBlocks']},
        {name: 'others', items: ['-']}
    ];

// Toolbar groups configuration.
    config.toolbarGroups = [
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
        {name: 'forms'},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
        {name: 'links'},
        {name: 'insert'},
        '/',
        {name: 'styles'},
        {name: 'colors'},
        {name: 'tools'},
        {name: 'others'}
    ];

    // Se the most common block elements.
    config.format_tags = 'p;h1;h2;h3;pre';
    var configurl = LocalSetting();
    // Make dialogs simpler.
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.filebrowserBrowseUrl = configurl + 'backend/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = configurl + 'backend/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = configurl + 'backend/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = configurl + 'backend/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = configurl + 'backend/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = configurl + 'backend/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
