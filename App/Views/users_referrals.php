<?php $sn = 1; ?>
<h1 class="dash-title"><?= $params['referrer']; ?> referrals</h1>

<div class="row">
    <div class="col-lg-12">
        <div class="card spur-card">
            <div class="card-header">
                <div class="spur-card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="spur-card-title">Referrals</div>
            </div>
            <div class="card-body card-body-with-dark-table">
                <table class="table table-dark table-in-card">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($params['referred'] as $referred) : ?>
                            <tr>
                                <td><?= $sn++; ?></td>
                                <td><?= $referred['email'] ?></td>
                                <td>button</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>