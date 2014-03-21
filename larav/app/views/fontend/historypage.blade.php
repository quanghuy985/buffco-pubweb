<script>
    function phantrang(page) {
        jQuery('.ajaxloader').css('display', 'block');
        var request = jQuery.ajax({
            url: "{{URL::action('AccountController@postAjaxHistory')}}?page=" + page,
            type: "POST",
            dataType: "html"
        });
        request.done(function(msg) {
            jQuery('#history').html(msg);
            jQuery('.ajaxloader').css('display', 'none');
        });
    }
</script>
<div class="col-md-12" id="divtableHistory">			
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 30px !important;">
                    STT
                </th>
                <th>
                    Nội dung
                </th>
                <th>
                    Thời gian
                </th>                                      
            </tr>
        </thead>
        <tbody id="hisTable">   
            <?php
            $i = 1;
            if (Input::get('page') > 1) {
                $i = 3 * Input::get('page') - 2;
            }
            ?>
            @foreach($datahis as $item)                                     
            <tr>
                <td>
                    {{$i}}
                </td>
                <td>
                    {{$item->historyContent}}
                </td>
                <td>
                    {{$item->historyTime}}
                </td>     
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
</div>
<div class="ajaxloader"  style="display: none;">

</div>