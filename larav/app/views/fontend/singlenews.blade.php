@extends("fontend.hometemplate")
@section("contenthomepage")
<link rel="stylesheet" href="{{Asset('fontendlib/css/theme-blog.css')}}" media="screen">
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="#">Blog</a></li>
                    <li class="active">Blog Post</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Blog</h2>
            </div>
        </div>
    </div>
</section>

<div class="container">

    <div class="row">
        <div class="col-md-9">
            <div class="blog-posts single-post">

                <article class="post post-large blog-single-post">

                    <div class="post-date">
                        <span class="day">{{date('d',$datanews->newsTime)}}</span>
                        <span class="month">{{date('M',$datanews->newsTime)}}</span>
                    </div>

                    <div class="post-content">

                        <h2><a href="blog-post.html">{{$datanews->newsName}}</a></h2>

                        <div class="post-meta">
                            <span><i class="icon icon-user"></i><a href="{{Asset('')}}">Pubweb.vn</a> </span>
                            <span><i class="icon icon-tag"></i> {{$datanews->newsTag}} </span>
                        </div>

                        <p>
                            {{$datanews->newsContent}}
                        </p>
                    </div>
                </article>
                <article class="post post-large blog-single-post">
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
                    <div class="fb-comments" data-href="http://example.com/comments" data-numposts="10" data-colorscheme="light"></div>
                </article>
            </div>
        </div>

        <div class="col-md-3">
            <aside class="sidebar">
                <h4>Chuyên mục</h4>
                <ul class="nav nav-list primary push-bottom">
                    @foreach($catelist as $itemcate)
                    <li><a href="{{URL::action('NewsController@getChuyenMuc')}}/{{$itemcate->catenewsSlug}}">{{$itemcate->catenewsName}}</a></li>
                    @endforeach
                </ul>

                <div class="tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#popularPosts" data-toggle="tab"><i class="icon icon-star"></i> Popular</a></li>
                        <li><a href="#recentPosts" data-toggle="tab">Recent</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="popularPosts">
                            <ul class="simple-post-list">
                                <li>
                                    <div class="post-image">
                                        <div class="img-thumbnail">
                                            <a href="blog-single.html">
                                                <img src="img/blog/blog-thumb-1.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="post-info">
                                        <a href="blog-single.html">Nullam Vitae Nibh Un Odiosters</a>
                                        <div class="post-meta">
                                            Jan 10, 2013
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">
                                        <div class="img-thumbnail">
                                            <a href="blog-single.html">
                                                <img src="img/blog/blog-thumb-2.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="post-info">
                                        <a href="blog-single.html">Vitae Nibh Un Odiosters</a>
                                        <div class="post-meta">
                                            Jan 10, 2013
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">
                                        <div class="img-thumbnail">
                                            <a href="blog-single.html">
                                                <img src="img/blog/blog-thumb-3.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="post-info">
                                        <a href="blog-single.html">Odiosters Nullam Vitae</a>
                                        <div class="post-meta">
                                            Jan 10, 2013
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="recentPosts">
                            <ul class="simple-post-list">
                                <li>
                                    <div class="post-image">
                                        <div class="img-thumbnail">
                                            <a href="blog-single.html">
                                                <img src="img/blog/blog-thumb-2.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="post-info">
                                        <a href="blog-single.html">Vitae Nibh Un Odiosters</a>
                                        <div class="post-meta">
                                            Jan 10, 2013
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">
                                        <div class="img-thumbnail">
                                            <a href="blog-single.html">
                                                <img src="img/blog/blog-thumb-3.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="post-info">
                                        <a href="blog-single.html">Odiosters Nullam Vitae</a>
                                        <div class="post-meta">
                                            Jan 10, 2013
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-image">
                                        <div class="img-thumbnail">
                                            <a href="blog-single.html">
                                                <img src="img/blog/blog-thumb-1.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="post-info">
                                        <a href="blog-single.html">Nullam Vitae Nibh Un Odiosters</a>
                                        <div class="post-meta">
                                            Jan 10, 2013
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <hr />

                <h4>About Us</h4>
                <p>Nulla nunc dui, tristique in semper vel, congue sed ligula. Nam dolor ligula, faucibus id sodales in, auctor fringilla libero. Nulla nunc dui, tristique in semper vel. Nam dolor ligula, faucibus id sodales in, auctor fringilla libero. </p>

            </aside>
        </div>
    </div>

</div>

@endsection