@extends("fontend.hometemplate")
@section("contenthomepage")
<section class="page-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Contact Us</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Contact Us</h2>
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

            <div class="alert alert-success hidden" id="contactSuccess">
                <strong>Success!</strong> Your message has been sent to us.
            </div>

            <div class="alert alert-danger hidden" id="contactError">
                <strong>Error!</strong> There was an error sending your message.
            </div>

            <h2 class="short"><strong>Contact</strong> Us</h2>
            <form action="php/contact-form.php" id="contactForm" type="post">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Your name *</label>
                            <input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name">
                        </div>
                        <div class="col-md-6">
                            <label>Your email address *</label>
                            <input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Subject</label>
                            <input type="text" value="" data-msg-required="Please enter the subject." maxlength="100" class="form-control" name="subject" id="subject">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Message *</label>
                            <textarea maxlength="5000" data-msg-required="Please enter your message." rows="10" class="form-control" name="message" id="message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" value="Send Message" class="btn btn-primary btn-lg" data-loading-text="Loading...">
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
<div class="clear"></div>
@endsection