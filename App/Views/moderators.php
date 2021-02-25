<h1 class="dash-title">Users</h1>
<div class="row">
<div class="col-lg-12">
    <div class="card spur-card">
        <div class="card-header">
            <div class="spur-card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="">Moderators</div>
        </div>
        <div class="card-body card-body-with-dark-table">
            <table class="table table-dark table-in-card">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($params as $moderator) : ?>
                    <tr>
                        <th scope="row">1</th>
                        <td><?= $moderator['user']['email']; ?></td>
                        <td><?= $moderator['auth']['is_active'] ? '<button class="btn btn-outline-success btn-sm mb-1">active</button>' : '<button class="btn btn-outline-danger btn-sm mb-1">inactive</button>'; ?></td>
                        <td>
                            
                            <a href="<?= VIEW_USER.$moderator['user']['id']; ?>" class="btn btn-primary btn-sm mb-3" title="view profile">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="<?= VIEW_USER_REFERRALS.$moderator['user']['id']; ?>" class="btn btn-info btn-sm mb-3"><i class="fa fa-users" title="view referrals"></i></a>
                            <button class="btn btn-warning btn-sm mb-3" title="downgrade to normal user" id="downgrade" user-id="<?= $moderator['user']['id']; ?>">
                                <i class="fa fa-angle-double-down"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" title="delete moderator" id="delete" user-id="<?= $moderator['user']['id'] ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                            
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

<script>
    $('button').click((e) => {
        var btn = $(e.currentTarget);
        var action = btn.attr('id');
        var userid = btn.attr('user-id');
        var verify = confirm('Are you sure to '+action+' this user');

        if (verify == true) {
            $.ajax({
                type : 'POST',
                url : '/user/'+action,
                data : {
                    userid : userid
                },
                success : (response) => {
                    if (response) {
                        alert('user has been '+action+'d');
                        location.reload();
                    } else {
                        alert('An error occurred');
                    }
                }
            })
        }
    })
</script>