@extends("fontend.hometemplate")
@section("contenthomepage")
<script>
    function kiemtratenmien() {
        jQuery('#hienthongbao').css('display', 'none');
        jQuery('#ajaxloadimg').css('display', 'block');
        var request = jQuery.ajax({
            url: "{{URL::action('DomainController@postDomainCheck')}}?tenmien=" + jQuery('#temmiencheck').val() + "&duoi=" + jQuery('#duoitenmien').val(),
            type: "POST"
        });
        request.done(function(msg) {
            jQuery('#hienthongbao').css('display', 'block');
            if (msg.length < 2) {
                jQuery('#hienthongbao').removeClass('alert-success');
                jQuery('#hienthongbao').addClass('alert-warning');
                jQuery('.domaincart').html("Miễn Phí");
                jQuery('.setupdomaincart').html("Miễn Phí");
                jQuery('.amount').html(parseInt('{{$dataproductsingle->productPrice}}') + " Pcash");
                jQuery('#thongbao').html('Tên miền không đúng hoặc đã được đăng ký');
                jQuery('#ajaxloadimg').css('display', 'none');
                jQuery('#submitpocced').attr('disabled', 'disabled');
            } else {
                var getData = jQuery.parseJSON(msg);
                jQuery('#hienthongbao').removeClass('alert-warning');
                jQuery('#hienthongbao').addClass('alert-success');
                jQuery('#thongbao').html('Tên miền <strong>' + jQuery('#temmiencheck').val() + '.' + getData.extDomain + '</strong> có thể đăng ký');
                jQuery('.domaincart').html(getData.maintainCash);
                jQuery('.setupdomaincart').html(getData.setupCash);
                jQuery('.amount').html(parseInt(getData.maintainCash) + parseInt(getData.setupCash) + parseInt('{{$dataproductsingle->productPrice}}') + " Pcash");
                jQuery('#ajaxloadimg').css('display', 'none');
                jQuery('#submitpocced').removeAttr('disabled');
            }

        });
    }
    function kiemsubtratenmien() {
        jQuery('#hienthongbao').css('display', 'none');
        jQuery('#ajaxloadimg').css('display', 'block');
        var request = jQuery.ajax({
            url: "{{URL::action('DomainController@postSubDomainCheck')}}?subdomain=" + jQuery('#subdomaininput').val(),
            type: "POST",
            dataType: 'html'
        });
        request.done(function(msg) {

            if (msg != 0) {
                jQuery('.domaincart').html("Miễn Phí");
                jQuery('.setupdomaincart').html("Miễn Phí");
                jQuery('.amount').html(parseInt('{{$dataproductsingle->productPrice}}') + " Pcash");
                jQuery('#hienthongbao').css('display', 'block');
                jQuery('#hienthongbao').removeClass('alert-success');
                jQuery('#hienthongbao').addClass('alert-warning');
                jQuery('#thongbao').html('Tên miền không đúng hoặc đã được đăng ký');
                jQuery('#ajaxloadimg').css('display', 'none');
                jQuery('#submitpocced').attr('disabled', 'disabled');
            } else {
                jQuery('.domaincart').html("Miễn Phí");
                jQuery('.setupdomaincart').html("Miễn Phí");
                jQuery('.amount').html(parseInt('{{$dataproductsingle->productPrice}}') + " Pcash");
                jQuery('#hienthongbao').css('display', 'block');
                jQuery('#hienthongbao').removeClass('alert-warning');
                jQuery('#hienthongbao').addClass('alert-success');
                jQuery('#thongbao').html('Tên miền <strong>' + jQuery('#subdomaininput').val() + '.pubweb.vn</strong> có thể đăng ký');
                jQuery('#ajaxloadimg').css('display', 'none');
                jQuery('#submitpocced').removeAttr('disabled');
            }

        });
    }
    function chondomain() {
        jQuery('.domaincart').html("Miễn Phí");
        jQuery('.setupdomaincart').html("Miễn Phí");
        jQuery('.amount').html(parseInt('{{$dataproductsingle->productPrice}}') + " Pcash");
        jQuery('#submitpocced').attr('disabled', 'disabled');
        jQuery('#domainlance').css('display', 'inline-grid');
        jQuery('#subdomainlance').css('display', 'none');
        jQuery('#temmiencheck').removeAttr('disabled');
        jQuery('#duoitenmien').removeAttr('disabled');
        jQuery('#domainsubmit').removeAttr('disabled');
        jQuery('#subdomaininput').attr('disabled', 'disabled');
        jQuery('#subdomaisubmit').attr('disabled', 'disabled');
    }
    function chondubdomain() {
        jQuery('.domaincart').html("Miễn Phí");
        jQuery('.setupdomaincart').html("Miễn Phí");
        jQuery('.amount').html(parseInt('{{$dataproductsingle->productPrice}}') + " Pcash");
        jQuery('#submitpocced').attr('disabled', 'disabled');
        jQuery('#subdomainlance').css('display', 'inline-grid');
        jQuery('#domainlance').css('display', 'none');
        jQuery('#subdomaininput').removeAttr('disabled');
        jQuery('#subdomaisubmit').removeAttr('disabled');
        jQuery('#temmiencheck').attr('disabled', 'disabled');
        jQuery('#duoitenmien').attr('disabled', 'disabled');
        jQuery('#domainsubmit').attr('disabled', 'disabled');
    }
    function onchangge() {
        jQuery('#submitpocced').attr('disabled', 'disabled');
    }
