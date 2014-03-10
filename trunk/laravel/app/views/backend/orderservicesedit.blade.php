@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ ĐƠN HÀNG DỊCH VỤ</h1>
    <span class="pagedesc">Quản lý đơn hàng</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Chỉnh sửa thông tin đơn hàng dịch vụ</h3>
        </div>
        <form class="stdform stdform2" method="post" action="@if(isset($orderdataedit)){{URL::action('OrderController@postOderServicesEdit')}} @endif" accept-charset="UTF-8">
            <p>
                <label>Người mua</label>
                <span class="field">         
                    <input type="hidden" name="idedit" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdataedit)){{$orderdataedit->id}}@endif">
                    <input type="text" name="username" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdataedit)){{$orderdataedit->userEmail}}@endif" disabled>
                </span>
            </p>
            <p>
                <label>Dịch vụ</label>
                <span class="field">                      
                    <input type="text" name="username" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdataedit)){{$orderdataedit->servicesName}}@endif" disabled>
                </span>
            </p>
            <p>
                <label>Mã đơn hàng sản phẩm</label>
                <span class="field">         
                    <a href="{{URL::action('OrderController@getEdit')}}/{{$orderdataedit->orderID}}" >  @if(isset($orderdataedit)){{$orderdataedit->orderID}}@endif</a>
                </span>
            </p>
            <p>
                <label>Tổng tiền</label>
                <span class="field">         
                    <input type="text" name="total" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdataedit)){{$orderdataedit->servicesorderAmount}}@endif" disabled>
                </span>
            </p>
            <p>
                <label>Hình thức thanh toán</label>
                <span class="field">         
                    <input type="text" name="paytype" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdataedit)){{$orderdataedit->servicesorderTypePay}}@endif" disabled>
                </span>
            </p>
            <p>
                <label>Trạng thái thanh toán</label>
                <span class="field">         
                    <input type="text" name="paystatus" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdataedit))@if($orderdataedit->servicesorderStatusPay==0) Chưa thanh toán @else Đã thanh toán @endif@endif " disabled>
                </span>
            </p>
            <p>
                <label>Thời gian</label>
                <span class="field">         
                    <input type="date" style="box-shadow: inset 0 1px 3px #ddd;border: 1px solid #ccc;border-radius: 2px;padding: 8px 5px;background: #fcfcfc;" name="expdate" placeholder="Nhập trên sản phẩm" class="smallinput" value="@if(isset($orderdataedit)){{date('Y-m-d',$orderdataedit->servicesorderTime)}}@endif" disabled>

                </span>
            </p>

            <p>
                <label>Trạng thái</label>
                <span class="field">         

                    <select name="status" id="selection2">
                        <option value="0" @if($orderdataedit->status==0)selected @endif >Chờ</option>
                        <option value="1" @if($orderdataedit->status==1)selected @endif >Thành công</option>
                        <option value="2" @if($orderdataedit->status==2)selected @endif >Xóa</option>
                    </select>
                </span>
            </p>
            <p class="stdformbutton">
                <button class="submit radius2">Cập nhật</button>
                <input type="reset" class="reset radius2" value="Làm lại">
            </p>
        </form>
    </div>
</div>
@endsection