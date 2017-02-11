<?php
session_start();

$login = 0;
if (isset($_GET['login'])) {
    $login = $_GET['login'];
}

if ($login == 1) {
    $komen = "Silahkan Login Ulang, Cek username dan Password Anda!!";
}

include_once "fungsi.php";
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
        ?>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-sm-5 col-lg-offset-1">
                        <div class="dividerHeading">
                            <h4>
                                <span>Login Form</span>
                            </h4>
                        </div>
                        <?php
                        if (isset($komen)) {
                            display_error("Login failed");
                        }
                        ?>
                        <form id="loginform" method="post" name="loginform" action="cek-login.php">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" placeholder="Username" name="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-default btn-lg button">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php
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
