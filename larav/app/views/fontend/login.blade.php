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
                            <h4>I'm a Returning Customer</h4>
                            <form action="" id="" type="post">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Username or E-mail Address</label>
                                            <input type="text" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <a class="pull-right" href="#">(Lost Password?)</a>
                                            <label>Password</label>
                                            <input type="password" value="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="remember-box checkbox">
                                            <label for="rememberme">
                                                <input type="checkbox" id="rememberme" name="rememberme">Remember Me
                                            </label>
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" value="Login" class="btn btn-primary pull-right push-bottom" data-loading-text="Loading...">
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