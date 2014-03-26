@extends("fontend.hometemplate")
@section("contenthomepage")

<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="index.html">Trang chủ</a></li>
                    <li class="active">Lời nhắn từ Pubweb</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Pubweb</h2>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        @if(isset($thongbao))
        <div class="alert alert-warning" style="text-align: center;">
            <strong>Thông báo !</strong> {{$thongbao}}.
            <p>Bấm <a href="{{Asset('')}}"> vào đây </a> để trở lại trang chủ</p>
        </div>
        @endif
        @if(isset($chucmung))
        <div class="alert alert-success">
            <strong>Cảm ơn bạn đã quan tâm đến dịch vụ của chúng tôi!</strong> {{$chucmung}}.
            <p>Bấm <a href="{{Asset('')}}"> vào đây </a> để trở lại trang chủ</p>
        </div>
        @endif
    </div>
</div>
@endsection