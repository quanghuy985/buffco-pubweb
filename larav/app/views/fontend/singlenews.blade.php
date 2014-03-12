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
                        <span class="day">10</span>
                        <span class="month">Jan</span>
                    </div>

                    <div class="post-content">

                        <h2><a href="blog-post.html">Class aptent taciti sociosqu ad litora torquent</a></h2>

                        <div class="post-meta">
                            <span><i class="icon icon-user"></i> By <a href="#">John Doe</a> </span>
                            <span><i class="icon icon-tag"></i> <a href="#">Duis</a>, <a href="#">News</a> </span>
                            <span><i class="icon icon-comments"></i> <a href="#">12 Comments</a></span>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur lectus lacus, rutrum sit amet placerat et, bibendum nec mauris. Duis molestie, purus eget placerat viverra, nisi odio gravida sapien, congue tincidunt nisl ante nec tellus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sagittis, massa fringilla consequat blandit, mauris ligula porta nisi, non tristique enim sapien vel nisl. Suspendisse vestibulum lobortis dapibus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent nec tempus nibh. Donec mollis commodo metus et fringilla. Etiam venenatis, diam id adipiscing convallis, nisi eros lobortis tellus, feugiat adipiscing ante ante sit amet dolor. Vestibulum vehicula scelerisque facilisis. Sed faucibus placerat bibendum. Maecenas sollicitudin commodo justo, quis hendrerit leo consequat ac. Proin sit amet risus sapien, eget interdum dui. Proin justo sapien, varius sit amet hendrerit id, egestas quis mauris.</p>
                        <p>Ut ac elit non mi pharetra dictum nec quis nibh. Pellentesque ut fringilla elit. Aliquam non ipsum id leo eleifend sagittis id a lorem. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam massa mauris, viverra et rhoncus a, feugiat ut sem. Quisque ultricies diam tempus quam molestie vitae sodales dolor sagittis. Praesent commodo sodales purus. Maecenas scelerisque ligula vitae leo adipiscing a facilisis nisl ullamcorper. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>
                        <p>Curabitur non erat quam, id volutpat leo. Nullam pretium gravida urna et interdum. Suspendisse in dui tellus. Cras luctus nisl vel risus adipiscing aliquet. Phasellus convallis lorem dui. Quisque hendrerit, lectus ut accumsan gravida, leo tellus porttitor mi, ac mattis eros nunc vel enim. Nulla facilisi. Nam non nulla sed nibh sodales auctor eget non augue. Pellentesque sollicitudin consectetur mauris, eu mattis mi dictum ac. Etiam et sapien eu nisl dapibus fermentum et nec tortor.</p>
                        <p>Curabitur nec nulla lectus, non hendrerit lorem. Quisque lorem risus, porttitor eget fringilla non, vehicula sed tortor. Proin enim quam, vulputate at lobortis quis, condimentum at justo. Phasellus nec nisi justo. Ut luctus sagittis nulla at dapibus. Aliquam ullamcorper commodo elit, quis ornare eros consectetur a. Curabitur nulla dui, fermentum sed dapibus at, adipiscing eget nisi. Aenean iaculis vehicula imperdiet. Donec suscipit leo sed metus vestibulum pulvinar. Phasellus bibendum magna nec tellus fringilla faucibus. Phasellus mollis scelerisque volutpat. Ut sed molestie turpis. Phasellus ultrices suscipit tellus, ac vehicula ligula condimentum et.</p>
                        <p>Aenean metus nibh, molestie at consectetur nec, molestie sed nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec euismod urna. Donec gravida pharetra ipsum, non volutpat ipsum sagittis a. Phasellus ut convallis ipsum. Sed nec dui orci, nec hendrerit massa. Curabitur at risus suscipit massa varius accumsan. Proin eu nisi id velit ultrices viverra nec condimentum magna. Ut porta orci quis nulla aliquam at dictum mi viverra. Maecenas ultricies elit in tortor scelerisque facilisis. Mauris vehicula porttitor lacus, vel pretium est semper non. Ut accumsan rhoncus metus non pharetra. Quisque luctus blandit nisi, id tempus tellus pulvinar eu. Nam ornare laoreet mi a molestie. Donec sodales scelerisque congue. </p>

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
                <h4>Categories</h4>
                <ul class="nav nav-list primary push-bottom">
                    <li><a href="#">Design</a></li>
                    <li><a href="#">Photos</a></li>
                    <li><a href="#">Videos</a></li>
                    <li><a href="#">Lifestyle</a></li>
                    <li><a href="#">Technology</a></li>
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