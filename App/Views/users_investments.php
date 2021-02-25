<?php
use App\Models\Package;

$sn = 1;
?>
<h1 class="dash-title"><?= $params['email']; ?> Investmtents</h1>

<div class="row">
    <div class="col-lg-12">
        <div class="card spur-card">
            <div class="card-header">
                <div class="spur-card-icon">
                    <i class="fas fa-table"></i>
                </div>
                <div class="spur-card-title">All Investments</div>
            </div>
            <div class="card-body card-body-with-dark-table">
                <table class="table table-dark table-in-card">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Package</th>
                            <th scope="col">Amount</th>
                            <th scope="col">ROI</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($params['investments'] as $investment) : ?>
                            <tr>
                                <td><?= $sn++; ?></td>
                                <td><?= Package::find(Package::$table, 'id', $investment['package_id'])[0]['package_name'] ?></td>
                                <td><?= '$'.number_format($investment['amount']); ?></td>
                                <td><?= '$'.number_format($investment['expected_amount']); ?></td>
                                <td>
                                    <?php if ($investment['is_paid'] && $investment['is_active']) : ?>
                                        <button class="btn btn-outline-primary btn-sm">active</button>
                                    <?php elseif ($investment['is_paid'] && !$investment['is_active']) : ?>
                                        <button class="btn btn-outline-warning btn-sm">pending</button>
                                    <?php elseif ($investment['is_paid'] && !$investment['is_active'] && $investment['is_completed']) : ?>
                                        <button class="btn btn-outline-success btn-sm">completed</button>
                                    <?php elseif ($investment['is_paid'] && !$investment['is_active'] && !$investment['is_completed']) : ?>
                                        <button class="btn btn-outline-warning btn-sm">awaiting confirmation</button>
                                    <?php elseif (!$investment['is_paid'] && !$investment['is_active'] && !$investment['is_completed']) : ?>
                                        <button class="btn btn-outline-danger btn-sm">not paid</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
