@extends("fontend.hometemplate")
@section("contenthomepage")
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Pages</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Login</h2>
            </div>
        </div>
    </div>
</section>

<div class="container">

    <div class="row">
        <div class="col-md-12">

            <div class="row featured-boxes login">
                <div class="col-md-6">
                    <div class="featured-box featured-box-secundary default info-content">
                        <div class="box-content">
                            <h4>Register An Account</h4>
                            <form action="" id="" type="post">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>E-mail Address</label>
                                            <input type="text" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label>Password</label>
                                            <input type="password" value="" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Re-enter Password</label>
                                            <input type="password" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" value="Register" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading...">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection