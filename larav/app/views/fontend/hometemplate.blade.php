<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
    <head>

        <!-- Basic -->
        <meta charset="utf-8">
        <title>Porto - Responsive HTML5 Template - 2.7.0</title>
        <meta name="keywords" content="HTML5 Template" />
        <meta name="description" content="Porto - Responsive HTML5 Template - 2.7.0">
        <meta name="author" content="okler.net">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Web Fonts  -->
        <link href="{{Asset('fontendlib/css/css@family=Open+Sans_3A300,400,600,700,800_7CShadows+Into+Light')}}" rel="stylesheet" type="text/css">

        <!-- Libs CSS -->
        <link rel="stylesheet" href="{{Asset('fontendlib/css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{Asset('fontendlib/css/fonts/font-awesome/css/font-awesome.css')}}">
        <link rel="stylesheet" href="{{Asset('fontendlib/vendor/owl-carousel/owl.carousel.css')}}" media="screen">
        <link rel="stylesheet" href="{{Asset('fontendlib/vendor/owl-carousel/owl.theme.css')}}" media="screen">
        <link rel="stylesheet" href="{{Asset('fontendlib/vendor/magnific-popup/magnific-popup.css')}}" media="screen">

        <!-- Theme CSS -->
        <link rel="stylesheet" href="{{Asset('fontendlib/css/theme.css')}}">
        <link rel="stylesheet" href="{{Asset('fontendlib/css/theme-elements.css')}}">
        <link rel="stylesheet" href="{{Asset('fontendlib/css/theme-animate.css')}}">

        <!-- Current Page Styles -->
        <link rel="stylesheet" href="{{Asset('fontendlib/vendor/rs-plugin/css/settings.css')}}" media="screen">
        <link rel="stylesheet" href="{{Asset('fontendlib/vendor/circle-flip-slideshow/css/component.css')}}" media="screen">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{Asset('fontendlib/css/custom.css')}}">

        <!-- Responsive CSS -->
        <link rel="stylesheet" href="{{Asset('fontendlib/css/theme-responsive.css')}}" />

        <!-- Head Libs -->
        <script src="{{Asset('fontendlib/vendor/modernizr.js')}}"></script>

        <!--[if IE]>
                <link rel="stylesheet" href="{{Asset('fontendlib/css/ie.css')}}">
        <![endif]-->

        <!--[if lte IE 8]>
                <script src="{{Asset('fontendlib/vendor/respond.js')}}"></script>
        <![endif]-->

    </head>
    <body class="boxed">

        <div class="body">
            <header>
                <div class="container">
                    <h1 class="logo">
                        <a href="{{Asset('')}}">
                            <img alt="Porto" src="{{Asset('fontendlib/img/logo.png')}}">
                        </a>
                    </h1>
                    <div class="search">
                        <form id="searchForm" action="page-search-results.html" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control search" name="q" id="q" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="icon icon-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <nav>
                        <ul class="nav nav-pills nav-top">

                            <li class="phone">
                                <div class="social-icons">
                                    <ul class="social-icons">
                                        <li class="facebook"><a href="../../../www.facebook.com/default.htm" target="_blank" title="Facebook">Facebook</a></li>
                                        <li class="twitter"><a href="../../../www.twitter.com/default.htm" target="_blank" title="Twitter">Twitter</a></li>
                                        <li class="linkedin"><a href="../../../www.linkedin.com/default.htm" target="_blank" title="Linkedin">Linkedin</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>

                    <button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
                        <i class="icon icon-bars"></i>
                    </button>
                </div>
                <div class="navbar-collapse nav-main-collapse collapse">
                    <div class="container">

                        <nav class="nav-main mega-menu">
                            <ul class="nav nav-pills nav-main" id="mainMenu">
                                <li class="active">
                                    <a href="#">
                                        <i class="icon icon-home" style="font-size: 17px;"></i>

                                    </a>
                                </li>
                                <li class="dropdown mega-menu-item mega-menu-fullwidth">
                                    <a class="dropdown-toggle" href="javascript:void(0);">Sản phẩm
                                        <i class="icon icon-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="mega-menu-content">
                                                <div class="row">
                                                    @foreach($menu as $item)
                                                    <div class="col-md-3">
                                                        <ul class="sub-menu">
                                                            <li>
                                                                <a href="{{URL::action('ProductController@getChuyenMuc')}}/{{$item->cateSlug}}"><span class="mega-menu-sub-title">{{$item->cateName}}</span>   </a>                                              
                                                                @if(isset($menuchild))
                                                                <ul class="sub-menu">
                                                                    @foreach($menuchild as $item1)
                                                                    @if($item1->cateParent==$item->id)
                                                                    <li><a href="{{URL::action('ProductController@getChuyenMuc')}}/{{$item1->cateSlug}}">{{$item1->cateName}}</a></li>
                                                                    @endif
                                                                    @endforeach
                                                                </ul>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="">
                                    <a href="{{URL::action('ServicesController@getDichVu')}}">
                                        Dịch vụ
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="#">
                                        Tin tức<i class="icon icon-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($menunew as $newme)
                                        @if($newme->catenewsParent==0)
                                        <?php $bien = 0; ?>
                                        @foreach($menunew as $newme1)
                                        @if($newme1->catenewsParent==$newme->id && $newme1->catenewsParent!=0)
                                        <?php $bien++; ?>
                                        @endif
                                        @endforeach
                                        <li @if($bien>0)class="dropdown-submenu" @endif><a href="{{URL::action('NewsController@getChuyenMuc')}}/{{$newme->catenewsSlug}}">{{$newme->catenewsName}}</a>
                                            @if($bien>0)
                                            <ul class="dropdown-menu">
                                                @foreach($menunew as $newme1)
                                                @if($newme1->catenewsParent==$newme->id && $newme1->catenewsParent!=0)
                                                <li><a href="{{URL::action('NewsController@getChuyenMuc')}}/{{$newme1->catenewsSlug}}">{{$newme1->catenewsName}}</a></li>
                                                @endif
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endif
                                        @endforeach

                                    </ul>
                                </li>
                                <li>
                                    <a  href="#">
                                        Giới thiệu                              
                                    </a>

                                </li>
                                <li >
                                    <a href="#">
                                        Liên hệ         
                                    </a>

                                </li>
                                @if(!Session::has('userSession'))
                                <li><a href="{{URL::action('LoginController@getDangNhap')}}">Đăng nhập</a></li>                                    
                                @endif
                                @if(Session::has('userSession'))
                                <?php
                                $user = Session::get('userSession');
                                ?>
                                <li class="dropdown mega-menu-item mega-menu-signin signin logged" id="headerAccount">
                                    <a class="dropdown-toggle" href="javascript:void(0);">
                                        <i class="icon icon-user"> Xin chào, {{ str_limit($user[0]->userLastName,15,'...')}}</i>
                                        <i class="icon icon-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="mega-menu-content">
                                                <div class="row">													
                                                    <div class="col-md-6">
                                                        <ul class="list-account-options">
                                                            <li>
                                                                <a href="{{URL::action('AccountController@getProfileView')}}">Thông tin cá nhân</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{URL::action('AccountController@getLogOut')}}">Thoát</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </header>

            <div role="main" class="main">

                @yield("contenthomepage")

            </div>

            <footer id="footer">
                <div class="container">
                    <div class="row">
                        <div class="footer-ribon">
                            <span>Get in Touch</span>
                        </div>
                        <div class="col-md-6">
                            <div class="newsletter">
                                <h4>Newsletter</h4>
                                <p>
                                <div id="fb-root"></div>
                                <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
                                </script>
                                <div class="fb-like-box" data-href="https://www.facebook.com/pubweb.vn" data-width="555" data-height="213" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
                                <style>                              
                                    .fb-like-box.fb_iframe_widget iframe {
                                        background: none repeat scroll 0 0 #FAFAFA;
                                    }
                                </style>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-details">
                                <h4>Liên hệ</h4>
                                <ul class="contact">
                                    <li><p><i class="icon icon-map-marker"></i> <strong>Địa chỉ:</strong> Số 16/11 Ngõ chùa hưng ký, Minh Khai, Hai bà trưng, Hà Nội</p></li>
                                    <li><p><i class="icon icon-phone"></i> <strong>Hotline :</strong> 0989333537 </p></li>
                                    <li><p><i class="icon icon-envelope"></i> <strong>Địa chỉ Email :</strong> <a href="mailto:pubweb.vn@gmail.com">pubweb.vn@gmail.com</a></p></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <h4>Follow Us</h4>
                            <div class="social-icons">
                                <ul class="social-icons">
                                    <li class="facebook"><a href="../../../www.facebook.com/default.htm" target="_blank" data-placement="bottom" rel="tooltip" title="Facebook">Facebook</a></li>
                                    <li class="twitter"><a href="../../../www.twitter.com/default.htm" target="_blank" data-placement="bottom" rel="tooltip" title="Twitter">Twitter</a></li>
                                    <li class="linkedin"><a href="../../../www.linkedin.com/default.htm" target="_blank" data-placement="bottom" rel="tooltip" title="Linkedin">Linkedin</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-copyright">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-1">
                                <a href="{{Asset('')}}" class="logo">
                                    <img alt="Porto Website Template" class="img-responsive" src="{{Asset('fontendlib/img/logo-footer.png')}}">
                                </a>
                            </div>
                            <div class="col-md-7">
                                <p>© Copyright 2014. All Rights Reserved.</p>
                            </div>
                            <div class="col-md-4">
                                <nav id="sub-menu">
                                    <ul>
                                        <li><a href="{{URL::action('PageContronller@getCauHoiThuongGap')}}">FAQ's</a></li>
                                        <li><a href="{{URL::action('PageContronller@getBaoMat')}}">Bảo mật</a></li>
                                        <li><a href="{{URL::action('PageContronller@getThoaThuanNguoiDung')}}">Thỏa thuận người dùng</a></li>
                                        <li><a href="{{URL::action('PageContronller@getThoaThuanNguoiDung')}}">Sitemap</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Libs -->
        <script src="{{Asset('fontendlib/vendor/jquery.js')}}"></script>
        <script src="{{Asset('fontendlib/js/plugins.js')}}"></script>
        <script src="{{Asset('fontendlib/vendor/jquery.easing.js')}}"></script>
        <script src="{{Asset('fontendlib/vendor/jquery.appear.js')}}"></script>
        <script src="{{Asset('fontendlib/vendor/jquery.cookie.js')}}"></script>    
        <script src="{{Asset('fontendlib/vendor/bootstrap.js')}}"></script>
        <script src="{{Asset('fontendlib/vendor/twitterjs/twitter.js')}}"></script>
        <script src="{{Asset('fontendlib/vendor/rs-plugin/js/jquery.themepunch.plugins.min.js')}}"></script>
        <script src="{{Asset('fontendlib/vendor/rs-plugin/js/jquery.themepunch.revolution.js')}}"></script>
        <script src="{{Asset('fontendlib/vendor/owl-carousel/owl.carousel.js')}}"></script>
        <script src="{{Asset('fontendlib/vendor/circle-flip-slideshow/js/jquery.flipshow.js')}}"></script>
        <script src="{{Asset('fontendlib/vendor/magnific-popup/magnific-popup.js')}}"></script>
        <script src="{{Asset('fontendlib/vendor/jquery.validate.js')}}"></script>

        <!-- Current Page Scripts -->
        <script src="{{Asset('fontendlib/js/views/view.home.js')}}"></script>

        <!-- Theme Initializer -->
        <script src="{{Asset('fontendlib/js/theme.js')}}"></script>

        <!-- Custom JS -->
        <script src="{{Asset('fontendlib/js/custom.js')}}"></script>
        <script>
