@extends("templateadmin2.mainfire")
@section("contentadmin")
<script type="text/javascript">

    function BrowseServer(startupPath, functionData)
    {
// You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();

// The path for the installation of CKFinder (default = "/ckfinder/").
        finder.basePath = '../';

//Startup path in a form: "Type:/path/to/directory/"
        finder.startupPath = startupPath;

// Name of a function which is called when a file is selected in CKFinder.
        finder.selectActionFunction = SetFileField;

// Additional data to be passed to the selectActionFunction in a second argument.
// We'll use this feature to pass the Id of a field that will be updated.
        finder.selectActionData = functionData;

// Name of a function which is called when a thumbnail is selected in CKFinder.
        finder.selectThumbnailActionFunction = ShowThumbnails;

// Launch CKFinder
        finder.popup();
    }

// This is a sample function which is called when a file is selected in CKFinder.
    function SetFileField(fileUrl, data)
    {
        document.getElementById(data["selectActionData"]).value = fileUrl;
    }

// This is a sample function which is called when a thumbnail is selected in CKFinder.
    function ShowThumbnails(fileUrl, data)
    {
// this = CKFinderAPI
        var sFileName = this.getSelectedFile().name;
        document.getElementById('thumbnails').innerHTML +=
                '<div class="thumb">' +
                '<img src="' + fileUrl + '" />' +
                '<div class="caption">' +
                '<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["fileSize"] + 'KB)' +
                '</div>' +
                '</div>';

        document.getElementById('preview').style.display = "";
