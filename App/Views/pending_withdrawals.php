<?php
use App\Models\Withdrawal;
use App\Models\User;
use App\Models\Wallet;

$sn = 1;
?>
<h1 class="dash-title">Withdrawal</h1>

<div class="row">
<div class="col-lg-12">
        <div class="card spur-card">
            <div class="card-header">
                <div class="spur-card-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="spur-card-title">Pending withdrawals</div>
            </div>
            <div class="card-body card-body-with-dark-table">
                <?php if (User::isMember()) : ?>
                <table class="table table-dark table-in-card">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Date Requested</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (array_key_first($params) == 'user') : ?>
                            <?php foreach ($params['user'] as $withdrawal) : ?>
                                <tr>
                                    <td><?= $sn++; ?></td>
                                    <td><?= '$'.number_format($withdrawal['amount']); ?></td>
                                    <td><?= $withdrawal['date']; ?></td>
                                    <td><button class="btn btn-outline-warning btn-sm">awaiting payment</button></td>
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
                            <th scope="col">Wallet</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Date Requested</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (array_key_first($params) == 'admin') : ?>
                            <?php foreach ($params['admin'] as $withdrawal) : ?>
                                <tr>
                                    <td><?= User::find(User::$table, 'id', $withdrawal['user_id'])[0]['email']; ?></td>
                                    <td><?= Wallet::find(Wallet::$table, 'user_id', $withdrawal['user_id'])[0]['wallet_address'] ?></td>
                                    <td><?= '$'.number_format($withdrawal['amount']); ?></td>
                                    <td><?= $withdrawal['date']; ?></td>
                                    <td><button class="btn btn-outline-warning btn-sm">pending</button></td>
                                    <td><button class="btn btn-primary btn-sm" id="paid" withdrawal-id="<?= $withdrawal['id']; ?>">paid</button></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (User::isAdmin()) : ?>
<script>
    $('button').click((e) => {
        var with_id =  $(e.target).attr('withdrawal-id');

        var verify = confirm('Are you sure ?');
        

        if (verify == true) {
            $.ajax({
                type: 'POST',
                url : '/withdrawal/paid',
                data : {
                    id : with_id
                },
                success : (response) => {
                    if (response)
                    {
                        alert('user has been paid');
                        location.reload();
                    } else {
                        alert('An Error occurred, user was not paid')
                    }
                }
            })
        }
    });
</script>
<?php endif; ?>