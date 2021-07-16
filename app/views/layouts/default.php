<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=PROOT;?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=PROOT;?>css/sb_styles.css">
    <link rel="stylesheet" href="<?=PROOT;?>css/custom.css">
    <?= $this->content("head");?>
    <title><?=SITE_TITLE;?></title>
  </head>
  <body class="sb-nav-fixed">
    <?= $this->content("body");?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?=PROOT;?>js/jQuery.min.js"></script>    
    <script src="<?=PROOT;?>js/popper.min.js"></script>    
    <script src="<?=PROOT;?>js/bootstrap.min.js"></script>
    <script src="<?=PROOT;?>js/sb_scripts.js"></script>
  </body>
</html>