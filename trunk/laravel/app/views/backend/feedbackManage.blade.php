@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    function phantrang(page) {
        var request = jQuery.ajax({
            url: "{{URL::action('FeedbackController@postAjaxpagion')}}?page=" + page,
            type: "POST",
            dataType: "html"
        }
        );
        request.done(function(msg) {
            jQuery('#tableproduct').html(msg);
        });
    }
    jQuery(document).ready(function() {
        jQuery('#searchblur').keypress(function(e) {
            // Enter pressed?
            if (e.which == 10 || e.which == 13) {
                var request = jQuery.ajax({
                    url: "{{URL::action('FeedbackController@postAjaxsearch')}}?keywordsearch=" + jQuery('#searchblur').val(),
                    type: "POST",
                    dataType: "html"
                });
                request.done(function(msg) {
                    jQuery('#tableproduct').html(msg);
                });
            }
        });
    });
</script>
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ PHẢN HỒI</h1>
    <span class="pagedesc">Quản lý các phản hồi</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Bảng phản hồi</h3>
        </div>
        <div class="tableoptions">
            <button class="radius3" id="loctheotieuchi">Lọc theo tiêu chí</button>
            <div class="dataTables_filter" id="searchformfile"><label>Search: <input id="searchblur" name="searchblur" style="border: 1px solid #ddd;padding: 7px 5px 8px 5px;width: 200px;background: #fff;" type="text"></label></div>
        </div> 
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con1" style="width: 3%">
                <col class="con0" style="width: 13%">
                <col class="con1" style="width: 13%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 18%">
                <col class="con0" style="width: 15%">
                <col class="con1" style="width: 8%">
                <col class="con0" style="width: 15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="head1">STT</th>
                    <th class="head0">Email</th>
                    <th class="head1">Tài khỏan</th>
                    <th class="head0">Tiêu đề</th>
                    <th class="head1">Nội dung</th>
                    <th class="head0">Thời gian</th>
                    <th class="head1">Tình trạng</th>
                    <th class="head0">Chức năng</th>
                </tr>  
            </thead>
            <tbody id="tableproduct">
                <?php $i = 1 ?>
                @foreach($arrayFeedback as $item)
                <tr> 
                    <td><label value="cateNews">{{$i++ }}</label></td> 
                    <td><label value="cateNews">{{str_limit( $item->feedbackUserEmail, 30, '...')}}</label></td> 
                    <td><label value="cateNews">{{str_limit($item->feedbackUserName,30,'...' )}}</label></td> 
                    <td><label value="cateNews">{{str_limit($item->feedbackSubject, 30, '...')}} </label></td>
                    <td><label value="cateNews">{{str_limit($item->feedbackContent, 30, '...')}} </label></td> 
                    <td><label value="cateNews"><?php echo date('d/m/Y h:i:s', $item->feedbackTime); ?></label></td> 
                    <td><label value="cateNews"><?php
                            if ($item->status == 0) {
                                echo "chờ phản hồi";
                            } else if ($item->status == 1) {
                                echo "đã trả lời";
                            } else if ($item->status == 2) {
                                echo "đã xóa";
                            }
                            ?>
                        </label>
                    </td> 
                    <td>
                        <a href="{{URL::action('FeedbackController@getFeedbackReply')}}?id={{$item->id}}" class="btn btn4 btn_mail" title="Trả lời"></a>
                        @if($item->status!='2')
                        <a href="{{URL::action('FeedbackController@getFeedbackDelete')}}?id={{$item->id}}" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif

                    </td> 
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="8">{{$link}}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
