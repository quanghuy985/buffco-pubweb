@extends("fontend.template")
@section("content")   
<!-- MAIN CONTENT -->
<div id="outermain">
    <div class="container">
        <section id="maincontent" class="twelve columns">
            <section id="content" class="positionleft nine columns alpha"> 
                <div class="padcontent">

                    <article class="post single">
                        <h2 class="posttitle"><a href="single.html">Pellentesque ac ante arcu. Mauris quis nunc velit.</a></h2>
                        <div class="entry-utility">
                            Posted by <a href="#">Templatesquare</a> on May 16, 2012 / <a href="#">0 Comment</a>
                        </div>
                        <div class="postimg">
                            <img src="{{Asset('fontend')}}/images/content/post1.jpg" alt="" class="scale-with-grid" />
                        </div>
                        <div class="entry-content">
                            <p>Aliquam luctus rhoncus eros, non malesuada nunc consectetur a. Donec tristique rhoncus libero vitae cursus. Morbi commodo, massa non lobortis rutrum, tortor risus viverra augue, et vehicula quam quam molestie ante. Donec ac eleifend turpis. Duis est ipsum, bibendum at semper sit amet, bibendum id tellus. Aenean aliquam erat nec lectus ultrices eleifend. Etiam ac diam tortor, vel vulputate ante.</p>

                            <p>Curabitur tincidunt iaculis ipsum, eu malesuada tellus congue a. Quisque aliquet, enim eget consequat scelerisque, lectus nibh pulvinar lectus, ac vestibulum nisl urna quis magna. Quisque laoreet pulvinar orci, eget tempor ante consectetur in. Nullam et lorem ut magna aliquet eleifend scelerisque eu justo. </p>

                            <p>Maecenas sollicitudin, urna sit amet tristique euismod, tellus orci malesuada sapien, ut volutpat ante augue interdum leo. Ut neque massa, lacinia et consectetur ac, sodales ac risus. </p>

                            <div class="clearfix"></div>
                        </div>
                    </article>

                    <section id="comment">
                        <h4 class="titleBold">Bình luận</h4>
                        <script type="text/javascript" src="{{Asset('fontend')}}/js/jquery-1.10.2.js"></script>
                        <script>var j110 = jQuery.noConflict(true);</script>
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id))
                                    return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                        <div id="fb_chat" class="fb-comments" data-href="{{URL::current()}}"  data-send="true" data-numposts="10" data-colorscheme="light"></div>

                        <script>
                            j110('#fb_chat').attr('data-width', j110('#comment').width());
                        </script>

                    </section>

                </div>
            </section>
            <aside id="sidebar" class="positionright three columns omega">
                <ul>
                    <li class="widget-container">
                        <h2 class="widget-title">Categories</h2>
                        <ul>
                            <li><a href="#">Limited Edition</a><span>15</span></li>
                            <li><a href="#">On Sale</a><span>27</span></li>
                            <li><a href="#">New Product</a><span>10</span></li>
                            <li><a href="#">Furniture</a><span>23</span></li>
                            <li><a href="#">Electronic</a><span>25</span></li>
                            <li><a href="#">Other</a><span>70</span></li>
                        </ul>
                    </li>
                    <li class="widget-container">
                        <h2 class="widget-title">Text Widget</h2>
                        <div class="textwidget">Pellentesque at mauris fringilla nunc sollicitudin vehicula. Aliquam et nibh ipsum, vel porta augue. Sed dolor ligula, facilisis.</div>
                    </li>
                    <li class="widget-container">
                        <h2 class="widget-title">Latest Product</h2>
                        <ul class="lp-widget">
                            <li>
                                <img src="{{Asset('fontend')}}/images/content/product/small-img1.jpg" alt="" class="alignleft imgborder" />
                                <h3><a href="product-details.html">Smart Strip Armchair</a></h3>
                                <div class="price">$120.00</div>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <img src="{{Asset('fontend')}}/images/content/product/small-img2.jpg" alt="" class="alignleft imgborder" />
                                <h3><a href="product-details.html">Smart Chair</a></h3>
                                <div class="price">$200.00</div>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <img src="{{Asset('fontend')}}/images/content/product/small-img3.jpg" alt="" class="alignleft imgborder" />
                                <h3><a href="product-details.html">Smart Camera SLR</a></h3>
                                <div class="price">$120.00</div>
                                <div class="clear"></div>
                            </li>
                        </ul>
                    </li>
                    <li class="widget-container">
                        <div class="textwidget"><img src="{{Asset('fontend')}}/images/content/banner.gif" alt="" class="scale-with-grid"/></div>
                    </li>
                    <li class="widget-container">
                        <h2 class="widget-title">Top Rated Product</h2>
                        <ul class="lp-widget">
                            <li>
                                <img src="{{Asset('fontend')}}/images/content/product/small-img1.jpg" alt="" class="alignleft imgborder" />
                                <h3><a href="product-details.html">Smart Strip Armchair</a></h3>
                                <div class="price">$120.00</div>
                                <div class="star">
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt=""/>
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                </div>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <img src="{{Asset('fontend')}}/images/content/product/small-img2.jpg" alt="" class="alignleft imgborder" />
                                <h3><a href="product-details.html">Smart Chair</a></h3>
                                <div class="price">$200.00</div>
                                <div class="star">
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt=""/>
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                </div>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <img src="{{Asset('fontend')}}/images/content/product/small-img3.jpg" alt="" class="alignleft imgborder" />
                                <h3><a href="product-details.html">Smart Camera SLR</a></h3>
                                <div class="price">$120.00</div>
                                <div class="star">
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt=""/>
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                    <img src="{{Asset('fontend')}}/images/content/star.png" alt="" />
                                </div>
                                <div class="clear"></div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>

            <div class="clear"></div><!-- clear float --> 
        </section>
    </div>
</div>
<!-- END MAIN CONTENT -->
@endsection
