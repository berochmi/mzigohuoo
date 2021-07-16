<select class="form-control lazima" name="to_branch_id" id="to_branch_id">
    <option></option>
    <?php if (isset($rs_branches_to)) : ?>
    <?php foreach ($rs_branches_to as $item) : ?>
    <option <?= $to_branch_id == $item['c0d']? " selected ": " ";?> value="<?= $item['c0d']; ?>">
        <?= $item['branch_name']; ?></option>
    <?php endforeach; ?>
    <?php endif; ?>
</select>