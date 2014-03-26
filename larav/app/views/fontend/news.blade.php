@extends("fontend.hometemplate")
@section("contenthomepage")
<script>
    function phantrang(page) {
        var request = jQuery.ajax({
            url: "{{URL::action('NewsController@postPhantrang')}}?slug={{$catname->catenewsSlug}}&page=" + page,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('.blog-posts').html(msg);
        });
    }
</script>
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="#">Blog</a></li>
                    <li class="active">Medium Image</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>{{$catname->catenewsName}}</h2>
            </div>
        </div>
    </div>
</section>

<div class="container">

    <div class="row">
        <div class="col-md-9">
            <div class="blog-posts">

                <?php

                function catch_that_image($post) {
                    $first_img = '';
                    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post, $matches);


                    if ($matches[1] == NULL || $matches[1] == '') {
                        $first_img = Asset('') . "/fontendlib/img/defau.jpg";
                    } else {
                        $first_img = $matches[1][0];
                    }
                    if ($first_img == NULL || $first_img == '') {
                        $first_img = Asset('') . "/fontendlib/img/defau.jpg";
                    }
                    return $first_img;
                }
                ?>
                @foreach($datanews as $item) 
                <article class="post post-medium">
                    <div class="row">

                        <div class="col-md-5">
                            <div class="post-image"> 
                                <div>
                                    <div class="img-thumbnail">
                                        <img title="{{$item->newsName}}" class="img-responsive" src="{{Asset('timthumb.php')}}?src={{catch_that_image($item->newsContent)}}&w=325&h=200&zc=0&q=100" alt="{{$item->newsName}}">
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-7">

                            <div class="post-content">

                                <h2><a href="{{URL::action('NewsController@getBaiViet')}}/{{$item->newsSlug}}">{{$item->newsName}}</a></h2>
                                <p>{{str_limit($item->newsDescription, 250, ' [...]')}}</p>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="post-meta">
                                <span><i class="icon icon-calendar"></i>{{date(' F d , Y ',$item->newsTime)}}</span>
                                <span><i class="icon icon-tag"></i>{{$item->newsTag}}</span>                     
                                <a href="{{URL::action('NewsController@getBaiViet')}}/{{$item->newsSlug}}" class="btn btn-xs btn-primary pull-right">Chi tiết...</a>
                            </div>
                        </div>
                    </div>

                </article>
                @endforeach
                @if($pargion!='')
                {{$pargion}}
                @endif


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