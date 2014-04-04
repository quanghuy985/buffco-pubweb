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
            <div class="contenttitle2">
                <h3>Tổng quát</h3>
            </div>
            <p>
                <label>Tiêu đề trang :</label>
                <span class="field">
                    <input type="text" name="titlewebsite" placeholder="pubweb.vn" class="longinput" value="{{$arrSetting['titlewebsite']}}"/>
                </span>
            </p>
            <p>
                <label>Tagline :</label>
                <span class="field">
                    <input type="text" name="tagline" placeholder="Cung cấp website miễn phí" value="{{$arrSetting['tagline']}}" class="longinput"/>
                </span>
            </p>
            <p>
                <label>Logo website :</label>
                <span class="field">
                    <input id="logowebsite" name="logowebsite" class="smallinput" type="text" value="{{$arrSetting['logowebsite']}}" />
                    <input type="button" value="Chọn hình ảnh" class="stdbtn" onclick="BrowseServer('Images:/', 'logowebsite');" />
                </span>
            </p>
            <p>
                <label>Mô tả trang :</label>
                <span class="field">
                    <textarea cols="80" rows="5" name="description"  placeholder="Chúng tôi cung cấp website miễn phí . Cam kết giá rẻ nhất và nhanh nhất ." class="longinput">{{$arrSetting['description']}}</textarea>
                </span>
            </p>
            <p>
                <label>Từ khóa :</label>
                <span class="field">
                    <textarea cols="80" rows="5" name="keywordsearch" placeholder="Chúng tôi cung cấp website miễn phí . Cam kết giá rẻ nhất và nhanh nhất ." class="longinput">{{$arrSetting['keywordsearch']}}</textarea>
                </span>
            </p>
            <div class="contenttitle2">
                <h3>Cấu hình gửi e-mail</h3>
            </div>
            <p>
                <label>SMTP host :</label>
                <span class="field">
                    <input type="text" name="smtphost" placeholder="smtp.gmail.com"  value="{{$arrSetting['smtphost']}}" class="longinput"/>
                </span>
            </p>
            <p>
                <label>SMTP port :</label>
                <span class="field">
                    <input type="text" name="smtpport" placeholder="587" value="{{$arrSetting['smtpport']}}" class="longinput"/>
                </span>
            </p>
            <p>
                <label>From mail :</label>
                <span class="field">
                    <input type="text" name="frommail" placeholder="Contact@Pubweb.vn" value="{{$arrSetting['frommail']}}" class="longinput"/>
                </span>
            </p>
            <p>
                <label>From name :</label>
                <span class="field">
                    <input type="text" name="fromname" placeholder="PUBWEB.VN" value="{{$arrSetting['fromname']}}" class="longinput"/>
                </span>
            </p>
            <p>
                <label>Tài khoản :</label>
                <span class="field">
                    <input type="text" name="usernamemail" placeholder="Contact@Pubweb.vn" value="{{$arrSetting['usernamemail']}}" class="longinput"/>
                </span>
            </p>
            <p>
                <label>mật khẩu :</label>
                <span class="field">
                    <input type="text" name="passwordmail" placeholder="Mật khẩu"  value="{{$arrSetting['passwordmail']}}" class="longinput"/>
                </span>
            </p>
            <div class="contenttitle2">
                <h3>Cấu hình thanh toán</h3>
            </div>
            <p>
                <label>Bảo Kim :</label>
                <span class="field">
                    <input type="text" name="baokimuser" placeholder="Tài khoản bảo kim" value="{{$arrSetting['baokimuser']}}" class="longinput"/>
                </span>
            </p>
            <p>
                <label>Ngân Lượng :</label>
                <span class="field">
                    <input type="text" name="nganluonguser" placeholder="Tài khoản ngân lượng" value="{{$arrSetting['nganluonguser']}}" class="longinput"/>
                </span>
            </p>
            <p>
                <label>Đơn vị tiền tệ :</label>
                <span class="field">
                    <input type="text" name="tiente" placeholder="VNĐ , USD ..." value="{{$arrSetting['tiente']}}" class="longinput"/>
                </span>
            </p>
            <p class="stdformbutton">
                <input type="submit" class="submit radius2" value="Lưu cấu hình">
                <input type="reset" class="reset radius2" value="Reset Button">
            </p>
        </form>
    </div>
</div>

@endsection