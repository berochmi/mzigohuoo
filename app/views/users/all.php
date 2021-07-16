<?php $this->start("head"); ?>
<?php $this->end(); ?>
<?php $this->start("body"); ?>
<main>
    <div class="container-fluid mb-1">
        <div class="row">
            <div class="col-sm-4 mt-4">
                <h2 class="">Users</h2>
            </div>
            <div class="col-sm-2 mt-4 ml-auto text-right">
                <h1><a href="<?= $back_to_1; ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </h1>
            </div>
        </div>
        <hr class="bg-info" />
        <div class="row">
            <div class="col-sm-12" id="fb_msg">
                <?= $vars["fb_msg"]; ?>
            </div>
        </div>
        <div class="">
            <form class="" method="POST" action="<?= $action; ?>" id="form_products">
                <div class="row form-group">
                    <div class="col-sm-3 ml-auto">
                        <label class="" for="search_term">Search Name</label>
                        <input type="text" name="search_term" id="search_term" class="form-control mb-2 mr-sm-2" value="<?= $search_term; ?>">
                    </div>
                    <div class="col-sm-2">
                        <label class="" for="btn_search" style="color:white;">Search</label>
                        <button type="submit" name="btn_search" id="btn_search" class="form-control btn btn-success mb-2 rounded-0">Search</button>
                    </div>
                    <div class="col-sm-2">
                        <label class="" for="btn_export" style="color:white;">Export</label>
                        <button type="submit" name="btn_export" id="btn_export" class="form-control btn btn-info mb-2 rounded-0">Export</button>
                    </div>
                </div>
                <hr />
            </form>
        </div>
        <div class="card mb-4 rounded-0">
            <div class="card-header"><i class="fa fa-table mr-1"></i>Users</div>
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
                            <?php if (isset($rs_users)) : ?>
                            <?php $i = 0; ?>
                            <?php foreach ($rs_users as $item) : ?>
                            <?php $i++; ?>
                            <tr class="text-right">
                                <td><?= $i; ?></td>
                                <td class="text-left"><?= $item['fname']; ?></td>
                                <td class="text-left"><?= $item['lname']; ?></td>
                                <td class="text-left"><?= $item['username']; ?></td>
                                <td class="text-left"><?= $item['role']; ?></td>
                                <td class="text-center">
                                    <a href="<?= PROOT; ?>users/eone/<?= $item['c0d']; ?>"
                                        id="view<?= $item['c0d']; ?>"
                                        class="btn btn-info  btn-view rounded-0">VIEW</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?= $pagination; ?>
                </div>
            </div>
        </div>

 
    </div>
</main>

<?php $this->end(); ?>
<?php $this->start("section_js"); ?>

<?php $this->end(); ?>