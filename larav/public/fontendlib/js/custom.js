jQuery("#contactForm").validate({
    rules: {
        name: {
            required: true,
            minlength: 3,
        },
        email: {
            required: true,
            email: true,
        },
        subject: {
            required: true,
        },
        message: {
            required: true,
        }
    },
    messages: {
        name: {
            required: "Bạn chưa nhập họ tên.",
            minlength: "Phải nhập 3 kí tự trở lên"
        },
        subject: {
            required: "Bạn chưa nhập tiêu đề.",
        },
        email: {
            required: "Bạn chưa nhập email.",
        },
        message: {
            required: "Bạn chưa nhập nội dung.",
        },
    }
})

// kiểm tra thông tin form cập nhật thông tin
jQuery("#frmProfile").validate({
    rules: {
        name: {
            required: true,
            minlength: 3,
        },
    },
    messages: {
        name: {
            required: "Bạn chưa nhập tên.",
            minlength: "Phải nhập 3 kí tự trở lên"
        },
    }
})


jQuery('#months').change(function() {
    check();
});

jQuery('#cbadvertising').change(function() {
    check();
});

function check() {
    if (jQuery('#cbadvertising').is(':checked')) {
        // alert('checked');
        jQuery('#tongtien').text((parseInt(jQuery('#giasaucung').text()) * parseInt(jQuery('#months').val()) + parseInt(jQuery('#cbadvertising').val())) + ' Pcash');
    } else {
        jQuery('#tongtien').text((parseInt(jQuery('#giasaucung').text()) * parseInt(jQuery('#months').val())) + ' Pcash');
    }
}
//    jQuery('#domain').change(function() {
//
//        jQuery('#tongtien').text(parseFloat(jQuery('#subject').val()) * parseFloat(jQuery('#totalpriceinput').val()) + 'K VNĐ');
//        // alert(jQuery('#subject').val());
//    });

// kiểm tra form đổi mật khẩu
jQuery("#frmChangePassword").validate({
    rules: {
        oldPassWord: {
            required: true,
        },
        newPassWord: {
            required: true,
            minlength: 6,
        },
        reNewPassWord: {
            equalTo: "#newPassWord"
        },
    },
    messages: {
        oldPassWord: {
            required: "Bạn phải nhập vào mật khẩu",
        },
        newPassWord: {
            required: "Bạn phải nhập vào mật khẩu mới",
            minlength: "Mật khẩu mới phải từ 6 ký tự trở lên",
        },
        reNewPassWord: {
            equalTo: "Mật khẩu mới không khớp",
        }
    }
})