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
                    <h2>Data Mahasiswa</h2>
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
    $cek_exist = $db_object->count_data("mahasiswa",
                            'nim',
                            "nim='".$_POST['nim']."'");
    if ($cek_exist[0]>0) {
        $input_error = 1;
        //$pesan_error = ("Data yang dimasukkan sudah ada");
        ?>
        <script> location.replace("?menu=mahasiswa&pesan_error=Data yang dimasukkan sudah ada "); </script>
        <?php
    }

    if(!$input_error){
        $table = "mahasiswa";
        $field_value = array("nim"=>$_POST['nim'],
            "nama"=>$_POST['nama'],
            "tahun_masuk"=>$_POST['tahun']);

        $query = $db_object->insert_record($table, $field_value);
        if ($query) {
                //$pesan_success = ("Data berhasil disimpan");
                ?>
                <script> location.replace("?menu=mahasiswa&pesan_success=Data berhasil disimpan"); </script>
                <?php
        }else{
                //$pesan_error = ("Gagal menyimpan data <br>(".$db_object->db_error().") ");
                ?>
                <script> location.replace("?menu=mahasiswa&pesan_error=Gagal menyimpan data "); </script>
                <?php
        }
    }
}

if(isset($_GET['delete'])){
    $id_delete=$_GET['delete'];

    $input_error = 0;
    //CEK EXISTING DATA IN TABLE
    $cek_exist = $db_object->count_data("peserta_mk",
                            'id_mhs',
                            "id_mhs='".$id_delete."'");
    if ($cek_exist[0]>0) {
        $input_error = 1;
        ?>
        <script> location.replace("?menu=mahasiswa&pesan_error=Data masih digunakan"); </script>
        <?php
    }
    if(!$input_error){
        $user = $db_object->find_in_table("mahasiswa", 'id_login', "WHERE id_mhs='$id_delete'");

        //delete
        $sql_del = "DELETE FROM mahasiswa WHERE id_mhs = '$id_delete'";
        $tr=$db_object->db_query($sql_del);

        $sql_del = "DELETE FROM login WHERE id_login = '".$user['id_login']."'";
        $db_object->db_query($sql_del);
        ?>
        <script> location.replace("?menu=mahasiswa&pesan_success=berhasil delete data"); </script>
        <?php
    }
}
$sql = "select * from mahasiswa order by(id_mhs)";
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
                        <label>NIM</label>
                        <input name="nim" type="text" class="form-control" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label>Nama Mahasiswa</label>
                        <input name="nama" type="text" class="form-control" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label>Tahun Masuk</label>
                        <input name="tahun" type="text" class="form-control" required="required"/>
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
                    <th>No</th><th>NIM</th><th>Nama Mahasiswa</th>
                    <th>Tahun Masuk</th><th>Username</th><th></th>
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
                            <td><?php echo $row['nim'];?></td>
                            <td><?php echo $row['nama'];?></td>
                            <td><?php echo $row['tahun_masuk'];?></td>
                            <td><?php echo $user;?></td>
                            <td>
                                <a href="?menu=mahasiswa&delete=<?php echo $row['id_mhs'];?>"
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