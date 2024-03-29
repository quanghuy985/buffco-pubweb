jQuery(function($) {

    /* highlight current menu group
     ------------------------------------------------------------------------- */
    $('#menu-group li[id="group-' + current_group_id + '"]').addClass('current');

    /* global ajax setup
     ------------------------------------------------------------------------- */
    $.ajaxSetup({
        type: 'GET',
        datatype: 'json',
        timeout: 20000
    });
    $('#loading').ajaxStart(function() {
        $(this).show();
    });
    $('#loading').ajaxStop(function() {
        $(this).hide();
    });

    /* modal box
     ------------------------------------------------------------------------- */
    gbox = {
        defaults: {
            autohide: false,
            buttons: {
                'Close': function() {
                    gbox.hide();
                }
            }
        },
        init: function() {
            var winHeight = $(window).height();
            var winWidth = $(window).width();
            var box =
                    '<div id="gbox">' +
                    '<div id="gbox_content"></div>' +
                    '</div>' +
                    '<div id="gbox_bg"></div>';

            $('body').append(box);

            $('#gbox').css({
                top: '15%',
                left: winWidth / 2 - $('#gbox').width() / 2
            });

            $('#gbox_close, #gbox_bg').click(gbox.hide);
        },
        show: function(options) {
            var options = $.extend({}, this.defaults, options);
            switch (options.type) {
                case 'ajax':
                    $.ajax({
                        type: 'GET',
                        datatype: 'html',
                        url: options.url,
                        success: function(data) {
                            options.content = data;
                            gbox._show(options);
                        }
                    });
                    break;
                default:
                    this._show(options);
                    break;
            }
        },
        _show: function(options) {
            $('#gbox_footer').remove();
            if (options.buttons) {
                $('#gbox').append('<div id="gbox_footer"></div>');
                $.each(options.buttons, function(k, v) {
                    $('<button></button>').text(k).click(v).appendTo('#gbox_footer');
                });
            }

            $('#gbox, #gbox_bg').fadeIn();
            $('#gbox_content').html(options.content);
            $('#gbox_content input:first').focus();
            if (options.autohide) {
                setTimeout(function() {
                    gbox.hide();
                }, options.autohide);
            }
        },
        hide: function() {
            $('#gbox').fadeOut(function() {
                $('#gbox_content').html('');
                $('#gbox_footer').remove();
            });
            $('#gbox_bg').fadeOut();
        }
    };
    gbox.init();

    /* same as site_url() in php
     ------------------------------------------------------------------------- */
    function site_url(url) {
        return _BASE_URL + 'index.php?act=' + url;
    }

    /* nested sortables
     ------------------------------------------------------------------------- */
    var menu_serialized;
    var fixSortable = function() {
        if (!$.browser.msie)
            return;
        //this is fix for ie
        $('#easymm').NestedSortableDestroy();
        $('#easymm').NestedSortable({
            accept: 'sortable',
            helperclass: 'ns-helper',
            opacity: .8,
            handle: '.ns-title',
            onStop: function() {
                fixSortable();
            },
            onChange: function(serialized) {
                menu_serialized = serialized[0].hash;
                $('#btn-save-menu').attr('disabled', false);
            }
        });
    };
    $('#easymm').NestedSortable({
        accept: 'sortable',
        helperclass: 'ns-helper',
        opacity: .8,
        handle: '.ns-title',
        onStop: function() {
            fixSortable();
        },
        onChange: function(serialized) {
            menu_serialized = serialized[0].hash;
            $('#btn-save-menu').attr('disabled', false);
        }
    });

    /* edit menu
     ------------------------------------------------------------------------- */
    $('.edit-menu').live('click', function() {
        var menu_id = $(this).next().next().val();
        var menu_div = $(this).parent().parent();
        gbox.show({
            type: 'ajax',
            url: urledit + '?id=' + menu_id,
            buttons: {
                'Lưu': function() {
                    $.ajax({
                        type: 'POST',
                        url: $('#gbox form').attr('action'),
                        data: $('#gbox form').serialize(),
                        success: function(data) {
                            data = $.parseJSON(data);
                            switch (data.status) {
                                case 1:
                                    gbox.hide();
                                    menu_div.find('.ns-title').html(data.menu.title);
                                    menu_div.find('.ns-url').html(data.menu.url);
                                    menu_div.find('.ns-class').html(data.menu.klass);
                                    break;
                                case 2:
                                    gbox.hide();
                                    break;
                            }
                        }
                    });
                },
                'Hủy bỏ': gbox.hide
            }
        });
        return false;
    });

    /* delete menu
     ------------------------------------------------------------------------- */
    $('.delete-menu').live('click', function() {
        var li = $(this).closest('li');
        var param = {id: $(this).next().val()};
        var menu_title = $(this).parent().parent().children('.ns-title').text();
        gbox.show({
            content: '<h2>Xóa trình đơn</h2>Bạn có chắc chắn muốn xóa trình đơn ?<br><b>'
                    + menu_title +
                    '</b><br><br>Chú ý : Tất cả những trình đơn con sẽ bị xóa.',
            buttons: {
                'Đồng ý': function() {
                    $.post(urldelete, param, function(data) {
                        data = $.parseJSON(data);
                        if (data.success) {
                            gbox.hide();
                            li.remove();
                        } else {
                            gbox.show({
                                content: 'Xóa lỗi.'
                            });
                        }
                    });
                },
                'Hủy bỏ': gbox.hide
            }
        });
        return false;
    });

    /* add menu
     ------------------------------------------------------------------------- */
    $('#form-add-menu').submit(function() {
        if ($('#menu-title').val() == '') {
            $('#menu-title').focus();
        } else {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                error: function() {
                    gbox.show({
                        content: 'Add menu error. Please try again.',
                        autohide: 1000
                    });
                },
                success: function(data) {
                    data = $.parseJSON(data);
                    switch (data.status) {
                        case 1:
                            $('#form-add-menu')[0].reset();
                            $('#easymm')
                                    .append(data.li)
                                    .SortableAddItem($('#' + data.li_id)[0]);
                            break;
                        case 2:
                            gbox.show({
                                content: data.msg,
                                autohide: 1000
                            });
                            break;
                        case 3:
                            $('#menu-title').val('').focus();
                            break;
                    }
                }
            });
        }
        return false;
    });

    $('#gbox form').live('submit', function() {
        return false;
    });

    /* add menu group
     ------------------------------------------------------------------------- */
    $('#add-group a').click(function() {
        gbox.show({
            type: 'ajax',
            url: $(this).attr('href'),
            buttons: {
                'Lưu': function() {
                    var group_title = $('#menu-group-title').val();
                    if (group_title == '') {
                        $('#menu-group-title').focus();
                    } else {
                        //$('#gbox_ok').attr('disabled', true);
                        $.ajax({
                            type: 'POST',
                            url: urladdgroup,
                            data: 'title=' + group_title,
                            error: function() {
                                //$('#gbox_ok').attr('disabled', false);
                            },
                            success: function(data) {
                                //$('#gbox_ok').attr('disabled', false);
                                data = $.parseJSON(data);
                                switch (data.status) {
                                    case 1:
                                        gbox.hide();
                                        $('#menu-group').append('<li><a href="' + site_url('menu&group_id=' + data.id) + '">' + group_title + '</a></li>');
                                        break;
                                    case 2:
                                        $('<span class="error"></span>')
                                                .text(data.msg)
                                                .prependTo('#gbox_footer')
                                                .delay(1000)
                                                .fadeOut(500, function() {
                                                    $(this).remove();
                                                });
                                        break;
                                    case 3:
                                        $('#menu-group-title').val('').focus();
                                        break;
                                }
                            }
                        });
                    }
                },
                'Hủy bỏ': gbox.hide
            }
        });
        return false;
    });

    /* update menu / save menu position
     ------------------------------------------------------------------------- */
    $('#btn-save-menu').attr('disabled', true);
    $('#form-menu').submit(function() {
        $('#btn-save-menu').attr('disabled', true);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: menu_serialized,
            error: function() {
                $('#btn-save-menu').attr('disabled', false);
                gbox.show({
                    content: '<h2>Lỗi</h2>Cập nhật lỗi.',
                    autohide: 1000
                });
            },
            success: function(data) {
                gbox.show({
                    content: '<h2>Thành công</h2>Trình đơn đã được cập nhật',
                    autohide: 1000
                });
            }
        });
        return false;
    });

    /* edit group
     ------------------------------------------------------------------------- */
    $('#edit-group').click(function() {
        var sgroup = $('#edit-group-input');
        var group_title = sgroup.text();
        sgroup.html('<input value="' + group_title + '">');
        var inputgroup = sgroup.find('input');
        inputgroup.focus().select().keydown(function(e) {
            if (e.which == 13) {
                var title = $(this).val();
                if (title == '') {
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    url: urleditgroup,
                    data: 'id=' + current_group_id + '&title=' + title,
                    success: function(data) {
                        data = $.parseJSON(data);
                        if (data.success) {
                            sgroup.html(title);
                            $('#group-' + current_group_id + ' a').text(title);
                        }
                    }
                });
            }
            if (e.which == 27) {
                sgroup.html(group_title);
            }
        });
        return false;
    });

    /* delete menu group
     ------------------------------------------------------------------------- */
    $('#delete-group').click(function() {
        var group_title = $('#menu-group li.current a').text();
        var param = {id: current_group_id};
        gbox.show({
            content: '<h2>Xóa nhóm trình đơn</h2>Bạn có chắc chắn muốn xóa nhóm trình đơn ?<br><b>'
                    + group_title +
                    '</b><br><br>Chú ý : Tất cả những trình đơn trong nhóm sẽ bị xóa .',
            buttons: {
                'Đồng ý': function() {
                    $.post(urldelgroup, param, function(data) {
                        data = $.parseJSON(data);
                        if (data.success) {
                            window.location = menuurrl;
                        } else {
                            gbox.show({
                                content: 'Xóa lỗi.'
                            });
                        }
                    });
                },
                'Hủy bỏ': gbox.hide
            }
        });
        return false;
    });
    $('#urlselectoption').change(function() {
        $('#menu-url').val($('#urlselectoption').val());
    });
});