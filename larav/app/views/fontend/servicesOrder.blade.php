@extends("fontend.hometemplate")
@section("contenthomepage")

<link rel="stylesheet" href="{{Asset('fontendlib/css/theme-shop.css')}}">
<script>

    function getQuangCao() {
        var request = jQuery.ajax({
            url: "{{URL::action('ServicesController@postAdvertising')}}?domain=" + jQuery('#domain').val(),
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            if (msg == 'TRUE') {
                jQuery('#txtquangcao').hide();
                document.getElementById("cbadvertising").checked = false;
                document.getElementById("cbadvertising").disabled = false;
            } else {
                jQuery('#txtquangcao').show();
                document.getElementById("cbadvertising").checked = false;
                document.getElementById("cbadvertising").disabled = false;
            }
        });
    }
    function getDonGia() {
        var request = jQuery.ajax({
            url: "{{URL::action('ServicesController@postServicesPrices')}}?id=" + jQuery('#diskStore').val(),
            type: "POST"
        });
        request.done(function(msg) {
            if (msg != 'FALSE') {
                var data = jQuery.parseJSON(msg);
                //alert(parseInt(data.servicesPrices));
                jQuery('#gia').text(parseInt(data.servicesPrices));
                jQuery('#khuyenmai').text(parseInt(data.servicesPromotion));
                jQuery('#giasaucung').text(parseInt(data.servicesPrices) - parseInt(data.servicesPromotion));
                if (jQuery('#cbadvertising').is(':checked')) {
                    // alert('checked');
                    jQuery('#tongtien').text((parseInt(jQuery('#giasaucung').text()) * parseInt(jQuery('#months').val()) + parseInt(jQuery('#cbadvertising').val())) + ' Pcash');
                } else {
                    jQuery('#tongtien').text((parseInt(jQuery('#giasaucung').text()) * parseInt(jQuery('#months').val())) + ' Pcash');
                }
            } else {

            }
        });
    }
</script>
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="index.html">Trang chủ</a></li>
                    <li class="active">Thanh toán dịch vụ</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Thanh toán</h2>
            </div>
        </div>
    </div>
</section>
<div role="main" class="main shop"> 
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        Thông tin thanh toán
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="accordion-body collapse in" style="height: auto;">
                <div class="panel-body">
                    <hr class="tall">
                    <h4>Thông tin hóa đơn</h4>
                    <form action="{{URL::action('ServicesCheckOutController@postServicesCheckOut')}}" method="POST">
                        <table cellspacing="0" class="cart-totals">
                            <tbody>
                                <tr class="cart-subtotal">
                                    <th>
                                        <strong>Họ và tên :</strong>
                                    </th>
                                    <td>
                                        {{$objusers[0]->userFirstName.' '.$objusers[0]->userLastName}}
                                    </td>
                                </tr>
                                <tr class="cart-subtotal">
                                    <th>
                                        <strong>Domain :</strong>
                                    </th>
                                    <td> 
                                        @if (isset($arrayOrder))

                                        <select data-msg-required="Please enter the subject."  class="form-control" name="domain" id="domain" onchange="getQuangCao()">
                                            <?php
                                            foreach ($arrayOrder as $item) {
                                                if ($item->status == 1) {
                                                    echo '<option  value="' . $item->domain . '">' . $item->domain . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>

                                        @endif
                                    </td>
                                </tr>
                                <tr class="cart-subtotal">
                                    <th>
                                        <strong>Dung lượng :</strong>
                                    </th>

                                    <td>
                                        <select data-msg-required="Please enter the subject."  class="form-control" name="diskStore" id="diskStore" onchange="getDonGia()">
                                            <?php
                                            foreach ($objservices as $item1) {
                                                if ($item1->status == 1) {
                                                    echo '<option  value="' . $item1->servicesSlug . '">' . $item1->servicesName . ' MB' . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>

                                </tr>
                                <tr class="cart-subtotal">
                                    <th>
                                        <strong>Đơn giá :</strong>
                                    </th>
                                    <td>
                                        <span class="amount" id="gia"  >@if(isset($objservices)){{$objservices[0]->servicesPrices}}@endif </span> <label> Pcash/ 1 tháng</label> 
                                    </td>

                                </tr>
                                <tr class="cart-subtotal">
                                    <th>
                                        <strong>Khuyến mại :</strong>
                                    </th>
                                    <td>
                                        <span class="amount" id="khuyenmai" >@if(isset($objservices)){{$objservices[0]->servicesPromotion}}@endif </span> <label> Pcash/ 1 tháng</label>
                                    </td>

                                </tr>
                                <tr class="cart-subtotal">
                                    <th>
                                        <strong>Giá sau khuyến mại :</strong>
                                    </th>
                                    <td>
                                        <span class="amount" id="giasaucung" >@if(isset($objservices)){{$objservices[0]->servicesPrices - $objservices[0]->servicesPromotion}}@endif </span> <label>Pcash/ 1 tháng</label>
                                    </td>

                                </tr>
                                <tr class="cart-subtotal">
                                    <th>
                                        <strong>Giải pháp :</strong>
                                    </th>
                                    <td> 
                                        <select data-msg-required="Please enter the subject."  class="form-control" name="select-months" id="months">

                                            <option value="3">3 Tháng</option>
                                            <option value="6">6 Tháng</option>
                                            <option value="11">12 Tháng</option>
                                            <option value="22">24 Tháng</option>
                                        </select>
                                    </td>

                                </tr>
                                <tr class="cart-subtotal" id='txtquangcao'>
                                    <th>
                                        <input @if (isset($arrayOrder) && $arrayOrder[0]->advertising == 1) checked='checked' disabled='disabled' @endif type="checkbox" name="cbadvertising" id="cbadvertising" value="500"><strong> Gỡ bỏ quảng cáo</strong>
                                    </th>
                                    <td>
                                        <span class="amount" id="quangcao">500.000 VND</span>
                                    </td>
                                </tr>

                                <tr class="total">
                                    <th>
                                        <strong>Tổng tiền</strong>
                                    </th>
                                    <td>
                                        <strong><span class="amount" id="tongtien"></span></strong>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <hr class="tall">
                        <div class="actions-continue">
                            <input type="submit" value="Thanh Toán" name="proceed" class="btn btn-lg btn-primary push-top">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

