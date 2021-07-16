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
        <a href="<?= PROOT; ?>users/eone/<?= $item['c0d']; ?>" id="view<?= $item['c0d']; ?>"
            class="btn btn-info  btn-view rounded-0">VIEW</a>
    </td>
</tr>
<?php endforeach; ?>
<?php endif; ?>