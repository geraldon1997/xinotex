<?php

use App\Models\Investment;
use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use App\Models\PaymentMethod;

$sn = 1;
?>
<h1 class="dash-title">Investments</h1>

<?php if (User::isMember() || User::isModerator()) : ?>
    <?php include_once 'investment_form.php'; ?>
<?php endif; ?>
<hr>
<div class="payment-details"></div>

<div class="row">
<div class="col-lg-12">
    <div class="card spur-card">
        <div class="card-header">
            <div class="spur-card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="">Pending investment</div>
        </div>
        <div class="card-body card-body-with-dark-table">
            <?php if (array_key_first($params) == 'user') : ?>
            <table class="table table-dark table-in-card">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Package</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Coin</th>
                        <th scope="col">ROI</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($params['user'] as $investment) : ?>
                        <tr>
                            <td><?= $sn++; ?></td>
                            <td><?= Package::package($investment['package_id'])[0]['package_name'] ?></td>
                            <td>$<?= number_format($investment['amount']) ?></td>
                            <td><?= PaymentMethod::find(PaymentMethod::$table, 'id', $investment['payment_method_id'])[0]['method']; ?></td>
                            <td>$<?= number_format($investment['expected_amount']) ?></td>
                            <td>
                                <?= !$investment['is_active'] ? '<button class="btn btn-outline-warning btn-sm">pending</button>' : '' ?>
                            </td>
                            
                            <td>
                                <a href="/investment/deposit/<?= $investment['id']; ?>" class="btn btn-primary btn-sm mb-3">Deposit</a>
                            </td>
                        </tr>
                    
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php elseif (array_key_first($params) == 'admin') : ?>
                <table class="table table-dark table-in-card">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User</th>
                            <th scope="col">Package</th>
                            <th scope="col">Coin</th>
                            <th scope="col">Amount</th>
                            <th scope="col">ROI</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($params['admin'] as $investment) : ?>
                            <tr>
                                <td><?= $sn++; ?></td>
                                <td><?= User::find(User::$table, 'id', $investment['user_id'])[0]['email'] ?></td>
                                <td><?= Package::package($investment['package_id'])[0]['package_name'] ?></td>
                                <td><?= PaymentMethod::find(PaymentMethod::$table, 'id', $investment['payment_method_id'])[0]['method']; ?></td>
                                <td><?= '$'.number_format($investment['amount']) ?></td>
                                <td><?= '$'.number_format($investment['expected_amount']) ?></td>
                                <td><button class="btn btn-outline-warning btn-sm">pending</button></td>
                                <td>    
                                    <button class="btn btn-success btn-sm" inv-id="<?= $investment['id'] ?>" txn-id="<?= Payment::findMultiple(Payment::$table, "inv_id = ".$investment['id']." ORDER BY id DESC LIMIT 1 ") ? Payment::findMultiple(Payment::$table, "inv_id = ".$investment['id']." ORDER BY id DESC LIMIT 1 ")[0]['gateway_id'] : ''; ?>">confirm</button>
                                </td>
                                    
                                    
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
    $('button').click((e) => {
        
        var btn = $(e.currentTarget);
        var btnid = btn.attr('id');

        if (btnid === 'deposit') {
            var amount = (btn.attr('amount'));
            var coin = btn.attr('payment-method');
            var address = btn.attr('wallet-address');

            var html = "<h4>";
                html += 'Deposit';
                html += '<i> $'+amount+' </i>';
                html += 'worth of <b>' + coin + '</b> ';
                html += 'to the wallet address below';
                html += '<input type="text" id="btc-address" class="form-control" value="'+address+'" readonly>';
                html += '<button id="copy-address" class="btn btn-primary btn-sm"> copy address</button>';
                html += "</h4><hr>";

            $('.payment-details').html(html);

            copyaddress();

        } else if (btnid === 'paid') {
            var formdata = btn.attr('inv-id');

            $(e.target).prop('disabled', 'true').html('processing . . .');

            $.ajax({
                type : 'POST',
                url : '/investment/pay',
                data : {
                    inv_id : formdata
                },
                success : (response) => {
                    if (response) {
                        alert('confirmation request has been sent')
                        location.reload();
                    } else {
                        alert('An error occurred');
                        location.reload();
                    }
                }
            });
            
        }
        
    });
</script>

<?php elseif (User::isAdmin()) : ?>
    <script>
        $('button').click((e) => {

            var inv_id = $(e.target).attr('inv-id');
            var txn_id = $(e.target).attr('txn-id');
            
            if (txn_id === '' || txn_id === null || txn_id === undefined) {
                return alert('user has not initiated payment');
            } else {
                $(e.target).prop('disabled', 'true').html('processing . . .');
                $.ajax({
                    type : 'POST',
                    url : '/investment/activate',
                    data : {
                        inv_id : inv_id,
                        txn_id : txn_id
                    },
                    success : (response) => {
                        if (response) {
                            alert('Investment has been confirmed');
                            location.reload();
                        } else {
                            alert('An error occurred');
                        }
                    }
                })
            }
        
        })
    </script>
<?php endif; ?>

<script>
    function copyaddress() {
        $('#copy-address').click(() => {
            var addr = $('#btc-address');
            addr.select();
            
            document.execCommand('copy');
            addr.css('background', 'white');
            $('#copy-address').html('address copied . . .')

            setTimeout(() => {
                $('#copy-address').html('copy address')
            }, 2000);
            
        })
    }
</script>