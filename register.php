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
include_once "database.php";

//object database class
$db_object = new database();

$pesan_error = $pesan_success = "";
if(isset($_POST['submit'])){
    $input_error = 0;

    $cek_exist = $db_object->count_data("mahasiswa", 
                            'nim',
                            "nim='".$_POST['nim']."'");
    if ($cek_exist[0]<=0) {
        $input_error = 1;
        $pesan_error = "NIM tersebut tidak ada dalam daftar mahasiswa. Silahkan hubungi admin";
    }

    //CEK EXISTING DATA IN TABLE
    $cek_exist = $db_object->count_data("mahasiswa", 
                            'nim',
                            "nim='".$_POST['nim']."' AND id_login>0");
    if ($cek_exist[0]>0) {
        $input_error = 1;
        $pesan_error = "NIM tersebut sudah terdaftar";
    }


    if(!$input_error){
        $table = "login";
        $field_value = array(
            "id_priv"=>2,
            "username"=>$_POST['username'],
            "password"=>$_POST['password']
            );
        
        $query = $db_object->insert_record($table, $field_value);
        if ($query) {
            $idLogin = $db_object->db_insert_id();

            $table = "mahasiswa";
            $set_update = array("id_login"=>$idLogin);
            $where_condition  = array("nim"=>$_POST['nim']);
            
            $query = $db_object->update_record($table, $set_update , $where_condition);

            $pesan_success = "NIM ".$_POST['username']." berhasil registrasi";
        }
        else{
            $pesan_error = "Gagal menyimpan data ";
        }
    }
}
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
                                <span>Register Form</span>
                            </h4>
                        </div>
                        <?php
                        if (!empty($pesan_error)) {
                            display_error($pesan_error);
                        }
                        if (!empty($pesan_success)) {
                            display_success($pesan_success);
                        }
                        ?>
                        <form id="loginform" method="post" name="loginform" action="">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" placeholder="NIM" name="nim" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" placeholder="Username" name="username" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-default btn-lg button">Register</button>
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