</script>
<link rel="stylesheet" href="{{Asset('fontendlib/css/theme-shop.css')}}">
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{Asset('')}}">Trang chủ</a></li>
                    <li class="active">Giao diện</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Đăng ký giao diện</h2>
            </div>
        </div>
    </div>
</section>

<div role="main" class="main shop">
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                @if(isset($thongbao))
                @if($thongbao!=false)
                <div class="alert alert-warning">
                    <strong>Thông báo!</strong> {{$thongbao}}
                </div>
                @endif
                @if($thongbao==false)
                <div class="alert alert-success">
                    <strong>Thông báo !</strong> Đăng ký thành công . Vui lòng đợi chúng tôi cấu hình web cho bạn trong thời gian nhanh nhất.
                </div>
                @endif
                @endif
                <form action="{{URL::action('ProductController@postDangKyWebsite')}}" method="POST">
                    <input type="hidden" value="{{$dataproductsingle->id}}" name="idproduct" />
                    <div class="panel-group" id="accordion">   
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                        Thông tin đơn đặt hàng
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="accordion-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div>
                                                <div class="thumbnail">
                                                    <img alt="" class="img-responsive" src="{{Asset('timthumb.php')}}?src={{Asset($dataproductsingle->productUrlImage)}}&w=447&h=447&zc=0&q=100">
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="col-md-7">

                                            <div class="portfolio-info">
                                                <div class="row">
                                                    <div class="col-md-12 center">
                                                        <ul>
                                                            <li>
                                                                <i class="icon icon-calendar"></i>{{date('d F Y',$dataproductsingle->productTime)}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <h4><a href="{{URL::action('ProductController@getChiTiet')}}/{{$dataproductsingle->productSlug}}" >{{$dataproductsingle->productName}}</a></h4>
                                            <p class="taller"></p>
                                            <a href="{{$dataproductsingle->productUrlDemo}}" class="btn btn-primary btn-icon"><i class="icon icon-external-link"></i>Dùng thử</a> <span class="arrow hlb" data-appear-animation="rotateInUpLeft" data-appear-animation-delay="800"></span>

                                            <ul class="portfolio-details">
                                                <li>
                                                    <p><strong>Giá :</strong></p>
                                                    <p>@if($dataproductsingle->productPrice==0) Miễn phí @else {{number_format($dataproductsingle->productPrice,0)}} Pcash @endif</p>
                                                </li>
                                                <li>
                                                    <p><strong>Tính năng tích hợp :</strong></p>

                                                    <ul class="list list-skills icons list-unstyled list-inline">
                                                        <li><i class="icon icon-check-circle"></i> Thiết kế</li>
                                                        <li><i class="icon icon-check-circle"></i> HTML5/CSS3</li>
                                                        <li><i class="icon icon-check-circle"></i> Javascript</li>
                                                        <br/>
                                                        <li><i class="icon icon-check-circle"></i> Quản lý</li>
                                                        <li><i class="icon icon-check-circle"></i> jQuery</li>
                                                        <li><i class="icon icon-check-circle"></i> PHP</li>  
                                                    </ul>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    <h4>Lựa chọn thêm</h4> 
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <img  style="display: none;margin-bottom: 10px" class="center" id="ajaxloadimg" src="{{Asset('fontendlib/img/ajax-loader.gif')}}"/>
                                        </div>
                                        <div class="alert" id="hienthongbao" style="display: none">
                                            <strong>Thông báo !</strong> <span id="thongbao"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input  type="radio" name="domaintype" value="domain" onclick="chondomain()" >
                                        <strong>Domain</strong>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" name="domaintype" value="subdomain" onclick="chondubdomain()" checked="checked" >
                                        <strong>Subdomain</strong>
                                    </div>

                                    <table cellspacing="0" class="cart-totals">
                                        <tbody>
                                            <tr class="cart-subtotal" id="domainlance" style="display: none">
                                                <th>

                                                    <strong>Domain</strong>
                                                </th>
                                                <td>
                                                    <div class="col-md-6">
                                                        <input type="text" value="" class="form-control" name="temmiencheck" id="temmiencheck" onkeypress="onchangge()" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="duoitenmien" id="duoitenmien" disabled>
                                                            @foreach($domainlist as $domain)
                                                            <option value="{{$domain->extDomain}}" id="{{$domain->extDomain}}">{{$domain->extDomain}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-md-2">
                                                        <input disabled  type="button" value="Kiểm tra" name="proceed" id="domainsubmit"  class="btn btn-lg btn-primary" onclick="kiemtratenmien()">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="shipping" id="subdomainlance">
                                                <th>
                                                    <strong>Subdomain</strong>
                                                </th>
                                                <td>
                                                    <div class="col-md-6">
                                                        <input type="text" name="subdomaininput" id="subdomaininput" value="" onkeypress="onchangge()" class="form-control">
                                                    </div>
                                                    <div class="col-md-4" style="line-height: 45px;">
                                                        <strong>.PUBWEB.VN</strong>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="button" value="Kiểm tra" id="subdomaisubmit" name="proceed" class="btn btn-lg btn-primary" onclick="kiemsubtratenmien()">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="actions-continue">
                        <input type="submit" value="Đăng ký" name="proceed" id="submitpocced" class="btn btn-lg btn-primary push-top" disabled="">
                    </div>
                </form>
            </div>

            <div class="col-md-3">
                <h4>Tổng đơn hàng</h4>
                <table cellspacing="0" class="cart-totals">
                    <tbody>
                        <tr class="cart-subtotal">
                            <th>
                                <strong>Giao diện</strong>
                            </th>
                            <td>
                                <strong><span class="amountweb">@if($dataproductsingle->productPrice==0) Miễn phí @else {{number_format($dataproductsingle->productPrice,0)}} Pcash @endif</span></strong>
                            </td>
                        </tr>
                        <tr class="cart-subtotal">
                            <th>
                                <strong>Tên miền</strong>
                            </th>
                            <td>
                                <strong><span class="domaincart">Miễn phí</span></strong>
                            </td>
                        </tr>
                        <tr class="cart-subtotal">
                            <th>
                                <strong>Cài đặt</strong>
                            </th>
                            <td>
                                <strong><span class="setupdomaincart">Miễn phí</span></strong>
                            </td>
                        </tr>
                        <tr class="shipping">
                            <th>
                                Thuế
                            </th>
                            <td>
                                0 Pcash<input type="hidden" value="free_shipping" id="shipping_method" name="shipping_method">
                            </td>
                        </tr>
                        <tr class="shipping">
                            <th>
                                Dung lượng
                            </th>
                            <td>
                                <strong><span>200 MB</span></strong>
                            </td>
                        </tr>
                        <tr class="shipping">
                            <th>
                                Băng thông
                            </th>
                            <td>
                                <strong><span>Không giới hạn</span></strong>
                            </td>
                        </tr>
                        <tr class="total">
                            <th>
                                <strong>Tổng tiền</strong>
                            </th>
                            <td>
                                <strong><span class="amount">@if($dataproductsingle->productPrice==0) Miễn phí @else {{$dataproductsingle->productPrice}} Pcash @endif</span></strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection