<?php
//session_start();
if (!isset($_SESSION['knn_mhs_prestasi_id'])) {
    header("location:index.php?menu=forbidden");
}

include_once "database.php";
include_once "fungsi.php";
include_once "import/excel_reader2.php";
?>
<section class="page_head">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="page_title">
                    <h2>Input Nilai</h2>
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
    // if(!$input_error){
    $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

        $baris = $data->rowcount($sheet_index=0);
        $column = $data->colcount($sheet_index=0);
        //import data excel dari baris kedua, karena baris pertama adalah nama kolom
        for ($i=2; $i<=$baris; $i++) {
            for($c=1; $c<=$column; $c++){
                $value[$c] = $data->val($i, $c);
            }

            $table = "data_latih";
            $field_value = array("id_mhs"=>$value[1],
                "id_periode"=>$_POST['periode'],
                "mk1"=>$value[2],
                "mk2"=>$value[3],
                "mk3"=>$value[4],
                "mk4"=>$value[5],
                "mk5"=>$value[6],

                "mk6"=>$value[7],
                "mk7"=>$value[8],
                "mk8"=>$value[9],
                "mk9"=>$value[10],
                "mk10"=>$value[11],

                "mk11"=>$value[12],
                "mk12"=>$value[13],
                "mk13"=>$value[14],
                "mk14"=>$value[15],
                "mk15"=>$value[16]);

            $query = $db_object->insert_record($table, $field_value);
        }
        ?>
        <script> location.replace("?menu=input_nilai&pesan_success=Data berhasil disimpan"); </script>
        <?php
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

$sql = "SELECT
        period.`semester`,period.`tahun`,
        mhs.`nim`, mhs.`nama`,
          latih.*
        FROM
          data_latih latih,
          mahasiswa mhs,
          periode period
        WHERE latih.`id_mhs` = mhs.`id_mhs`
        AND period.`id_periode` = latih.`id_periode`";
$query=$db_object->db_query($sql);
$jumlah=$db_object->db_num_rows($query);
?>

<div class="super_sub_content">
    <div class="container">
        <div class="row">
            <!--UPLOAD EXCEL FORM-->
            <form method="post" enctype="multipart/form-data" action="">
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
                        <label>Import data from excel</label>
                        <input name="userfile" type="file" class="form-control">
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
                <th>No</th>
                <th>NIM</th>
                <th>Periode</th>
                <th>MK_1</th>
                <th>MK_2</th>
                <th>MK_3</th>
                <th>MK_4</th>
                <th>MK_5</th>
                <th>MK_6</th>
                <th>MK_7</th>
                <th>MK_8</th>
                <th>MK_9</th>
                <th>MK_10</th>
                <th>MK_11</th>
                <th>MK_12</th>
                <th>MK_13</th>
                <th>MK_14</th>
                <th>MK_15</th>
                </tr>
                <?php
                    $no=1;
                    while($row=$db_object->db_fetch_array($query)){
                        echo "<tr>";
                            echo "<td>".$no."</td>";
                            echo "<td>".$row['nim']."</td>";
                            echo "<td>".$row['semester']." - ".$row['tahun']."</td>";

                            echo "<td>".$row['mk1']."</td>";
                            echo "<td>".$row['mk2']."</td>";
                            echo "<td>".$row['mk3']."</td>";
                            echo "<td>".$row['mk4']."</td>";
                            echo "<td>".$row['mk5']."</td>";
                            echo "<td>".$row['mk6']."</td>";
                            echo "<td>".$row['mk7']."</td>";
                            echo "<td>".$row['mk8']."</td>";
                            echo "<td>".$row['mk9']."</td>";
                            echo "<td>".$row['mk10']."</td>";
                            echo "<td>".$row['mk11']."</td>";
                            echo "<td>".$row['mk12']."</td>";
                            echo "<td>".$row['mk13']."</td>";
                            echo "<td>".$row['mk14']."</td>";
                            echo "<td>".$row['mk15']."</td>";
                        echo "</tr>";
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