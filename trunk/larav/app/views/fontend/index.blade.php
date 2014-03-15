@extends("fontend.hometemplate")

@section("contenthomepage")
<div id="content" class="content full">
    <div class="slider-container">
        <div class="slider" id="revolutionSlider">
            <ul>
                <li data-transition="fade" data-slotamount="13" data-masterspeed="300" >

                    <img src="{{Asset('fontendlib/img/slides/slide-bg.jpg')}}" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                    <div class="tp-caption sft stb visible-lg"
                         data-x="72"
                         data-y="180"
                         data-speed="300"
                         data-start="1000"
                         data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-title-border.png')}}" alt=""></div>

                    <div class="tp-caption top-label lfl stl"
                         data-x="122"
                         data-y="180"
                         data-speed="300"
                         data-start="500"
                         data-easing="easeOutExpo">Bạn cần một website</div>

                    <div class="tp-caption sft stb visible-lg"
                         data-x="372"
                         data-y="180"
                         data-speed="300"
                         data-start="1000"
                         data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-title-border.png')}}" alt=""></div>

                    <div class="tp-caption main-label sft stb"
                         data-x="30"
                         data-y="210"
                         data-speed="300"
                         data-start="1500"
                         data-easing="easeOutExpo">Chuyên nghiệp</div>

                    <div class="tp-caption bottom-label sft stb"
                         data-x="80"
                         data-y="280"
                         data-speed="500"
                         data-start="2000"
                         data-easing="easeOutExpo">Miễn phí , tối ưu và nhiều hơn thế nữa ...</div>

                    <div class="tp-caption randomrotate"
                         data-x="800"
                         data-y="248"
                         data-speed="500"
                         data-start="2500"
                         data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-1.png')}}" alt=""></div>

                    <div class="tp-caption sfb"
                         data-x="850"
                         data-y="200"
                         data-speed="400"
                         data-start="3000"
                         data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-2.png')}}" alt=""></div>

                    <div class="tp-caption sfb"
                         data-x="820"
                         data-y="170"
                         data-speed="700"
                         data-start="3150"
                         data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-3.png')}}" alt=""></div>

                    <div class="tp-caption sfb"
                         data-x="770"
                         data-y="130"
                         data-speed="1000"
                         data-start="3250"
                         data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-4.png')}}" alt=""></div>

                    <div class="tp-caption sfb"
                         data-x="500"
                         data-y="80"
                         data-speed="600"
                         data-start="3450"
                         data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-5.png')}}" alt=""></div>

                    <div class="tp-caption blackboard-text lfb "
                         data-x="530"
                         data-y="300"
                         data-speed="500"
                         data-start="3450"
                         data-easing="easeOutExpo" style="font-size: 37px;">Đột phá</div>

                    <div class="tp-caption blackboard-text lfb "
                         data-x="555"
                         data-y="350"
                         data-speed="500"
                         data-start="3650"
                         data-easing="easeOutExpo" style="font-size: 47px;">TRONG</div>

                    <div class="tp-caption blackboard-text lfb "
                         data-x="580"
                         data-y="400"
                         data-speed="500"
                         data-start="3850"
                         data-easing="easeOutExpo" style="font-size: 32px;">Ý tưởng</div>
                </li>
                <li data-transition="fade" data-slotamount="5" data-masterspeed="1000" >

                    <img src="{{Asset('fontendlib/img/slides/slide-bg.jpg')}}" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                    <div class="tp-caption fade"
                         data-x="50"
                         data-y="100"
                         data-speed="1500"
                         data-start="500"
                         data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-concept.png')}}" alt=""></div>

                    <div class="tp-caption blackboard-text fade "
                         data-x="180"
                         data-y="180"
                         data-speed="1500"
                         data-start="1000"
                         data-easing="easeOutExpo" style="font-size: 30px;">khởi nghiệp</div>

                    <div class="tp-caption blackboard-text fade "
                         data-x="180"
                         data-y="220"
                         data-speed="1500"
                         data-start="1200"
                         data-easing="easeOutExpo" style="font-size: 40px;">CÓ TỐN KÉM ?</div>

                    <div class="tp-caption main-label sft stb"
                         data-x="580"
                         data-y="190"
                         data-speed="300"
                         data-start="1500"
                         data-easing="easeOutExpo">Miễn phí!</div>

                    <div class="tp-caption bottom-label sft stb"
                         data-x="580"
                         data-y="260"
                         data-speed="500"
                         data-start="2000"
                         data-easing="easeOutExpo">là điều chúng tối mang đến cho bạn .</div>



                </li>
            </ul>
        </div>
    </div>
    <div class="home-intro">
        <div class="container">

            <div class="row">
                <div class="col-md-8">
                    <p>
                        Miễn phí trọn đời sản phẩm và dịch vụ chỉ có thể là <em>Pubweb.vn</em>
                        <span>Lựa chọn sản phẩm bạn cần và đăng ký ngay .</span>
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="get-started">
                        <a href="#" class="btn btn-lg btn-primary">Đăng ký!</a>
                        <div class="learn-more">hoặc <a href="index.html">tìm hiểu thêm.</a></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container">

        <div class="row center">
            <div class="col-md-12">
                <h2 class="short word-rotator-title">
                    Porto is
                    <strong class="inverted">
                        <span class="word-rotate">
                            <span class="word-rotate-items">
                                <span>incredibly</span>
                                <span>especially</span>
                                <span>extremely</span>
                            </span>
                        </span>
                    </strong>
                    beautiful and fully responsive.
                </h2>
                <p class="featured lead">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce elementum, nulla vel pellentesque consequat, ante nulla hendrerit arcu, ac tincidunt mauris lacus sed leo. vamus suscipit molestie vestibulum.
                </p>
            </div>
        </div>

    </div>

    <div class="home-concept">
        <div class="container">

            <div class="row center">
                <span class="sun"></span>
                <span class="cloud"></span>
                <div class="col-md-2 col-md-offset-1">
                    <div class="process-image" data-appear-animation="bounceIn">
                        <img src="{{Asset('fontendlib/img/home-concept-item-1.png')}}" alt="" />
                        <strong>Strategy</strong>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="process-image" data-appear-animation="bounceIn" data-appear-animation-delay="200">
                        <img src="{{Asset('fontendlib/img/home-concept-item-2.png')}}" alt="" />
                        <strong>Planning</strong>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="process-image" data-appear-animation="bounceIn" data-appear-animation-delay="400">
                        <img src="{{Asset('fontendlib/img/home-concept-item-3.png')}}" alt="" />
                        <strong>Build</strong>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-1">
                    <div class="project-image">
                        <div id="fcSlideshow" class="fc-slideshow">
                            <ul class="fc-slides">
                                <li><a href="portfolio-single-project.html"><img class="img-responsive" src="{{Asset('fontendlib/img/projects/project-home-1.jpg')}}" /></a></li>
                                <li><a href="portfolio-single-project.html"><img class="img-responsive" src="{{Asset('fontendlib/img/projects/project-home-2.jpg')}}" /></a></li>
                                <li><a href="portfolio-single-project.html"><img class="img-responsive" src="{{Asset('fontendlib/img/projects/project-home-3.jpg')}}" /></a></li>
                            </ul>
                        </div>
                        <strong class="our-work">Our Work</strong>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container">

        <div class="row">
            <hr class="tall" />
        </div>

    </div>

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h2>Hỗ trợ khách hàng</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="image-icon small user"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">Nguyễn Tuấn Anht</h4>
                                <p class="tall">
                                    <a href="ymsgr:sendim?tuananhnguyen_1990"><img src="http://opi.yahoo.com/online?u=tuananhnguyen_1990&amp;m=g&amp;t=1" class="yahoo-img"></a>
                                    <a href="Skype:tuananhnguyen_1990?chat"> <img src="http://mystatus.skype.com/smallclassic/tuananhnguyen_1990" class="skype-img"> </a>
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="image-icon small user"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">Ngô Quang huy</h4>
                                <p class="tall">
                                    <a href="ymsgr:sendim?tuananhnguyen_1990"><img src="http://opi.yahoo.com/online?u=tuananhnguyen_1990&amp;m=g&amp;t=1" class="yahoo-img"></a>
                                    <a href="Skype:tuananhnguyen_1990?chat"> <img src="http://mystatus.skype.com/smallclassic/tuananhnguyen_1990" class="skype-img"> </a>
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="feature-box">
                            <div class="feature-box-icon">
                                <i class="image-icon small user"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="shorter">Hà Ngọc Quân</h4>
                                <p class="tall">
                                    <a href="ymsgr:sendim?tuananhnguyen_1990"><img src="http://opi.yahoo.com/online?u=tuananhnguyen_1990&amp;m=g&amp;t=1" class="yahoo-img"></a>
                                    <a href="Skype:tuananhnguyen_1990?chat"> <img src="http://mystatus.skype.com/smallclassic/tuananhnguyen_1990" class="skype-img"> </a>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <hr class="tall" />

        <div class="row center">
            <div class="col-md-12">
                <h2 class="short word-rotator-title">
                    We're not the only ones
                    <strong>
                        <span class="word-rotate">
                            <span class="word-rotate-items">
                                <span>excited</span>
                                <span>happy</span>
                            </span>
                        </span>
                    </strong>
                    about Porto Template...
                </h2>
                <h4 class="lead tall">5,500 customers in 100 countries use Porto Template. Meet our customers.</h4>
            </div>
        </div>
        <div class="row center">
            <div class="owl-carousel" data-plugin-options='{"items": 6, "singleItem": false, "autoPlay": true}'>
                <div>
                    <img class="img-responsive" src="img/logos/logo-1.png" alt="">
                </div>
                <div>
                    <img class="img-responsive" src="img/logos/logo-2.png" alt="">
                </div>
                <div>
                    <img class="img-responsive" src="img/logos/logo-3.png" alt="">
                </div>
                <div>
                    <img class="img-responsive" src="img/logos/logo-4.png" alt="">
                </div>
                <div>
                    <img class="img-responsive" src="img/logos/logo-5.png" alt="">
                </div>
                <div>
                    <img class="img-responsive" src="img/logos/logo-6.png" alt="">
                </div>
                <div>
                    <img class="img-responsive" src="img/logos/logo-4.png" alt="">
                </div>
                <div>
                    <img class="img-responsive" src="img/logos/logo-2.png" alt="">
                </div>
            </div>
        </div>

    </div>
    <div class="map-section">
        <section class="featured footer map">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="recent-posts push-bottom">
                            <h2>Latest <strong>Blog</strong> Posts</h2>
                            <div class="row">
                                <div class="owl-carousel" data-plugin-options='{"items": 1, "autoHeight": true}'>
                                    <div>
                                        <div class="col-md-6">
                                            <article>
                                                <div class="date">
                                                    <span class="day">15</span>
                                                    <span class="month">Jan</span>
                                                </div>
                                                <h4><a href="blog-post.html">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat libero. <a href="../../default.htm" class="read-more">read more <i class="icon icon-angle-right"></i></a></p>
                                            </article>
                                        </div>
                                        <div class="col-md-6">
                                            <article>
                                                <div class="date">
                                                    <span class="day">15</span>
                                                    <span class="month">Jan</span>
                                                </div>
                                                <h4><a href="blog-post.html">Lorem ipsum dolor</a></h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat. <a href="../../default.htm" class="read-more">read more <i class="icon icon-angle-right"></i></a></p>
                                            </article>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-6">
                                            <article>
                                                <div class="date">
                                                    <span class="day">12</span>
                                                    <span class="month">Jan</span>
                                                </div>
                                                <h4><a href="blog-post.html">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat libero. <a href="../../default.htm" class="read-more">read more <i class="icon icon-angle-right"></i></a></p>
                                            </article>
                                        </div>
                                        <div class="col-md-6">
                                            <article>
                                                <div class="date">
                                                    <span class="day">11</span>
                                                    <span class="month">Jan</span>
                                                </div>
                                                <h4><a href="blog-post.html">Lorem ipsum dolor</a></h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="../../default.htm" class="read-more">read more <i class="icon icon-angle-right"></i></a></p>
                                            </article>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-6">
                                            <article>
                                                <div class="date">
                                                    <span class="day">15</span>
                                                    <span class="month">Jan</span>
                                                </div>
                                                <h4><a href="blog-post.html">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat libero. <a href="../../default.htm" class="read-more">read more <i class="icon icon-angle-right"></i></a></p>
                                            </article>
                                        </div>
                                        <div class="col-md-6">
                                            <article>
                                                <div class="date">
                                                    <span class="day">15</span>
                                                    <span class="month">Jan</span>
                                                </div>
                                                <h4><a href="blog-post.html">Lorem ipsum dolor</a></h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat. <a href="../../default.htm" class="read-more">read more <i class="icon icon-angle-right"></i></a></p>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2><strong>What</strong> Client’s Say</h2>
                        <div class="row">
                            <div class="owl-carousel push-bottom" data-plugin-options='{"items": 1, "autoHeight": true}'>
                                <div>
                                    <div class="col-md-12">
                                        <blockquote class="testimonial">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat.  Donec hendrerit vehicula est, in consequat.  Donec hendrerit vehicula est, in consequat.</p>
                                        </blockquote>
                                        <div class="testimonial-arrow-down"></div>
                                        <div class="testimonial-author">
                                            <div class="img-thumbnail img-thumbnail-small">
                                                <img src="img/clients/client-1.jpg" alt="">
                                            </div>
                                            <p><strong>John Smith</strong><span>CEO & Founder - Okler</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="col-md-12">
                                        <blockquote class="testimonial">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </blockquote>
                                        <div class="testimonial-arrow-down"></div>
                                        <div class="testimonial-author">
                                            <div class="img-thumbnail img-thumbnail-small">
                                                <img src="img/clients/client-1.jpg" alt="">
                                            </div>
                                            <p><strong>John Smith</strong><span>CEO & Founder - Okler</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection