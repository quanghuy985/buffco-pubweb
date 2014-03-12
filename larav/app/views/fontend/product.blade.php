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
                <h2>4 Columns</h2>
            </div>
        </div>
    </div>
</section>
<div class="container">

    <h2>Portfolio</h2>

    <ul class="nav nav-pills sort-source" data-sort-id="portfolio" data-option-key="filter">
        <li data-option-value="*" class="active"><a href="#">Show All</a></li>
        <li data-option-value=".websites"><a href="#">Websites</a></li>
        <li data-option-value=".logos"><a href="#">Logos</a></li>
        <li data-option-value=".brands"><a href="#">Brands</a></li>
    </ul>

    <hr />

    <div class="row">

        <ul class="portfolio-list sort-destination" data-sort-id="portfolio">
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
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
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
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
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
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
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
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
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
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
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
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
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
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
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
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
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
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
            <li class="col-md-3 isotope-item websites">
                <div class="portfolio-item img-thumbnail">
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

        </ul>
    </div>

</div>
<div class="center">

    <ul class="pagination pagination-lg">
        <li><a href="#"><i class="icon icon-chevron-left"></i></a></li>
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#"><i class="icon icon-chevron-right"></i></a></li>
    </ul>

</div>
@endsection