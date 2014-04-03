@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">QUẢN LÝ PHẢN HỒI</h1>
    <span class="pagedesc">Trả lời phản hồi</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>Bảng trả lời</h3>
        </div>
        <form class="stdform stdform2" method="post" action="{{URL::action('FeedbackController@postTraLoi')}}">

            <p>
                <input type="hidden" id="feedbackID" name="feedbackID" value="@if(isset($feedbackdata)){{$feedbackdata->id}}@endif"/>
            </p>
            <p>
                <label>Email :</label>
                <span class="field">
                    <input type="hidden" name="userEmail" placeholder=" eg: John@email.com" @if(isset($feedbackdata)) @endif  value="@if(isset($feedbackdata)){{$feedbackdata->feedbackUserEmail}}@endif" class="longinput"/>
                           <input type="text" name="userEmail1" placeholder=" eg: John@email.com" @if(isset($feedbackdata))disabled @endif  value="@if(isset($feedbackdata)){{$feedbackdata->feedbackUserEmail}}@endif" class="longinput"/>
                </span>
            </p>
            <p>
                <label>Tài khoản :</label>
                <input type="hidden" name="feedbackUserName" placeholder="Nhập tên của trang" value="@if(isset($feedbackdata)){{$feedbackdata->feedbackUserName}}@endif" class="longinput">
                <span class="field"><input type="text" name="feedbackUserName1" placeholder="Nhập tên của trang" @if(isset($feedbackdata))disabled @endif value="@if(isset($feedbackdata)){{$feedbackdata->feedbackUserName}}@endif" class="longinput"></span>
            </p>
            <p>
                <label>Về việc :</label>
                <span class="field">
                    <input type="hidden" name="feedbackSubject" placeholder="Chủ đề phản hồi"  value="@if(isset($feedbackdata)){{$feedbackdata->feedbackSubject}}@endif" class="longinput">
                    <input type="text" name="feedbackSubject1" placeholder="Chủ đề phản hồi" @if(isset($feedbackdata))disabled @endif  value="@if(isset($feedbackdata)){{$feedbackdata->feedbackSubject}}@endif" class="longinput">
                </span>
            </p>
            <p>
                <label>Nội dung<small>Nội dung phản hồi khách hàng</small></label>
                <span class="field"><textarea cols="80" rows="5" id="location2" name="feedbackContent" placeholder="Nội dung trang" @if(isset($feedbackdata))disabled @endif>@if(isset($feedbackdata)){{$feedbackdata->feedbackContent}}@endif</textarea></span>
            </p>

            <p>
                <label>Thời điểm</label>
                <span class="field">
                    <input type="hidden" name="time" placeholder="Chủ đề phản hồi" value="@if(isset($feedbackdata))<?php echo date('d/m/Y h:i:s', $feedbackdata->time); ?>@endif" class="longinput">
                    <input type="text" name="time1" placeholder="Chủ đề phản hồi" @if(isset($feedbackdata))disabled @endif value="@if(isset($feedbackdata))<?php echo date('d/m/Y h:i:s', $feedbackdata->time); ?>@endif" class="longinput">
                </span>
            </p>
            <p>
                <label>Nội dung trả lời</label>
                <span class="field"><textarea cols="80" rows="5" id="location3" class="ckeditor" name="feedbackReplyContent" placeholder="Nội dung trả lời"></textarea></span>
            </p>

            <p class="stdformbutton">
                <button class="submit radius2" value="Gửi phản hồi">Gửi phản hồi </button>

            </p>
        </form>
    </div>
</div>
@endsection