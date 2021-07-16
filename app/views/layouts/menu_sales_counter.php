<ul class="navbar-nav">
    <li class="nav-item m-1 dropdown">
        <a class="nav-link btn btn-success rounded-0 text-white" data-toggle="dropdown">Packages</a>
        <div class="dropdown-menu rounded-0">
            <a class="dropdown-item" href="<?= PROOT; ?>SalesCounter/sendPackage">Send Package</a>
            <a class="dropdown-item" href="<?= PROOT; ?>SalesCounter/receivePackage">Receive Package</a>
            <a class="dropdown-item" href="<?= PROOT; ?>SalesCounter/collectPackage">Collect Package</a>
        </div>
    </li>

</ul>
<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell fa-fw"></i></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?= PROOT; ?>customers/add">Notifications</a>
            <div class="dropdown-divider"></div>

        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog fa-fw"></i></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?= PROOT; ?>products/add">Add Product</a>
            <a class="dropdown-item" href="<?= PROOT; ?>customers/add">Add Customer</a>
            <a class="dropdown-item" href="<?= PROOT; ?>suppliers/add">Add Suppliers</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= PROOT; ?>productsins/bills">Bills</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-fw"></i><?= $_SESSION["username"];?></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?= PROOT; ?>users/changePassword">Change Password</a>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= PROOT; ?>logout">Logout</a>
        </div>
    </li>
</ul>