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
                                            <h4 class="text-center">Sign up Form</h4>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="email" placeholder="Email Address" id="email" name="email">
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="password" placeholder="Password" id="password" name="password">
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="password" placeholder="Confirm Password" id="confirmpassword">
                                                </div>
                                                
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" class="btn">Sign up</button>
                                                </div>

                                                <p>already a user ? <a href="<?= SIGNIN; ?>" > Login</a> </p>
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

$('#password').keyup(()=>{
    var cp = $('#confirmpassword').val();
    var p = $('#password').val();

    if (p != cp) {
        $('#passerror').remove();
        $('#confirmpassword').after('<p style="color:red;" id="passerror">Passwords do not match</p>')
        return;
    } else {
        $('#passerror').remove();
    }
});

$('#confirmpassword').keyup(()=>{
    var cp = $('#confirmpassword').val();
    var p = $('#password').val();

    if (cp != p) {
        $('#passerror').remove();
        $('#password').after('<p style="color:red;" id="passerror">Passwords do not match</p>')
        return;
    } else {
        $('#passerror').remove();
    }
});


$('form').submit((event)=>{
    event.preventDefault();

    $('form button').prop('disabled', 'true');
    $('form button').html('Processing . . .');

    $.ajax({
        type : 'POST',
        url : '/user/store',
        data : {
            email : $('input#email').val(),
            pass : $('input#password').val()
        },
        success : (response) => {
            if (response) {
                setTimeout(() => {
                    $('form button').html('registration was successful');
                }, 1000);
                
                setTimeout(() => {
                    alert('A verification link has been sent to your email.\nplease check your spam if not found inbox and move it to inbox');
                    location.href = "/user/signin"
                }, 2000);
            } else {
                alert('An Error occurred, Registration not successful. possibly duplicate credentials');
                location.href = '/user/signin';
            }
        }
    });
})

</script>