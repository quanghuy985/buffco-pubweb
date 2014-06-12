
@if(Session::has('alert_success'))
<script>jQuery(document).ready(function(){jQuery('html, body').animate({ scrollTop: jQuery("#zxcvbnm1").offset().top }, 2000);})</script>
<div class="notibar msgsuccess" id="zxcvbnm1" style="margin-left: 20px;margin-right: 20px;" >
    <a class="close"></a>
    <p>{{Session::get('alert_success')}}</p>
</div>
@endif
@if(Session::has('alert_error'))
<script>jQuery(document).ready(function(){jQuery('html, body').animate({ scrollTop: jQuery("#zxcvbnm2").offset().top }, 2000);})</script>
<div class="notibar msgerror" id="zxcvbnm2" style="margin-left: 20px;margin-right: 20px;">
    <a class="close"></a>
    <p>{{Session::get('alert_error')}}</p>
</div>
@endif
@if(Session::has('alert_info'))
<script>jQuery(document).ready(function(){jQuery('html, body').animate({ scrollTop: jQuery("#zxcvbnm13").offset().top }, 2000);})</script>
<div class="notibar msginfo" id="zxcvbnm3" style="margin-left: 20px;margin-right: 20px;">
    <a class="close"></a>
    <p>{{Session::get('alert_info')}}</p>
</div>
@endif
@if($errors->any())
<script>jQuery(document).ready(function(){jQuery('html, body').animate({ scrollTop: jQuery("#zxcvbnm4").offset().top - 70 }, 2000);})</script>
<div class="notibar announcement" id="zxcvbnm4" style="margin-left: 20px;margin-right: 20px;">
    <a class="close"></a>
    {{ implode('',$errors->all('<p style="margin: 10px 10px 10px 55px;color: #D30808">:message</p>')) }}
</div>
@endif
