<?php $this->start("head"); ?>
<?php $this->end(); ?>
<?php $this->start("body"); ?>
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 mt-4">
                <h3 class="text-primary">Sending Package, Add Package Details</h3>
            </div>
            <div class="col-sm-2 mt-4 ml-auto text-right">
                <h3>
                    <a class="btn btn-info" href="<?= PROOT; ?>SalesCounter/sendPackage"><i class="fa fa-plus"
                            aria-hidden="true"></i></a>
                    <a class="btn btn-info" href="<?= PROOT; ?>SalesCounter/allSentPackages"><i class="fa fa-backward"
                            aria-hidden="true"></i></a>
                </h3>
            </div>
        </div>
        <hr class="bg-info" />
        <div class="row">
            <div class="col-sm-12" id="fb_msg">
                <?= $vars["fb_msg"]; ?>
            </div>
        </div>
        <form class="mb-1" name="add_site" id="add_site" method="POST" action="<?= $action; ?>">
            <div class="row form-group">
                <div class="col-sm-3">
                    <label class="" for="city_to">City Sending To</label>
                    <select name="city_to" id="city_to" class="form-control mb-2 mr-sm-2" required>
                        <option value="">Select City</option>
                        <?php if (isset($rs_bases)) : ?>
                        <?php foreach ($rs_bases as $item) : ?>
                        <option <?= $city_to ==$item["base_name"]? " selected ": "";?>><?= $item['base_name']; ?>
                        </option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <?= Tool::csrfInput(); ?>
                <div class="col-sm-3">
                    <label class="" for="to_branch_id">Branch Sending To</label>
                    <div id="rs_branches_to">
                        <select class="form-control lazima" name="to_branch_id" id="to_branch_id">
                            <option></option>
                            <?php if (isset($rs_branches_to)) : ?>
                            <?php foreach ($rs_branches_to as $item) : ?>
                            <option <?= $to_branch_id == $item['c0d']? " selected ": " ";?>
                                value="<?= $item['c0d']; ?>">
                                <?= $item['branch_name']; ?></option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label class="" for="sender_name">Sender Name</label>
                    <input type="text" name="sender_name" id="sender_name" class="form-control mb-2 mr-sm-2"
                        value="<?= $sender_name; ?>" required />
                </div>
                <div class="col-sm-3">
                    <label class="" for="sender_contacts">Sender Contacts</label>
                    <input type="text" name="sender_contacts" id="sender_contacts"
                        class="form-control mb-2 mr-sm-2 my-num-only" value="<?= $sender_contacts; ?>" required />
                </div>
            </div>
            <hr />
            <div class="row form-group">
                <div class="col-sm-6 ml-auto">
                    <label class="" for="package_description">Package Description</label>
                    <input type="text" name="package_description" id="package_description"
                        class="form-control mb-2 mr-sm-2" value="<?= $package_description; ?>" required />
                </div>
                <div class="col-sm-1 text-center">
                    <label for="package_qty">Qty</label>
                    <input type="text" name="package_qty" id="package_qty" class="form-control mb-2 mr-sm-2 text-right"
                        value="<?= $package_qty; ?>" required />
                </div>
                <div class="col-sm-1 text-center">
                    <label for="package_amount_paid">Amount Paid</label>
                    <input type="text" name="package_amount_paid" id="package_amount_paid"
                        class="form-control mb-2 mr-sm-2 text-right" value="<?= $package_amount_paid; ?>" required />
                </div>
                <div class="col-sm-1">
                    <label class="" for="date_received">Date</label>
                    <input type="text" name="date_received" id="date_received" data-provide="datepicker"
                        data-date-format="yyyy-mm-dd" class="form-control mb-2 mr-sm-2" readonly
                        value="<?= $date_received; ?>" required style="background-color:white;" required />
                </div>
                <div class="col-sm-1 text-center">
                    <label class="" for="time_received">Time</label>
                    <input type="text" name="time_received" id="time_received"
                        class="form-control mb-2 mr-sm-2 timepicker-without-dropdown" style="background: white;"
                        value="<?= $time_received;?>" required placeholder="hh:mm" />
                </div>
            </div>
            <hr />
            <div class="row form-group">
                <div class="col-sm-3 ml-auto">
                    <label class="" for="receiver_name">Receiver Name</label>
                    <input type="text" name="receiver_name" id="receiver_name" class="form-control mb-2 mr-sm-2"
                        value="<?= $receiver_name; ?>" required />
                </div>
                <div class="col-sm-3">
                    <label class="" for="receiver_contacts">Receiver Contacts</label>
                    <input type="text" name="receiver_contacts" id="receiver_contacts"
                        class="form-control mb-2 mr-sm-2 my-num-only" value="<?= $receiver_contacts; ?>" required />
                </div>
                <div class="col-sm-1">
                    <label class="" for="collection_date">Collect Date</label>
                    <input type="text" name="collection_date" id="collection_date" data-provide="datepicker"
                        data-date-format="yyyy-mm-dd" class="form-control mb-2 mr-sm-2" readonly
                        value="<?= $collection_date; ?>" required style="background-color:white;" />
                </div>
                <div class="col-sm-1 text-center">
                    <label class="" for="collection_time">Collect Time</label>
                    <input type="text" name="collection_time" id="collection_time"
                        class="form-control mb-2 mr-sm-2 timepicker-without-dropdown" style="background: white;"
                        value="<?= $collection_time;?>" required placeholder="hh:mm" />
                </div>
                <div class="col-sm-1">
                    <label class="" for="add" style="color:white;">Add</label>
                    <button type="submit" name="add" id="add"
                        class="form-control btn btn-success mb-2 rounded-0">Add</button>
                </div>
            </div>
            <hr class="bg-info" />
        </form>
    </div>
</main>
<?php $this->end(); ?>
<?php $this->start("section_js"); ?>
<script src="<?= PROOT; ?>js/cleave-phone.tz.js?v=1"></script>
<script src="<?= PROOT; ?>js/salesCounter/sendPackage.js?v=12"></script>
<?php $this->end(); ?>