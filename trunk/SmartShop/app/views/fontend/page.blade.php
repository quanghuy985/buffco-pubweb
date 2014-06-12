@extends("fontend.template")
@section("content") 
<!-- BEFORE CONTENT -->
<div id="outerbeforecontent">
    <div class="container">
        <section id="beforecontent" class="twelve columns">
            <h1 class="pagetitle">Contact Us</h1>
            <div class="clear"></div>
        </section>
    </div>
</div>
<!-- END BEFORE CONTENT -->

<!-- MAIN CONTENT -->
<div id="outermain">
    <div class="container">
        <section id="maincontent" class="twelve columns">

            <p>Donec consectetur libero ut tortor condimentum eu egestas est viverra. Sed eget turpis dui, sed auctor nisi. Fusce suscipit risus sed tortor mattis sollicitudin. Vivamus dictum, nisl sed aliquet sodales, nisi ipsum interdum metus, quis rhoncus felis ligula sit amet nisi. Quisque ultricies turpis nec ipsum rutrum condimentum. Quisque sollicitudin, lectus sed tincidunt viverra, nisl lacus semper massa, a pellentesque lectus massa at orci.</p><br>


            <div class="six columns alpha">
                <h3>Contact Form</h3>
                <div id="contactform">
                    <form id="contact" action="#">
                        <fieldset>
                            <label for="name" id="name_label">Your Name:</label>
                            <input type="text" name="name" id="name" size="50" value="" class="text-input" />
                            <label for="email" id="email_label">Your Email:</label>
                            <input type="text" name="email" id="email" size="50" value="" class="text-input" />
                            <label for="subject" id="subject_label">Subject:</label>
                            <input type="text" name="subject" id="subject"  value="" class="text-input" size="50" />
                            <label for="msg" id="msg_label">Message:</label>
                            <textarea cols="10" rows="7" name="msg" id="msg" class="text-input"></textarea><br />
                            <input type="submit" name="submit" class="button" id="submit_btn" value="Submit"/><br class="clear" />
                        </fieldset>
                    </form>
                    <script type="text/javascript" src="{{Asset('fontend')}}/js/jquery-1.10.2.min.js"></script>
                    <script>
                        jQuery(document).ready(function() {
                            jQuery("#contact").validate({
                                rules: {
                                    email: {
                                        required: true,
                                        email: true
                                    },
                                    name: {
                                        required: true,
                                        minlength: 6
                                    }
                                },
                                messages: {
                                    email: {
                                        required: 'Email là trường bắt buộc',
                                        email: 'Email chưa đúng định dạng'
                                    },
                                    name: {
                                        required: "Mật khẩu là trường bắt buộc",
                                        minlength: "Mật khẩu không ngắn hơn 6 ký tự"
                                    }
                                }
                            });
                        });
                    </script>
                </div><!-- end contactform -->
            </div>

            <div class="six columns omega">
                <h3>Map</h3>
                <iframe src="../../maps.google.com/maps@f=q&source=s_q&hl=en&geocode=&q=jalan+kemanggisan+utama,+jakarta,+indonesia&sll=37.0625,-95.677068&sspn=40d3049c458" style="width:100%; height:360px;" class="frame"></iframe>
            </div>

            <div class="clear"></div><!-- clear float --> 
        </section>
    </div>
</div>
<!-- END MAIN CONTENT -->

@endsection