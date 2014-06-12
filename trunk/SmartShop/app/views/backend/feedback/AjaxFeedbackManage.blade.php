<?php $i = ($arrayFeedback->getCurrentPage() - 1) * 1 + 1;$feedback_status = Lang::get('general.feedback_status'); ?>
@foreach($arrayFeedback as $item)
<tr> 
    <td><label value="cateNews">{{$i++ }}</label></td> 
    <td><label value="cateNews">{{str_limit( $item->feedbackUserEmail, 30, '...')}}</label></td> 
    <td><label value="cateNews">{{str_limit($item->feedbackUserName,30,'...' )}}</label></td> 
    <td><label value="cateNews">{{str_limit($item->feedbackSubject, 30, '...')}} </label></td>
    <td><label value="cateNews">{{str_limit($item->feedbackContent, 30, '...')}} </label></td> 
    <td><label value="cateNews"><?php echo date('d/m/Y h:i:s', $item->time); ?></label></td> 
    <td><label value="cateNews">
            <?php
            if(array_key_exists($item->status, $feedback_status)){
                echo $feedback_status[$item->status];
            }
            ?>
        </label>
    </td> 
    <td>
        <a href="{{URL::action('\BackEnd\FeedbackController@getRepFeedBack', $item->id)}}" class="btn btn4 btn_mail" title="{{Lang::get('general.reply')}}"></a>
        @if($item->status!='2')
        <a href="javascript:void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="{{Lang::get('button.delete')}}"></a>
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
    <td colspan="8" style="text-align: center;"><span class="center">{{Lang::get('general.data_empty')}}</span></td>
</tr>
@endif
