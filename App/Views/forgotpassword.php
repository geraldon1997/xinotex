<!-- c-onepage-contact starts
        ============================================ -->
        <div id="contact" class="section c-onepage-contact">
            <div class="container">
                <div class="o-contact-block wow fadeIn">
                    <div class="row align-items-center">
                        

                        <div class="col-lg-6 offset-3">
                            <div class="flip-container wow fadeIn">
                                <div class="flipper">
                                    <div class="o-form-content front">
                                        <form method="post" class="o-contact-form">
                                            <h4 class="text-center">Password Reset Form</h4>
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <input type="email" placeholder="Email Address" name="email" required>
                                                </div>
                                                
                                                <div class="col-md-12 text-center">
                                                <button class="button button-lg button-rounded button-outline-dark-2" type="submit" >Send Password Reset Link</button>
                                                </div>

                                            </div>
                                            <!-- End of .row -->
                                        </form>
                                        <!-- End of .o-contact-form -->
                                    </div>
                                    <!-- End of .o-form-content -->

                                    <div class="back o-map-container">
                                        <div id="map" class="o-map"></div>
                                    </div>
                                    <!-- o-map-content -->
                                </div>
                                <!-- End of .fliper -->
                            </div>
                            <!-- End of .flip-container -->
                        </div>
                        <!-- End of .col-md-3 -->
                    </div>
                    <!-- End of .row -->
                </div>
                <!-- End of .o-contact-block -->
            </div>
            <!-- End fo .container -->
        </div>
        <!-- End of .c-onepage-contact -->

        <script>
        $('form').submit((e) => {
            e.preventDefault();

            var formdata = $('form').serialize();

            var btn = $('form button');
            btn.prop({'disabled':'true'}).html('processing . . .');

            $.ajax({
                type : 'POST',
                url : '/user/sendpasswordresetlink',
                data : formdata,
                success : (response) => {
                    switch (response) {
                        case 'ie':
                            setTimeout(() => {
                                btn.html('Invalid Email Address');
                            }, 3000);
                            
                            setTimeout(() => {
                                alert('Invalid Email Address');
                                btn.removeAttr('disabled').html('Send Password Reset Link');
                            }, 6000);
                            break;

                        case 'prls':
                            setTimeout(() => {
                                btn.html('email address confirmed');
                            }, 3000);
                            setTimeout(() => {
                                alert('A password reset link has been sent to your email. \n please check your spam if not found inbox and move it to inbox');
                                window.location = "<?= SIGNIN; ?>";
                            }, 6000);
                            break;
                    
                        default:
                            break;
                    }
                }
            });
        });
    </script>