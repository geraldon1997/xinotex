<div class="section-lg">
			<div class="container">
				<div class="margin-bottom-20">
					<div class="row text-center">
						<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
							<h2 class="font-weight-light">Login Form</h2>
							
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
						<!-- Contact Form -->
						<div class="contact-form">
							<form method="post" action="<?= AUTH; ?>">
								
									<div class="col-12 col-sm-12">
									<label for="username">Email adress</label>
										<input type="text" id="email" name="email" placeholder="Email address" required="">
									</div>
									<div class="col-12 col-sm-12">
									<label for="password">Password</label>
										<input type="password" id="password" name="password" placeholder="Password" required="">
									</div>
								<a style="color: orange;" href="<?= FORGOT_PASSWORD; ?>">Forgot Pasword</a>
                                <br>
								<button class="button button-lg button-rounded button-outline-dark-2 margin-top-20" type="submit" id="signin">Login</button>
							</form>
							<!-- Submit result -->
							<div class="submit-result">
								<span id="success">Thank you! Your Message has been sent.</span>
								<span id="error">Something went wrong, Please try again!</span>
							</div>
						</div><!-- end contact-form -->
					</div>
				</div><!-- end row -->
			</div><!-- end container -->
		</div>

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

            var formdata = $('form').serialize();
            var signin = $('#signin');
            signin.prop({'disabled':'true'}).html('processing . . .');

            $.ajax({
                type : 'POST',
                url : "<?= AUTH; ?>",
                data : formdata,
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