// It is not required to return any value.
// When false is returned, CKFinder will not close automatically.
        return false;
    }
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">CẤU HÌNH WEBSITE</h1>
    <span class="pagedesc">Cài đặt cấu hình website</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <form class="stdform" method="post" action="{{URL::action('SettingController@postUpdateSetting')}}">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Tổng quát</a></li>
                    <li><a href="#tabs-2">Cấu hình e-mail</a></li>
                    <li><a href="#tabs-3">Cấu hình thanh toán</a></li>
                    <li><a href="#tabs-4">Cấu hình Slider ảnh</a></li>
                    <li><a href="#tabs-5">Cấu hình chân trang</a></li>
                    <li><a href="#tabs-6">Thông tin liên hệ</a></li>
                    <li><a href="#tabs-7">Mạng xã hội</a></li>
                </ul>
                <div id="tabs-1">
                    <div class="contenttitle2">
                        <h3>Tổng quát</h3>
                    </div>
                    <p>
                        <label>Tiêu đề trang :</label>
                        <span class="field">
                            <input type="text" name="titlewebsite" placeholder="pubweb.vn" class="longinput" value="@if(isset($arrSetting)){{$arrSetting['titlewebsite']}} @endif"/>
                        </span>
                    </p>
                    <p>
                        <label>Tagline :</label>
                        <span class="field">
                            <input type="text" name="tagline" placeholder="Cung cấp website miễn phí" value="@if(isset($arrSetting)){{$arrSetting['tagline']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>Logo website :</label>
                        <span class="field">
                            <input id="logowebsite" name="logowebsite" class="smallinput" onclick="BrowseServer('Images:/', 'logowebsite');" type="text" value="@if(isset($arrSetting)){{$arrSetting['logowebsite']}}@endif" />
                            <input type="button" value="Chọn hình ảnh" class="stdbtn" onclick="BrowseServer('Images:/', 'logowebsite');" />
                        </span>
                    </p>
                    <p>
                        <label>Mô tả trang :</label>
                        <span class="field">
                            <textarea cols="80" rows="5" name="description"  placeholder="Chúng tôi cung cấp website miễn phí . Cam kết giá rẻ nhất và nhanh nhất ." class="longinput">@if(isset($arrSetting)){{$arrSetting['description']}}@endif</textarea>
                        </span>
                    </p>
                    <p>
                        <label>Từ khóa :</label>
                        <span class="field">
                            <textarea cols="80" rows="5" name="keywordsearch" placeholder="website mien phi,pubweb.vn." class="longinput">@if(isset($arrSetting)){{$arrSetting['keywordsearch']}}@endif</textarea>
                        </span>
                    </p>
                    <p>
                        <label>Google Analytics Code :</label>
                        <span class="field">
                            <input type="text" name="googleanc" placeholder="Google Analytics Code" value="@if(isset($arrSetting['googleanc'])){{$arrSetting['googleanc']}}@endif" class="longinput"/>
                        </span>
                    </p>
                </div>
                <div id="tabs-2">
                    <div class="contenttitle2">
                        <h3>Cấu hình gửi e-mail</h3>
                    </div>
                    <p>
                        <label>SMTP host :</label>
                        <span class="field">
                            <input type="text" name="smtphost" placeholder="smtp.gmail.com"  value="@if(isset($arrSetting)){{$arrSetting['smtphost']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>SMTP port :</label>
                        <span class="field">
                            <input type="text" name="smtpport" placeholder="587" value="@if(isset($arrSetting)){{$arrSetting['smtpport']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>From mail :</label>
                        <span class="field">
                            <input type="text" name="frommail" placeholder="Contact@Pubweb.vn" value="@if(isset($arrSetting)){{$arrSetting['frommail']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>From name :</label>
                        <span class="field">
                            <input type="text" name="fromname" placeholder="PUBWEB.VN" value="@if(isset($arrSetting)){{$arrSetting['fromname']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>Tài khoản :</label>
                        <span class="field">
                            <input type="text" name="usernamemail" placeholder="Contact@Pubweb.vn" value="@if(isset($arrSetting)){{$arrSetting['usernamemail']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>mật khẩu :</label>
                        <span class="field">
                            <input type="text" name="passwordmail" placeholder="Mật khẩu"  value="@if(isset($arrSetting)){{$arrSetting['passwordmail']}}@endif" class="longinput"/>
                        </span>
                    </p>
                </div>
                <div id="tabs-3">
                    <div class="contenttitle2">
                        <h3>Cấu hình thanh toán</h3>
                    </div>
                    <p>
                        <label>Bảo Kim :</label>
                        <span class="field">
                            <input type="text" name="baokimuser" placeholder="Tài khoản bảo kim" value="@if(isset($arrSetting)){{$arrSetting['baokimuser']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>Ngân Lượng :</label>
                        <span class="field">
                            <input type="text" name="nganluonguser" placeholder="Tài khoản ngân lượng" value="@if(isset($arrSetting)){{$arrSetting['nganluonguser']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>Đơn vị tiền tệ :</label>
                        <span class="field">
                            <input type="text" name="tiente" placeholder="VNĐ , USD ..." value="@if(isset($arrSetting)){{$arrSetting['tiente']}}@endif" class="longinput"/>
                        </span>
                    </p>
                </div>
                <div id="tabs-4">
                    Your content goes here for tab 1
                </div>
                <div id="tabs-5">
                    <div class="contenttitle2">
                        <h3>Cấu hình chân trang</h3>
                    </div>
                    <p>
                        <label>Chân trang (footer) :</label>
                        <span class="field">
                            <textarea cols="80" rows="5" id="footer" class="ckeditor" name="footer" placeholder="Nội dung bài viết">@if(isset($arrSetting['footer'])){{$arrSetting['footer']}}@endif</textarea>
                        </span>
                    </p>
                </div>
                <div id="tabs-6">
                    <div class="contenttitle2">
                        <h3>Thông tin liên hệ</h3>
                    </div>
                    <p>
                        <label>Tên công ty hoặc của hàng :</label>
                        <span class="field">
                            <input type="text" name="tencongty" placeholder="Nhập tên công ty hoặc của hàng" value="@if(isset($arrSetting['tencongty'])){{$arrSetting['tencongty']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>Địa chỉ :</label>
                        <span class="field">
                            <input type="text" name="diachicongty" placeholder="Nhập địa chỉ" value="@if(isset($arrSetting['diachicongty'])){{$arrSetting['diachicongty']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>Sô điện thoại cố định :</label>
                        <span class="field">
                            <input type="text" name="sodienthoaicongty" placeholder="Nhập số điện thoại" value="@if(isset($arrSetting['sodienthoaicongty'])){{$arrSetting['sodienthoaicongty']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>Sô điện thoại đi động :</label>
                        <span class="field">
                            <input type="text" name="sodienthoaiddcongty" placeholder="Nhập số điện thoại" value="@if(isset($arrSetting['sodienthoaiddcongty'])){{$arrSetting['sodienthoaiddcongty']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>E-mail :</label>
                        <span class="field">
                            <input type="text" name="emailcongty" placeholder="Nhập e-mail" value="@if(isset($arrSetting['emailcongty'])){{$arrSetting['emailcongty']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>Website :</label>
                        <span class="field">
                            <input type="text" name="webcongty" placeholder="Nhập website" value="@if(isset($arrSetting['webcongty'])){{$arrSetting['webcongty']}}@endif" class="longinput"/>
                        </span>
                    </p>
                    <p>
                        <label>Url bản đồ google maps :</label>
                        <span class="field">
                            <input type="text" name="googlemaps" placeholder="Nhập url bản đồ" value="@if(isset($arrSetting['googlemaps'])){{$arrSetting['googlemaps']}}@endif" class="longinput"/>
                        </span>
                    </p>
                </div>
                <div id="tabs-7">
                    <div class="contenttitle2">
                        <h3>Mạng xã hội</h3>
                    </div>
                    <p>
                        <label>Bình luận facebook:</label>
                        <span class="formwrapper">
                            <input type="radio" name="commentfb" @if(isset($arrSetting['commentfb']) && $arrSetting['commentfb']==0)checked="checked" @endif value="0" />Tắt &nbsp; &nbsp;
                                   <input type="radio" name="commentfb" @if(isset($arrSetting['commentfb']) && $arrSetting['commentfb']==1)checked="checked" @endif  value="1" /> Bật &nbsp; &nbsp;
                        </span>
                    </p>
                    <p>
                        <label>Facebook Fanpage:</label>
                        <span class="field">
                            <input type="text" name="facebookfanpage" placeholder="Nhập website" value="@if(isset($arrSetting['facebookfanpage'])){{$arrSetting['facebookfanpage']}}@endif" class="longinput"/>
                        </span>
                    </p>
                </div>
            </div>
            <div class="f_left">
                <p class="f_left">
                    <input type="submit" class="submit radius2" value="Lưu cấu hình">
                    <input type="reset" class="reset radius2" value="Reset Button">
                </p>
            </div>
        </form>
    </div>
</div>

@endsection