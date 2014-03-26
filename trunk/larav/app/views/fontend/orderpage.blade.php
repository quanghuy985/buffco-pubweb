<script>
    function phantrang(page) {
        jQuery('.loader-ajax').css('display', 'block');
        var request = jQuery.ajax({
            url: "{{URL::action('AccountController@postAjaxOrder')}}?page=" + page,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#order').html(msg);
            jQuery('.loader-ajax').css('display', 'none');
        });
    }
</script>
<div id="divtableOrder">
      @if(count($dataOrder)==0)
    <p> Bạn chưa chọn mua gói dịch vụ nào. Bấm vào <a href="#">đây</a> để tới trang sản phẩm</p>
    @endif
    @if(count($dataOrder)>0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 30px !important;">
                    STT
                </th>
                <th>
                    Tên miền
                </th>
                <th>
                    Lưu lượng
                </th>         
                <th>
                    Ngày đăng ký
                </th>     
                <th>
                    Ngày hết hạn
                </th>    
<!--                <th>
                    Trạng thái
                </th>  -->
            </tr>
        </thead>
        <tbody id="hisTable">   
            <?php
            $i = 1;
            if (Input::get('page') > 1) {
                $i = 10 * Input::get('page') - 9;
            }
            ?>
            @foreach($dataOrder as $item)                                     
            <tr>
                <td>
                    {{$i}}
                </td>
                <td>
                    {{$item->domain}}
                </td>
                <td>
                    {{$item->diskStore}}
                </td>  
                <td>
                    {{$item->orderTime}}
                </td>  
                <td>
                    {{$item->orderExp}}
                </td>  
<!--                <td>
                    {{$item->status}}
                </td>  -->
                <?php
                $i++;
                ?>
            </tr>
            @endforeach
            @if($page!='')
            <tr>
                <td colspan="3">
                    {{$page}}
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif
</div>
<div class="loader-ajax"  style="display: none;">

</div>