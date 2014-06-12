@extends("backend.template")
@section("titleAdmin")
{{Lang::get('backend/title.feedback.reply')}}
@stop
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.feedback.heading')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.feedback.reply')}}</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.feedback.reply')}}</h3>
        </div>
        @include('backend.alert')
        <form class="stdform stdform2" method="post" action="{{URL::action('\BackEnd\FeedbackController@postTraLoi')}}">
            <p>
                <input type="hidden" id="feedbackID" name="id" value="{{$feedbackdata->id}}"/>
            </p>
            <p>
                <label>{{Lang::get('general.email')}}</label>
                <span class="field">
                    <input type="hidden" name="userEmail"    value="{{$feedbackdata->feedbackUserEmail}}" class="longinput"/>
                           <input type="text" name="userEmail1" disabled   value="{{$feedbackdata->feedbackUserEmail}}" class="longinput"/>
                </span>
            </p>
            <p>
                <label>{{Lang::get('general.feedback_user')}}</label>
                <input type="hidden" name="feedbackUserName" value="{{$feedbackdata->feedbackUserName}}" class="longinput">
                <span class="field"><input type="text" name="feedbackUserName1" disabled  value="{{$feedbackdata->feedbackUserName}}" class="longinput"></span>
            </p>
            <p>
                <label>{{Lang::get('general.feedback_subject')}}</label>
                <span class="field">
                    <input type="hidden" name="feedbackSubject" value="{{$feedbackdata->feedbackSubject}}" class="longinput">
                    <input type="text" name="feedbackSubject1" disabled   value="{{$feedbackdata->feedbackSubject}}" class="longinput">
                </span>
            </p>
            <p>
                <label>{{Lang::get('general.feedback_content')}}</label>
                <span class="field"><textarea cols="80" rows="5" id="location2" name="feedbackContent1" disabled >{{$feedbackdata->feedbackContent}}</textarea></span>
                    <textarea cols="80" style="display: none" rows="5" id="" name="feedbackContent" >{{$feedbackdata->feedbackContent}}</textarea>
            </p>

            <p>
                <label>{{Lang::get('general.time_send')}}</label>
                <span class="field">
                    <input type="hidden" name="time" value="<?php echo date('d/m/Y h:i:s', $feedbackdata->time); ?>" class="longinput">
                    <input type="text" name="time1" disabled  value="<?php echo date('d/m/Y h:i:s', $feedbackdata->time); ?>" class="longinput">
                </span>
            </p>
            <p>
                <label>{{Lang::get('general.reply_content')}}</label>
                <span class="field"><textarea cols="80" rows="5" id="location3" class="ckeditor" name="feedbackReplyContent">{{Input::old('feedbackReplyContent')}}</textarea></span>
            </p>

            <p class="stdformbutton">
                <label>&nbsp;</label>
                <button class="submit radius2">{{Lang::get('general.reply')}}</button>
            </p>
        </form>
    </div>
</div>
@endsection