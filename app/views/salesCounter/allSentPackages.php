<?php $this->start("head"); ?>
<?php $this->end(); ?>
<?php $this->start("body"); ?>
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 mt-4">
                <h3 class="text-primary">Sent Packages</h3>
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

        <form class="mb-1" name="all_sent_packages" id="all_sent_packages" method="POST" action="<?= $action; ?>">
            <div class="row form-group">
                <div class="col-sm-2 ml-auto">
                    <label class="" for="search_receipt_no">Receipt No.</label>
                    <input type="text" name="search_receipt_no" id="search_receipt_no" class="form-control mb-2 mr-sm-2"
                        value="<?= $search_receipt_no; ?>" />
                </div>

                <div class="col-sm-3">
                    <label class="" for="search_sender_name">Sender Name</label>
                    <input type="text" name="search_sender_name" id="search_sender_name"
                        class="form-control mb-2 mr-sm-2" value="<?= $search_sender_name; ?>" />
                </div>
                <div class="col-sm-3">
                    <label class="" for="search_receiver_name">Receiver Name</label>
                    <input type="text" name="search_receiver_name" id="search_receiver_name"
                        class="form-control mb-2 mr-sm-2" value="<?= $search_receiver_name; ?>" />
                </div>


                <div class="col-sm-1">
                    <label class="" for="date_from">From</label>
                    <input type="text" name="date_from" id="date_from" data-provide="datepicker"
                        data-date-format="yyyy-mm-dd" class="form-control mb-2 mr-sm-2" readonly
                        value="<?= $date_from; ?>" required />
                </div>
                <div class="col-sm-1">
                    <label class="" for="date_to">To</label>
                    <input type="text" name="date_to" id="date_to" data-provide="datepicker"
                        data-date-format="yyyy-mm-dd" class="form-control mb-2 mr-sm-2" readonly
                        value="<?= $date_to; ?>" required />
                </div>
                <div class="col-sm-1">
                    <label class="" for="btn_search" style="color:white;">Search</label>
                    <button type="submit" name="btn_search" id="btn_search"
                        class="form-control btn btn-success mb-2 rounded-0">Search</button>
                </div>
                <div class="col-sm-1">
                    <label class="" for="btn_export" style="color:white;">Export</label>
                    <button type="submit" name="btn_export" id="btn_export"
                        class="form-control btn btn-info mb-2 rounded-0">Export</button>
                </div>
            </div>
            <hr />
            <div class="card mb-4 rounded-0">
                <div class="card-header"><i class="fa fa-table mr-1"></i>Sent Packages</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-center">
                                <tr>
                                    <th>Sn</th>
                                    <th>Receipt No.</th>
                                    <th>Sender Name</th>
                                    <th>Sender Contacts</th>
                                    <th>Date Sent</th>
                                    <th>Sent From</th>
                                    <th>Receiver Name</th>
                                    <th>Receiver Contacts</th>
                                    <th>Receiver Location</th>
                                    <th>Expected Collection Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="rs_sites" class="">
                                <?php if (isset($rs_all_sent_packages)) : ?>
                                <?php $i = (($pg_no - 1) * $rows_per_pg); ?>
                                <?php foreach ($rs_all_sent_packages as $item) : ?>
                                <?php $i++; ?>
                                <tr>
                                    <td class="text-right"><?= $i; ?></td>
                                    <td class="text-center"><?= $item['receipt_no']; ?></td>
                                    <td class=""><?= $item['sender_name']; ?></td>
                                    <td class=""><?= $item['sender_contacts']; ?></td>
                                    <td class=""><?= $item['date_received']; ?></td>
                                    <td class="text-center"><?= $item['city_from']; ?></td>
                                    <td class="text-center"><?= $item['receiver_name']; ?></td>
                                    <td class="text-center"><?= $item['receiver_contacts']; ?></td>
                                    <td class="text-center"><?= $item['city_to']; ?></td>
                                    <td class=""><?= $item['collection_date']; ?></td>
                                    <td class=""><?= $item['sending_package_status']; ?></td>
                                    <td class="text-center">
                                        <?php if($item['sending_package_status']== "DROP OFF"):?>
                                        <a href="<?= PROOT; ?>SalesCounter/vOneSentPackage/<?= $item['c0d']; ?>"
                                            id="view<?= $item["c0d"]; ?>"
                                            class="btn btn-info  btn-view rounded-0">Update</a>


                                        <?php elseif($item['sending_package_status']== "IN TRANSIT"):?>
                                        <a href="<?= PROOT; ?>SalesCounter/receivePackage/<?= $item['c0d']; ?>"
                                            id="view<?= $item["c0d"]; ?>"
                                            class="btn btn-warning  btn-view rounded-0">Receive</a>
                                        <?php elseif($item['sending_package_status']== "ARRIVED"):?>
                                        <a href="<?= PROOT; ?>SalesCounter/collectPackage/<?= $item['c0d']; ?>"
                                            id="view<?= $item["c0d"]; ?>"
                                            class="btn btn-success  btn-view rounded-0">Collect</a>

                                        <?php endif;?>
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

        </form>
    </div>
</main>
<?php $this->end(); ?>
<?php $this->start("section_js"); ?>
<script>
$('#date_from').datepicker({

    autoclose: true,
    todayHighlight: true
});
$('#date_to').datepicker({
    autoclose: true,
    todayHighlight: true
});
</script>
<?php $this->end(); ?>