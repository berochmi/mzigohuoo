<?php $this->start("head"); ?>
<?php $this->end(); ?>
<?php $this->start("body"); ?>
<main>
    <div class="container-fluid mb-1">
        <div class="row">
            <div class="col-sm-12 mt-4">
                <h2 class="text-center">Change Password</h2>
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
                <div class="col-sm-3 ml-auto">
                    <label class="text-center" for="password">New Password</label>
                    <input type="password" name="password" id="password" class="form-control mb-2 mr-sm-2" value="<?= $password; ?>">
                </div>
                <?= Tool::csrfInput(); ?>

                <div class="col-sm-2  mr-auto">
                    <label class="" for="add" style="color: white;">add</label>
                    <button type="submit" name="add" id="add"
                        class="form-control btn btn-success mb-2 rounded-0">Update</button>
                </div>

            </div>



        </form>
   

    </div>
</main>
<?php $this->end(); ?>
<?php $this->start("section_js"); ?>
<script src="<?= PROOT; ?>js/change_password.js?p=1"></script>
<?php $this->end(); ?>