<div class="section-lg">
			<div class="container">
				<div class="margin-bottom-20">
					<div class="row text-center">
						<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
							<h2 class="font-weight-light">Register Form</h2>
							
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
						<!-- Contact Form -->
						<div class="contact-form">
							<form method="post" >
								
									<div class="col-12 col-sm-12">
									<label for="username">Email address</label>
										<input type="email" id="email" name="email" placeholder="Email address" required="">
									</div>
									<div class="col-12 col-sm-12">
									<label for="password">Password</label>
										<input type="password" id="password" name="password" placeholder="Password" required="">
									</div>
									<div class="col-12 col-sm-12">
									<label for="password">Confirm Password</label>
										<input type="password" id="confirmpassword" name="password" placeholder="Confirm Password" required="">
									</div>
								<a style="color: orange;" href="<?= SIGNIN; ?>">Already a user ?</a>
                                <br>
								<button class="button button-lg button-rounded button-outline-dark-2 margin-top-20" type="submit">Register</button>
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
        url : "<?= REGISTER; ?>",
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
                    location.href = "<?= SIGNIN; ?>"
                }, 2000);
            } else {
                alert('An Error occurred, Registration not successful. possibly duplicate credentials');
                location.href = "<?= SIGNIN; ?>";
            }
        }
    });
})

</script>