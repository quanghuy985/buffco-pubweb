<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>

        <!-- Basic Page Needs
  ================================================== -->
        <meta charset="utf-8" />
        <title>SmartShop</title>
        <meta name="robots" content="index, follow" />
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <!-- Mobile Specific Metas
  ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />


        <!-- CSS
  ================================================== -->
        <link rel="stylesheet" href="{{Asset('fontend')}}/styles/skeleton.css" />
        <link rel="stylesheet" href="{{Asset('fontend')}}/styles/style.css" />
        <link rel="stylesheet" href="{{Asset('fontend')}}/styles/inner.css" />
        <link rel="stylesheet" href="{{Asset('fontend')}}/styles/flexslider.css" />
        <link rel="stylesheet" href="{{Asset('fontend')}}/styles/color.css" />
        <link rel="stylesheet" href="{{Asset('fontend')}}/styles/layout.css" />
        <link rel="stylesheet" href="{{Asset('fontend')}}/styles/fullwidth-layout.css" />
        <link rel="stylesheet" href="{{Asset('fontend')}}/styles/prettyphoto.css" media="screen"/>
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
        <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Favicons
              ================================================== -->
        <link rel="shortcut icon" href="{{Asset('fontend')}}/images/favicon.ico" />
        <link rel="apple-touch-icon" href="{{Asset('fontend')}}/images/apple-touch-icon.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="{{Asset('fontend')}}/images/apple-touch-icon-72x72.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="{{Asset('fontend')}}/images/apple-touch-icon-114x114.png" />
<!--        <script type="text/javascript" src="{{Asset('fontend')}}/js/jquery-1.10.2.js"></script>
        <script>var j110 = jQuery.noConflict(true);</script>-->
    </head>

    <body>
        <div id="bodychild">
            <div id="outercontainer">

                <!-- HEADER -->
                <div id="outerheader">
                    <div class="container">
                        <header id="top" class="twelve columns">
                            <div id="logo"  class="three columns alpha"><a href="index.html"><img src="{{Asset('fontend')}}/images/logo.png" alt=""></a></div>
                            <div id="headerright" class="six columns omega">
                                <div id="chart">
                                    <a href="#" id="shop-bag"></a>
                                    <ul class="shop-box">
                                        <li>
                                            <img src="{{Asset('fontend')}}/images/content/product/small.jpg" alt="" class="alignright imgborder" />
                                            <h2>Smart Strip Armchair</h2>
                                            <div class="price">1 x $120</div>
                                        </li>
                                        <li>
                                            <div class="total">Subtotal: $120</div>
                                            <a href="#" class="button">View Cart</a> <a href="#" class="button">Checkout</a>
                                            <div class="clear"></div>
                                        </li>
                                    </ul>

                                    <h6>Shopping Cart</h6>
                                    <p>You have no items in your shopping cart</p>
                                </div>
                                <ul id="user-nav">
                                    <li><a href="account.html">My Account</a></li>
                                    <li><a href="login.html">My Wishlist</a></li>
                                    <li><a href="cart.html">My Cart</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
                                    <li><a href="login.html">Login</a></li>
                                </ul>
                            </div>

                            <section id="navigation" class="twelve columns">
                                <nav id="nav-wrap">
                                    {{$arrmenu}}
                                    <!--                                    <ul id="topnav" class="sf-menu">
                                                                            <li class="current"><a href="index.html">Home</a></li>
                                                                            <li><a href="about.html">About</a>
                                                                                <ul>
                                                                                    <li><a href="element.html">Elements</a></li>
                                                                                    <li><a href="single.html">Blog Details</a></li>
                                                                                    <li><a href="sidebar-left.html">Sidebar Left</a></li>
                                                                                    <li><a href="#">Dropdown</a>
                                                                                        <ul>
                                                                                            <li><a href="#">Only</a></li>
                                                                                            <li><a href="single.html">Example of</a></li>
                                                                                            <li><a href="#">The Dropdown</a></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li><a href="products.html">Products</a>
                                                                                <ul>
                                                                                    <li><a href="products.html">Category</a></li>
                                                                                    <li><a href="product-details.html">Product Details</a></li>
                                                                                    <li><a href="account.html">My Account</a></li>
                                                                                    <li><a href="cart.html">My Cart</a></li>
                                                                                    <li><a href="checkout.html">Checkout</a></li>
                                                                                    <li><a href="login.html">Login</a></li>
                                                                                </ul>
                                                                            </li>
                                                                            <li><a href="blog.html">Blog</a></li>
                                                                            <li><a href="portfolio.html">Portfolio</a></li>
                                                                            <li><a href="contact.html">Contact</a></li>
                                                                        </ul> topnav -->
                                </nav><!-- nav -->	

                                <form method="get" id="searchform" action="#">
                                    <div class="bgsearch">
                                        <input type="text" name="s" id="s" value="" /> 
                                        <input type="submit" class="searchbutton" value="" />
                                    </div>
                                </form>

                                <div class="clear"></div>
                            </section>
                            <div class="clear"></div>
                        </header>
                    </div>
                </div>
                <!-- END HEADER -->