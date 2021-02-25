<?php

use App\Models\Auth;
use App\Models\User;

$sn = 1;
?>
<h1 class="dash-title">Referrals</h1>

<div class="row">
    <div class="col-lg-10">
        <div class="form-group">
            <input type="text" id="reflink" class="form-control" value="<?= APP_URL.ltrim(SIGNUP, '/').'/'.User::ref($_SESSION['email']) ?>">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <button class="form-control btn btn-outline-primary" id="copylink">copy link</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card spur-card">
            <div class="card-header">
                <div class="spur-card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="spur-card-title">referred members</div>
            </div>
            <div class="card-body card-body-with-dark-table">
                <table class="table table-dark table-in-card">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <?php if (User::isModerator()) : ?>
                            <th scope="col">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($params as $referrals) : ?>
                        <tr>
                            <td><?= $sn++; ?></td>
                            <td><?= User::find(User::$table, 'id', $referrals['referred'])[0]['email'] ?></td>
                            <td>
                                <?= Auth::find(Auth::$table, 'user_id', $referrals['referred'])[0]['is_active'] ? '<button class="btn btn-outline-warning btn-sm">pending</button>' : '<button class="btn btn-outline-success btn-sm">active</button>' ?>
                            </td>
                            <?php if (User::isModerator()) : ?>
                                <td>
                                    <a href="<?= VIEW_USER.$referrals['referred']; ?>" class="btn btn-primary btn-sm" id="details" user-id="<?= 1; ?>" title="view profile"><i class="fa fa-eye"></i> </a>
                                    <a href="<?= VIEW_USER_INVESTMENTS.$referrals['referred']; ?>" class="btn btn-info btn-sm" id="investments" user-id="<?= 1; ?>" title="view investments"><i class="fa fa-money-bill-wave"></i></a>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('#copylink').click(() => {
        var link = $('#reflink');

        link.select();

        document.execCommand('copy');

        $('#copylink').html('link copied');

        setTimeout(() => {
            $('#copylink').html('copy link')
        }, 5000);
    });
</script>

<?php if (User::isModerator()) : ?>
    <script>
        $('button').click((e) => {
            var btn = $(e.currentTarget);
            var btnType = btn.attr('id');
            var id = btn.attr('user-id');

            $.ajax({
                type : 'POST',
                url : '/user/'+id,
                data : {
                    userid : id
                },
                success: (response) => {
                    console.log(response);
                }
            })
        })
    </script>
<?php endif; ?>