<style>
@media only screen and (max-width: 700px) {
    .offset-3{
        margin-left: 0;
    }
}
</style>
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
                                            <h4 class="text-center">Login Form</h4>
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <input type="email" placeholder="Email Address" id="email" name="email" required>
                                                </div>

                                                <div class="col-md-12">
                                                    <input type="password" placeholder="Password" id="password" name="password" required>
                                                </div>
                                                
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" id="signin" class="btn">Login</button>
                                                </div>

                                                <p>Not a User ? <a href="<?= SIGNUP; ?>">Sign up</a> </p>
                                                <a href="<?= FORGOT_PASSWORD; ?>">Forgot password ?</a>
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
        $('form').submit((e)=>{
            e.preventDefault();
            
            var email = $('#email').val();
            var pass = $('#password').val();

            if (email == '' || email == ' ' || email == null || email == undefined) {
                $('#emailerror').remove();
                $('#email').after('<p style="color:red;" id="emailerror">email address field is required</p>');
                return;
            } else {
                $('#emailerror').remove();
            }

            if (pass == '' || pass == ' ' || pass == null || pass == undefined) {
                $('#passerror').remove();
                $('#password').after('<p style="color:red;" id="passerror">password field is required</p>');
                return;
            } else {
                $('#passerror').remove();
            }

            
            var signin = $('#signin');
            signin.prop({'disabled':'true'}).html('processing . . .');
            
            $.ajax({
                type : 'POST',
                url : '/user/auth',
                data : {
                    email : $('#email').val(),
                    password : $('#password').val()
                },
                success : (response) => {
                    
                    switch (response) {
                        case 'ne':
                            alert('This user does not exist');
                            signin.removeAttr('disabled').html('Sign in');
                            break;

                        case 'ic':
                            alert('Incorrect Username or Password');
                            signin.removeAttr('disabled').html('Sign in');
                            break;

                        case 'tni':
                            alert('An Error occurred, please try again in a short while');
                            signin.removeAttr('disabled').html('Sign in');
                            break;

                        case 'mns':
                            alert('An Error occured, please try again in a short while');
                            signin.removeAttr('disabled').html('Sign in');
                            break;

                        case 'ms':
                            alert('Email not verified, a verification link has been sent to your email. \n please check your spam if not found inbox and move it to inbox');
                            signin.removeAttr('disabled').html('Sign in');
                            break;

                        case 'lcni':
                            alert('An error occurred while signing you in, please try again in a short while');
                            signin.removeAttr('disabled').html('Sign in');
                            break;

                        case 'lcns':
                            alert('An error occurred, login code was not sent. please try again in a while');
                            signin.removeAttr('disabled').html('Sign in');
                            break;

                        case 'lcs':
                            $('#signin').prop({'disabled':'true'}).html('credentials verified');
                            setTimeout(() => {
                                alert('Login code has been sent to your email. \nplease check your spam if not found inbox and move it to inbox');                          
                                window.location = "<?= LOGIN; ?>";
                            }, 1000);
                            break;

                        case 'usli':
                            window.location = "<?= DASHBOARD; ?>";
                            break;
                    
                        default:
                            break;
                    }
                }
            });
        })

    </script>