<?php
//session_start();
if (!isset($_SESSION['knn_mhs_prestasi_id'])) {
    header("location:index.php?menu=forbidden");
}

include_once "database.php";
include_once "fungsi.php";
include_once "fungsi_proses_mining.php";
?>
<section class="page_head">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="page_title">
                    <h2>Proses</h2>
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

// $data_latih = $kolom_mata_kuliah = $baris_mahasiswa = array();
// while($row = $db_object->db_fetch_array($query)){
//     $data_latih[$row['id_mk']][$row['id_mhs']] = $row['nilai'];

//     if(!in_array($row['id_mk'], $kolom_mata_kuliah)){
//         $kolom_mata_kuliah[] = $row['id_mk'];
//     }
//     if(!in_array($row['id_mhs'], $baris_mahasiswa)){
//         $baris_mahasiswa[] = $row['id_mhs'];
//     }
// }


?>

<div class="super_sub_content">
    <div class="container">
        <div class="row">
            <!--UPLOAD EXCEL FORM-->
            <form method="post" action="">
            <center>
                <div class="form-group">
                    <input name="submit" type="submit" value="Proses" class="btn btn-success">
                </div>
                </center>
            </form>

            <?php
            if (!empty($pesan_error)) {
                display_error($pesan_error);
            }
            if (!empty($pesan_success)) {
                display_success($pesan_success);
            }


            echo "Jumlah data: ".$jumlah."<br>";
            // if($jumlah==0){
            //         echo "Data kosong...";
            // }
            // else{
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
                <?php
                    // echo "<th></th>";
                    // foreach ($kolom_mata_kuliah as $key => $value) {
                    //     echo "<th>".$value."</th>";
                    // }
                ?>
                </tr>
                <?php
                $no = 1;
                while($row = $db_object->db_fetch_array($query)){
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
            // }

            //proses manggil fungsi proses_mining
            if(isset($_POST['submit'])){
                $input_error = 0;
                
                if(!$input_error){
                    proses_mining($db_object);
                }
            }

            ?>


        </div>
    </div>
</div>