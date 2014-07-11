<script>
    function xoasanpham(id) {
    jConfirm("{{Lang::get('messages.delete_confirm')}}", "{{Lang::get('messages.alert')}}", function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('vaytienController@postDeleteKhoanTinDungPhaiThu')}}?id=" + id,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableKhoanVay').html(msg);
                    jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            });
            return false;
    } else {
    return false;
    }
    });
    }

    function kichhoat(id, stus) {
    if (stus == 0) {

    var request = jQuery.ajax({
    url: "{{URL::action('vaytienController@postActiveKhoanTinDungPhaiThu')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableKhoanVay').html(msg);
                    jQuery.jGrowl("Đã tải dữ liệu thành công ...");
            });
            return true;
    } else{
    jConfirm("{{Lang::get('messages.thanhtoan_confirm')}}", "{{Lang::get('messages.alert')}}", function(r) {
    if (r == true) {
    var request = jQuery.ajax({
    url: "{{URL::action('vaytienController@postActiveKhoanTinDungPhaiThu')}}?id=" + id + '&status=' + stus,
            type: "POST",
            dataType: "html"
    });
            request.done(function(msg) {
            jQuery('#tableKhoanVay').html(msg);
                    jQuery.jGrowl("Đã tải dữ liệu thành công ...")
                    ;
            });
            return true;
    } else {
    return false;
    }
    });
    }
    }
</script>


<div class="contenttitle2">
    <h3>Thông tin tín dụng</h3>
</div>
<table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
    <colgroup>
        <col class="con1" style="width: 3%">
        <col class="con0" style="width: 12%">
        <col class="con1" style="width: 10%">
        <col class="con0" style="width: 10%">
        <col class="con1" style="width: 10%">
        <col class="con0" style="width: 7%">
        <col class="con1" style="width: 7%">
        <col class="con0" style="width: 8%">
        <col class="con1" style="width: 8%">
        <col class="con0" style="width: 10%">
        <col class="con1" style="width: 15%">

    </colgroup>
    <thead>
        <tr>
            <th class="head1"></th> 
            <th class="head0">Họ tên</th>
            <th class="head1">Miêu tả</th>
            <th class="head0">Khoản vay</th>
            <th class="head1">Thu về</th>
            <th class="head0">Chu kỳ</th>
            <th class="head1">Lãi xuất</th>
            <th class="head0">Từ ngày</th>
            <th class="head1">Đến ngày</th>
            <th class="head0">Tình trạng</th>
            <th class="head1">Chức năng</th>
        </tr>  
    </thead>

    <tbody id="tableKhoanVay"> 

        <?php $i = 1 ?>
        @if(isset($arrTinDung))
        @foreach($arrTinDung as $itemKhoanVay)
        <tr> 
            <td>{{$i}}</td> 
            <td><label value="manuf"><a style="color: blue" href="{{URL::action('vaytienController@getKhoanVayChiTietByUserID')}}?userid={{$itemKhoanVay->userID}}">{{str_limit( $itemKhoanVay->userLastName.' '.$itemKhoanVay->userFirstName, 30, '...')}}</a></label></td> 
            <td><label value="manuf">{{str_limit( $itemKhoanVay->vaytienDescription, 30, '...')}}</label></td> 
            <td><label value="manuf">{{number_format($itemKhoanVay->giatri,0,'.', ',')}} VNĐ </label></td> 
            <td><label value="manuf">{{number_format($itemKhoanVay->thuve,0,'.', ',')}} VNĐ </label></td> 
            <td><label value="manuf">{{str_limit($itemKhoanVay->chuky, 30, '...')}} ngày </label></td> 
            <td><label value="manuf">{{number_format($itemKhoanVay->laixuat,0,'.', ',')}}/ 1 triệu </label></td> 
            <td><label value="manuf"></label><?php echo date('d/m/Y', $itemKhoanVay->from); ?></td> 
            <td><label value="manuf"></label><?php echo date('d/m/Y', $itemKhoanVay->to); ?></td>
            <td><label value="manuf">
                    <?php
                    if ($itemKhoanVay->status == 0) {
                        echo "Chưa hết";
                    } else if ($itemKhoanVay->status == 1) {
                        echo "Đã hết";
                    } else if ($itemKhoanVay->status == 2) {
                        echo "Xóa";
                    } else if ($itemKhoanVay->status == 3) {
                        echo "Nợ xấu";
                    }
                    ?>
                </label>
            </td> 
            <td>
                <a href="{{URL::action('vaytienController@getKhoanVayEdit')}}?id={{$itemKhoanVay->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                @if($itemKhoanVay->status=='2')
                <a href="javascript: void(0)" onclick="kichhoat({{$itemKhoanVay->id}}, 0)" class="btn btn4 btn_flag" title="Bỏ xóa"></a>
                @endif
                @if($itemKhoanVay->status=='0')
                <a href="javascript: void(0)" onclick="kichhoat({{$itemKhoanVay->id}}, 1)" class="btn btn4 btn_world" title="Thanh toán"></a>
                @endif
                @if($itemKhoanVay->status!='2')
                <a href="javascript: void(0)" onclick="xoasanpham({{$itemKhoanVay->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                @endif
            </td> 
        </tr> 
        <?php $i++ ?>
        @endforeach

        @endif
    </tbody>
</table>