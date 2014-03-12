@extends("fontend.hometemplate")
@section("contenthomepage")
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Portfolio</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Single Project</h2>
            </div>
        </div>
    </div>
</section>

<div class="container">

    <div class="portfolio-title">
        <div class="row">
            <div class="portfolio-nav-all col-md-1">
                <a href="portfolio-single-project.html" rel="tooltip" data-original-title="Back to list"><i class="icon icon-th"></i></a>
            </div>
            <div class="col-md-9 center">
                <h2 class="shorter">Lorem Ipsum Dolor</h2>
            </div>
            <div class="portfolio-nav col-md-2">
                <button type="button" class="btn btn-primary" onclick="return window.location.href = '#';">Đăng ký ngay</button>
            </div>
        </div>
    </div>

    <hr class="tall">

    <div class="row">
        <div class="col-md-4">

            <div class="owl-carousel" data-plugin-options='{"items": 1, "autoHeight": true}'>
                <div>
                    <div class="thumbnail">
                        <img alt="" class="img-responsive" src="{{Asset('fontendlib/img/projects/project.jpg')}}">
                    </div>
                </div>
                <div>
                    <div class="thumbnail">
                        <img alt="" class="img-responsive" src="{{Asset('fontendlib/img/projects/project-1.jpg')}}">
                    </div>
                </div>
                <div>
                    <div class="thumbnail">
                        <img alt="" class="img-responsive" src="{{Asset('fontendlib/img/projects/project-2.jpg')}}">
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-8">

            <div class="portfolio-info">
                <div class="row">
                    <div class="col-md-12 center">
                        <ul>
                            <li>
                                <a href="#" rel="tooltip" data-original-title="Like"><i class="icon icon-heart"></i>14</a>
                            </li>
                            <li>
                                <i class="icon icon-calendar"></i> 21 November 2013
                            </li>
                            <li>
                                <i class="icon icon-tags"></i> <a href="#">Brand</a>, <a href="#">Design</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <h4>Project <strong>Description</strong></h4>
            <p class="taller">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus nibh sed elimttis adipiscing. Fusce in hendrerit purus. Suspendisse potenti. Proin quis eros odio, dapibus dictum mauris. Donec nisi libero, adipiscing id pretium eget, consectetur sit amet leo. Nam at eros quis mi egestas fringilla non nec purus.</p>

            <a href="#" class="btn btn-primary btn-icon"><i class="icon icon-external-link"></i>Live Preview</a> <span class="arrow hlb" data-appear-animation="rotateInUpLeft" data-appear-animation-delay="800"></span>

            <ul class="portfolio-details">
                <li>
                    <p><strong>Skills:</strong></p>

                    <ul class="list list-skills icons list-unstyled list-inline">
                        <li><i class="icon icon-check-circle"></i> Design</li>
                        <li><i class="icon icon-check-circle"></i> HTML/CSS</li>
                        <li><i class="icon icon-check-circle"></i> Javascript</li>
                        <li><i class="icon icon-check-circle"></i> Backend</li>
                    </ul>
                </li>
                <li>
                    <p><strong>Client:</strong></p>
                    <p>Okler Themes</p>
                </li>
            </ul>

        </div>
    </div>

    <hr class="tall" />

    <div class="row">

        <div class="col-md-12">
            <h3>Related <strong>Work</strong></h3>
        </div>

        <ul class="portfolio-list">
            <li class="col-md-3">
                <div class="portfolio-item thumbnail">
                    <a href="portfolio-single-project.html" class="thumb-info">
                        <img alt="" class="img-responsive" src="{{Asset('fontendlib/img/projects/project.jpg')}}">
                        <span class="thumb-info-title">
                            <span class="thumb-info-inner">SEO</span>
                            <span class="thumb-info-type">Website</span>
                        </span>
                        <span class="thumb-info-action">
                            <span title="Universal" href="#" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
                        </span>
                    </a>
                </div>
            </li>
            <li class="col-md-3">
                <div class="portfolio-item thumbnail">
                    <a href="portfolio-single-project.html" class="thumb-info">
                        <img alt="" class="img-responsive" src="{{Asset('fontendlib/img/projects/project-1.jpg')}}">
                        <span class="thumb-info-title">
                            <span class="thumb-info-inner">Okler</span>
                            <span class="thumb-info-type">Brand</span>
                        </span>
                        <span class="thumb-info-action">
                            <span title="Universal" href="#" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
                        </span>
                    </a>
                </div>
            </li>
            <li class="col-md-3">
                <div class="portfolio-item thumbnail">
                    <a href="portfolio-single-project.html" class="thumb-info">
                        <img alt="" class="img-responsive" src="{{Asset('fontendlib/img/projects/project-2.jpg')}}">
                        <span class="thumb-info-title">
                            <span class="thumb-info-inner">The Fly</span>
                            <span class="thumb-info-type">Logo</span>
                        </span>
                        <span class="thumb-info-action">
                            <span title="Universal" href="#" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
                        </span>
                    </a>
                </div>
            </li>
            <li class="col-md-3">
                <div class="portfolio-item thumbnail">
                    <a href="portfolio-single-project.html" class="thumb-info">
                        <img alt="" class="img-responsive" src="{{Asset('fontendlib/img/projects/project-3.jpg')}}">
                        <span class="thumb-info-title">
                            <span class="thumb-info-inner">The Code</span>
                            <span class="thumb-info-type">Website</span>
                        </span>
                        <span class="thumb-info-action">
                            <span title="Universal" href="#" class="thumb-info-action-icon"><i class="icon icon-link"></i></span>
                        </span>
                    </a>
                </div>
            </li>
        </ul>

    </div>

</div>
@endsection