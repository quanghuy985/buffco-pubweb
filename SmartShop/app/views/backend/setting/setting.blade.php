@extends("backend.template")
@section("titleAdmin")
{{Lang::get('backend/setting.title')}}
@endsection
@section("contentadmin")
<script type="text/javascript">

    function BrowseServer(startupPath, functionData) {
// You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
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
    function SetFileField(fileUrl, data) {
        document.getElementById(data["selectActionData"]).value = fileUrl;
    }

    // This is a sample function which is called when a thumbnail is selected in CKFinder.
    function ShowThumbnails(fileUrl, data) {
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
    <h1 class="pagetitle uppercase">{{Lang::get('backend/setting.title')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/setting.title_description')}}</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        {{Form::model($arrSetting, array('action'=>'\BackEnd\SettingController@postUpdateSetting', 'class'=>'stdform'))}}
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">{{Lang::get('backend/setting.general')}}</a></li>
                <li><a href="#tabs-2">{{Lang::get('backend/setting.setting_email')}}</a></li>
                <li><a href="#tabs-3">{{Lang::get('backend/setting.setting_payment')}}</a></li>
                <li><a href="#tabs-4">{{Lang::get('backend/setting.setting_slider')}}</a></li>
                <li><a href="#tabs-5">{{Lang::get('backend/setting.setting_footer')}}</a></li>
                <li><a href="#tabs-6">{{Lang::get('backend/setting.setting_contact')}}</a></li>
                <li><a href="#tabs-7">{{Lang::get('backend/setting.setting_social_networking')}}</a></li>
            </ul>
            <div id="tabs-1">
                <div class="contenttitle2">
                    <h3>{{Lang::get('backend/setting.general')}}</h3>
                </div>
                <p>
                    <label>{{Lang::get('backend/setting.website.title')}} :</label>
                    <span class="field">
                        {{Form::text('titlewebsite', null, array('placeholder'=>Lang::get('placeholder.title_website'), 'class'=>"longinput"))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.website.tag')}}  :</label>
                    <span class="field">
                        {{Form::text('tagline', null, array('class'=>"longinput"))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.website.logo')}} :</label>
                    <span class="field">
                        {{Form::text('logowebsite', null, array('class'=>"smallinput" ,'id'=>'logowebsite', 'onclick'=>"BrowseServer('Images:/', 'logowebsite');",'placeholder'=>Lang::get('placeholder.logo_website')))}}
                        <input type="button" value="{{Lang::get('button.choose_image')}}" class="stdbtn" onclick="BrowseServer('Images:/', 'logowebsite');"/>
                    </span>
                </p>
                <p>
                    <label>{{Lang::get('backend/setting.website.description')}} :</label>
                    <span class="field">
                        {{Form::textarea('description', null, array('cols'=>80, 'rows'=>5, 'class'=>'longinput', 'placeholder'=>Lang::get('placeholder.setting_description')))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.website.keyword')}}  :</label>
                    <span class="field">
                        {{Form::textarea('keywordsearch', null, array('cols'=>80, 'rows'=>5, 'class'=>'longinput',  'placeholder'=>Lang::get('placeholder.keyword_search')))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.website.analytics_code')}}  :</label>
                    <span class="field">
                        {{Form::text('googleanc', null, array('class'=>"longinput",  'placeholder'=>Lang::get('placeholder.analytics')))}}
                    </span>
                </p>
                <p>
                    <label>{{Lang::get('backend/setting.website.menus')}}  :</label>
                    <span class="field">
                        <?php
                        $arrmu = array();
                        foreach ($arrgmenu as $item) {
                            $arrmu = $arrmu + array($item->id => $item->title);
                        }
                        ?>
                        {{Form::select('menuheader', $arrmu)}}
                    </span>
                </p>
            </div>
            <div id="tabs-2">
                <div class="contenttitle2">
                    <h3>{{Lang::get('backend/setting.setting_email')}}</h3>
                </div>
                <p>
                    <label>{{Lang::get('backend/setting.email.smtp_host')}} :</label>
                    <span class="field">
                        {{Form::text('smtphost', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.smtp_host')))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.email.smtp_port')}} :</label>
                    <span class="field">
                        {{Form::text('smtpport', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.smtp_port')))}}
                    </span>
                </p>
                <p>
                    <label>{{Lang::get('backend/setting.email.from_mail')}} :</label>
                    <span class="field">
                        {{Form::text('frommail', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.email_from_name')))}}
                    </span>
                </p>
                <p>
                    <label>{{Lang::get('backend/setting.email.from_name')}} :</label>
                    <span class="field">
                        {{Form::text('fromname', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.email_from_mail')))}}
                    </span>
                </p>
                <p>
                    <label>{{Lang::get('backend/setting.email.user')}} :</label>
                    <span class="field">
                        {{Form::text('usernamemail', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.email_user')))}}
                    </span>
                </p>
                <p>
                    <label>{{Lang::get('backend/setting.email.password')}} :</label>
                    <span class="field">
                        {{Form::text('passwordmail', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.email_password')))}}
                    </span>
                </p>
            </div>
            <div id="tabs-3">
                <div class="contenttitle2">
                    <h3>{{Lang::get('backend/setting.setting_payment')}}</h3>
                </div>
                <p>
                    <label>{{Lang::get('backend/setting.payment.baokim')}}:</label>
                    <span class="field">
                        {{Form::text('baokimuser', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.baokim')))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.payment.nganluong')}} :</label>
                    <span class="field">
                        {{Form::text('nganluonguser', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.nganluong')))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.payment.currency')}} :</label>
                    <span class="field">
                        {{Form::text('tiente', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.currency')))}}
                    </span>
                </p>
            </div>
            <div id="tabs-4">
                <div class="contenttitle2">
                    <h3>{{Lang::get('backend/setting.setting_slider')}}</h3>
                </div>
                <p> <label>{{Lang::get('backend/setting.slider.selectimg')}} :</label>
                    <script type="text/javascript">


                        function BrowseServer1()
                        {
                            var finder = new CKFinder();
                            finder.selectActionFunction = SetFileField1;
                            //   finder.selectActionData = functionData;
                            finder.popup();

                        }
                        var i = 0;
                        function SetFileField1(fileUrl)
                        {
                            var sFileName = this.getSelectedFile().name + i;
                            var urlImg = '<span id="image-' + sFileName + '"><img src="' + fileUrl + '" width="95%"/><a href="javascript:void(0); " onclick="xoaanhthum1(\'image-' + sFileName + '\');" class="delete" title="Delete image">x</a></span>';
                            document.getElementById('thumbnails').innerHTML += urlImg;
                            i++;
                            returnurlimg1();
                        }
                        function xoaanhthum1(id) {
                            document.getElementById(id).remove();
                            returnurlimg1()
                        }
                        function returnurlimg1() {
                            var images = jQuery("#thumbnails").find("img").map(function() {
                                return this.src;
                            }).get();
                            jQuery("#slideimg").val(images);
                        }
                    </script>
                    </script>
                    <span class="field">        
                        {{Form::hidden('slideimg',null,array('id'=>"slideimg"))}}
                        <span id="thumbnails">
                            <?php
                            if (isset($arrSetting['slideimg']) && strlen($arrSetting['slideimg']) > 1) {
                                $tag = explode(',', $arrSetting['slideimg']);
                                foreach ($tag as $item) {

                                    echo '<span id="image-' . $item . '"><img src="' . $item . '" width="95%"/><a href="javascript:void(0); " onclick="xoaanhthum1(\'image-' . $item . '\');" class="delete" title="Delete image">x</a></span>';
                                }
                            }
                            ?>

                        </span>
                        <input type="button" value="Chọn ảnh" class="stdbtn btn_orange" onclick="BrowseServer1();" />
                    </span>
                </p>
            </div>
            <div id="tabs-5">
                <div class="contenttitle2">
                    <h3>{{Lang::get('backend/setting.setting_footer')}}</h3>
                </div>
                <p>
                    <label>{{Lang::get('backend/setting.footer')}} :</label>
                    <span class="field">
                        {{Form::textarea('footer', null, array('cols'=>80, 'rows'=>5, 'class'=>'ckeditor', 'id'=>'footer'))}}
                    </span>
                </p>
            </div>
            <div id="tabs-6">
                <div class="contenttitle2">
                    <h3>{{Lang::get('backend/setting.setting_contact')}}</h3>
                </div>
                <p>
                    <label>{{Lang::get('backend/setting.contact.name')}}:</label>
                    <span class="field">
                        {{Form::text('tencongty', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.company_name')))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.contact.address')}} :</label>
                    <span class="field">
                        {{Form::text('diachicongty', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.company_address')))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.contact.phone')}} :</label>
                    <span class="field">
                        {{Form::text('sodienthoaicongty', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.company_phone')))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.contact.mobile')}} :</label>
                    <span class="field">
                        {{Form::text('sodienthoaiddcongty', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.company_mobile')))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.contact.email')}} :</label>
                    <span class="field">
                        {{Form::text('emailcongty', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.company_email')))}}
                    </span>
                </p>
                <p>
                    <label>{{Lang::get('backend/setting.contact.website')}} :</label>
                    <span class="field">
                        {{Form::text('webcongty', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.website_name')))}}
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.contact.google_maps')}}:</label>
                    <span class="field">
                        {{Form::text('googlemaps', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.google_maps')))}}
                    </span>
                </p>
            </div>
            <div id="tabs-7">
                <div class="contenttitle2">
                    <h3>{{Lang::get('backend/setting.setting_social_networking')}}</h3>
                </div>
                <p>
                    <label>{{Lang::get('backend/setting.social_networking.comment_fb')}}:</label>
                    <span class="formwrapper">

                        <input type="radio" name="commentfb" @if(isset($arrSetting['commentfb']) && $arrSetting['commentfb']==0)checked="checked" @endif value="0" />Tắt &nbsp; &nbsp;
                               <input type="radio" name="commentfb" @if(isset($arrSetting['commentfb']) && $arrSetting['commentfb']==1)checked="checked" @endif  value="1" /> Bật &nbsp; &nbsp;
                    </span>
                </p>

                <p>
                    <label>{{Lang::get('backend/setting.social_networking.fanpage_fb')}}:</label>
                    <span class="field">
                        {{Form::text('facebookfanpage', null, array('class'=>"longinput", 'placeholder'=>Lang::get('placeholder.fb_fanpage')))}}
                    </span>
                </p>
            </div>
        </div>
        <div class="f_left">
            <p class="f_left">
                <input type="submit" class="submit radius2" value="{{Lang::get('button.save')}}">
                <input type="reset" class="reset radius2" value="{{Lang::get('button.reset')}}">
            </p>
        </div>
        {{Form::close()}}
    </div>
</div>

@endsection
