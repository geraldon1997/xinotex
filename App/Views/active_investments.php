<?php
use App\Models\Package;
use App\Models\Investment;
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
                <div class="">Active investment</div>
            </div>
            <div class="card-body card-body-with-dark-table" >
                <?php if (array_key_first($params) == 'user') : ?>
                <table class="table table-dark table-in-card">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">package</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Maturity Date</th>
                            <th scope="col">ROI</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($params['user'] as $investment) : ?>
                            <?php if ($investment['period'] < time()) : ?>
                                <?php Investment::update(Investment::$table, "is_active = 0, is_completed = 1", 'id', $investment['id']); ?>
                            <?php endif; ?>
                        <tr>
                            <td><?= $sn++; ?></td>
                            <td><?= Package::package($investment['package_id'])[0]['package_name'] ?></td>
                            <td><?= '$'.number_format($investment['amount']); ?></td>
                            <td><?= date('d-m-Y', $investment['period']) ?></td>
                            <td><?= '$'.number_format($investment['expected_amount']); ?></td>
                            <td><button class="btn btn-outline-primary btn-sm">active</button></td>
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
                            <?php if ($params['admin']) : ?>
                                <?php foreach ($params['admin'] as $investment) : ?>
                                    <tr>
                                        <td><?= $sn++; ?></td>
                                        <td><?= User::find(User::$table, 'id', $investment['user_id'])[0]['email'] ?></td>
                                        <td>
                                            <?= Package::find(Package::$table, 'id', $investment['package_id'])[0]['package_name'] ?>
                                        </td>
                                        <td><?= number_format($investment['amount']); ?></td>
                                        <td><?= number_format($investment['expected_amount']); ?></td>
                                        <td><button class="btn btn-outline-primary btn-sm">active</button></td>
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
