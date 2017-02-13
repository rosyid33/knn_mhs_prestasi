<?php
//session_start();
if (!isset($_SESSION['knn_mhs_prestasi_id'])) {
    header("location:index.php?menu=forbidden");
}

include_once "database.php";
include_once "fungsi.php";
?>
<section class="page_head">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="page_title">
                    <h2>Data Dosen</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
//object database class
$db_object = new database();

$pesan_error = $pesan_success = "";
if(isset($_GET['pesan_error'])){
    $pesan_error = $_GET['pesan_error'];
}
if(isset($_GET['pesan_success'])){
    $pesan_success = $_GET['pesan_success'];
}

if(isset($_POST['submit'])){
    $input_error = 0;
    //CEK EXISTING DATA IN TABLE
    $cek_exist = $db_object->count_data("dosen",
                            'nid',
                            "nid='".$_POST['nid']."'");
    if ($cek_exist[0]>0) {
        $input_error = 1;
        //$pesan_error = ("Data yang dimasukkan sudah ada");
        ?>
        <script> location.replace("?menu=dosen&pesan_error=Data yang dimasukkan sudah ada "); </script>
        <?php
    }

    $cek_exist = $db_object->count_data("login",
                            'username',
                            "username='".$_POST['username']."'");
    if ($cek_exist[0]>0) {
        $input_error = 1;
        //$pesan_error = ("Data yang dimasukkan sudah ada");
        ?>
        <script> location.replace("?menu=dosen&pesan_error=Username sudah digunakan "); </script>
        <?php
    }

    if(!$input_error){
        $table1 = "login";
        $field_value1 = array("username"=>$_POST['username'],
            "password"=>$_POST['password'],
            "id_priv"=>3);

        $query1 = $db_object->insert_record($table1, $field_value1);
        $id_login = $db_object->db_insert_id();

        $table = "dosen";
        $field_value = array("nid"=>$_POST['nid'],
            "nama"=>$_POST['nama'],
            "id_login"=>$id_login);

        $query = $db_object->insert_record($table, $field_value);
        if ($query) {
                //$pesan_success = ("Data berhasil disimpan");
                ?>
                <script> location.replace("?menu=dosen&pesan_success=Data berhasil disimpan"); </script>
                <?php
        }else{
                //$pesan_error = ("Gagal menyimpan data <br>(".$db_object->db_error().") ");
                ?>
                <script> location.replace("?menu=dosen&pesan_error=Gagal menyimpan data "); </script>
                <?php
        }
    }
}

if(isset($_GET['delete'])){
    $id_delete=$_GET['delete'];

    $input_error = 0;
    //CEK EXISTING DATA IN TABLE
    $cek_exist = $db_object->count_data("dosen_mk",
                            'id_dosen',
                            "id_dosen='".$id_delete."'");
    if ($cek_exist[0]>0) {
        $input_error = 1;
        ?>
        <script> location.replace("?menu=dosen&pesan_error=Data masih digunakan"); </script>
        <?php
    }
    if(!$input_error){

        $user = $db_object->find_in_table("dosen", 'id_login', "WHERE id_dosen='$id_delete'");

        //delete
        $sql_del = "DELETE FROM dosen WHERE id_dosen = '$id_delete'";
        $tr=$db_object->db_query($sql_del);

        $sql_del1 = "DELETE FROM login WHERE id_login = '".$user['id_login']."'";
        $db_object->db_query($sql_del1);
        ?>
        <script> location.replace("?menu=dosen&pesan_success=berhasil delete data"); </script>
        <?php
    }
}
$sql = "select * from dosen order by(id_dosen)";
$query=$db_object->db_query($sql);
$jumlah=$db_object->db_num_rows($query);
?>

<div class="super_sub_content">
    <div class="container">
        <div class="row">
            <!--UPLOAD EXCEL FORM-->
            <form method="post" action="">
                <div class="form-group">
                    <div class="input-group">
                        <label>NID</label>
                        <input name="nid" type="text" class="form-control" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label>Nama dosen</label>
                        <input name="nama" type="text" class="form-control" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label>Username</label>
                        <input name="username" type="text" class="form-control" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label>Password</label>
                        <input name="password" type="password" class="form-control" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <input name="submit" type="submit" value="Create" class="btn btn-success">
                </div>
            </form>

            <?php
            if (!empty($pesan_error)) {
                display_error($pesan_error);
            }
            if (!empty($pesan_success)) {
                display_success($pesan_success);
            }


            echo "Jumlah data: ".$jumlah."<br>";
            if($jumlah==0){
                    echo "Data kosong...";
            }
            else{
            ?>
            <table class='table table-bordered table-striped  table-hover'>
                <tr>
                    <th>No</th><th>NID</th><th>Nama dosen</th>
                    <th>Username</th><th></th>
                </tr>
                <?php
                    $no=1;
                    while($row=$db_object->db_fetch_array($query)){
                        $login = $db_object->get_login_by_id($row['id_login']);
                        $user = "";
                        if(count($login)<=0){
                            $user = 'belum register';
                        }
                        else{
                            $user = $login['username'];
                        }
                    ?>
                    <tr>
                            <td><?php echo $no;?></td>
                            <td><?php echo $row['nid'];?></td>
                            <td><?php echo $row['nama'];?></td>
                            <td><?php echo $user;?></td>
                            <td>
                                <a href="?menu=dosen&delete=<?php echo $row['id_dosen'];?>"
                                   onClick="return confirm('Are you sure, want to delete?')">
                                    <img src="images/icon/delete.gif"/>
                                </a>
                            </td>
                    </tr>
                    <?php
                        $no++;
                    }
                    ?>
            </table>
            <?php
            }
            ?>
        </div>
    </div>
</div>