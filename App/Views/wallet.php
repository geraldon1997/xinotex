<?php
use App\Models\User;

$sn = 1;
?>

<h1 class="dash-title">Wallet</h1>

<?php if (!User::isAdmin()) : ?>
<div class="row">
    <div class="col-lg-12">
        <form id="waf" class="form">
            <div class="form-row">
                <div class="col-lg-10">
                    <input type="text" name="wa" class="form-control" placeholder="Enter Wallet address" required>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-primary" id="updateaddress">update address</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
<?php endif; ?>
<hr>

<div class="row">
<div class="col-lg-12">
    <div class="card spur-card">
        <div class="card-header">
            <div class="spur-card-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="spur-card-title"></div>
        </div>
        <div class="card-body card-body-with-dark-table">
            <?php if (!User::isAdmin()) : ?>
                <table class="table table-dark table-in-card">
                    <thead>
                        <tr>
                            <th scope="col">Wallet Address</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($params['user']) : ?>
                            <?php foreach ($params['user'] as $wallet) : ?>
                                <tr>
                                    <td><?= $wallet['wallet_address']; ?></td>
                                    <td><?= '$'.number_format($wallet['balance']); ?></td>
                                    
                                    <td><input type="number" id="amount" placeholder="amount to withdraw" required></td>
                                    <td>
                                        <?php if ($wallet['withdrawable'] && $wallet['balance'] > 1) : ?>
                                            <input type="hidden" id="max" value="<?= $wallet['balance']; ?>">
                                            <button class="btn btn-primary btn-sm" id="request">request</button>   
                                        <?php elseif (!$wallet['withdrawable']) : ?>
                                            <button class="btn btn-outline-info">update wallet address</button>
                                        <?php elseif ($wallet['withdrawable'] && $wallet['balance'] < 1) : ?>
                                            <button class="btn btn-outline-warning">insuffucient funds</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php elseif (User::isAdmin()) : ?>
                <table class="table table-dark table-in-card">
                    <thead>
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Wallet Address</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php foreach ($params['admin'] as $wallet) : ?>
                    <tr>
                    <td><?= $wallet['user']['email']; ?></td>
                    <td><?= $wallet['wallets']['wallet_address']; ?></td>
                    <td><?= '$'.number_format($wallet['wallets']['balance']); ?></td>
                    <td><button id="update_wallet" class="btn btn-primary btn-sm" user-id="<?= $wallet['user']['id']; ?>" >update balance</button></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>

<?php if (User::isMember() || User::isModerator()) : ?>
<script>
    $('#waf').submit((e) => {
        e.preventDefault();
        $('#updateaddress').prop('disabled', 'true').html('processing . . .');
        $.ajax({
            type : 'POST',
            url : '/wallet/updateaddress',
            data : $('#waf').serialize(),
            success : (response) => {
                if (response) {
                    $('#updateaddress').html('address updated');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    alert('An error occurred, wallet address could not but updated');
                    $('#updateaddress').removeAttr('disabled').html('update address');
                }
            }
        })
    })

    $('#request').click(() => {
        var amount = $('#amount').val();
        var max = $('#max').val();

        if (amount === '' || amount === ' ' || amount === null || amount === undefined) {
            alert('your withdrawal amount cannot be empty');
            return;
        }

        if (amount < 1) {
            alert('you cannot withdraw negative balance');
            return;
        }

        if (parseInt(amount) > parseInt(max)) {
            alert('you cannot withdraw what you do not have');
            return;
        }
        $('#request').prop('disabled', 'true').html('processing . . .');

        $.ajax({
            type : 'POST',
            url : '/wallet/withdraw',
            data : {
                amount : amount
            },
            success : (response) => {
                if (response) {
                    $('#request').html('request sent');
                    setTimeout(() => {
                        location.reload();
                    }, 1000)
                } else {
                    $('#request').removeAttr('disabled').html('request');
                }
            }
        })
    })

    
</script>
<?php endif; ?>


<?php if (User::isAdmin()) : ?>
<script>
    $('button').click((e) => {
        var btn = $(e.currentTarget);
        var id = btn.attr('id');

        if (id === 'update_wallet') {
            var userid = btn.attr('user-id');
        var newbalance = prompt('New balance');
        
        if (newbalance !== null) {
            $.ajax({
                type : 'POST',
                url : '/wallet/updatebalance',
                data : {
                    userid : userid,
                    newbalance : newbalance
                },
                success : (response) => {
                    if (response) {
                        alert('Balance has been updated');
                        location.reload();
                    } else {
                        alert('An error occurred');
                    }
                }
            })
        }
        
        }
        
    });
</script>
<?php endif; ?>