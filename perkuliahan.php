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
                    <h2>Data Perkuliahan</h2>
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
    $cek_exist = $db_object->count_data("dosen_mk",
                            'id_dosen_mk',
                            "id_mk='".$_POST['mata_kuliah']."' AND id_periode='".$_POST['periode']."'");
    if ($cek_exist[0]>0) {
        $input_error = 1;
        //$pesan_error = ("Data yang dimasukkan sudah ada");
        ?>
        <script> location.replace("?menu=perkuliahan&pesan_error=Data yang dimasukkan sudah ada "); </script>
        <?php
    }
    
    if(!$input_error){
        $table = "dosen_mk";
        $field_value = array("id_dosen"=>$_POST['dosen'],
            "id_mk"=>$_POST['mata_kuliah'],
            "id_periode"=>$_POST['periode']);

        $query = $db_object->insert_record($table, $field_value);
        if ($query) {
                //$pesan_success = ("Data berhasil disimpan");
                ?>
                <script> location.replace("?menu=perkuliahan&pesan_success=Data berhasil disimpan"); </script>
                <?php
        }else{
                //$pesan_error = ("Gagal menyimpan data <br>(".$db_object->db_error().") ");
                ?>
                <script> location.replace("?menu=perkuliahan&pesan_error=Gagal menyimpan data "); </script>
                <?php
        }
    }
}

if(isset($_GET['delete'])){
    $id_delete=$_GET['delete'];

    $input_error = 0;
    //CEK EXISTING DATA IN TABLE
    $cek_exist = $db_object->count_data("peserta_mk",
                            'id_dosen_mk',
                            "id_dosen_mk='".$id_delete."'");
    if ($cek_exist[0]>0) {
        $input_error = 1;
        ?>
        <script> location.replace("?menu=perkuliahan&pesan_error=Data masih digunakan"); </script>
        <?php
    }
    if(!$input_error){
        //delete
        $sql_del = "DELETE FROM dosen_mk WHERE id_dosen_mk = '$id_delete'";
        $tr=$db_object->db_query($sql_del);
        ?>
        <script> location.replace("?menu=perkuliahan&pesan_success=berhasil delete data"); </script>
        <?php
    }
}

$sql = "SELECT kul.id_dosen_mk, per.semester, per.tahun, mat.n_mk, dosen.nama 
        FROM `dosen_mk` as kul, periode as per, mata_kuliah as mat, dosen as dosen 
        WHERE kul.id_periode = per.id_periode AND kul.id_mk = mat.id_mk AND kul.id_dosen = dosen.id_dosen";
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
                        <label>Periode</label>
                        <?php
                        list_periode("periode", '', true, true);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label>Mata Kuliah</label>
                        <?php
                        list_mata_kuliah("mata_kuliah", '', true, true);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <label>Dosen</label>
                        <?php
                        list_dosen("dosen", '', true, true);
                        ?>
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
                    <th>No</th><th>Periode</th><th>Mata Kuliah</th><th>Dosen</th><th></th>
                </tr>
                <?php
                    $no=1;
                    while($row=$db_object->db_fetch_array($query)){
                    ?>
                    <tr>
                            <td><?php echo $no;?></td>
                            <td><?php echo $row['semester']." - ".$row['tahun'];?></td>
                            <td><?php echo $row['n_mk'];?></td>
                            <td><?php echo $row['nama'];?></td>
                            <td>
                                <a href="?menu=perkuliahan&delete=<?php echo $row['id_dosen_mk'];?>"
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