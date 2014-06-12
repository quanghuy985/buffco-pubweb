@extends("fontend.template")
@section("content")
<!-- BEFORE CONTENT -->
<div id="outerbeforecontent">
    <div class="container">
        <section id="beforecontent" class="twelve columns">
            <h1 class="pagetitle">All Products</h1>
            <div class="clear"></div>
        </section>
    </div>
</div>
<!-- END BEFORE CONTENT -->

<!-- MAIN CONTENT -->
<div id="outermain">
    <div class="container">
        <section id="maincontent" class="twelve columns">
            <section id="content" class="positionleft nine columns alpha"> 
                <div class="padcontent">

                    <div id="ts-display-products">
                        <ul class="ts-display-pd-col-3">
                            <li>
                                <a href="product-details.html"><img src="{{Asset('fontend')}}/images/content/product/img1.jpg" alt="" class="scale-with-grid imgborder" /></a>
                                <h2><a href="product-details.html">Smart Table</a></h2>
                                <div class="price">$175.00</div>
                            </li>
                            <li>
                                <a href="product-details.html"><img src="{{Asset('fontend')}}/images/content/product/img2.jpg" alt="" class="scale-with-grid imgborder" /></a>
                                <h2><a href="product-details.html">Smart Chair</a></h2>
                                <div class="price">$200.00</div>  
                            </li>
                            <li class="nomargin">
                                <a href="product-details.html"><img src="{{Asset('fontend')}}/images/content/product/img3.jpg" alt="" class="scale-with-grid imgborder" /></a>
                                <h2><a href="product-details.html">Smart Desk Lamp</a></h2>
                                <div class="price">$75.00</div>
                            </li>
                            <li>
                                <a href="product-details.html"><img src="{{Asset('fontend')}}/images/content/product/img5.jpg" alt="" class="scale-with-grid imgborder" /></a>
                                <h2><a href="product-details.html">Smart Camera SLR</a></h2>
                                <div class="price">$140.00</div>
                            </li>
                            <li>
                                <a href="product-details.html"><img src="{{Asset('fontend')}}/images/content/product/img6.jpg" alt="" class="scale-with-grid imgborder" /></a>
                                <h2><a href="product-details.html">Vintage Wall Lamp</a></h2>
                                <div class="price">$300.00</div>  
                            </li>
                            <li class="nomargin">
                                <a href="product-details.html"><img src="{{Asset('fontend')}}/images/content/product/img7.jpg" alt="" class="scale-with-grid imgborder" /></a>
                                <h2><a href="product-details.html">Smart Oval Sofa</a></h2>
                                <div class="price">$400.00</div>
                            </li>
                        </ul>
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
                        <h2 class="widget-title">Text Widget</h2>
                        <div class="textwidget">Pellentesque at mauris fringilla nunc sollicitudin vehicula. Aliquam et nibh ipsum, vel porta augue. Sed dolor ligula, facilisis.</div>
                    </li>
                    <li class="widget-container">
                        <div class="textwidget"><img src="{{Asset('fontend')}}/images/content/banner.gif" alt="" class="scale-with-grid"/></div>
                    </li>

                </ul>
            </aside>

            <div class="clear"></div><!-- clear float --> 
        </section>
    </div>
</div>
<!-- END MAIN CONTENT -->
@endsection
