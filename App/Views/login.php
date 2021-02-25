<!--community area start-->
<div class="community-area v2 wow fadeInUp section-padding" id="contact" style="visibility: visible; animation-name: fadeInUp;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="heading">
                        <h5></h5>
                        <div class="space-10"></div>
                        <h1>Verify Login Code</h1>
                    </div>
                    <div class="space-30"></div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-3">
                    <div class="contact-form">
                    <p>copy the code sent to your email and paste it inside the box</p>
                        <form>
                            <input type="text" id="login_code" name="login_code" placeholder="Login code">                        
                        <div class="space-20"></div>
                        <div class="row">
                            <div class="col">
                            <button style="cursor: pointer;" class="btn btn-primary" id="signin">Verify</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
        
       
    </div>
    <!--community area end-->

    <script>
        $('form').submit((e)=>{
            e.preventDefault();
            
            var lc = $('#login_code');

            if (lc.val() == '' || lc.val() == ' ' || lc.val() == null || lc.val() == undefined) {
                alert('Please enter your login code');
                return;
            }

            var formdata = $('form').serialize();
            var btn = $('#signin');
            btn.prop({'disabled':'true'}).html('verifying . . .');

            $.ajax({
                type : 'POST',
                url : '/user/verifylogincode',
                data : formdata,
                success : (response) => {
                    
                    switch (response) {
                        case 'ilc':
                            alert('Invalid Login Code, a new Code has been sent to your email');
                            btn.removeAttr('disabled').html('Verify');
                            break;

                        case 'lcng':
                            alert('An Error Occurred');
                            window.location = '/user/signin';
                            break;

                        case 'exlc':
                            alert('Login Code has expired, a new Code has been sent to your email');
                            btn.removeAttr('disabled').html('Verify');
                            break;
                    
                        case 'lcv':
                            setTimeout(() => {
                                btn.html('Login Code Verified');
                            }, 1000);
                            setTimeout(()=>{
                                btn.html('Redirecting . . . .');
                            }, 2000);
                            setTimeout(() => {
                                window.location = '/user/dashboard';
                            }, 3000)

                        default:
                            break;
                    }
                }
            });
        })

    </script>