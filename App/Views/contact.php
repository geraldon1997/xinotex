<div class="section-lg">
	<div class="container">
		<div class="margin-bottom-70">
			<div class="row text-center">
				<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
					<h2 class="font-weight-light">Please fill the form below</h2>
					
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 text-center">
				<!-- Contact Form -->
				<div class="contact-form">
					<form method="post" id="contactform">
						<div class="form-row">
							<div class="col-12 col-sm-6">
								<input type="text" id="name" name="name" placeholder="Name" required>
							</div>
							<div class="col-12 col-sm-6">
								<input type="email" id="email" name="email" placeholder="E-Mail" required>
							</div>
						</div>
						<input type="text" id="subject" name="subject" placeholder="Subject" required>
						<textarea name="message" id="message" placeholder="Message" required></textarea>
						<button class="button button-lg button-rounded button-outline-dark-2" type="submit">Send Message</button>
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

	$('form').submit((e) => {
		e.preventDefault();
		$('#success').hide();
		$('#error').hide();

		$('form button').attr({'disabled':true}).html('sending . . .');
		let data = $('form').serialize();

		$.post(
			"<?= SEND_CONTACT; ?>",
			data	
		).then(result => {
			setTimeout(() => {
				if (result == 'sent') {
					$('#success').show();
					$('form button').removeAttr('disabled').html('send message');
				} else if (result == 'not sent') {
					$('#error').show();
					$('form button').removeAttr('disabled').html('send message');
				}
			}, 2000);
		})
	})
</script>