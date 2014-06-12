<div class="topheader">
    <div class="left">
        <a href="{{url()}}"><h1 class="logo">{{Config::get('configall.title-website')}}</h1></a>
        <span class="slogan">{{Config::get('configall.meta-description')}}</span>
        <br clear="all" />
    </div><!--left-->
    <div class="right">
        <div class="userinfo">
            <img src="http://www.gravatar.com/avatar/{{md5(Auth::user()->email)}}?s=25" alt="" />
            <span>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</span>
        </div><!--userinfo-->
        <div class="userinfodrop">
            <div class="avatar">
                <a href="#"><img src="http://www.gravatar.com/avatar/{{md5(Auth::user()->email)}}?s=100" alt="" /></a>
            </div><!--avatar-->
            <div class="userdata">
                <h4>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</h4>
                <span class="email">{{Auth::user()->email}}</span>
                <ul>
                    <li><a href="{{action('\BackEnd\AdminController@getProfileAdmin')}}">{{Lang::get('backend/dashboard.edit_profile')}}</a></li>
                    <li><a href="">{{Lang::get('backend/dashboard.history')}}</a></li>
                    <li><a href="{{action('\BackEnd\LoginController@getLogOut')}}">{{Lang::get('backend/dashboard.sign_out')}}</a></li>
                </ul>
            </div><!--userdata-->
        </div><!--userinfodrop-->
    </div><!--right-->
</div><!--topheader-->


<div class="header">


</div><!--header-->