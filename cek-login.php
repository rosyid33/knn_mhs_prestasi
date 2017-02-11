<?php
session_start(); // harus ada di bagian paling atas kode
$path_to_root = "";
include $path_to_root . 'database.php';

//object database class
$db = new database();

$user = strip_tags(trim($_POST['username'])); #echo $user;
$pass = strip_tags(trim($_POST['password'])); #echo $pass;

$sql = get_sql_login_admin_page($user, $pass);

$result = $db->db_query($sql);
$num_rows = $db->db_num_rows($result);

if ($num_rows > 0) {
    $rows = $db->db_fetch_array($result);
    
        unset($_POST); // hapus post form
        $_SESSION['knn_mhs_prestasi_id'] = $rows['id_login']; // mengisi session
        $_SESSION['knn_mhs_prestasi_username'] = $rows['username'];
        $_SESSION['knn_mhs_prestasi_level'] = $rows['id_priv'];

        $sql_level = get_sql_level($rows['id_priv']);
        $result_1 = $db->db_query($sql_level);
        $row_1 = $db->db_fetch_array($result_1);
        $_SESSION['knn_mhs_prestasi_level_name'] = $row_1['n_priv'];

        $_SESSION['knn_mhs_prestasi_key'] = sha1(date("Y-m-d H:i:s") . $rows['id_login']);
        $_SESSION['knn_mhs_prestasi_last_login'] = date("d-m-Y H:i:s");
        header("location:index.php");
} else {
    header("location:login.php?login=1");
}


/**
 * query get login 
 * @param string $user username
 * @param string $pass password
 * @return string
 */
function get_sql_login_admin_page($user, $pass){
    $sql = "SELECT * FROM login"
        . " WHERE username = '" . $user . "' AND password = ('" . $pass . "')";
    return $sql;
}

function get_sql_level($id){
    $sql = "SELECT * FROM priv"
        . " WHERE id_priv = '" . $id . "'";
    return $sql;
}
?>
