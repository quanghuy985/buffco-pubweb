<?php $i = ($arrayFeedback->getCurrentPage() - 1) * 10 + 1; ?>
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