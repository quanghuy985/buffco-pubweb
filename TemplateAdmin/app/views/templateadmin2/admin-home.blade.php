@extends("templateadmin2.mainfire")
@section("contentadmin")
@if(isset($thongbao))
<div class="pageheader notab">
    <h1 class="pagetitle">TRANG CHỦ QUẢN TRỊ</h1>
    <span class="pagedesc">Quản trị</span>
</div>

<div class="contentwrapper">
    <div class="notibar msginfo">
        <a class="close"></a>
        <p>
            {{$thongbao}}
        </p>
    </div>
</div>
@endif
@endsection