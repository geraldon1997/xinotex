<?php
use App\Models\User;
use App\Models\Profile as P;
use App\Controllers\Location as L;
?>
<div class="col-xl-12">
    <div class="card spur-card">
        <div class="card-header">
            <div class="spur-card-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="spur-card-title"> Profile </div>
        </div>
        <div class="card-body ">
            <form id="<?= User::hasProfile() ? 'update' : 'add'; ?>" class="form">
            
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">First Name</label>
                        <input type="text" class="form-control" name="firstname" id="inputEmail4" placeholder="First Name" value="<?= P::authUser() ? P::authUser()['firstname'] : ''; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="inputPassword4" placeholder="Last Name" value="<?= P::authUser() ? P::authUser()['lastname'] : ''; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="country">Country</label>
                        <select id="inputCountry" name="country" class="form-control">
                            <option value="<?= P::authUser() ? P::authUser()['country'] : ''; ?>"><?= P::authUser() ? P::authUser()['country'] : 'country of residence ...'; ?></option>
                            <?php foreach (L::countries() as $country) : ?>
                            <option value="<?= $country['country']; ?>"><?= $country['country']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="state">State</label>
                        <input type="text" name="state" id="" class="form-control" placeholder="State of residence" value="<?= P::authUser() ? P::authUser()['state'] : ''; ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">City</label>
                        <input type="text" name="city" id="" class="form-control" placeholder="City" value="<?= P::authUser() ? P::authUser()['city'] : ''; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" id="inputAddress" placeholder="Residential Address" value="<?= P::authUser() ? P::authUser()['address'] : ''; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input type="tel" name="phone" id="inputPhone" class="form-control" placeholder="Enter contact phone" value="<?= P::authUser() ? P::authUser()['phone'] : ''; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Gender</label>
                        <select name="gender" id="" class="form-control">
                            <option value="<?= P::authUser() ? P::authUser()['gender'] : ''; ?>"><?= P::authUser() ? P::authUser()['gender'] : 'Gender'; ?></option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="others">others</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="update">Update</button>
            </form>
        </div>
    </div>
</div>

<script>
    // $.ajax({
    //     type : 'GET',
    //     url : '/location/countries',
    //     success : (data) => {
    //         console.log(data)

    //         var countries = data;
    //         countries.forEach(country => {
    //             $('#inputCountry').append("<option value="+country.country+">"+country.country+"</option>"); 
    //         });
    //     }
    // })

    $('form').submit((e) => {
        e.preventDefault();

        var form = $('.form').attr('id');
        var formdata = $('form').serialize();

        $('form #update').prop('disabled','true').html('processing . . .');
        if (form === 'add') {
            $.ajax({
                type : "POST",
                url : "/user/addprofile",
                data : formdata,
                success : (response) => {
                    if (response) {
                        alert('Profile updated');
                        location.href = "<?= ACTIVE_INVESTMENT; ?>";
                    }
                    $('form #update').removeAttr('disabled').html('Update');
                }
            });
        } else if (form === 'update') {
            $.ajax({
                type : "POST",
                url : "/user/updateprofile",
                data : formdata,
                success : (response) => {
                    if (response) {
                        alert('Profile updated');
                        location.reload();
                    }
                    $('form #update').removeAttr('disabled').html('Update');
                }
            });
        }
        
    });
</script>