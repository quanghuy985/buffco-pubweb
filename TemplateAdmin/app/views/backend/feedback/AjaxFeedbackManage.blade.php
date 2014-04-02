<?php $i = ($arrayFeedback->getCurrentPage() - 1) * 1 + 1; ?>
@foreach($arrayFeedback as $item)
<tr> 
    <td><label value="cateNews">{{$i++ }}</label></td> 
    <td><label value="cateNews">{{str_limit( $item->feedbackUserEmail, 30, '...')}}</label></td> 
    <td><label value="cateNews">{{str_limit($item->feedbackUserName,30,'...' )}}</label></td> 
    <td><label value="cateNews">{{str_limit($item->feedbackSubject, 30, '...')}} </label></td>
    <td><label value="cateNews">{{str_limit($item->feedbackContent, 30, '...')}} </label></td> 
    <td><label value="cateNews"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td> 
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
        <a href="{{URL::action('FeedbackController@getTraLoi')}}?id={{$item->id}}" class="btn btn4 btn_mail" title="Trả lời"></a>
        @if($item->status!='2')
        <a href="javascript:void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
        @endif

    </td> 
</tr> 
@endforeach
@if($links!='')
<tr>
    <td colspan="8">{{$links}}</td>
</tr>
@endif
@if(count($arrayFeedback)==0)
<tr>
    <td colspan="8" style="text-align: center;"><span class="center">Không có dữ liệu trả về .</span></td>
</tr>
@endif