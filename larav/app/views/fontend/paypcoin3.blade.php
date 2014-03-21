@extends("fontend.hometemplate")
@section("contenthomepage")
<link rel="stylesheet" href="{{Asset('fontendlib/css/theme-shop.css')}}">
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{Asset('')}}">Trang chủ</a></li>
                    <li class="active">Tài khoản</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Nạp <strong style="color: #2baab1;">Pcash</strong> vào tài khoản</h2>
            </div>
        </div>
    </div>
</section>
<div class="container">

    <div class="row" style="position: relative;">
        <div class="center">
            <img src="{{Asset('fontendlib/img/buoc3.png')}}"  style="width: 75%;"/>
        </div>
        <hr class="tall">
        <h2>Hoàn thành</h2>
        <div class="alert alert-success">
            <strong>Thông báo!</strong> {{$thongbao}}.
        </div>
    </div>

</div>
@endsection