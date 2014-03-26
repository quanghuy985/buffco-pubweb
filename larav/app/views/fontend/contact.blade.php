@extends("fontend.hometemplate")
@section("contenthomepage")
<script>    
    function checkValid() {
        var $form = $('#frmChangePassword');
        if (!$form.valid())
            return false;
    }
</script>
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                  <li><a href="{{Asset('')}}">Trang chủ</a></li>
                    <li class="active">Liên hệ</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Liên hệ</h2>
            </div>
        </div>
    </div>
</section>
<!-- Google Maps -->
<div id="googlemaps" class="google-map hidden-xs">
    <iframe width="100%" height="400px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=d&amp;source=s_d&amp;saddr=20.994658,105.855006&amp;daddr=&amp;hl=vi&amp;geocode=&amp;sll=20.993977,105.857842&amp;sspn=0.01192,0.021136&amp;mra=mift&amp;mrsp=0&amp;sz=16&amp;ie=UTF8&amp;ll=20.994603,105.855187&amp;spn=0.01192,0.021136&amp;t=m&amp;output=embed"></iframe>
</div>

<div class="container">   
    <div class="row">
        <div class="col-md-6">
            @if($susscess == '1' )
            <div class="alert alert-success" id="contactSuccess">
                <strong>Thành công!</strong> Câu hỏi của bạn đã được gủi đi.
            </div>
            @endif
            @if($susscess == '2' )
            <div class="alert alert-danger " id="contactError">
                <strong>Lỗi!</strong> Câu hỏi của bạn chưa được gủi đi, vui lòng kiểm tra lại các trường thông tin.
            </div>
            @endif            
            <form id="contactForm" method="post" action="{{URL::action('ContactController@postContact')}}" >
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Họ và tên *</label>
                            <input type="text" value="" class="form-control" name="name" id="name">
                        </div>
                        <div class="col-md-6">
                            <label>Email *</label>
                            <input type="email" value=""  class="form-control" name="email" id="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Tiêu đề *</label>
                            <input type="text" value=""  class="form-control" name="subject" id="subject">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Nội dung *</label>
                            <textarea maxlength="5000"  rows="10" class="form-control" name="message" id="message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" value="Gủi" onclick="" class="btn btn-primary btn-lg" data-loading-text="Loading...">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">

            <h4 class="push-top">Get in <strong>touch</strong></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus.</p>

            <hr />

            <h4>The <strong>Office</strong></h4>
            <ul class="list-unstyled">
                <li><i class="icon icon-map-marker"></i> <strong>Address:</strong> 1234 Street Name, City Name, United States</li>
                <li><i class="icon icon-phone"></i> <strong>Phone:</strong> (123) 456-7890</li>
                <li><i class="icon icon-envelope"></i> <strong>Email:</strong> <a href="mailto:mail@example.com">mail@example.com</a></li>
            </ul>

            <hr />

            <h4>Business <strong>Hours</strong></h4>
            <ul class="list-unstyled">
                <li><i class="icon icon-time"></i> Monday - Friday 9am to 5pm</li>
                <li><i class="icon icon-time"></i> Saturday - 9am to 2pm</li>
                <li><i class="icon icon-time"></i> Sunday - Closed</li>
            </ul>

        </div>

    </div>

</div>
@endsection