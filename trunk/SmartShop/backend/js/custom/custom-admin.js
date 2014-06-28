jQuery.noConflict();
function isset()
{
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: FremyCompany
    // +   improved by: Onno Marsman
    // +   improved by: Rafał Kukawski
    // *     example 1: isset( undefined, true);
    // *     returns 1: false
    // *     example 2: isset( 'Kevin van Zonneveld' );
    // *     returns 2: true

    var a = arguments,
            l = a.length,
            i = 0,
            undef;

    if (l === 0)
    {
        throw new Error('Empty isset');
    }

    while (i !== l)
    {
        if (a[i] === undef || a[i] === null)
        {
            return false;
        }
        i++;
    }
    return true;
}

jQuery(document).ready(function() {
    jQuery('.pagination li a').live('click', function(event) {
        var elem = jQuery(this);
        var cat_product = jQuery("#cat_product_id").val();
        var status = jQuery("#status_fillter").val();
        var pathname = window.location.protocol + "//" + window.location.hostname + window.location.pathname;

        var url = jQuery(this).attr('href');
        event.preventDefault();
        event.stopPropagation();
        url = pathname + '?' + url.split(/\?(.+)?/)[1];
        NProgress.start();
        jQuery.ajax({
            url: url,
            dataType: 'html',
            success: function(data) {
                window.history.pushState({
                    path: url
                }, '', url);
                jQuery('.tabledataajax').html(data);
                NProgress.done();
            }
        });

    });
});
function kickhoat(url, id, curentpage) {
    var the = jQuery(this);
    jConfirm('Bạn có chắc chắn muốn kích hoạt nhân viên này ?', 'Thông báo', function(r) {
        if (r == true) {
            NProgress.start();
            var request = jQuery.ajax({
                url: url,
                type: "POST",
                data: {id: id, page: curentpage},
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery('.tabledataajax').html(msg);
                NProgress.done();
            });
            return false;
        } else
        {
            return false;
        }
    });
}
function deleteproduct(url, id, curentpage) {
    var the = jQuery(this);
    jConfirm('Bạn có chắc chắn muốn xóa ?', 'Thông báo', function(r) {
        if (r == true) {
            NProgress.start();
            var request = jQuery.ajax({
                url: url,
                type: "POST",
                data: {id: id, page: curentpage},
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery('.tabledataajax').html(msg);
                NProgress.done();
            });
            return false;
        } else
        {
            return false;
        }
    });
}
function active_element(url, id) {
    var the = jQuery(this);
    jConfirm('Bạn có chắc chắn  ?', 'Thông báo', function(r) {
        if (r == true) {
            NProgress.start();
            var request = jQuery.ajax({
                url: url,
                type: "POST",
                data: {id: id},
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery('.tabledataajax').html(msg);
                NProgress.done();
            });
            return false;
        } else
        {
            return false;
        }
    });
}
//function ajaxfillter_all(url, value1, value2) {
//    var data;
//    if (value1 != '' && value2 == '') {
//        data = {value1: value1};
//    }
//    if (value1 == '' && value2 != '') {
//        data = {value2: value2};
//    }
//    if (value1 != '' && value2 != '') {
//        data = {value1: value1, value2: value2};
//    }
//    if (value1 == '' && value2 == '') {
//        data = '';
//    }
//    NProgress.start();
//    var request = jQuery.ajax({
//        url: url,
//        type: "POST",
//        data: data,
//        dataType: "html"
//    });
//    request.done(function(msg) {
//        window.history.pushState({
//            path: url
//        }, '', url);
//        jQuery('.tabledataajax').html(msg);
//        NProgress.done();
//    });
//}