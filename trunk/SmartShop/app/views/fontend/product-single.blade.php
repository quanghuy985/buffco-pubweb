@extends("fontend.template")
@section("content")
<!-- MAIN CONTENT -->
<div id="outermain">
    <div class="container">
        <section id="maincontent" class="twelve columns">
            <section id="content" class="positionleft nine columns alpha"> 
                <div class="padcontent product-detail" id="ts-display-portfolio">
                    <div class="four columns alpha">
                        <a class="image" href="{{Asset('fontend')}}/images/content/product/img5.jpg" data-rel="prettyPhoto[mixed]" > 
                            <img src="{{Asset('fontend')}}/images/content/product/img5.jpg" alt="" class="imgborder scale-with-grid" />
                        </a>
                    </div>
                    <div class="one_half lastcols">

                        <div class="price">$140.00</div>
                        <p>Donec consectetur libero ut tortor condimentum eu egestas est viverra. Sed eget turpis dui, sed auctor nisi. Fusce suscipit risus sed tortor mattis sollicitudin. </p>
                        <div class="variations_button">
                            <form class="variations_form cart" method="post" action="cart.html">
                                <div class="quantity buttons_added">
                                    <input type="button" class="minus" id="minus1" value="-">
                                    <input maxlength="12" class="input-text qty text" title="Qty" size="4" value="1" name="quantity" id="quantity" readonly="">
                                    <input type="button" class="plus" id="add1" value="+">
                                </div>	
                              
                                <button class="button alt" type="submit">Add to cart</button>	
                            </form>			

                            <div class="product_meta"> 
                                <span class="posted_in">Category: <a href="products.html">Electronic</a>, <a href="products.html">Camera</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div><br><br>

                    <div class="tabcontainer">
                        <ul class="tabs">
                            <li><a href="#tab0">Description</a></li>
                            <li><a href="#tab1">Additional Information</a></li>
                            <li><a href="#tab2">Ảnh sản phẩm</a></li>
                            <li><a href="#tab3">Reviews (0)</a></li>
                        </ul>
                        <div id="tab-body">
                            <div id="tab0" class="tab-content">
                                <p>Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Sed placerat libero quis metus malesuada venenatis. Nulla facilisi malesuada.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis feugiat rutrum luctus. Proin nisl augue, tempus quis lacinia at, ultrices eget sapien. Vestibulum at orci a eros molestie rutrum. Fusce interdum erat vel eros elementum vitae interdum massa varius. Morbi fermentum commodo nisi, id interdum mauris suscipit pellentesque. Morbi velit eros, accumsan ut faucibus at, viverra id mi. Nunc augue nisl, rutrum vitae luctus nec, lobortis sit amet diam.</p>
                            </div>
                            <div id="tab1" class="tab-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis feugiat rutrum luctus. Proin nisl augue, tempus quis lacinia at, ultrices eget sapien. Vestibulum at orci a eros molestie rutrum. Fusce interdum erat vel eros elementum vitae interdum massa varius. Morbi fermentum commodo nisi, id interdum mauris suscipit pellentesque. Morbi velit eros, accumsan ut faucibus at, viverra id mi. Nunc augue nisl, rutrum vitae luctus nec, lobortis sit amet diam. Proin porttitor semper sollicitudin. Donec mollis rhoncus turpis et rhoncus. In elit nisl, ultrices id mollis ut, dapibus eget nulla. Fusce laoreet neque ut purus faucibus ut condimentum purus condimentum. Vestibulum vel magna ligula, in tincidunt augue. Fusce sit amet neque ut neque vestibulum rhoncus in eu nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer interdum sapien facilisis odio fermentum tincidunt. Nullam a ante augue.</p>
                            </div>
                            <div id="tab2" class="tab-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis feugiat rutrum luctus. Proin nisl augue, tempus quis lacinia at, ultrices eget sapien. Vestibulum at orci a eros molestie rutrum. Fusce interdum erat vel eros elementum vitae interdum massa varius. Morbi fermentum commodo nisi, id interdum mauris suscipit pellentesque. Morbi velit eros, accumsan ut faucibus at, viverra id mi. Nunc augue nisl, rutrum vitae luctus nec, lobortis sit amet diam. Proin porttitor semper sollicitudin. Donec mollis rhoncus turpis et rhoncus. In elit nisl, ultrices id mollis ut, dapibus eget nulla. Morbi nec magna erat, id tincidunt sapien. Morbi id porttitor lorem. In mi velit, viverra a congue et, congue sit amet nibh. Pellentesque a libero eget quam consequat condimentum eu eu est. Vestibulum at tellus eget massa accumsan volutpat. Suspendisse felis arcu, sagittis nec ultrices sit amet, faucibus a ante. Nunc et ante at ipsum iaculis porta eu quis augue. Praesent ultrices suscipit quam, vitae malesuada erat volutpat non. Sed ut tortor turpis, eu dignissim elit.</p>
                            </div>
                            <div id="tab3" class="tab-content">
                                <a class="image" href="{{Asset('fontend')}}/images/content/product/img5.jpg" data-rel="prettyPhoto[mixed]" > 
                                    <img src="{{Asset('fontend')}}/images/content/product/img5.jpg" alt="" class="imgborder scale-with-grid" />
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="separator line"></div>

                    <h3>Related Product</h3> 
                    <div class="one_third firstcols">
                        <a href="product-details.html"><img src="{{Asset('fontend')}}/images/content/product/img1.jpg" alt="" class="scale-with-grid imgborder" /></a>
                        <h4><a href="product-details.html">Smart Table</a></h4>
                        <div class="price">$175.00</div>
                    </div> 
                    <div class="one_third">
                        <a href="product-details.html"><img src="{{Asset('fontend')}}/images/content/product/img2.jpg" alt="" class="scale-with-grid imgborder" /></a>
                        <h4><a href="product-details.html">Smart Chair</a></h4>
                        <div class="price">$175.00</div>  
                    </div> 
                    <div class="one_third lastcols">
                        <a href="product-details.html"><img src="{{Asset('fontend')}}/images/content/product/img3.jpg" alt="" class="scale-with-grid imgborder" /></a>
                        <h4><a href="product-details.html">Smart Desk Lamp</a></h4>
                        <div class="price">$175.00</div>
                    </div>            
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