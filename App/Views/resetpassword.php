<!--community area start-->
<div class="community-area v2 wow fadeInUp section-padding" id="contact" style="visibility: visible; animation-name: fadeInUp;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="heading">
                        <h5></h5>
                        <div class="space-10"></div>
                        <h1>password reset Form</h1>
                    </div>
                    <div class="space-30"></div>
                    
                    <div class="space-30"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-3">
                    <div class="contact-form">
                        
                        <form>
                            <input type="hidden" name="token" id="token" value="<?= $params; ?>">
                            <div class="space-20"></div>
                            <input type="password" id="password" name="password" placeholder="your new password">
                            <div class="space-20"></div>
                            <input type="password" id="confirmpassword" placeholder="confirm new password">    
                            <div class="space-20"></div>             
                            <button class="btn btn-primary">Reset</button>
                        </form>
                    </div>
                </div>
                
            </div>
            
        </div>
        
       
    </div>
    <!--community area end-->

    <script>
        $(window).load(() => {
            var token = $('#token').val();
            $.ajax({
                type: 'POST',
                url: '/user/checkpasswordresettoken',
                data: {
                    token : token
                },
                success: (response) => {
                    switch (response) {
                        case 'tde':
                            alert('Invalid Token');
                            window.location = '/user/signin';
                            break;
                        
                        case 'the':
                            alert('Token has expired');
                            window.location = '/user/forgotpassword';
                            break;

                        default :
                        break;
                    }
                }
            })
        })

        var pass = $('#password');
        var cpass = $('#confirmpassword');

        $(pass).keyup(()=>{
            $('#pe').remove();
            if (pass.val() != cpass.val()) {
                cpass.after('<p id="pe" style="color:red;">passwords do not match</p>');
                return;
            }
            $('#pe').remove();
        })

        $(cpass).keyup(()=>{
            $('#pe').remove();
            if (cpass.val() != pass.val()) {
                pass.after('<p id="pe" style="color:red;">passwords do not match</p>');
                return;
            }
            $('#pe').remove();
        })

        $('form').submit((e) => {
            e.preventDefault();
            
            $('form button').prop('disabled','true').html('Processing . . .');
            $.ajax({
                type : 'POST',
                url : '/user/updatepassword',
                data : $('form').serialize(),
                success : (response) => {
                    switch (response) {
                        case 'pnu':
                            alert('An error occurred, please try again later');
                            $('form button').removeAttr('disabled').html('Reset');
                            setTimeout(()=>{
                                window.location = '/user/forgotpassword';
                            }, 2000);
                            break;

                        case '1':
                            $('form button').html('password updated');
                            setTimeout(()=>{
                                alert('password updated, you can now login with your new password');
                            }, 3000);
                            setTimeout(()=>{
                                window.location = '/user/signin';
                            }, 6000);
                            break;

                        default :
                        break;
                    }
                }
            })
        })
    </script>