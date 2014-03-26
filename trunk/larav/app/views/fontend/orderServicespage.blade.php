<script>
    function phantrang(page) {
        jQuery('.loader-ajax').css('display', 'block');
        var request = jQuery.ajax({
            url: "{{URL::action('AccountController@postAjaxOrderServices')}}?page=" + page,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#orderServices').html(msg);
            jQuery('.loader-ajax').css('display', 'none');
        });
    }
</script>
<div id="divtableOrderServices">
    @if(count($dataOrderServices)==0)
    <p> Bạn chưa chọn mua gói dịch vụ nào. Bấm vào <a href="#">đây</a> để tới trang dịch vụ</p>
    @endif
    @if(count($dataOrderServices)>0)
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
                    Tên dịch vụ
                </th>
                <th>
                    Tổng Lưu lượng
                </th>   
                <th>
                    Ngày hết hạn
                </th>   
            </tr>
        </thead>
        <tbody id="hisTable">   
            <?php
            $i = 1;
            if (Input::get('page') > 1) {
                $i = 10 * Input::get('page') - 9;
            }
            ?>
            @foreach($dataOrderServices as $item)                                     
            <tr>
                <td>
                    {{$i}}
                </td>
                <td>
                    {{$item->domain}}
                </td>
                <td>
                    {{$item->servicesName}}
                </td>  
                <td>
                    {{$item->Tongcong}}
                </td>                 
                <td>
                    <?php echo date('d/m/Y h:i:s', $item->ngayhethan); ?>               
                </td>  
                <?php
                $i++;
                ?>
            </tr>
            @endforeach
            @if($link!='')
            <tr>
                <td colspan="3">
                    {{$link}}
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif
</div>
<div class="loader-ajax"  style="display: none;">

</div>