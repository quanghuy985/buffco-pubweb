@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ ĐƠN HÀNG</h1>
    <span class="pagedesc">Quản lý đơn hàng</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Chỉnh sửa thông tin đơn hàng</h3>
        </div>
        <form class="stdform stdform2" method="post" action="@if(isset($orderdata)){{URL::action('OrderController@postEdit')}} @endif" accept-charset="UTF-8">
            <p>
                <label>Người mua</label>
                <span class="field">         
                    <input type="hidden" name="idedit" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdata)){{$orderdata->id}}@endif">
                    <input type="text" name="username" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdata)){{$orderdata->userEmail}}@endif" disabled>
                </span>
            </p>
            <p>
                <label>Tên sản phẩm</label>
                <span class="field">         
                    <input type="text" name="productname" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdata)){{$orderdata->productName}}@endif" disabled>
                </span>
            </p>
            <p>
                <label>Loại tên miền</label>
                <span class="field">         
                    <select name="domaintype" id="selection2">
                        <option value="0" @if($orderdata->domainType==0)selected @endif >Subdomain</option>
                        <option value="1" @if($orderdata->domainType==1)selected @endif >Domain</option>
                    </select>
                </span>
            </p>
            <p>
                <label>Tên miền</label>
                <span class="field">         
                    <input type="text" name="domain" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdata)){{$orderdata->domain}}@endif">
                </span>
            </p>
            <p>
                <label>Tổng tiền</label>
                <span class="field">         
                    <input type="text" name="total" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdata)){{$orderdata->orderAmount}}@endif" disabled>
                </span>
            </p>
            <p>
                <label>Hình thức thanh toán</label>
                <span class="field">         
                    <input type="text" name="paytype" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdata)){{$orderdata->orderTypePay}}@endif" disabled>
                </span>
            </p>
            <p>
                <label>Trạng thái thanh toán</label>
                <span class="field">         
                    <input type="text" name="paystatus" placeholder="Nhập trên sản phẩm" class="longinput" value="@if(isset($orderdata))@if($orderdata->orderStatusPay==0) Chưa thanh toán @else Đã thanh toán @endif@endif " disabled>
                </span>
            </p>
            <p>
                <label>Dung lượng ổ đĩa</label>
                <span class="field">         
                    <input type="text" name="diskspace" placeholder="Nhập trên sản phẩm" class="smallinput" value="@if(isset($orderdata)){{$orderdata->diskStore}}@endif"> ( {{round($orderdata->diskStore/1024/1024,2).' MB'}} )
                </span>
            </p>
            <p>
                <label>Hạn dùng</label>
                <span class="field">         
                    <input type="date" style="box-shadow: inset 0 1px 3px #ddd;border: 1px solid #ccc;border-radius: 2px;padding: 8px 5px;background: #fcfcfc;" name="expdate" placeholder="Nhập trên sản phẩm" class="smallinput" value="@if(isset($orderdata)){{date('Y-m-d',$orderdata->orderExp)}}@endif">

                </span>
            </p>

            <p>
                <label>Trạng thái</label>
                <span class="field">         

                    <select name="status" id="selection2">
                        <option value="0" @if($orderdata->status==0)selected @endif >Chờ</option>
                        <option value="1" @if($orderdata->status==1)selected @endif >Thành công</option>
                        <option value="2" @if($orderdata->status==2)selected @endif >Xóa</option>
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