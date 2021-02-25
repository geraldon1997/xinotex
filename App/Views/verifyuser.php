<script>
    var url = window.location.pathname;
    var path = url.split('/');
    var token = path[3];
    var expiry = path[4];

    $.ajax({
        type : 'POST',
        url : '/user/verifyuseremail',
        data : {
            token : token,
            time : expiry
        },
        success : (response) => {
            switch (response) {
                case 'it':
                    alert('Invalid Token');
                    window.location = '/user/signin';
                    break;

                case 'te':
                    alert('Token has expired');
                    window.location = '/user/signin';
                    break;

                case 'env':
                    alert('Email not verified');
                    window.location = '/user/signin';
                    break;

                case 'ev':
                    alert('Email verified successfully');
                    window.location = '/user/signin';
                    break;
            
                default:
                    break;
            }
        }
    })
</script>