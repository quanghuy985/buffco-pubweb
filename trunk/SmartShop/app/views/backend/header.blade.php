<div class="topheader">
    <div class="left">
        <a href="{{action('\BackEnd\HomeController@getHome')}}"><h1 class="logo">{{Config::get('configall.title-website')}}</h1></a>
        <span class="slogan">{{Config::get('configall.meta-description')}}</span>
        <br clear="all" />
    </div><!--left-->
    <div class="right" style="width: 600px;">
        <button class="stdbtn btn_red" style="float: left;margin-right: 10px; margin-top: 3px;">Mua thêm dung lượng</button>
        <div class="progress" style="float: left; width: 297px;">
            <div class="bar2"><div class="value redbar" style="width: 34%;">Storage (34%)</div></div>
        </div>           
        <div class="userinfo" style="float: right;">
            <img src="http://www.gravatar.com/avatar/{{md5(Auth::user()->email)}}?s=25" alt="" />
            <span>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</span>
        </div><!--userinfo-->
        <div class="userinfodrop" >
            <div class="avatar">
                <a href="#"><img src="http://www.gravatar.com/avatar/{{md5(Auth::user()->email)}}?s=100" alt="" /></a>
            </div><!--avatar-->
            <div class="userdata" style="float: right !important;">
                <h4>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</h4>
                <span class="email">{{Auth::user()->email}}</span>
                <ul>
                    <li><a href="{{action('\BackEnd\AdminController@getProfileAdmin')}}">{{Lang::get('backend/dashboard.edit_profile')}}</a></li>
                    <li><a href="{{action('\BackEnd\HistoryUserController@getUserHistory')}}/{{Auth::user()->id}}">{{Lang::get('backend/dashboard.history')}}</a></li>
                    <li><a href="{{action('\BackEnd\LoginController@getLogOut')}}">{{Lang::get('backend/dashboard.sign_out')}}</a></li>
                </ul>
            </div><!--userdata-->
        </div><!--userinfodrop-->
    </div><!--right-->
</div><!--topheader-->


<div class="header">


</div><!--header-->