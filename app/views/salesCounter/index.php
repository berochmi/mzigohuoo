<?php $this->start("head"); ?>
<?php $this->end(); ?>
<?php $this->start("body"); ?>
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 mt-4">
                <h3 class="text-primary">Dashboard</h3>
            </div>
            <div class="col-sm-2 mt-4 ml-auto text-right">


            </div>
        </div>
        <hr class="bg-info" />
        <div class="row form-group rounded-0 ">

            <div class="col-sm-4">
                <div class="card rounded-0 bg-warning text-white" style="width: 100%;height:170px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <h4 class="card-title">Current Month's Package</h4>
                                <h5 class="card-subtitle mb-2 font-italic">Sent Pacakges:
                                    <?= number_format($packages_sent,0);?>
                                </h5>
                                <h5 class="card-subtitle mb-2 font-italic">Received Packages:
                                    <?= number_format($packages_received,0);?>
                                </h5>
                                <h5 class="card-subtitle mb-2 font-italic">Collected Packages:
                                    <?= number_format($packages_collected,0);?>
                                </h5>

                            </div>
                            <div class="col-sm-4 border-left">
                                <h1 class="text-left mt-4"><?= number_format($percent_collected,0);?> %</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
<?php $this->end(); ?>
<?php $this->start("section_js"); ?>
<script src="<?= PROOT; ?>js/Chart.min.js?p=8"></script>
<?php $this->end(); ?>