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
<div class="col-md-12" id="divtableOrderServices">			
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
                    {{$item->ngayhethan}}
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
</div>
<div class="loader-ajax"  style="display: none;">

</div>