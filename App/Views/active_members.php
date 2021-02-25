<?php $sn = 1; ?>
<h1 class="dash-title">Users</h1>
<div class="row">
<div class="col-lg-12">
    <div class="card spur-card">
        <div class="card-header">
            <div class="spur-card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="">Active members</div>
        </div>
        <div class="card-body card-body-with-dark-table" style="overflow:auto;">
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
                    <?php foreach ($params as $active) : ?>
                    <tr>
                        <th scope="row"><?= $sn++; ?></th>
                        <td><?= $active['user']['email'] ?></td>
                        <td><?= $active['auth']['is_active'] ? '<button class="btn btn-outline-success btn-sm mb-1">active</button>' : '<button class="btn btn-outline-danger btn-sm mb-1">inactive</button>'; ?></td>
                        <td>

                            <a href="<?= VIEW_USER.$active['user']['id']; ?>" class="btn btn-primary btn-sm mb-3" title="view profile" >
                                <i class="fa fa-eye"></i>
                            </a>

                            <button class="btn btn-success btn-sm mb-3" title="upgrade user to moderator" id="upgrade" user-id="<?= $active['user']['id']; ?>">
                                <i class="fa fa-angle-double-up"></i>
                            </button>

                            <button class="btn btn-danger btn-sm" title="delete user" id="delete" user-id="<?= $active['user']['id']; ?>" >
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
                        alert('an error occurred');
                    }
                }
            })
        }
    })
</script>