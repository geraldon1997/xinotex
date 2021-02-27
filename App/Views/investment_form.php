<?php
use App\Models\Package;
use App\Models\PaymentMethod;
?>
<div class="">
        <form class="form" id="invest-form">
            <div class="form-row">

                <div class="form-group col-md-3">
                    <select name="package" id="package" class="form-control" required>
                        <option value="">choose package . . .</option>
                        <?php foreach (Package::allPackages() as $package) : ?>
                            <option value="<?= $package['id'] ?>"><?= $package['package_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <input type="text" name="amount" id="amount" class="form-control" placeholder="amount" minlength="3" maxlength="5" required>
                </div>

                <div class="form-group col-md-4">
                    <select name="coin" id="coin" class="form-control" required>
                        <option value="">choose payment option . . .</option>
                        <?php foreach (PaymentMethod::allMethods() as $coin) : ?>
                            <option value="<?= $coin['id'] ?>"><?= $coin['method'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                

                <div class="form-group col-md-2">
                    
                <button class="btn btn-primary" id="invest">invest</button>
                </div>
                
            </div>
            
        </form>
</div>

<script>
    $('#package').change(()=>{
        var package = $('#package').val();
        var benchmark;
        var min, max;

        if (package === '1') {
            benchmark = '$500 to $1,000';
            min = 500;
            max = 1000;
        } else if (package === '2') {
            benchmark = '$1,100 to $5,000';
            min = 1100;
            max = 5000;
        } else if (package === '3') {
            benchmark = '$5,100 to $50,000';
            min = 5100;
            max = 50000;  
        } else {
            benchmark = 'amount'
            $('#amount').removeAttr('min','max');
        }

        $('#amount').prop({'placeholder':benchmark, 'min':min, 'max':max});
    });

    $('#amount').keyup(()=>{
        var amount = parseInt($('#amount').val());
        var min = parseInt($('#amount').attr('min'));
        var max = parseInt($('#amount').attr('max'));

        $('#aerror').remove();
        if (amount < min) {
            $('#amount').after("<p style='color:red;' id='aerror'>Amount cannot be less than $"+min+" </p>");
        } else if (amount > max) {
            $('#amount').after("<p style='color:red;' id='aerror'>Amount cannot be more than $"+max+"</p>");
        }
    })

    $('#invest-form').submit((e)=>{
        e.preventDefault();
        
        var amount = parseInt($('#amount').val());
        var min = parseInt($('#amount').attr('min'));
        var max = parseInt($('#amount').attr('max'));

        if (amount < min) {
            alert('Amount cannot be less than the minimum threshold');
            return;
        } else if (amount > max) {
            alert('Amount cannot be more than the maximum threshold');
            return;
        }

        $('#invest').prop('disabled', 'true').html('processing . . .');

        $.ajax({
            type : 'POST',
            url : '/investment/addInvestment',
            data : $('#invest-form').serialize(),
            success : (response) => {
                if (response) {
                    $('#invest').html('successful');
                    setTimeout(() => {
                        alert('Investment Successful');
                    }, 1000);
                    setTimeout(() => {
                        window.location = "<?= PENDING_INVESTMENT; ?>"
                    }, 2000);
                } else {
                    $('#invest').html('Error Occurred');
                    setTimeout(() => {
                        alert('An error occurred');
                        $('#invest').removeAttr('disabled').html('invest');
                    }, 1000);
                }
            }
        });
    })
</script>