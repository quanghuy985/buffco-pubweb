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
                         data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-title-border.png')}}" alt="Ảnh slide"></div>

                    <div class="tp-caption top-label lfl stl"
                         data-x="122"
                         data-y="180"
                         data-speed="300"
                         data-start="500"
                         data-easing="easeOutExpo">Bạn cần một website</div>

                    <div class="tp-caption sft stb visible-lg"
                         data-x="360"
                         data-y="180"
                         data-speed="300"
                         data-start="1000"
                         data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-title-border.png')}}" alt="Ảnh slide"></div>

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
                         data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-1.png')}}" alt="Ảnh slide"></div>

                    <div class="tp-caption sfb"
                         data-x="850"
                         data-y="200"
                         data-speed="400"
                         data-start="3000"
                         data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-2.png')}}" alt="Ảnh slide"></div>

                    <div class="tp-caption sfb"
                         data-x="820"
                         data-y="170"
                         data-speed="700"
                         data-start="3150"
                         data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-3.png')}}" alt="Ảnh slide"></div>

                    <div class="tp-caption sfb"
                         data-x="770"
                         data-y="130"
                         data-speed="1000"
                         data-start="3250"
                         data-easing="easeOutBack"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-4.png')}}" alt="Ảnh slide"></div>

                    <div class="tp-caption sfb"
                         data-x="500"
                         data-y="80"
                         data-speed="600"
                         data-start="3450"
                         data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-concept-2-5.png')}}" alt="Ảnh slide"></div>

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
                         data-easing="easeOutExpo"><img src="{{Asset('fontendlib/img/slides/slide-concept.png')}}" alt="Ảnh slide"></div>

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
                    Pubweb luôn
                    <strong class="inverted">
                        <span class="word-rotate">
                            <span class="word-rotate-items">
                                <span>lắng nghe</span>
                                <span>chia sẻ</span>
                                <span>đồng hành</span>
                            </span>
                        </span>
                    </strong>
                    với sự phát triển của bạn.
                </h2>
                <p class="featured lead">
                    Chúng tôi mang tới một khái niệm mới về website thương mại điện tử. Ngày xưa khi nghĩ đến thương mại điện tử nhiều
                    người nghĩ đến sự đầu tư tốn kém , khó sử dụng , nay với phương châm "khách hàng là bạn đồng hành" chúng tôi
                    mang tới cho các bạn dịch vụ tốt nhất , nhanh nhất , dễ sử dụng nhất và đặc biệt giá rẻ nhất.
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
                        <strong>Đăng ký</strong>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="process-image" data-appear-animation="bounceIn" data-appear-animation-delay="200">
                        <img src="{{Asset('fontendlib/img/home-concept-item-2.png')}}" alt="" />
                        <strong>Chọn Theme</strong>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="process-image" data-appear-animation="bounceIn" data-appear-animation-delay="400">
                        <img src="{{Asset('fontendlib/img/home-concept-item-3.png')}}" alt="" />
                        <strong>Xây dựng</strong>
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
                        <strong class="our-work">Thưởng thức</strong>
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
                            <h2>Tin tức <strong>mới</strong> nhất</h2>
                            <div class="row">
                                <div class="owl-carousel" data-plugin-options='{"items": 1, "autoHeight": true}'>
                                    <div>
                                        <?php $biendem = 0; ?>
                                        @foreach($baiviet as $item)
                                        <?php $biendem ++; ?>
                                        @if($biendem==1 || $biendem==2)
                                        <div class="col-md-6">
                                            <article>
                                                <div class="date">
                                                    <span class="day">{{date('d',$item->newsTime)}}</span>
                                                    <span class="month">{{date('M',$item->newsTime)}}</span>
                                                </div>
                                                <h4><a href="{{URL::action('NewsController@getBaiViet')}}/{{$item->newsSlug}}">{{$item->newsName}}</a></h4>
                                                <p>{{str_limit($item->newsDescription,150,' ...')}}<a href="{{URL::action('NewsController@getBaiViet')}}/{{$item->newsSlug}}" class="read-more">đọc tiếp <i class="icon icon-angle-right"></i></a></p>
                                            </article>
                                        </div>
                                        @endif
                                        @endforeach   
                                    </div>
                                    <div>
                                        <?php $biendem = 0; ?>
                                        @foreach($baiviet as $item)
                                        <?php $biendem ++; ?>
                                        @if($biendem==3 || $biendem==4)
                                        <div class="col-md-6">
                                            <article>
                                                <div class="date">
                                                    <span class="day">{{date('d',$item->newsTime)}}</span>
                                                    <span class="month">{{date('M',$item->newsTime)}}</span>
                                                </div>
                                                <h4><a href="{{URL::action('NewsController@getBaiViet')}}/{{$item->newsSlug}}">{{$item->newsName}}</a></h4>
                                                <p>{{str_limit($item->newsDescription,150,' ...')}}<a href="{{URL::action('NewsController@getBaiViet')}}/{{$item->newsSlug}}" class="read-more">đọc tiếp <i class="icon icon-angle-right"></i></a></p>
                                            </article>
                                        </div>
                                        @endif
                                        @endforeach   
                                    </div>
                                    <div>
                                        <?php $biendem = 0; ?>
                                        @foreach($baiviet as $item)
                                        <?php $biendem ++; ?>
                                        @if($biendem==5 || $biendem==6)
                                        <div class="col-md-6">
                                            <article>
                                                <div class="date">
                                                    <span class="day">{{date('d',$item->newsTime)}}</span>
                                                    <span class="month">{{date('M',$item->newsTime)}}</span>
                                                </div>
                                                <h4><a href="{{URL::action('NewsController@getBaiViet')}}/{{$item->newsSlug}}">{{$item->newsName}}</a></h4>
                                                <p>{{str_limit($item->newsDescription,150,' ...')}}<a href="{{URL::action('NewsController@getBaiViet')}}/{{$item->newsSlug}}" class="read-more">đọc tiếp <i class="icon icon-angle-right"></i></a></p>
                                            </article>
                                        </div>
                                        @endif
                                        @endforeach   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2>Khách hàng nói gì ?</h2>
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
                                                <img src="{{Asset('fontendlib')}}/img/clients/client-1.jpg" alt="">
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
                                                <img src="{{Asset('fontendlib')}}/img/clients/client-1.jpg" alt="">
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
                                                <img src="{{Asset('fontendlib')}}/img/clients/client-1.jpg" alt="">
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