jQuery("#loginfrom").validate({
    rules: {
        userEmail: {
            required: true,
            email: true
        }
    },
    messages: {
        userEmail: {
            required: '<i style="color:#FF7D8C">Vui lòng nhập Email để đăng nhập</i>',
            email: '<i style="color:#FF7D8C">Email phải đúng định dạng</i>'
        }
    }
});
jQuery("#changePasswordForm").validate({
    rules: {
        userPassword: {
            required: true,
            minlength: 8
        },
        ReUserPassword: {
            equalTo: "#userPassword"
        }
    },
    messages: {
        userPassword: {
            required: '<i style="color:#FF7D8C">Password là trường bắt buộc</i>',
            minlength: '<i style="color:#FF7D8C">Mật khẩu phải có ít nhất 8 ký tự</i>'
        },
        ReUserPassword: {
            equalTo: '<i style="color:#FF7D8C">Mật khẩu không khớp</i>'
        }
    }
});
jQuery("#registerForm").validate({
    rules: {
        userEmail: {
            required: true,
            email: true,
            remote: {
                url: "{{URL::action('LoginController@postCheckExist')}}",
                type: "POST"
            }
        },
        userPassword: {
            required: true,
            minlength: 8
        },
        userRePassword: {
            equalTo: "#userPassword"
        },
        userFirstName: {
            required: true
        },
        userLastName: {
            required: true
        },
        userAddress: {
            required: true
        },
        userPhone: {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 11
        },
        userIdentity: {
            required: true,
            number: true,
            minlength: 9,
            maxlength: 12
        }
    },
    messages: {
        userEmail: {
            required: '<i style="color:#FF7D8C">Email là trường bắt buộc</i>',
            email: '<i style="color:#FF7D8C">Email phải đúng định dạng</i>',
            remote: '<i style="color:#FF7D8C">Email đã đăng ký vui lòng chọn email khác</i>'
        },
        userPassword: {
            required: '<i style="color:#FF7D8C">Mật khẩu là trường bắt buộc</i>',
            minlength: '<i style="color:#FF7D8C">Mật khẩu phải có ít nhất 8 ký tự</i>'
        },
        userRePassword: {
            equalTo: '<i style="color:#FF7D8C">Mật khẩu không khớp</i>'
        },
        userFirstName: {
            required: '<i style="color:#FF7D8C">Vui lòng nhập họ và đệm</i>'
        },
        userLastName: {
            required: '<i style="color:#FF7D8C">Vui lòng nhập tên </i>'
        },
        userAddress: {
            required: '<i style="color:#FF7D8C">Vui lòng nhập địa chỉ</i>'
        },
        userPhone: {
            required: '<i style="color:#FF7D8C">Vui lòng nhập số điện thoại để chúng tôi liên lạc</i>',
            number: '<i style="color:#FF7D8C">Số điện thoại phải là số</i>',
            minlength: '<i style="color:#FF7D8C">Số điện thoại không đúng</i>',
            maxlength: '<i style="color:#FF7D8C">Số điện thoại không đúng</i>'
        },
        userIdentity: {
            required: '<i style="color:#FF7D8C">Vui lòng nhập số CMND</i>',
            number: '<i style="color:#FF7D8C">CMND không đúng</i>',
            minlength: '<i style="color:#FF7D8C">CMND không đúng</i>',
            maxlength: '<i style="color:#FF7D8C">CMND không đúng</i>'
        }
    }
});
        </script>

    </body>
</html>
