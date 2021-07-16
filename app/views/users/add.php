<?php $this->start("head"); ?>
<?php $this->end(); ?>
<?php $this->start("body"); ?>
<main>
    <div class="container-fluid mb-1">
        <div class="row">
            <div class="col-sm-4 mt-4">
                <h2 class="">Add User</h2>
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
                        <option value="<?= $user_role['c0d']; ?>"
                            <?= $user_role == $user_role['user_group_name'] ? " selected " : " "; ?>>
                            <?= $user_role['user_group_name']; ?></option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-sm-2 ml-auto">
                    <label class="" for="add" style="color: white;">add</label>
                    <button type="submit" name="add" id="add"
                        class="form-control btn btn-success mb-2 rounded-0">Add</button>
                </div>

            </div>



        </form>
        <div class="card mb-4 rounded-0">
            <div class="card-header"><i class="fa fa-table mr-1"></i>Products</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sn</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Role</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="rs_user" class="">
                            <?php if (isset($rs_items)) : ?>
                            <?php $i = 0; ?>
                            <?php foreach ($rs_items as $item) : ?>
                            <?php $i++; ?>
                            <tr class="text-right">
                                <td><?= $i; ?></td>
                                <td class="text-left"><?= $item['fname']; ?></td>
                                <td class="text-left"><?= $item['lname']; ?></td>
                                <td class="text-left"><?= $item['username']; ?></td>
                                <td class="text-left"><?= $item['role']; ?></td>
                                <td class="text-center">
                                    <a href="<?= PROOT; ?>users/eone/<?= $item['user_id']; ?>"
                                        id="view<?= $item['user_id']; ?>"
                                        class="btn btn-info  btn-view rounded-0">VIEW</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</main>
<?php $this->end(); ?>
<?php $this->start("section_js"); ?>
<script src="<?= PROOT; ?>js/add_user.js?p=2"></script>
<?php $this->end(); ?>