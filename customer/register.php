<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
  ob_start();
  // if(!isset($_SESSION['system'])){

    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  // }
  ob_end_flush();
?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>
<?php include 'header.php' ?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">Pick&GO <b><?php echo $_SESSION['system']['name'] ?></b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <div class="col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <form action="" id="manage-staff">
                                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="msg" class=""></div>

                                        <div class="row">
                                            <div class="col-sm-12 form-group ">
                                                <label for="" class="control-label">First Name</label>
                                                <input type="text" name="firstname" id=""
                                                    class="form-control form-control-sm"
                                                    value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
                                            </div>
                                            <div class="col-sm-12 form-group ">
                                                <label for="" class="control-label">Last Name</label>
                                                <input type="text" name="lastname" id=""
                                                    class="form-control form-control-sm"
                                                    value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 form-group ">
                                                <label for="" class="control-label">Branch</label>
                                                <select name="branch_id" id="" class="form-control input-sm select2">
                                                    <option value=""></option>
                                                    <?php
                    $branches = $conn->query("SELECT *,concat(street,', ',city,', ',state,', ',zip_code,', ',country) as address FROM branches");
                    while($row = $branches->fetch_assoc()):
                  ?>
                                                    <option value="<?php echo $row['id'] ?>"
                                                        <?php echo isset($branch_id) && $branch_id == $row['id'] ? "selected":'' ?>>
                                                        <?php echo $row['branch_code']. ' | '.(ucwords($row['address'])) ?>
                                                    </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 form-group ">
                                                <label for="" class="control-label">Email</label>
                                                <input type="email" name="email" id=""
                                                    class="form-control form-control-sm"
                                                    value="<?php echo isset($email) ? $email : '' ?>" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 form-group ">
                                                <label for="" class="control-label">Password</label>
                                                <input type="password" name="password" id=""
                                                    class="form-control form-control-sm"
                                                    <?php echo isset($id) ? '' : 'required' ?>>
                                                <?php if(isset($id)): ?>
                                                <small class=""><i>Leave this blank if you dont want to change
                                                        this</i></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer border-top border-info">
                            <div class="d-flex w-100 justify-content-center align-items-center">
                                <button class="btn btn-flat  bg-gradient-secondary mx-2"
                                    form="manage-staff">Save</button>
                                <a class="btn btn-flat bg-gradient-secondary mx-2"
                                    href="./index.php?page=staff_list">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
$('#manage-staff').submit(function(e) {
    e.preventDefault()
    $.ajax({
        url: 'ajax.php?action=save_user',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
              location.href = 'login.php';
            } else if (resp == 2) {
                $('#msg').html(
                    '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Email already exist.</div>'
                )
                end_load()
            }
        }
    })
})

function displayImgCover(input, _this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#cover').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>