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
    <form action="{{URL::action('NapTienController@postNapTien')}}" method="POST">
        <div class="row" style="position: relative;">
            <div class="center">
                <img src="{{Asset('fontendlib/img/buoc2.png')}}"  style="width: 75%;"/>
            </div>
            <hr class="tall">
            <h2>Chọn Hình thức thanh toán</h2>
            <div role="main" class="main shop">
                <div class="col-md-8">
                    <table cellspacing="0" class="tables">
                        <tr>
                            <td class="col-md-4">
                                <input type="radio" name="hinhthucthanhtoan" id="hinhthucthanhtoan" value="nganluong" checked="">
                                <img src="{{Asset('fontendlib/img/nganluong.png')}}"  style="width: 60%;"/>
                            </td>

                            <td class="col-md-4">      <input type="radio" name="hinhthucthanhtoan" id="hinhthucthanhtoan" value="baokim">
                                <img src="{{Asset('fontendlib/img/baokim.png')}}"  style="width: 90%;"/>
                            <td class="col-md-4"></td>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <h4>Chi tiết đơn hàng</h4>
                    <table cellspacing="0" class="cart-totals">
                        <tbody>
                            <tr class="cart-subtotal">
                                <th>
                                    <strong>Giá tiền</strong>
                                </th>
                                <td>
                                    <strong><span class="amount">{{$tienthanhtoan}}.000 VNĐ</span></strong>
                                </td>
                            </tr>
                            <tr class="shipping">
                                <th>
                                    Khuyến mại
                                </th>
                                <td>
                                    @if($tienthanhtoan==500)75.000 VNĐ @endif
                                    @if($tienthanhtoan==200)20.000 VNĐ @endif
                                    @if($tienthanhtoan==100)5.000 VNĐ @endif
                                    @if($tienthanhtoan==50)0.000 VNĐ @endif
                                </td>
                            </tr>
                            <tr class="total">
                                <th>
                                    <strong>Thành tiền</strong>
                                </th>
                                <td>
                                    <strong><span class="amount">
                                            @if($tienthanhtoan==500)425.000 VNĐ @endif
                                            @if($tienthanhtoan==200)180.000 VNĐ @endif
                                            @if($tienthanhtoan==100)95.000 VNĐ @endif
                                            @if($tienthanhtoan==50)50.000 VNĐ @endif
                                            <input type="hidden" value=" @if($tienthanhtoan==500){{md5(425000)}}@endif
                                                   @if($tienthanhtoan==200){{md5(180000)}} @endif
                                                   @if($tienthanhtoan==100){{md5(95000)}} @endif
                                                   @if($tienthanhtoan==50){{md5(50000)}} @endif" name="tongtien"/>
                                        </span></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row" style="position: relative;">
            <button type="button" class="btn btn-warning" onclick="return window.location.href = '{{URL::action('NapTienController@getNapTien')}}';">Trở lại bước một</button>
            <button type="submit" class="btn btn-success" >Tiếp tục thanh toán</button>
        </div>
    </form>
</div>
@endsection