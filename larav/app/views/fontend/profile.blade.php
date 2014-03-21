@extends("fontend.hometemplate")
@section("contenthomepage")
<style type="text/css">
    div.tabs ul.nav-tabs li.active a{        
        background: #FFF !important;
        border-top: 3px solid #2baab1 !important;
        color: #2baab1 !important;    
    }
    div.tabs ul.nav-tabs a, div.tabs ul.nav-tabs a{

        color: #2baab1 !important;
    }
    ul.simple-post-list div.post-image{

        width: 100px !important;
    }
    input, button, select, textarea{
        width: 300px !important;

    }
</style>
<script>
    function changePass() {        
       var $form = $('#frmChangePassword');
       if(!$form.valid())
           return false;
       jQuery('.ajaxloader').css('display', 'block');
        var request = jQuery.ajax({
            url: "{{URL::action('AccountController@postChangePassWord')}}",
            type: "POST",
            data: {oldPass: $('#oldPassWord').val(), newPass: $('#newPassWord').val()},
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('.ajaxloader').css('display', 'none');
            if (msg == '0') {
                jQuery('#changePassSuccess').removeClass('alert-success').addClass('alert-danger').css('display', 'block').html("Mật khẩu cũ không đúng!");
            }
            else if (msg == '1') {
                jQuery('#changePassSuccess').removeClass('alert-danger').addClass('alert-success').css('display', 'block').html("Thay đổi mật khẩu thành công!");
            }
            else {
                jQuery('#changePassSuccess').removeClass('alert-success').addClass('alert-danger').css('display', 'block').html("Thay đổi mật khẩu không thành công!");
            }
        });
        
    }
    function divHistoryClick() {
        jQuery('#divtableOrder').empty();
        jQuery('.ajaxloader').css('display', 'block');
        var request = jQuery.ajax({
            url: "{{URL::action('AccountController@postAjaxHistory')}}",
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#history').html(msg);
        });
    }
    function divOrderClick() {
        jQuery('#divtableHistory').empty();
        jQuery('.ajaxloader').css('display', 'block');
        var request = jQuery.ajax({
            url: "{{URL::action('AccountController@postAjaxOrder')}}",
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#order').html(msg);
        });
    }
    function updateInfo(){
          var $form = $('#frmProfile');
       if(!$form.valid())
           return false;
         jQuery('.ajaxloader').css('display', 'block');
    }
</script>
<hr class="tall">
<div class="container">

    <div class="row">   
        <div class="col-md-12">
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#profile" data-toggle="tab"><i class="icon icon-star"></i> Thông tin cá nhân</a></li>
                    <li><a href="#ChargePass" data-toggle="tab">Đổi mật khẩu</a></li>
                    <li><a href="#history" data-toggle="tab"  onclick="setTimeout(divHistoryClick(), 5000)">Lịch sử hoạt động</a></li>
                    <li><a href="#order" data-toggle="tab" onclick="setTimeout(divOrderClick(), 5000)">Đơn hàng đã đăng ký</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                        @if($check == '1' )
                        <div class="alert alert-success" id="contactSuccess">
                            Cập nhật thành công!
                        </div>
                        @endif
                        @if($check == '2' )
                        <div class="alert alert-danger " id="contactError">
                            Cập nhật không thành công
                        </div>
                        @endif
                        <form id="frmProfile" method="post" action="{{URL::action('AccountController@postProfile')}}" >
                              <div class="ajaxloader"  style="display: none;background-position-x: 19% !important;background-position-y: 218px !important;">

                        </div>
                            <ul class="simple-post-list">    
                                <li>
                                    <input type="hidden" id="hId" name="hId" value="{{$datauser->id}}">
                                    <div class="post-image">                                  
                                        <p>Email: </p>                               
                                    </div>
                                    <div class="post-info">
                                        <input type="hidden" id="hEmail" name="hEmail" value="{{$datauser->userEmail}}">
                                        <label  id="lblEmail"> {{$datauser->userEmail}}</label>                            
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">                                  
                                        <p>Họ và đệm: </p>                                   
                                    </div>
                                    <div class="post-info">
                                        <input type="text" value="{{$datauser->userFirstName}}"  name="firstName" id="firstName">                               
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">                                  
                                        <p>Tên: </p>                                   
                                    </div>
                                    <div class="post-info">
                                        <input type="text" value="{{$datauser->userLastName}}"  name="lastName" id="lastName">                               
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">                                  
                                        <p>Điện thoại: </p>                                   
                                    </div>
                                    <div class="post-info">
                                        <input type="text" value="{{$datauser->userPhone}}"  name="phone" id="phone">                               
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">                                  
                                        <p>Địa chỉ: </p>                               
                                    </div>
                                    <div class="post-info">
                                        <textarea maxlength="5000" rows="10"  name="address" id="address" style="height: 90px;">{{$datauser->userAddress}}</textarea>                              
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">                                  
                                        <p>Chứng minh nhân dân: </p>                               
                                    </div>
                                    <div class="post-info">
                                        <input type="text" value="{{$datauser->userIdentify}}" name="identify" id="identify">                               
                                    </div>
                                </li>             
                                <li>
                                    <div class="post-image">                                  
                                        <input style=" width: 103px !important;" type="submit" onclick="updateInfo();" value="Cập nhật" class="btn btn-primary btn-lg" data-loading-text="Loading...">
                                    </div>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="tab-pane" id="ChargePass">
                        <div class="alert " id="changePassSuccess" style="display: none;">
                            Đổi mật khẩu thành công!
                        </div>
                        <form action="{{URL::action('AccountController@postChangePassWord')}}" id="frmChangePassword" method="post">
                          <div class="ajaxloader"  style="display: none;background-position-x: 19% !important;background-position-y: 102px !important;">

                        </div>
                            <ul class="simple-post-list">
                                <li>
                                    <div class="post-image">                                   
                                        <p>Mật khẩu cũ: </p>

                                    </div>
                                    <div class="post-info">
                                        <input type="password" value="" name="oldPassWord" id="oldPassWord" placeholder="Nhập mật khẩu cũ" class="form-control">
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">                                 
                                        <p>Mật khẩu mới: </p>                                  
                                    </div>
                                    <div class="post-info">
                                        <input type="password" value="" name="newPassWord" id="newPassWord" placeholder="Nhập mật khẩu mới" class="form-control">
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">                                 
                                        <p>Nhập lại mật khẩu mới</p>                                  
                                    </div>
                                    <div class="post-info">
                                        <input type="password" value="" name="reNewPassWord" id="newPassWord" placeholder="Nhập lại mật khẩu mới" class="form-control">
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">                                  
                                        <input style=" width: 103px !important;" type="button" onclick="changePass();" value="Cập nhật" class="btn btn-primary btn-lg" data-loading-text="Loading...">
                                    </div>
                                </li>
                            </ul>                            
                        </form>                       
                    </div>
                    <div class="tab-pane" id="history">
                        <div class="ajaxloader"  style="display: block;">
                        </div>
                    </div>
                    <div class="tab-pane" id="order">
                        <div class="ajaxloader"  style="display: block;">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <hr class="tall" />


</div>
@endsection