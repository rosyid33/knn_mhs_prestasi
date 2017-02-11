<?php
session_start();
$menu = '';
if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];
}

if (!file_exists($menu.".php")) {
    $menu = 'not_found';
}

if (!isset($_SESSION['knn_mhs_prestasi_user_id']) && 
    ($menu!= '' & $menu != 'home' & $menu != 'tentang' & $menu != 'not_found')) {
    header("location:login.php");
}

include 'koneksi.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>K-NN - Mahasiswa Prestasi</title>
        <link href="images/icon/gl.png" rel="shortcut icon" />
        <link rel="stylesheet" href="scripts/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="scripts/ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="scripts/toast/jquery.toast.min.css">
    </head>

    <body>
        <?php
        include "header.php";

        include "menu.php";

        $menu = ''; //variable untuk menampung menu
        if (isset($_GET['menu'])) {
            $menu = $_GET['menu'];
        }


        if ($menu != '') {
            if (file_exists($menu.".php")) {
                include $menu.'.php';
            } else {
                include "not_found.php";
            }
        } else {
            include "home.php";
        }

        include "footer.php";
        ?>

        <script src="js/jquery.js"></script>
        <script src="js/jquery.migrate.js"></script>
        <script src="scripts/bootstrap/bootstrap.min.js"></script>
        <script src="js/e-magz.js"></script>
        <script src="scripts/toast/jquery.toast.min.js"></script>
        <script src="scripts/touchswipe/jquery.touchSwipe.min.js"></script>
        <script src="scripts/jquery-number/jquery.number.min.js"></script>
    </body>
</html>