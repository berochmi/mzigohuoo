<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, shrink-to-fit=no">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="<?= PROOT; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= PROOT; ?>css/sb_styles.css?v=2">
    <link rel="stylesheet" href="<?= PROOT; ?>css/custom.css">
    <link rel="stylesheet" href="<?= PROOT; ?>css/datepicker3.css">
    <link rel="stylesheet" href="<?= PROOT; ?>css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="<?= PROOT; ?>fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= PROOT; ?>css/tempusdominus-bootstrap-4.min.css" />
    <link rel="stylesheet" href="<?= PROOT; ?>css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?= PROOT; ?>css/toastr.min.css">
    <link rel="stylesheet" href="<?= PROOT; ?>css/vtoast.css">
    <link rel="stylesheet" href="<?= PROOT; ?>css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= PROOT; ?>css/lightbox.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="<?= PROOT; ?>js/vue.global.prod.js"></script>


    <link rel="stylesheet" href="<?= PROOT; ?>css/jquery.timepicker.min.css">
    <link rel="icon" href="<?= PROOT; ?>images/logo_4.ico" type="image/x-icon">
    <?= $this->content("head"); ?>
    <title><?= SITE_TITLE; ?></title>
</head>

<body class="sb-nav-fixed" style="zoom: 90%;">
    <div id="load_screen">
        <div id="loading">
            <p class="text-center"><img src="<?= PROOT; ?>images/loading2.gif" /></p>
            <p class="text-center"></p>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="z-index:1;">
        <a class="navbar-brand" href="#" style="width: 225px;"><?= BRAND;?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <button class="btn btn-link btn-sm order-1 order-lg-0 rounded-0" onclick="openNav()" href="#"><i
                class="fa fa-bars fa-lg" style="color: white;"></i></button>
        <div class="collapse navbar-collapse" id="main_nav">
            <?php 
                if(file_exists(ROOT.DS.'app'.DS.'views'.DS.'layouts'.DS.'menu_'.strtolower(str_replace(' ','_',$_SESSION['role'])).'.php')){
                    include('menu_'.strtolower(str_replace(' ','_',$_SESSION['role'])).'.php');
                }
            ?>
        </div> <!-- navbar-collapse.// -->
    </nav>

    <div id="mySidebar" class="sidebar">
        <?php include('side_bar2.php'); ?>
    </div>
    <div id="layoutSidenav_content" style="padding:15px 10px 10px 10px;transition: margin-left .5s">
        <?= $this->content("body"); ?>

    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="<?= PROOT; ?>js/jQuery.min.js"></script>
    <script src="<?= PROOT; ?>js/jquery-1.11.1.min.js"></script>
    <script src="<?= PROOT; ?>js/popper.min.js"></script>
    <script src="<?= PROOT; ?>js/bootstrap.min.js"></script>
    <script src="<?= PROOT; ?>js/moment.min.js"></script>

    <script src="<?= PROOT; ?>js/sb_scripts.js"></script>
    <script src="<?= PROOT; ?>js/bootstrap-datepicker.js"></script>
    <script src="<?= PROOT; ?>js/bootstrap-datetimepicker.js?v=3"></script>
    <script src="<?= PROOT; ?>js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="<?= PROOT; ?>js/my_js.js?v=9"></script>
    <script src="<?= PROOT; ?>js/compress.js"></script>
    <script src="<?= PROOT; ?>js/cleave.min.js"></script>


    <script src="<?= PROOT; ?>js/jquery.fancybox.min.js"></script>
    <script src="<?= PROOT; ?>js/vtoast.js"></script>
    <script src="<?= PROOT; ?>js/jquery.timepicker.min.js"></script>
    <script src="<?= PROOT; ?>js/lightbox.js"></script>
    <script src="<?= PROOT; ?>js/bootbox.all.min.js"></script>
    <script>
    function openNav() {
        if (document.getElementById("mySidebar").style.width == "" || document.getElementById("mySidebar").style
            .width == "0px") {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("layoutSidenav_content").style.marginLeft = "250px";
        } else {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("layoutSidenav_content").style.marginLeft = "0";
        }
    }
    </script>
    <script>
    window.addEventListener('load', function() {
        document.body.removeChild(_("load_screen"));
    });
    </script>
    <?= $this->content('section_js'); ?>
</body>

</html>