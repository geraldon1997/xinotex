
<!DOCTYPE html>
<html lang="en">
	
<!-- Mirrored from mono.flatheme.net/home/business-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 28 Jan 2021 05:22:25 GMT -->
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
        <meta name="keywords" content="">
		<title><?= APP_NAME; ?></title>
		<!-- Favicon -->
        <link href="<?= ASSETS; ?>main/images/favicon.png" rel="shortcut icon">
		<!-- CSS -->
		<link href="<?= ASSETS; ?>main/plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
		<link href="<?= ASSETS; ?>main/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
		<link href="<?= ASSETS; ?>main/plugins/owl-carousel/owl.theme.default.min.css" rel="stylesheet">
		<link href="<?= ASSETS; ?>main/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="<?= ASSETS; ?>main/plugins/sal/sal.min.css" rel="stylesheet">
		<link href="<?= ASSETS; ?>main/css/theme.min.css" rel="stylesheet">
		<!-- Fonts/Icons -->
		<link href="<?= ASSETS; ?>main/plugins/font-awesome/css/all.css" rel="stylesheet">
		<link href="<?= ASSETS; ?>main/plugins/themify/themify-icons.min.css" rel="stylesheet">
		<link href="<?= ASSETS; ?>main/plugins/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
		<script src="<?= ASSETS; ?>main/plugins/jquery.min.js"></script>
		<style>
			#google_translate_element{
				margin-left: 50px;
			}

			@media only screen and (max-width: 700px) {
				#google_translate_element{
					margin-left: 10px;
				}
			}
		</style>

	</head>
	<body data-preloader="1">

		<!-- Header -->
		<div class="header dark sticky-autohide">
			<div class="container-fluid">
				<!-- Logo -->
				<div class="header-logo">
					<h3><a href="<?= HOME; ?>"><?= APP_NAME; ?></a></h3>
				</div>

				<div id="google_translate_element"></div>

				<!-- Menu -->
				<div class="header-menu">
					<ul class="nav">
						<li class="nav-item">
							<a class="nav-link" href="<?= APP_URL; ?>">Homepage</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= ABOUT; ?>">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link d-toggle" href="#">How to buy coins</a>
							<ul class="nav-dropdown">
								<li class="nav-dropdown-item">
									<a href="https://blockchain.com" target="_blank" class="nav-dropdown-link">Blockchain</a>
								</li>
								<li class="nav-dropdown-item">
									<a href="https://coinmama.com" target="_blank" class="nav-dropdown-link">Coin mama</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= Q_GUIDE; ?>">Question Guide</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= TERMS; ?>">Terms of service</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= CONTACT; ?>">contact us</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= SIGNIN; ?>">Login</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= SIGNUP; ?>">Register</a>
						</li>
					</ul>
				</div>
				<!-- Menu Extra -->
				
				<!-- Menu Toggle -->
				<button class="header-toggle">
					<span></span>
				</button>
			</div><!-- end container -->
		</div>
		<!-- end Header -->

		<!-- Scroll to top button -->
		<div class="scrolltotop">
			<a class="button-circle button-circle-sm button-circle-dark" href="#"><i class="ti-arrow-up"></i></a>
		</div>
		<!-- end Scroll to top button -->

		{{content}}
<hr>
		<footer>
			<div class="section-sm bg-dark">
				<div class="container">
					<div class="row col-spacing-20">
						<div class="col-6 col-sm-6 col-lg-4">
							<h3><?= APP_NAME; ?></h3>
						</div>
						<div class="col-6 col-sm-6 col-lg-4">
							<h6 class="font-small font-weight-normal uppercase">Useful Links</h6>
							<ul class="list-dash">
								<li><a href="<?= ABOUT; ?>">About</a></li>
								<li>
									<a type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
										How to buy coins
									</a>

									<div class="collapse" id="collapseExample">
										<ul class="list-dash">
											<li><a target="_blank" href="https://blockchain.com">Blockchain</a></li>
											<li><a target="_blank" href="https://coinmama.com">Coin mama</a></li>
										</ul>
									</div>
								</li>
								<li><a href="<?= Q_GUIDE; ?>">question guide</a></li>
								<li><a href="<?= CONTACT; ?>">Contact us</a></li>
							</ul>
						</div>
						<div class="col-6 col-sm-6 col-lg-4">
							<h6 class="font-small font-weight-normal uppercase">Contact Info</h6>
							<ul class="list-unstyled">
								<li><i class="ti-map"></i> 89 Jacolite Street BRIGADOON WA 6069, Australia</li>
								<li><a href="mailto:support@xinotex.com"><i class="ti-envelope"></i> support@xinotex.com</a></li>
								<li><a href="tel:+13233642197"><i class="ti-mobile"></i> +1 323 3642 197</a></li>
							</ul>
						</div>
					</div><!-- end row(1) -->

					<hr class="margin-top-30 margin-bottom-30">

					<div class="row col-spacing-10">
						<div class="col-12 col-md-6 text-center text-md-left">
							<p>&copy; <?= date('Y').' '.APP_NAME; ?>, All Rights Reserved.</p>
						</div>
					</div><!-- end row(2) -->
				</div><!-- end container -->
			</div>
		</footer>

		<!-- ***** JAVASCRIPTS ***** -->

		<script type="text/javascript">
			function googleTranslateElementInit() {
				new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
			}
		</script>

		<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

		<script src="<?= ASSETS; ?>main/plugins/jquery.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUma4oJ7_6VbfGNdUYdv6VQ0Ph07Fz0k8"></script>
		<script src="<?= ASSETS; ?>main/polyfill.io/v3/polyfill.minc677.js?features=IntersectionObserver"></script>
		<script src="<?= ASSETS; ?>main/plugins/plugins.js"></script>
		<script src="<?= ASSETS; ?>main/js/functions.min.js"></script>
	</body>

<!-- Mirrored from mono.flatheme.net/home/business-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 28 Jan 2021 05:24:29 GMT -->
</html>