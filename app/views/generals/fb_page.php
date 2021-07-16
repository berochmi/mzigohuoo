<?php $this->start("head"); ?>
<?php $this->end(); ?>
<?php $this->start("body"); ?>
<main>
    <div class="container-fluid">
        <h3 class="mt-4" style="text-align: center;"></h3>
        <div class="row">
            <div class="col-sm-12"><?= $fb_msg; ?></div>
        </div>
    </div>
</main>
<?php $this->end(); ?>