<?php $this->start("head"); ?>
<?php $this->end(); ?>
<?php $this->start("body"); ?>
<main>
    <div class="container-fluid mb-1">
        <div class="row">
            <div class="col-sm-4 mt-4">
                <h2 class="">Update User</h2>
            </div>
            <div class="col-sm-2 mt-4 ml-auto text-right">
                <h1><a href="<?= $back_to_1; ?>"><i class="fa fa-backward" aria-hidden="true"></i></a>
                </h1>
            </div>
        </div>
        <hr class="bg-info" />
        <div class="row">
            <div class="col-sm-12" id="fb_msg">
                <?= $vars["fb_msg"]; ?>
            </div>
        </div>
        <form class="mb-1" name="add-product" id="add-product" method="POST" action="<?= $action; ?>"
            enctype="multipart/form-data">
            <div class="row form-group">
                <div class="col-sm-3">
                    <label class="" for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" class="form-control mb-2 mr-sm-2" value="<?= $fname; ?>">
                </div>
                <?= Tool::csrfInput(); ?>
                <div class="col-sm-3">
                    <label class="" for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" class="form-control mb-2 mr-sm-2" value="<?= $lname; ?>">
                </div>
                <div class="col-sm-3">
                    <label class="" for="mname">Other Name</label>
                    <input type="text" name="mname" id="mname" class="form-control mb-2 mr-sm-2" value="<?= $mname; ?>">
                </div>
                <div class="col-sm-3">
                    <label class="" for="staff_id">Staff ID</label>
                    <input type="text" name="staff_id" id="staff_id" class="form-control mb-2 mr-sm-2 my-num"
                        value="<?= $staff_id; ?>">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-3">
                    <label class="" for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control mb-2 mr-sm-2"
                        value="<?= $username; ?>">
                </div>
                <div class="col-sm-2">
                    <label class="" for="role">User Role</label>
                    <select type="text" name="role" id="role" class="form-control mb-2 mr-sm-2">
                        <option value=""></option>
                        <?php if (isset($rs_user_roles)) : ?>
                        <?php foreach ($rs_user_roles as $user_role) : ?>
                        <option value="<?= $user_role['user_group_name']; ?>"
                            <?= strtolower($role) == strtolower($user_role['user_group_name']) ? " selected " : " "; ?>>
                            <?= $user_role['user_group_name']; ?></option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <input type="hidden" id="user_id" value="<?= $user_id;?>" />
                </div>
                <div class="col-sm-2">
                    <label class="" for="deleted">Status</label>
                    <select name="deleted" id="deleted" class="form-control mb-2 mr-sm-2">

                        <option value="0" <?= $deleted == '0' ? ' selected ' : ''; ?>>ACTIVE</option>
                        <option value="1" <?= $deleted == '1' ? ' selected ' : ''; ?>>INACTIVE</option>

                    </select>

                </div>

                <div class="col-sm-2">
                    <label class="" for="add" style="color: white;">add</label>
                    <button type="submit" name="add" id="add"
                        class="form-control btn btn-success mb-2 rounded-0">Update</button>
                </div>

            </div>
            <hr />
            <div class="row form-group">
                <div class="col-sm-3 ml-auto">
                    <label class="text-center" for="reset_password">New Password</label>
                    <input type="password" name="reset_password" id="reset_password" class="form-control mb-2 mr-sm-2"
                        value="<?= $password; ?>">
                </div>
                <div class="col-sm-2 mr-auto">
                    <label class="" for="btn_reset_password" style="color: white;">add</label>
                    <button type="submit" name="btn_reset_password" id="btn_reset_password"
                        class="form-control btn btn-warning mb-2 rounded-0">Reset Password</button>
                </div>
            </div>



        </form>
    </div>
</main>
<?php $this->end(); ?>
<?php $this->start("section_js"); ?>
<script src="<?= PROOT; ?>js/edit_user.js?p=3"></script>
<?php $this->end(); ?>