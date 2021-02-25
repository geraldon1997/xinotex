<?php
use App\Models\Package;
use App\Models\User;

$sn = 1;
?>
<h1 class="dash-title">Investments</h1>

<?php if (User::isMember() || User::isModerator()) : ?>
    <?php include_once 'investment_form.php'; ?>
<?php endif; ?>
<hr>

<div class="row">
<div class="col-lg-12">
    <div class="card spur-card">
        <div class="card-header">
            <div class="spur-card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="">Completed investment</div>
        </div>
        <div class="card-body card-body-with-dark-table">
            <?php if (array_key_first($params) == 'user') : ?>
            <table class="table table-dark table-in-card">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Package</th>
                        <th scope="col">Amount</th>
                        <th scope="col">ROI</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php foreach ($params['user'] as $investment) : ?>
                        <tr>
                    
                        <td><?= $sn++; ?></td>
                        <td><?= Package::package($investment['package_id'])[0]['package_name']; ?></td>
                        <td><?= '$'.$investment['amount']; ?></td>
                        <td><?= '$'.$investment['expected_amount']; ?></td>
                        <td><?= $investment['is_completed'] ? '<button class="btn btn-outline-success btn-sm">completed</button>' : ''; ?></td>
                        <td>
                            <?php if (!$investment['is_withdrawn_to_wallet']) : ?>
                            <form>
                                <input type="hidden" id="inv_id" name="inv_id" value="<?= $investment['id']; ?>">
                                <button class="btn btn-primary btn-sm">withdraw to wallet</button>
                            </form>
                            <?php else : ?>
                                <button class="btn btn-outline-secondary btn-sm">withdrawn to wallet</button>
                            <?php endif; ?>
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
                            <th scope="col">Amount</th>
                            <th scope="col">ROI</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($params['admin'] as $investment) : ?>
                            <tr>
                                <td><?= $sn++; ?></td>
                                <td><?= User::find(User::$table, 'id', $investment['user_id'])[0]['email'] ?></td>
                                <td><?= Package::package($investment['package_id'])[0]['package_name']; ?></td>
                                <td><?= '$'.number_format($investment['amount']); ?></td>
                                <td><?= '$'.number_format($investment['expected_amount']); ?></td>
                                <td><button class="btn btn-outline-success btn-sm">completed</button></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

</div>

<?php if (User::isMember() || User::isModerator()) : ?>
<script>
    $('form').submit((e) => {
        e.preventDefault();
        var formdata = $(e.target).serialize();
        
        $(e.target[1]).prop('disabled', 'true').html('pocessing  . . .');

        setTimeout(() => {
            $.ajax({
                type : 'POST',
                url : '/investment/withdrawtowallet',
                data : formdata,
                success : (response) => {
                    if (response) {
                        alert('Your request has been processed')
                        location.reload();
                    } else {
                        alert('An error occurred while processing your request');
                        $(e.target[1]).removeAttr('disabled').html('withdraw to wallet');
                    }
                }
            })
        }, 3000);

    })
</script>

<?php endif; ?>