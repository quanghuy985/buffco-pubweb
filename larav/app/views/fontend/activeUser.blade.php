@extends("fontend.hometemplate")
@section("contenthomepage")
@if(isset($thongbao))
<div class="alert alert-warning" style="text-align: center;">
    <strong>Thông báo !</strong> {{$thongbao}}.
</div>
@endif
@endsection