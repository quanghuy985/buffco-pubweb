jQuery("#contactForm").validate({
    rules: {
        name: {
            required: true,
            minlength: 3,
        },
        email:{
            required: true,
            email: true,
        },
        subject:{
            required: true,   
        },
        message:{
            required: true,
        }        
    },
    messages: {
        name: {
            required: "Please enter your name.",
            minlength: "Phải nhập 3 kí tự trở lên"
        },
        subject:{
            required: "Please enter the subject.",
        },
          email: {
            required: "Please enter your email address.",           
        },
        message:{
            required:"Please enter your message.",
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
            required: "Please enter your name.",
            minlength: "Phải nhập 3 kí tự trở lên"
        },       
        
    }
})

// kiểm tra form đổi mật khẩu
jQuery("#frmChangePassword").validate({
    rules: {
        oldPassWord: {
            required: true,  
        },    
        newPassWord:{
            required: true,
            minlength: 6,
        },
        reNewPassWord:{
           equalTo: "#newPassWord"
        },         
    },
    messages: {
        oldPassWord: {
            required: "Bạn phải nhập vào mật khẩu",              
        },    
        newPassWord:{
            required: "Bạn phải nhập vào mật khẩu mới",
            minlength: "Mật khẩu mới phải từ 6 ký tự trở lên",
        },
        reNewPassWord:{
            equalTo:"Mật khẩu mới không khớp",
        }
    }
})