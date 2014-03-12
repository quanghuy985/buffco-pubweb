@extends("fontend.hometemplate")
@section("contenthomepage")
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{Asset('')}}">Home</a></li>
                    <li class="active">Pages</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>404 - Page Not Found</h2>
            </div>
        </div>
    </div>
</section>
<div class="container">

    <section class="page-not-found">
        <div class="row">
            <div>
                <div class="page-not-found-main">
                    <h2>404 <i class="icon icon-file"></i></h2>
                    <p>We're sorry, but the page you were looking for doesn't exist.</p>
                </div>
            </div> 
        </div>
    </section>

</div>
@endsection