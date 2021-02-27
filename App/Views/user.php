<h1 class="dash-title">User</h1>

<div class="row">
<div class="col-lg-12">
    <div class="card spur-card">
        <div class="card-header">
            <div class="spur-card-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="spur-card-title"><?= $params[0]['firstname'].' '.$params[0]['lastname'] ?></div>
        </div>
        <div class="card-body card-body-with-dark-table">
            <table class="table table-dark table-in-card" border="1">
                <thead>
                    <tr>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">country</th>
                        <th scope="col">state</th>
                        <th scope="col">city</th>
                        <th scope="col">address</th>
                        <th scope="col">phone</th>
                        <th scope="col">gender</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($params as $user) : ?>
                    <tr>
                        <td><?= $user['firstname']; ?></td>
                        <td><?= $user['lastname']; ?></td>
                        <td><?= $user['country']; ?></td>
                        <td><?= $user['state']; ?></td>
                        <td><?= $user['city']; ?></td>
                        <td><?= $user['address']; ?></td>
                        <td><?= $user['phone']; ?></td>
                        <td><?= $user['gender']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>